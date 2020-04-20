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
        $userManager = new UserManager();
        $currentUser = $userManager->selectOneById($id);
        $info = $userManager->getUserInfo();
        return $this->twig->render(
            'Profil/edit-user-profil.html.twig',
            ['current_user' => $currentUser, 'info' => $info]
        );
    }
}
