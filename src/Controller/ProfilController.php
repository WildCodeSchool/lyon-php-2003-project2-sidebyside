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

    public function search()
    {
        $errorsArray = [];

        if (!empty($_POST)) {

            $keyword = trim($_POST['searched_profil']);
            if (empty($keyword))
                $errorsArray['keyword'] = '1 caractère minimum';

            $userManager = new UserManager();
            $users = $userManager->selectByName($keyword);
            return $this->twig->render('Profil/profils.html.twig', ['users' => $users]);
        }

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
}
