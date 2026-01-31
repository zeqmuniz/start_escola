<?php

require __DIR__ . '/../app/bootstrap.php';

$router = new Router();
require base_path('app/routes.php');

$router->dispatch(Request::method(), Request::path());
