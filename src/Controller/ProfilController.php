<?php

namespace App\Controller;

use App\Model\UserManager;

class ProfilController extends AbstractController
{
    /**
     * Display profils page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function all()
    {
        $userManager = new UserManager();
        $users = $userManager->selectAll();
        $skills = $userManager->getSkills();

        return $this->twig->render('Profil/profils.html.twig', ['users' => $users, 'skills' => $skills]);
    }

    public function user($id)
    {
        $userManager = new UserManager();
        $currentUser = $userManager->selectOneById($id);
        $skills = $userManager->getSkills();

        return $this->twig->render(
            'Profil/user-profil.html.twig',
            ['current_user' => $currentUser, 'skills' => $skills]
        );
    }

    public function getUser($id)
    {
        $userManager = new UserManager();
        $currentUser = $userManager->selectOneById($id);
        $info = $userManager->getUserInfo();
        return $this->twig->render(
            'Profil/edit-user-profil.html.twig',
            ['current_user' => $currentUser, 'info' => $info]
        );
    }

    public function setUser($id)
    {
        $errors = null;

        if (!empty($_POST)) {
            $firstName = trim($_POST['first_name']);
            $lastName = trim($_POST['last_name']);
            $email = trim($_POST['email']);
            $zipCode = trim($_POST['zip_code']);
            $description = trim($_POST['description']);
            $userId = $id;

            $profil = [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $email,
                'zipCode' => $zipCode,
                'description' => $description,
            ];
            if (empty($firstName)) {
                $errors['firstName'] = "Ce champ est requis";
            } elseif (empty($lastName)) {
                $errors['lastName'] = "Ce champ est requis";
            } elseif (empty($email)) {
                $errors['email'] = "Ce champ est requis";
            } elseif (empty($zipCode)) {
                $errors['zipcode'] = "Ce champ est requis";
            } elseif (empty($description)) {
                $errors['description'] = "Ce champ est requis";
            }

            if (empty($errors)) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $userManager = new UserManager();
                    $userManager->setUserInfo($profil, $userId);
                    header("Location: /profil/getuser/$id");
                }
            }
        }
    }
}
