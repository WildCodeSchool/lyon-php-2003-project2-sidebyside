<?php


namespace App\Controller;

use App\Model\CategoryManager;
use App\Model\ProjectManager;
use App\Model\SkillManager;

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


    /**
     * Display project information specified by $id
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
        $project = $projectManager->selectOneById($id);
        $categoryManager = new CategoryManager();
        $category = $categoryManager->getCategory($id);
        $skillManager = new SkillManager();
        $skills = $skillManager->getAllForProject($id);
        $project['skills'] = $skills; //Ajoute directement les skills au tableau project
        $project['category'] = $category;
        //var_dump($project);
        var_dump($category);
        return $this->twig->render(
            'Project/show.html.twig',
            ['project' => $project, 'id' => $id]
        );
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
        $project = $projectManager->selectOneById($id);
        $categoryManager = new CategoryManager();
        $category = $categoryManager->getCategory($id);
        $categories = $categoryManager->selectAll();
        $skillManager = new SkillManager();
        $skills = $skillManager->getAllForProject($id);
        $project['skills'] = $skills; //Ajoute directement les skills au tableau project
        $project['category'] = $category;
        var_dump($project);
        var_dump($categories);


        $errors = [];
        $title = $bannerImage = $description = $zipCode = $plan = $deadline = $teamDescription = " ";

        if (!empty($_POST)) {
            $title = trim($_POST['title']);
            $bannerImage = trim($_POST['banner_image']);
            $description = trim($_POST['description']);
            $zipCode = trim($_POST['zip_code']);
            $plan = trim($_POST['plan']);
            $deadline = trim($_POST['deadline']);
            $teamDescription = trim($_POST['team_description']);



            $project = [
                'id' => $id,
                'title' => $title,
                'banner_image' => $bannerImage,
                'description' => $description,
                'zip_code' => $zipCode,
                'plan' => $plan,
                'team_description' => $teamDescription,
                'deadline' => $deadline,
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

            if (empty($errors)) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $projectManager->update($project);
                    header('Location: /Project/show/' . $id . '/');
                }
            }
        }
        return $this->twig->render(
            'Project/edit.html.twig',
            ['project' => $project, 'errors' => $errors, 'id' => $id, 'categories' => $categories ]
        );
    }
}
