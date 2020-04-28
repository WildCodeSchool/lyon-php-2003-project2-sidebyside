<?php


namespace App\Controller;

use App\Model\ProjectManager;
use App\Model\UserManager;

class ProjectController extends AbstractController
{

    /**
     * Display projects creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function new()
    {
        $errors = [];
        $projects = [];
        $title = $bannerImage = $description = $deadline = $zipCode = '';

        if (!empty($_POST)) {
            $title = trim($_POST['title']);
            $bannerImage = trim($_POST['banner_image']);
            $description = trim($_POST['description']);
            $deadline = trim($_POST['deadline']);
            $zipCode = trim($_POST['zip_code']);

            $projects = [
                'title' => $title,
                'banner_image' => $bannerImage,
                'description' => $description,
                'deadline' => $deadline,
                'zip_code' => $zipCode,
            ];

            if (empty($title)) {
                $errors['title'] = 'Ce Champ est Requis';
            }

            if (empty($description)) {
                $errors['description'] = 'Ce Champ est Requis';
            }

            if (empty($deadline)) {
                $errors['deadline'] = 'Ce Champ est Requis';
            }

            if (empty($zipCode)) {
                $errors['zip_code'] = 'Ce Champ est Requis';
            }

            if (empty($errors)) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $projectsManager = new ProjectManager();
                    $projectsManager->insert($projects);
                    header('Location:/Home/index');
                }
            }
        }

        return $this->twig->render('Project/add.html.twig', ['errors' => $errors, 'projects' => $projects]);
    }


    public function show($id)
    {
        $projectManager = new ProjectManager();
        $currentProject = $projectManager->selectOneById($id);
        $similarProjects = $projectManager->selectAllExceptCurrent($id);
        $projectOwner = $projectManager->selectProjectOwner($id);

        return $this->twig->render(
            'Project/show.html.twig',
            ['currentProject' => $currentProject, 'similarProjects' => $similarProjects,
                'projectOwner' => $projectOwner]
        );
    }
}
