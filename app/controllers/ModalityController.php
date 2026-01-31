<?php

class ModalityController
{
    public function index(): void
    {
        $modalities = Modality::all();
        View::render('modalities/index', ['modalities' => $modalities], 'layouts/app');
    }

    public function create(): void
    {
        View::render('modalities/create', [], 'layouts/app');
    }

    public function store(): void
    {
        $data = [
            'name' => trim((string) Request::input('name')),
            'description' => trim((string) Request::input('description')),
        ];

        $errors = Validator::validate($data, [
            'name' => 'required',
        ]);

        if (!empty($errors)) {
            set_old_input($data);
            flash('error', 'Nome da modalidade e obrigatorio.');
            redirect(url('admin/modalidades/novo'));
        }

        Modality::create($data);
        Session::clearOld();
        flash('success', 'Modalidade criada.');
        redirect(url('admin/modalidades'));
    }

    public function edit(array $params): void
    {
        $id = (int) ($params['id'] ?? 0);
        $modality = Modality::find($id);
        if (!$modality) {
            Response::abort(404, 'Modalidade nao encontrada.');
        }
        View::render('modalities/edit', ['modality' => $modality], 'layouts/app');
    }

    public function update(array $params): void
    {
        $id = (int) ($params['id'] ?? 0);
        $modality = Modality::find($id);
        if (!$modality) {
            Response::abort(404, 'Modalidade nao encontrada.');
        }

        $data = [
            'name' => trim((string) Request::input('name')),
            'description' => trim((string) Request::input('description')),
        ];

        $errors = Validator::validate($data, [
            'name' => 'required',
        ]);

        if (!empty($errors)) {
            set_old_input($data);
            flash('error', 'Nome da modalidade e obrigatorio.');
            redirect(url('admin/modalidades/' . $id . '/editar'));
        }

        Modality::update($id, $data);
        Session::clearOld();
        flash('success', 'Modalidade atualizada.');
        redirect(url('admin/modalidades'));
    }
}
