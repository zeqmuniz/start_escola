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
        $user = Auth::user();
        $stats = [];

        if (RBAC::can('inscriptions.view_any')) {
            $stats[] = [
                'label' => 'Inscricoes pendentes',
                'value' => Inscription::pendingCount(),
                'hint' => 'Pedidos aguardando avaliacao',
            ];
        }
        if (RBAC::can('people.view_any')) {
            $stats[] = [
                'label' => 'Pessoas',
                'value' => (int) ($db->fetch('SELECT COUNT(*) as total FROM people')['total'] ?? 0),
                'hint' => 'Cadastros ativos',
            ];
        }
        if (RBAC::can('users.view_any')) {
            $stats[] = [
                'label' => 'Usuarios',
                'value' => (int) ($db->fetch('SELECT COUNT(*) as total FROM users')['total'] ?? 0),
                'hint' => 'Acesso ao sistema',
            ];
        }
        if (RBAC::can('poles.view_any')) {
            $stats[] = [
                'label' => 'Polos',
                'value' => (int) ($db->fetch('SELECT COUNT(*) as total FROM poles')['total'] ?? 0),
                'hint' => 'Unidades cadastradas',
            ];
        }

        if ($user && !$this->currentHasRole('admin') && $this->currentHasRole('coordinator')) {
            $pole = Pole::findByCoordinator((int) $user['id']);
            $stats[] = [
                'label' => 'Seu polo',
                'value' => $pole ? $pole['name'] : '-',
                'hint' => $pole ? 'Polo atribuido a voce' : 'Nenhum polo atribuido',
            ];
        }

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
}
