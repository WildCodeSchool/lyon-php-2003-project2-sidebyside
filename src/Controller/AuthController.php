<?php

namespace App\Controller;

use App\Model\AuthManager;
use App\Model\UserManager;

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

    public function signup()
    {
        $errorArray = [];
        $userPostArray = [
            'first_name' => '',
            'last_name' => '',
            'email' => ''
        ];

        if (!empty($_POST)) {
            $profilController = new ProfilController();
            $userPostArray = $profilController->trimPost($_POST);

            $errorArray = $this->verifyPost($userPostArray);

            $passwordHached = password_hash($userPostArray['password'], PASSWORD_DEFAULT);
            if ($this->verifyPassword($userPostArray['password_check'], $passwordHached) != null) {
                $errorArray['post']['pwd'] = $this->verifyPassword($userPostArray['password_check'], $passwordHached);
            }

            //check if an image is upload
            $userPostArray['profil_picture'] = null;
            if (!empty($_FILES['profil_picture']['name'])) {
                $path = UploadController::uploadProfilImage($_FILES);
                $userPostArray['profil_picture'] = $path['profil_picture'];

                if ($path == null) {
                    $errorArray['upload'] = 'Taille trop grande ou mauvais format';
                }
            } else {
                $userPostArray['profil_picture'] = '/assets/images/detective840x500.jpg';
            }

            if (empty($errorArray)) {
                $userPostArray['password'] = $passwordHached;
                $userManager = new UserManager();
                $userManager->create($userPostArray);

                $auth = new AuthManager();
                $user = $auth->signIn($userPostArray['email']);
                $this->startSession($user);
                header('Location: /Home/index');
            }
        }

        return $this->twig->render(
            'Auth/signUp.html.twig',
            ['errors' => $errorArray, 'user' => $userPostArray]
        );
    }

    public function logout()
    {
        unset($_SESSION['id']);
        session_destroy();
        header('Location: / ');
    }

    public function verifyPassword(string $password, string $passwordHached)
    {
        $passwordCheck = password_verify($password, $passwordHached);

        //if 2 passwords are different => error pwd
        if (!$passwordCheck) {
            return 'Mauvais mot de passe';
        } elseif (empty($password)) {
            return 'Champ requis';
        }
    }

    public function verifyPost(array $postArray): array
    {
        $errorArray = [];

        foreach ($postArray as $key => $value) {
            if (empty($value) && $key != "skills") {
                $errorArray['post'][$key] = 'Champ requis';
            }
        }
        return $errorArray;
    }
}
