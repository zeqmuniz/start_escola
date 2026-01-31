<?php

return [
    'permissions' => [
        'inscriptions.view_any' => 'Inscricoes: listar',
        'inscriptions.view' => 'Inscricoes: ver',
        'inscriptions.review' => 'Inscricoes: revisar (sem mudar status)',
        'inscriptions.approve' => 'Inscricoes: aprovar',
        'inscriptions.reject' => 'Inscricoes: rejeitar',

        'people.view_any' => 'Pessoas: listar',
        'people.view' => 'Pessoas: ver',
        'people.create' => 'Pessoas: criar',
        'people.update' => 'Pessoas: editar',

        'users.view_any' => 'Usuarios: listar',
        'users.view_self' => 'Usuarios: ver proprio',
        'users.create' => 'Usuarios: criar',
        'users.update' => 'Usuarios: editar',
        'users.update_own_credentials' => 'Usuarios: editar credenciais proprias',
        'users.disable' => 'Usuarios: desativar',

        'poles.view_any' => 'Polos: listar',
        'poles.create' => 'Polos: criar',
        'poles.update' => 'Polos: editar',
        'poles.disable' => 'Polos: desativar',

        'modules.view_any' => 'Modulos: listar',
        'modules.create' => 'Modulos: criar',
        'modules.update' => 'Modulos: editar',

        'modalities.view_any' => 'Modalidades: listar',
        'modalities.create' => 'Modalidades: criar',
        'modalities.update' => 'Modalidades: editar',

        'lessons.view_any' => 'Aulas: listar',
        'lessons.view_own' => 'Aulas: ver proprias',
        'lessons.create' => 'Aulas: criar',
        'lessons.update' => 'Aulas: editar',

        'classes.view_any' => 'Turmas: listar',
        'classes.view_own' => 'Turmas: ver proprias',
        'classes.create' => 'Turmas: criar',
        'classes.update' => 'Turmas: editar',
        'classes.status' => 'Turmas: alterar status',

        'enrollments.view_any' => 'Matriculas: listar',
        'enrollments.view_own' => 'Matriculas: ver proprias',
        'enrollments.create' => 'Matriculas: criar',
        'enrollments.update' => 'Matriculas: editar',
        'enrollments.situation' => 'Matriculas: alterar situacao',

        'attendance.view_any' => 'Frequencia: listar',
        'attendance.view_own' => 'Frequencia: ver propria',
        'attendance.create' => 'Frequencia: criar',
        'attendance.update' => 'Frequencia: editar',

        'reports.view_any' => 'Relatorios: listar',
    ],
    'roles' => [
        'admin' => 'Administrador Geral',
        'coordinator' => 'Coordenador',
        'secretary' => 'Secretario',
        'professor' => 'Professor',
        'student' => 'Aluno',
    ],
    'role_permissions' => [
        'admin' => [
            'inscriptions.view_any','inscriptions.view','inscriptions.review','inscriptions.approve','inscriptions.reject',
            'people.view_any','people.view','people.create','people.update',
            'users.view_any','users.view_self','users.create','users.update','users.update_own_credentials','users.disable',
            'poles.view_any','poles.create','poles.update','poles.disable',
            'modules.view_any','modules.create','modules.update',
            'modalities.view_any','modalities.create','modalities.update',
            'lessons.view_any','lessons.view_own','lessons.create','lessons.update',
            'classes.view_any','classes.view_own','classes.create','classes.update','classes.status',
            'enrollments.view_any','enrollments.view_own','enrollments.create','enrollments.update','enrollments.situation',
            'attendance.view_any','attendance.view_own','attendance.create','attendance.update',
            'reports.view_any',
        ],
        'coordinator' => [
            'inscriptions.view_any','inscriptions.view','inscriptions.review','inscriptions.approve','inscriptions.reject',
            'people.view_any','people.view',
            'users.view_any','users.view_self','users.update_own_credentials',
            'lessons.view_any','lessons.view_own',
            'classes.view_any','classes.view_own','classes.create','classes.update','classes.status',
            'enrollments.view_any','enrollments.view_own','enrollments.create','enrollments.update','enrollments.situation',
            'attendance.view_any','attendance.view_own',
        ],
        'secretary' => [
            'inscriptions.view_any','inscriptions.view','inscriptions.review','inscriptions.approve','inscriptions.reject',
            'people.view_any','people.view','people.create','people.update',
            'users.view_any','users.view_self','users.create','users.update','users.update_own_credentials','users.disable',
            'lessons.view_any','lessons.view_own','lessons.create','lessons.update',
            'classes.view_any','classes.view_own','classes.create','classes.update','classes.status',
            'enrollments.view_any','enrollments.view_own','enrollments.create','enrollments.update','enrollments.situation',
            'attendance.view_any','attendance.view_own','attendance.create','attendance.update',
        ],
        'professor' => [
            'people.view',
            'users.view_self','users.update_own_credentials',
            'lessons.view_any','lessons.view_own',
            'classes.view_any','classes.view_own',
        ],
        'student' => [
            'people.view',
            'users.view_self','users.update_own_credentials',
            'classes.view_own',
            'enrollments.view_own',
            'attendance.view_own',
        ],
    ],
];
