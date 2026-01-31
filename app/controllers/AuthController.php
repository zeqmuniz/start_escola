<?php

class AuthController
{
    public function showLogin(): void
    {
        View::render('auth/login', [], 'layouts/guest');
    }

    public function login(): void
    {
        $data = [
            'email' => trim((string) Request::input('email')),
            'password' => (string) Request::input('password'),
        ];
        $errors = Validator::validate($data, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (!empty($errors)) {
            set_old_input(['email' => $data['email']]);
            flash('error', 'Verifique os campos e tente novamente.');
            redirect(url('login'));
        }

        if (!Auth::attempt($data['email'], $data['password'])) {
            set_old_input(['email' => $data['email']]);
            flash('error', 'Credenciais invalidas ou usuario desativado.');
            redirect(url('login'));
        }

        Session::clearOld();
        $user = Auth::user();
        if ($user && (int) ($user['must_change_password'] ?? 0) === 1) {
            flash('warning', 'Defina uma nova senha para continuar.');
            redirect(url('minha-conta'));
        }
        redirect(url('dashboard'));
    }

    public function logout(): void
    {
        Auth::logout();
        redirect(url('login'));
    }
}
