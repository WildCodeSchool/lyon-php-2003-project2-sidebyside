<?php

namespace App\Controller;

use App\Model\SkillManager;
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

            if (empty($keyword)) {
                $errorsArray['keyword'] = '1 caractère minimum';
            }

            $userManager = new UserManager();
            $skills = $userManager->getSkills();
            $users = $userManager->selectByWord($keyword);
            return $this->twig->render('Profil/profils.html.twig', ['users' => $users, 'skills' => $skills]);
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

    public function updateUser($id)
    {
        $userManager = new UserManager();
        $skillManager = new SkillManager();
        $skills = $skillManager->getAllSkills();
        $info = $userManager->getUserInfo($id);
        $skillsUser = $skillManager->getAllUserSkills();
        $errors = [];

        if (!empty($_POST)) {
            $errors = $this->setUser($id, $_POST);
            if (isset($_SESSION['id'])) {
                $connectedUser = $userManager->selectOneById($_SESSION['id']);
                $_SESSION['profil_picture'] = $connectedUser['profil_picture'];
            }
        }

        return $this->twig->render(
            'Profil/edit-user-profil.html.twig',
            ['info' => $info, 'allSkillsAvailable' => $skills, 'skillsUser' => $skillsUser, 'errors' => $errors]
        );
    }

    public function trimPost(array $post)
    {
        $profil = [];
        foreach ($post as $key => $value) {
            if ($key !== "skills") {
                $profil[$key] = trim($value);
            }
            $profil["skills"] = "";
        }
        if (isset($post['skills'])) {
            $profil['skills'] = $post['skills'];
        }
        return $profil;
    }

    public function setUser(int $id, array $post)
    {
        $errors = null;
        if (!empty($post)) {
            $userId = $id;
            $profil = $this->trimPost($post);

            $errors = $this->postVerif($profil);

            $userManager = new UserManager();
            if (!empty($_FILES['profil_picture']['name'] || $_FILES['banner_image']['name'])) {
                $upload = new UploadController();
                $path = $upload->uploadProfilImage($_FILES);
                if ($path == null) {
                    $errors['upload'] = 'Taille trop grande ou mauvais format';
                } else {
                    $userManager->updateUserImg($path, $userId);
                }
            }

            if (empty($errors)) {
                $userManager->setUserInfo($profil, $userId);
                $userManager->deleteSkillUser($userId);
                if (!empty($profil['skills'])) {
                    $userManager->insertSkillUser($profil, $userId);
                }
                header("Location: /profil/user/$id");
            }
        }
        return $errors;
    }

    public function postVerif(array $profil)
    {
        $errors = null;
        foreach ($profil as $key => $value) {
            if ((empty($value) && $key !== "skills" && $key !== "description")) {
                $errors[$key] = "Ce champ est requis";
            }
        }
        return $errors;
    }
}
