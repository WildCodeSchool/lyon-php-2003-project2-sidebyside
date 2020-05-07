<?php


namespace App\Controller;

use App\Model\CategoryManager;
use App\Model\ProjectManager;
use App\Model\UserManager;
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

        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAll();
        $projectManager = new ProjectManager();
        $skillManager = new SkillManager();
        $skills = $skillManager->selectAll();
        $errors = [];
        $project = [];
        $title = $bannerImage = $description = $deadline = $zipCode = $categoryId = $skillsId = '';

        if (!empty($_POST)) {
            $title = trim($_POST['title']);
            $bannerImage = $_FILES['banner_image'];
            $description = trim($_POST['description']);
            $deadline = trim($_POST['deadline']);
            $zipCode = trim($_POST['zip_code']);
            $categoryId = $_POST['category'];
            if (isset($_POST['skills'])) {
                $skillsId = $_POST['skills'];
            }

            $project = [
                'title' => $title,
                'banner_image' => $bannerImage,
                'description' => $description,
                'deadline' => $deadline,
                'zip_code' => $zipCode,
                'category_id' => $categoryId,
                'skills' => $skillsId
            ];

            $errors = $this->postVerify($project);

            if (!empty($_FILES['banner_image']['name'])) {
                $path = UploadController::uploadProjectImage($_FILES);
                if ($path != null) {
                    $project['banner_image'] = $path['banner_image'];
                } else {
                    $errors['upload'] = "Taille trop grande ou mauvais format";
                }
            }
            if (empty($errors)) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $id = $_SESSION['id'];
                    $projectManager->insert($project, $id);
                    $lastId = $projectManager->selectLastProject();
                    $skillManager->insertSkills($project, $lastId['id']);
                    header('Location:/Home/index');
                }
            }
        }
        return $this->twig->render(
            'Project/add.html.twig',
            ['errors' => $errors, 'project' => $project, 'categories' => $categories, 'skills' => $skills]
        );
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
        $category = $categoryManager->getCategory($project['category_id']);
        $skillManager = new SkillManager();
        $projectSkills = $skillManager->getAllForProject($id);
        $project['skills'] = $projectSkills; //Ajoute directement les skills au tableau project
        $project['category'] = $category;
        $currentProject = $projectManager->selectOneById($id);
        $similarProjects = $projectManager->selectAllExceptCurrent($id);
        $projectOwner = $projectManager->selectProjectOwner($id);

        return $this->twig->render(
            'Project/show.html.twig',
            ['project' => $project, 'id' => $id, 'currentProject' => $currentProject,
                'similarProjects' => $similarProjects, 'projectOwner' => $projectOwner]
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
        $category = $categoryManager->getCategory($project['category_id']);
        $categories = $categoryManager->selectAll();
        $skillManager = new SkillManager();
        $projectSkills = $skillManager->getAllForProject($id);
        $skills = $skillManager->selectAll();
        $project['skills'] = $projectSkills; //Ajoute directement les skills au tableau project
        $project['category'] = $category;

        $errors = [];
        $title = $description = $zipCode = "";
        $plan = $deadline = $teamDescription = $categoryId = $skillsId = "";

        if (!empty($_POST)) {
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);
            $zipCode = trim($_POST['zip_code']);
            $plan = trim($_POST['plan']);
            $deadline = trim($_POST['deadline']);
            $teamDescription = trim($_POST['team_description']);
            $categoryId = $_POST['category'];
            if (isset($_POST['skills'])) {
                $skillsId = $_POST['skills'];
            }

            $updatedProject = [
                'id' => $id,
                'title' => $title,
                'description' => $description,
                'zip_code' => $zipCode,
                'plan' => $plan,
                'team_description' => $teamDescription,
                'deadline' => $deadline,
                'category_id' => $categoryId,
                'skills' => $skillsId
            ];

            $errors = $this->postVerify($updatedProject);

            if (!empty($_FILES['banner_image']['name'])) {
                $upload = new UploadController();
                $path = $upload->uploadProjectImage($_FILES);
                if ($path != null) {
                    $updatedProject['banner_image'] = $path['banner_image'];
                    $projectManager->updateProjectImg($path, $id);
                } else {
                    $errors['upload'] = "Taille trop grande ou mauvais format";
                }
            }

            if (empty($errors)) {
                $projectManager->update($updatedProject);
                $skillManager->updateSkillsForProject($updatedProject, $id);

                header('Location: /Project/show/' . $id . '/');
            }
        }
        return $this->twig->render(
            'Project/edit.html.twig',
            ['project' => $project, 'errors' => $errors, 'id' => $id, 'categories' => $categories, 'skills' => $skills]
        );
    }

    public function postVerify(array $postProject): array
    {
        $errors = [];

        if (empty($postProject['title'])) {
            $errors['title'] = 'Ce Champ est Requis';
        }

        if (empty($postProject['description'])) {
            $errors['description'] = 'Ce Champ est Requis';
        }

        if (empty($postProject['deadline'])) {
            $errors['deadline'] = 'Ce Champ est Requis';
        }

        if (empty($postProject['category_id'])) {
            $errors['category_id'] = 'Ce Champ est Requis';
        }

        if (empty($postProject['skills'])) {
            $errors['skills'] = 'Ce Champ est Requis';
        }
        return $errors;
    }

    public function all()
    {
        $projectManager = new ProjectManager();
        $projects = $projectManager->selectAll();

        return $this->twig->render('Project/projects.html.twig', ['projects' => $projects]);
    }

    // FUNCTION FOR COLLABORATION
    public function askCollaboration($id)
    {
        $acces = $this->acces($_SESSION);
        if ($acces) {
            $userId = $_SESSION['id'];
            $projectManager = new ProjectManager();
            $userManager = new UserManager();
            $skillManager = new SkillManager();
            $project = $projectManager->selectOneById($id);
            $projectOwner = $project['project_owner_id'];
            $projectOwner = $projectManager->selectProjectOwner($projectOwner);
            $currentUserInfo = $userManager->getUserInfo($userId);
            $skills = $skillManager->selectAll();

            if (!empty($_POST)) {
                $message['message'] = trim($_POST['ask-message']);
                $message['id'] = $userId;
                $projectManager->askCollaboration($message, $id);
                header("Location: /project/show/$id");
            }

            return $this->twig->render('Project/ask-collaboration.html.twig', ['project' => $project,
                'projectOwner' => $projectOwner, 'currentUserInfo' => $currentUserInfo,
                'skills' => $skills]);
        }
    }
}
