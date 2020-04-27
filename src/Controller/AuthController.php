<?php


namespace App\Controller;

class AuthController extends AbstractController
{
    public function signIn()
    {
        return $this->twig->render('Auth/signin.html.twig');
    }
}
