<?php

class PoleController
{
    public function index(): void
    {
        $poles = Pole::all();
        View::render('poles/index', ['poles' => $poles], 'layouts/app');
    }

    public function create(): void
    {
        View::render('poles/create', [], 'layouts/app');
    }

    public function store(): void
    {
        $data = [
            'name' => trim((string) Request::input('name')),
            'address' => trim((string) Request::input('address')),
            'status' => Request::input('status') ?: 'active',
        ];

        $errors = Validator::validate($data, [
            'name' => 'required',
        ]);

        if (!empty($errors)) {
            set_old_input($data);
            flash('error', 'Nome do polo e obrigatorio.');
            redirect(url('admin/polos/novo'));
        }

        Pole::create($data);
        Session::clearOld();
        flash('success', 'Polo criado.');
        redirect(url('admin/polos'));
    }

    public function edit(array $params): void
    {
        $id = (int) ($params['id'] ?? 0);
        $pole = Pole::find($id);
        if (!$pole) {
            Response::abort(404, 'Polo nao encontrado.');
        }
        View::render('poles/edit', ['pole' => $pole], 'layouts/app');
    }

    public function update(array $params): void
    {
        $id = (int) ($params['id'] ?? 0);
        $pole = Pole::find($id);
        if (!$pole) {
            Response::abort(404, 'Polo nao encontrado.');
        }

        $data = [
            'name' => trim((string) Request::input('name')),
            'address' => trim((string) Request::input('address')),
            'status' => Request::input('status') ?: 'active',
        ];

        $errors = Validator::validate($data, [
            'name' => 'required',
        ]);

        if (!empty($errors)) {
            set_old_input($data);
            flash('error', 'Nome do polo e obrigatorio.');
            redirect(url('admin/polos/' . $id . '/editar'));
        }

        Pole::update($id, $data);
        Session::clearOld();
        flash('success', 'Polo atualizado.');
        redirect(url('admin/polos'));
    }

    public function disable(array $params): void
    {
        $id = (int) ($params['id'] ?? 0);
        $pole = Pole::find($id);
        if (!$pole) {
            Response::abort(404, 'Polo nao encontrado.');
        }
        Pole::disable($id);
        flash('success', 'Polo desativado.');
        redirect(url('admin/polos'));
    }
}
