<?php

class DashboardController
{
    public function home(): void
    {
        redirect(url('dashboard'));
    }

    public function index(): void
    {
        $db = App::db();
        $stats = [];

        $stats[] = [
            'label' => 'Inscricoes pendentes',
            'value' => RBAC::can('inscriptions.view_any') ? Inscription::pendingCount() : '-',
            'hint' => 'Pedidos aguardando avaliacao',
        ];
        $stats[] = [
            'label' => 'Pessoas',
            'value' => RBAC::can('people.view_any') ? (int) ($db->fetch('SELECT COUNT(*) as total FROM people')['total'] ?? 0) : '-',
            'hint' => 'Cadastros ativos',
        ];
        $stats[] = [
            'label' => 'Usuarios',
            'value' => RBAC::can('users.view_any') ? (int) ($db->fetch('SELECT COUNT(*) as total FROM users')['total'] ?? 0) : '-',
            'hint' => 'Acesso ao sistema',
        ];
        $stats[] = [
            'label' => 'Polos',
            'value' => RBAC::can('poles.view_any') ? (int) ($db->fetch('SELECT COUNT(*) as total FROM poles')['total'] ?? 0) : '-',
            'hint' => 'Unidades cadastradas',
        ];

        $actions = [];
        if (RBAC::can('inscriptions.view_any')) {
            $actions[] = ['label' => 'Ver inscricoes', 'url' => url('admin/inscricoes')];
        }
        if (RBAC::can('users.create')) {
            $actions[] = ['label' => 'Novo usuario', 'url' => url('admin/usuarios/novo')];
        }
        if (RBAC::can('poles.create')) {
            $actions[] = ['label' => 'Novo polo', 'url' => url('admin/polos/novo')];
        }

        View::render('dashboard/index', [
            'stats' => $stats,
            'actions' => $actions,
        ], 'layouts/app');
    }
}
