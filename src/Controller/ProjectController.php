<?php


namespace App\Controller;

use App\Model\ProjectManager;

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
        $title = $bannerImage = $description = $deadline = $zipCode = '';

        if (!empty($_POST)) {
            $title = trim($_POST['title']);
            $bannerImage = trim($_POST['banner_image']);
            $description = trim($_POST['description']);
            $deadline = trim($_POST['deadline']);
            $zipCode = trim($_POST['zip_code']);

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
                    $projects = [
                        'title' => $title,
                        'banner_image' => $bannerImage,
                        'description' => $description,
                        'deadline' => $deadline,
                        'zip_code' => $zipCode,
                    ];
                    $projectsManager->insert($projects);
                    header('Location:/Home/index');
                }
            }
        }
            return $this->twig->render('Project/add.html.twig', ['errors' => $errors]);
    }
}
