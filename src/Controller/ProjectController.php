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

            return $this->twig->render('Project/add.html.twig', ['errors' => $errors, 'projects'=>$projects]);
    }

    /**
     * Display project informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show($id)
    {
        $projectManager = new ProjectManager();
        $projects = $projectManager->selectOneById($id);

        return $this->twig->render('Project/show.html.twig', ['projects' => $projects]);
    }


    /**
     * Display project edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit($id): string
    {
        $projectManager = new ProjectManager();
        $projects = $projectManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $projects['title'] = $_POST['title'];
            $projects['banner_image'] = $_POST['banner_image'];
            $projects['description'] = $_POST['description'];
            $projects['zip_code'] = $_POST['zip_code'];
            $projects['plan'] = $_POST['plan'];
            $projects['team_description'] = $_POST['team_description'];
            $projects['deadline'] = $_POST['deadline'];
            $projectManager->update($projects);
        }

        return $this->twig->render('Project/edit.html.twig', ['projects' => $projects]);
    }
}
