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
