<?php

class ModuleController
{
    public function index(): void
    {
        $modules = Module::all();
        View::render('modules/index', ['modules' => $modules], 'layouts/app');
    }

    public function create(): void
    {
        View::render('modules/create', [], 'layouts/app');
    }

    public function store(): void
    {
        $data = [
            'name' => trim((string) Request::input('name')),
            'sort_order' => Request::input('sort_order') ?: 0,
            'description' => trim((string) Request::input('description')),
        ];

        $errors = Validator::validate($data, [
            'name' => 'required',
        ]);

        if (!empty($errors)) {
            set_old_input($data);
            flash('error', 'Nome do modulo e obrigatorio.');
            redirect(url('admin/modulos/novo'));
        }

        Module::create($data);
        Session::clearOld();
        flash('success', 'Modulo criado.');
        redirect(url('admin/modulos'));
    }

    public function edit(array $params): void
    {
        $id = (int) ($params['id'] ?? 0);
        $module = Module::find($id);
        if (!$module) {
            Response::abort(404, 'Modulo nao encontrado.');
        }
        View::render('modules/edit', ['module' => $module], 'layouts/app');
    }

    public function update(array $params): void
    {
        $id = (int) ($params['id'] ?? 0);
        $module = Module::find($id);
        if (!$module) {
            Response::abort(404, 'Modulo nao encontrado.');
        }

        $data = [
            'name' => trim((string) Request::input('name')),
            'sort_order' => Request::input('sort_order') ?: 0,
            'description' => trim((string) Request::input('description')),
        ];

        $errors = Validator::validate($data, [
            'name' => 'required',
        ]);

        if (!empty($errors)) {
            set_old_input($data);
            flash('error', 'Nome do modulo e obrigatorio.');
            redirect(url('admin/modulos/' . $id . '/editar'));
        }

        Module::update($id, $data);
        Session::clearOld();
        flash('success', 'Modulo atualizado.');
        redirect(url('admin/modulos'));
    }
}
