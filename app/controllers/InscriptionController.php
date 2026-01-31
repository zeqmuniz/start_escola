<?php

class InscriptionController
{
    public function publicForm(): void
    {
        $modules = Module::all();
        $poles = Pole::all();
        $modalities = Modality::all();
        View::render('inscriptions/public', [
            'modules' => $modules,
            'poles' => $poles,
            'modalities' => $modalities,
        ], 'layouts/guest');
    }

    public function submit(): void
    {
        if (Request::input('website')) {
            flash('success', 'Inscricao recebida.');
            redirect(url('inscricao'));
        }

        $data = [
            'full_name' => trim((string) Request::input('full_name')),
            'cpf' => trim((string) Request::input('cpf')),
            'email' => trim((string) Request::input('email')),
            'phone' => trim((string) Request::input('phone')),
            'module_id' => Request::input('module_id') ?: null,
            'pole_id' => Request::input('pole_id') ?: null,
            'modality_id' => Request::input('modality_id') ?: null,
        ];

        $errors = Validator::validate($data, [
            'full_name' => 'required',
            'email' => 'required|email',
        ]);

        if (!empty($errors)) {
            set_old_input($data);
            flash('error', 'Preencha os campos obrigatorios.');
            redirect(url('inscricao'));
        }

        Inscription::createPublic($data);
        Session::clearOld();
        flash('success', 'Inscricao enviada com sucesso. Aguarde o contato da secretaria.');
        redirect(url('inscricao'));
    }

    public function index(): void
    {
        $inscriptions = Inscription::all();
        View::render('inscriptions/index', ['inscriptions' => $inscriptions], 'layouts/app');
    }

    public function show(array $params): void
    {
        $id = (int) ($params['id'] ?? 0);
        $inscription = Inscription::find($id);
        if (!$inscription) {
            Response::abort(404, 'Inscricao nao encontrada.');
        }
        View::render('inscriptions/show', ['inscription' => $inscription], 'layouts/app');
    }

    public function review(array $params): void
    {
        $id = (int) ($params['id'] ?? 0);
        $notes = trim((string) Request::input('review_notes'));
        if ($notes === '') {
            flash('error', 'Informe observacoes para o review.');
            redirect(url('admin/inscricoes/' . $id));
        }
        $inscription = Inscription::find($id);
        if (!$inscription) {
            Response::abort(404, 'Inscricao nao encontrada.');
        }
        if ($inscription['status'] !== 'pending') {
            flash('error', 'Inscricao ja foi decidida.');
            redirect(url('admin/inscricoes/' . $id));
        }
        $user = Auth::user();
        Inscription::review($id, $notes, (int) $user['id']);
        flash('success', 'Review registrado.');
        redirect(url('admin/inscricoes/' . $id));
    }

    public function reject(array $params): void
    {
        $id = (int) ($params['id'] ?? 0);
        $reason = trim((string) Request::input('rejection_reason'));
        if ($reason === '') {
            flash('error', 'Informe o motivo da rejeicao.');
            redirect(url('admin/inscricoes/' . $id));
        }
        $inscription = Inscription::find($id);
        if (!$inscription) {
            Response::abort(404, 'Inscricao nao encontrada.');
        }
        if ($inscription['status'] !== 'pending') {
            flash('error', 'Inscricao ja foi decidida.');
            redirect(url('admin/inscricoes/' . $id));
        }
        $user = Auth::user();
        Inscription::reject($id, $reason, (int) $user['id']);
        flash('success', 'Inscricao rejeitada.');
        redirect(url('admin/inscricoes'));
    }

    public function approve(array $params): void
    {
        $id = (int) ($params['id'] ?? 0);
        $inscription = Inscription::find($id);
        if (!$inscription) {
            Response::abort(404, 'Inscricao nao encontrada.');
        }
        if ($inscription['status'] !== 'pending') {
            flash('error', 'Inscricao ja foi decidida.');
            redirect(url('admin/inscricoes/' . $id));
        }

        $duplicate = Inscription::findDuplicate($inscription['email'], $inscription['cpf']);
        if ($duplicate['person'] || $duplicate['user']) {
            flash('error', 'Possivel duplicidade encontrada. Resolva antes de aprovar.');
            redirect(url('admin/inscricoes/' . $id));
        }

        $db = App::db();
        $user = Auth::user();
        $tempPassword = bin2hex(random_bytes(4));

        $db->beginTransaction();
        try {
            $personId = Person::create([
                'full_name' => $inscription['full_name'],
                'cpf' => $inscription['cpf'],
                'email' => $inscription['email'],
                'phone' => $inscription['phone'],
            ]);

            $studentRoleId = $this->getRoleId('student');
            $userId = User::create([
                'person_id' => $personId,
                'display_name' => $inscription['full_name'],
                'email' => $inscription['email'],
                'password_hash' => password_hash($tempPassword, PASSWORD_BCRYPT),
                'status' => 'active',
                'must_change_password' => 1,
            ], $studentRoleId ? [$studentRoleId] : []);

            Enrollment::create([
                'person_id' => $personId,
                'module_id' => $inscription['module_id'],
                'pole_id' => $inscription['pole_id'],
                'modality_id' => $inscription['modality_id'],
                'status' => 'cursando',
            ]);

            $db->execute(
                'UPDATE inscriptions SET status = :status, decided_by_user_id = :user_id, decided_at = NOW(), updated_at = NOW() WHERE id = :id AND status = :pending',
                [
                    'status' => 'approved',
                    'user_id' => $user['id'],
                    'id' => $id,
                    'pending' => 'pending',
                ]
            );

            Audit::log('approve', 'inscription', $id, ['user_id' => $user['id'], 'student_user_id' => $userId]);
            $db->commit();
        } catch (Throwable $e) {
            $db->rollBack();
            flash('error', 'Falha ao aprovar inscricao.');
            redirect(url('admin/inscricoes/' . $id));
        }

        flash('success', 'Inscricao aprovada. Usuario aluno criado.');
        flash('warning', 'Senha temporaria do aluno: ' . $tempPassword);
        redirect(url('admin/inscricoes/' . $id));
    }

    private function getRoleId(string $slug): ?int
    {
        $db = App::db();
        $role = $db->fetch('SELECT id FROM roles WHERE slug = :slug', ['slug' => $slug]);
        return $role ? (int) $role['id'] : null;
    }
}
