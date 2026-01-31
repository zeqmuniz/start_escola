<?php

class View
{
    public static function render(string $view, array $data = [], ?string $layout = null): void
    {
        $viewFile = base_path('app/views/' . $view . '.php');
        if (!file_exists($viewFile)) {
            Response::abort(500, 'View nao encontrada.');
        }

        extract($data, EXTR_SKIP);
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        if ($layout) {
            $layoutFile = base_path('app/views/' . $layout . '.php');
            if (!file_exists($layoutFile)) {
                echo $content;
                Session::clearOld();
                return;
            }
            require $layoutFile;
            Session::clearOld();
            return;
        }

        echo $content;
        Session::clearOld();
    }
}
