<?php

spl_autoload_register(function ($class) {
    $class = trim($class, '\\');
    $paths = [
        base_path('app/core/' . $class . '.php'),
        base_path('app/controllers/' . $class . '.php'),
        base_path('app/models/' . $class . '.php'),
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require $path;
            return;
        }
    }
});
