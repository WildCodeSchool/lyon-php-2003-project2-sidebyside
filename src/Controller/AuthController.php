<?php

namespace App\Controller;

use App\Model\UserManager;

class AuthController extends AbstractController
{
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

            foreach ($userPostArray as $key => $value) {
                if (empty($value) && $key != "skills") {
                    $errorArray['post'][$key] = 'Champ requis';
                }
            }

            $passwordHached = password_hash($userPostArray['password'], PASSWORD_DEFAULT);
            $errorArray = $this->verifyPassword($userPostArray['password_check'], $passwordHached);

            //check if an image is upload
            $userPostArray['profil_picture'] = null;
            if (!empty($_FILES['profil_picture']['name']) && empty($errorArray)) {
                $path = UploadController::uploadProfilImage($_FILES);
                $userPostArray['profil_picture'] = $path['profil_picture'];

                if ($path == null) {
                    $errorArray['upload'] = 'Taille trop grande ou mauvais format';
                }
            }

            if (empty($errorArray)) {
                $userPostArray['password'] = $passwordHached;
                $userManager = new UserManager();
                $userManager->create($userPostArray);

                header('Location: /Home/index');
            }
        }

        return $this->twig->render(
            'Auth/signUp.html.twig',
            ['errors' => $errorArray, 'user' => $userPostArray]
        );
    }

    public function verifyPassword(string $password, string $passwordHached)
    {
        $passwordCheck = password_verify($password, $passwordHached);

        //if 2 passwords are different => error pwd
        if (!$passwordCheck) {
            return ['post' => ['pwd' => 'Mauvais mot de passe']];
        }
    }
}
