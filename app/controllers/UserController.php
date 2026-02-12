<?php

class UserController
{
    public function index(): void
    {
        $users = $this->currentHasRole('secretary') && !$this->currentHasRole('admin')
            ? User::allByRoleSlug('student')
            : User::all();
        View::render('users/index', ['users' => $users], 'layouts/app');
    }

    public function create(): void
    {
        $roles = $this->currentHasRole('secretary') && !$this->currentHasRole('admin')
            ? User::roleOptionsBySlug(['student'])
            : User::rolesOptions();
        $people = Person::all();
        View::render('users/create', ['roles' => $roles, 'people' => $people], 'layouts/app');
    }

    public function store(): void
    {
        $data = [
            'display_name' => trim((string) Request::input('display_name')),
            'email' => trim((string) Request::input('email')),
            'password' => (string) Request::input('password'),
            'person_id' => Request::input('person_id') ?: null,
            'status' => Request::input('status') ?: 'active',
            'roles' => Request::input('roles') ?? [],
        ];

        $errors = Validator::validate($data, [
            'display_name' => 'required',
            'email' => 'required|email',
        ]);

        if (!empty($errors)) {
            set_old_input($data);
            flash('error', 'Preencha os campos obrigatorios.');
            redirect(url('admin/usuarios/novo'));
        }

        $db = App::db();
        $exists = $db->fetch('SELECT id FROM users WHERE email = :email', ['email' => $data['email']]);
        if ($exists) {
            set_old_input($data);
            flash('error', 'Email ja cadastrado.');
            redirect(url('admin/usuarios/novo'));
        }

        $password = $data['password'];
        $mustChange = 0;
        if ($password === '') {
            $password = bin2hex(random_bytes(4));
            $mustChange = 1;
            flash('warning', 'Senha temporaria gerada: ' . $password . '. Solicite troca no primeiro acesso.');
        }

        $roleIds = array_map('intval', (array) $data['roles']);
        if ($this->currentHasRole('secretary') && !$this->currentHasRole('admin')) {
            $roleIds = $this->filterRoleIdsBySlug($roleIds, ['student']);
        }
        User::create([
            'person_id' => $data['person_id'],
            'display_name' => $data['display_name'],
            'email' => $data['email'],
            'password_hash' => password_hash($password, PASSWORD_BCRYPT),
            'status' => $data['status'],
            'must_change_password' => $mustChange,
        ], $roleIds);

        Session::clearOld();
        flash('success', 'Usuario criado com sucesso.');
        redirect(url('admin/usuarios'));
    }

    public function edit(array $params): void
    {
        $id = (int) ($params['id'] ?? 0);
        $user = User::findWithRoles($id);
        if (!$user) {
            Response::abort(404, 'Usuario nao encontrado.');
        }
        if ($this->currentHasRole('secretary') && !$this->currentHasRole('admin') && !$this->userHasRole($user, 'student')) {
            Response::abort(403, 'Acesso negado.');
        }
        $roles = User::rolesOptions();
        if ($this->currentHasRole('secretary') && !$this->currentHasRole('admin')) {
            $roles = User::roleOptionsBySlug(['student']);
        }
        $people = Person::all();
        View::render('users/edit', [
            'user' => $user,
            'roles' => $roles,
            'people' => $people,
        ], 'layouts/app');
    }

    public function update(array $params): void
    {
        $id = (int) ($params['id'] ?? 0);
        $user = User::find($id);
        if (!$user) {
            Response::abort(404, 'Usuario nao encontrado.');
        }
        $userWithRoles = User::findWithRoles($id);
        if ($userWithRoles && $this->currentHasRole('secretary') && !$this->currentHasRole('admin') && !$this->userHasRole($userWithRoles, 'student')) {
            Response::abort(403, 'Acesso negado.');
        }

        $data = [
            'display_name' => trim((string) Request::input('display_name')),
            'email' => trim((string) Request::input('email')),
            'password' => (string) Request::input('password'),
            'person_id' => Request::input('person_id') ?: null,
            'status' => Request::input('status') ?: 'active',
            'roles' => Request::input('roles') ?? [],
        ];

        $errors = Validator::validate($data, [
            'display_name' => 'required',
            'email' => 'required|email',
        ]);

        if (!empty($errors)) {
            set_old_input($data);
            flash('error', 'Preencha os campos obrigatorios.');
            redirect(url('admin/usuarios/' . $id . '/editar'));
        }

        $db = App::db();
        $exists = $db->fetch('SELECT id FROM users WHERE email = :email AND id != :id', [
            'email' => $data['email'],
            'id' => $id,
        ]);
        if ($exists) {
            set_old_input($data);
            flash('error', 'Email ja cadastrado.');
            redirect(url('admin/usuarios/' . $id . '/editar'));
        }

        $payload = [
            'person_id' => $data['person_id'],
            'display_name' => $data['display_name'],
            'email' => $data['email'],
            'status' => $data['status'],
        ];
        if ($data['password'] !== '') {
            $payload['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        $roleIds = array_map('intval', (array) $data['roles']);
        if ($this->currentHasRole('secretary') && !$this->currentHasRole('admin')) {
            $roleIds = $this->filterRoleIdsBySlug($roleIds, ['student']);
        }
        User::update($id, $payload, $roleIds);
        $current = Auth::user();
        if ($current && (int) $current['id'] === $id) {
            Session::forget('perm_cache');
        }
        Session::clearOld();
        flash('success', 'Usuario atualizado.');
        redirect(url('admin/usuarios'));
    }

    public function disable(array $params): void
    {
        $id = (int) ($params['id'] ?? 0);
        $current = Auth::user();
        if (!$current) {
            Response::abort(403, 'Acesso negado.');
        }
        if ((int) $current['id'] === $id) {
            flash('error', 'Nao e permitido desativar o proprio usuario.');
            redirect(url('admin/usuarios'));
        }

        $target = User::findWithRoles($id);
        if (!$target) {
            Response::abort(404, 'Usuario nao encontrado.');
        }
        if ($this->currentHasRole('secretary') && !$this->currentHasRole('admin') && !$this->userHasRole($target, 'student')) {
            Response::abort(403, 'Acesso negado.');
        }

        if ($this->currentHasRole('secretary') && $this->userHasRole($target, 'admin')) {
            flash('error', 'Secretario nao pode desativar Administrador Geral.');
            redirect(url('admin/usuarios'));
        }

        User::disable($id);
        flash('success', 'Usuario desativado.');
        redirect(url('admin/usuarios'));
    }

    public function account(): void
    {
        $user = Auth::user();
        if (!$user) {
            Response::abort(403, 'Acesso negado.');
        }
        View::render('users/account', ['user' => $user], 'layouts/app');
    }

    public function updatePassword(): void
    {
        $user = Auth::user();
        if (!$user) {
            Response::abort(403, 'Acesso negado.');
        }
        $current = (string) Request::input('current_password');
        $new = (string) Request::input('new_password');
        $confirm = (string) Request::input('confirm_password');

        if (!password_verify($current, $user['password_hash'])) {
            flash('error', 'Senha atual incorreta.');
            redirect(url('minha-conta'));
        }
        if ($new === '' || strlen($new) < 6) {
            flash('error', 'Nova senha deve ter pelo menos 6 caracteres.');
            redirect(url('minha-conta'));
        }
        if ($new !== $confirm) {
            flash('error', 'Confirmacao de senha nao confere.');
            redirect(url('minha-conta'));
        }

        $db = App::db();
        $db->execute(
            'UPDATE users SET password_hash = :hash, must_change_password = 0, updated_at = NOW() WHERE id = :id',
            ['hash' => password_hash($new, PASSWORD_BCRYPT), 'id' => $user['id']]
        );
        Session::forget('perm_cache');
        flash('success', 'Senha atualizada com sucesso.');
        redirect(url('minha-conta'));
    }

    private function currentHasRole(string $slug): bool
    {
        $roles = Auth::roles();
        foreach ($roles as $role) {
            if (($role['slug'] ?? '') === $slug) {
                return true;
            }
        }
        return false;
    }

    private function userHasRole(array $user, string $slug): bool
    {
        foreach ($user['roles'] ?? [] as $role) {
            if (($role['slug'] ?? '') === $slug) {
                return true;
            }
        }
        return false;
    }

    private function filterRoleIdsBySlug(array $roleIds, array $allowedSlugs): array
    {
        if (empty($roleIds)) {
            return [];
        }
        $roles = User::roleOptionsBySlug($allowedSlugs);
        $allowedIds = array_map(fn($role) => (int) $role['id'], $roles);
        return array_values(array_intersect($roleIds, $allowedIds));
    }
}
