<?php

namespace App\Controller;

class ManageController extends AbstractController
{

    public function index()
    {
        return $this->twig->render('Manage/index.html.twig');
    }
}
