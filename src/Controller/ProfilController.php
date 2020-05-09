<?php

namespace App\Controller;

use App\Model\ProjectManager;
use App\Model\RequestManager;
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
        $projectManager = new ProjectManager();
        $userProjects = [
            $projectManager->selectByOwnerId($id),
            $projectManager->selectIWorkOnByUserId($id)
        ];
        $skills = $userManager->getSkills();
        $userManager = new UserManager();
        $requestManager = new RequestManager();
        $userInfo = [];
        $currentUser['description'] = explode("\n", $currentUser['description']);

        if (isset($userProjects[0])) {
            foreach ($userProjects[0] as $key => $myProject) {
                if (!empty($myProject['id'])) {
                    $requests[$key] = $requestManager->selectRequestForCollaboration($myProject['id']);
                }
            }
        }

        if (!empty($requests)) {
            $index = 0;
            foreach ($requests as $key => $request) {
                if (!empty($request[0]['user_id'])) {
                    $userInfo[$index] = [
                        $userManager->selectOneById($request[0]['user_id']),
                        $request[0]
                    ];
                    $index++;
                }
            }

            return $this->twig->render(
                'Profil/user-profil.html.twig',
                [
                    'current_user' => $currentUser, 'skills' => $skills,
                    'projects' => $userProjects, 'userInfo' => $userInfo
                ]
            );
        }

        return $this->twig->render(
            'Profil/user-profil.html.twig',
            ['current_user' => $currentUser, 'skills' => $skills, 'projects' => $userProjects]
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
                header("Location: /profil/user/$id");
            }
            return $errors;
        }
    }
}
