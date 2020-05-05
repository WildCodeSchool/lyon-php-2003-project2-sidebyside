<?php


namespace App\Controller;

use App\Model\AuthManager;

class AuthController extends AbstractController
{
    public function signIn()
    {
        if (!empty($_POST)) {
            $email = trim($_POST['email']);
            $pass = trim($_POST['password']);
            $auth = new AuthManager();
            $user = $auth->signIn($email);
            $error = null;
            if (!$user) {
                $error['email'] = "Désolé, nous n'avons pas trouvé de compte avec cette adresse e-mail. 
                                    Veuillez réessayer !";
            } else {
                $passwordCheck = password_verify($pass, $user['password']);
                if (!$passwordCheck) {
                    $error['pass'] = "Le mot de passe ne correspond pas avec ce compte. 
                                        Veuillez réessayer !";
                }
            }
            if (empty($error)) {
                $this->startSession($user);
                header("Location: /");
            }
            return $this->twig->render('Auth/signin.html.twig', ['user' => $user, 'error' => $error]);
        }
        return $this->twig->render('Auth/signin.html.twig');
    }

    public function startSession(array $user)
    {
        $_SESSION['id'] = $user['id'];
        $_SESSION['profil_picture'] = $user['profil_picture'];
    }
}
