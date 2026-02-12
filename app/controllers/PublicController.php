<?php

class PublicController
{
    public function home(): void
    {
        $modules = Module::all();
        View::render('public/home', ['modules' => $modules, 'pageWide' => true], 'layouts/guest');
    }
}
