<?php

class PersonController
{
    public function index(): void
    {
        $people = Person::all();
        View::render('people/index', ['people' => $people], 'layouts/app');
    }

    public function create(): void
    {
        View::render('people/create', [], 'layouts/app');
    }

    public function store(): void
    {
        $data = [
            'full_name' => trim((string) Request::input('full_name')),
            'cpf' => trim((string) Request::input('cpf')),
            'email' => trim((string) Request::input('email')),
            'phone' => trim((string) Request::input('phone')),
            'birth_date' => Request::input('birth_date') ?: null,
            'gender' => trim((string) Request::input('gender')),
        ];

        $errors = Validator::validate($data, [
            'full_name' => 'required',
            'email' => 'email',
        ]);

        if (!empty($errors)) {
            set_old_input($data);
            flash('error', 'Preencha os campos obrigatorios.');
            redirect(url('admin/pessoas/novo'));
        }

        Person::create($data);
        Session::clearOld();
        flash('success', 'Pessoa criada.');
        redirect(url('admin/pessoas'));
    }

    public function show(array $params): void
    {
        $id = (int) ($params['id'] ?? 0);
        $person = Person::find($id);
        if (!$person) {
            Response::abort(404, 'Pessoa nao encontrada.');
        }

        $user = Auth::user();
        if (!RBAC::can('people.view_any') && $user && (int) ($user['person_id'] ?? 0) !== $id) {
            Response::abort(403, 'Acesso negado.');
        }

        View::render('people/show', ['person' => $person], 'layouts/app');
    }

    public function edit(array $params): void
    {
        $id = (int) ($params['id'] ?? 0);
        $person = Person::find($id);
        if (!$person) {
            Response::abort(404, 'Pessoa nao encontrada.');
        }
        View::render('people/edit', ['person' => $person], 'layouts/app');
    }

    public function update(array $params): void
    {
        $id = (int) ($params['id'] ?? 0);
        $person = Person::find($id);
        if (!$person) {
            Response::abort(404, 'Pessoa nao encontrada.');
        }

        $data = [
            'full_name' => trim((string) Request::input('full_name')),
            'cpf' => trim((string) Request::input('cpf')),
            'email' => trim((string) Request::input('email')),
            'phone' => trim((string) Request::input('phone')),
            'birth_date' => Request::input('birth_date') ?: null,
            'gender' => trim((string) Request::input('gender')),
        ];

        $errors = Validator::validate($data, [
            'full_name' => 'required',
            'email' => 'email',
        ]);

        if (!empty($errors)) {
            set_old_input($data);
            flash('error', 'Preencha os campos obrigatorios.');
            redirect(url('admin/pessoas/' . $id . '/editar'));
        }

        Person::update($id, $data);
        Session::clearOld();
        flash('success', 'Pessoa atualizada.');
        redirect(url('admin/pessoas'));
    }
}
