<?php

$router->get('/', [DashboardController::class, 'home'], ['auth' => true]);
$router->get('/dashboard', [DashboardController::class, 'index'], ['auth' => true]);

$router->get('/login', [AuthController::class, 'showLogin'], ['guest' => true]);
$router->post('/login', [AuthController::class, 'login'], ['guest' => true]);
$router->post('/logout', [AuthController::class, 'logout'], ['auth' => true]);

$router->get('/inscricao', [InscriptionController::class, 'publicForm'], ['guest' => true]);
$router->post('/inscricao', [InscriptionController::class, 'submit'], ['guest' => true]);

$router->get('/admin/inscricoes', [InscriptionController::class, 'index'], ['auth' => true, 'permission' => 'inscriptions.view_any']);
$router->get('/admin/inscricoes/{id}', [InscriptionController::class, 'show'], ['auth' => true, 'permission' => 'inscriptions.view']);
$router->post('/admin/inscricoes/{id}/review', [InscriptionController::class, 'review'], ['auth' => true, 'permission' => 'inscriptions.review']);
$router->post('/admin/inscricoes/{id}/approve', [InscriptionController::class, 'approve'], ['auth' => true, 'permission' => 'inscriptions.approve']);
$router->post('/admin/inscricoes/{id}/reject', [InscriptionController::class, 'reject'], ['auth' => true, 'permission' => 'inscriptions.reject']);

$router->get('/admin/usuarios', [UserController::class, 'index'], ['auth' => true, 'permission' => 'users.view_any']);
$router->get('/admin/usuarios/novo', [UserController::class, 'create'], ['auth' => true, 'permission' => 'users.create']);
$router->post('/admin/usuarios', [UserController::class, 'store'], ['auth' => true, 'permission' => 'users.create']);
$router->get('/admin/usuarios/{id}/editar', [UserController::class, 'edit'], ['auth' => true, 'permission' => 'users.update']);
$router->post('/admin/usuarios/{id}', [UserController::class, 'update'], ['auth' => true, 'permission' => 'users.update']);
$router->post('/admin/usuarios/{id}/desativar', [UserController::class, 'disable'], ['auth' => true, 'permission' => 'users.disable']);
$router->get('/minha-conta', [UserController::class, 'account'], ['auth' => true, 'permission' => 'users.view_self']);
$router->post('/minha-conta/senha', [UserController::class, 'updatePassword'], ['auth' => true, 'permission' => 'users.update_own_credentials']);

$router->get('/admin/pessoas', [PersonController::class, 'index'], ['auth' => true, 'permission' => 'people.view_any']);
$router->get('/admin/pessoas/novo', [PersonController::class, 'create'], ['auth' => true, 'permission' => 'people.create']);
$router->post('/admin/pessoas', [PersonController::class, 'store'], ['auth' => true, 'permission' => 'people.create']);
$router->get('/admin/pessoas/{id}', [PersonController::class, 'show'], ['auth' => true, 'permission' => 'people.view']);
$router->get('/admin/pessoas/{id}/editar', [PersonController::class, 'edit'], ['auth' => true, 'permission' => 'people.update']);
$router->post('/admin/pessoas/{id}', [PersonController::class, 'update'], ['auth' => true, 'permission' => 'people.update']);

$router->get('/admin/polos', [PoleController::class, 'index'], ['auth' => true, 'permission' => 'poles.view_any']);
$router->get('/admin/polos/novo', [PoleController::class, 'create'], ['auth' => true, 'permission' => 'poles.create']);
$router->post('/admin/polos', [PoleController::class, 'store'], ['auth' => true, 'permission' => 'poles.create']);
$router->get('/admin/polos/{id}/editar', [PoleController::class, 'edit'], ['auth' => true, 'permission' => 'poles.update']);
$router->post('/admin/polos/{id}', [PoleController::class, 'update'], ['auth' => true, 'permission' => 'poles.update']);
$router->post('/admin/polos/{id}/desativar', [PoleController::class, 'disable'], ['auth' => true, 'permission' => 'poles.disable']);

$router->get('/admin/modulos', [ModuleController::class, 'index'], ['auth' => true, 'permission' => 'modules.view_any']);
$router->get('/admin/modulos/novo', [ModuleController::class, 'create'], ['auth' => true, 'permission' => 'modules.create']);
$router->post('/admin/modulos', [ModuleController::class, 'store'], ['auth' => true, 'permission' => 'modules.create']);
$router->get('/admin/modulos/{id}/editar', [ModuleController::class, 'edit'], ['auth' => true, 'permission' => 'modules.update']);
$router->post('/admin/modulos/{id}', [ModuleController::class, 'update'], ['auth' => true, 'permission' => 'modules.update']);

$router->get('/admin/modalidades', [ModalityController::class, 'index'], ['auth' => true, 'permission' => 'modalities.view_any']);
$router->get('/admin/modalidades/novo', [ModalityController::class, 'create'], ['auth' => true, 'permission' => 'modalities.create']);
$router->post('/admin/modalidades', [ModalityController::class, 'store'], ['auth' => true, 'permission' => 'modalities.create']);
$router->get('/admin/modalidades/{id}/editar', [ModalityController::class, 'edit'], ['auth' => true, 'permission' => 'modalities.update']);
$router->post('/admin/modalidades/{id}', [ModalityController::class, 'update'], ['auth' => true, 'permission' => 'modalities.update']);
