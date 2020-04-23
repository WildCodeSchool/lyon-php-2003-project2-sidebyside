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
        $skillManager = new SkillManager();
        $skills = $skillManager->getAllSkills();
        $info = $userManager->getUserInfo($id);
        $skillsUser = $skillManager->getAllUserSkills();
        echo  $id;
        var_dump($info);
        return $this->twig->render(
            'Profil/edit-user-profil.html.twig',
            ['info' => $info, 'allSkillsAvailable' => $skills, 'skillsUser' => $skillsUser]
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
        if (isset($_POST['skills'])) {
            $profil['skills'] = $post['skills'];
        }
        return $profil;
    }

    public function setUser($id)
    {
        $errors = null;
        if (!empty($_POST)) {
            $userId = $id;
            $profil = $this->trimPost($_POST);
            foreach ($profil as $key => $value) {
                if ((empty($value) && $key !== "skills")) {
                    $errors[$key] = "Ce champ est requis";
                }
            }

            if (empty($errors)) {
                $userManager = new UserManager();
                if (!empty($_FILES['profil_picture']['name'] || $_FILES['banner_image']['name'])) {
                    $upload = new UploadController();
                    $path = $upload->uploadProfilImage($_FILES);
                    $userManager->updateUserImg($path, $userId);
                }
                $userManager->setUserInfo($profil, $userId);
                $userManager->deleteSkillUser($userId);
                if (!empty($profil['skills'])) {
                    $userManager->insertSkillUser($profil, $userId);
                }
                //header("Location: /profil/getuser/$id");
            }
        }
    }
}
