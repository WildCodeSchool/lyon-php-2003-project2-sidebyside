<?php


namespace App\Controller;

use App\Model\CategoryManager;
use App\Model\CollabManager;
use App\Model\MessageManager;
use App\Model\ProjectManager;
use App\Model\RequestManager;
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
            $description = trim($_POST['description']);
            $deadline = trim($_POST['deadline']);
            $zipCode = trim($_POST['zip_code']);
            $categoryId = $_POST['category'];
            $bannerImage = $_FILES['banner_image'];
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
            } else {
                $project['banner_image'] = '/assets/images/project_img.jpg';
            }
            if (empty($errors)) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $connectedUser = $_SESSION['id'];
                    $projectManager->insert($project, $connectedUser);
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
        $collabManager = new CollabManager();
        $collaborators = $collabManager->selectOneByProjectId($id);
        $isCollaborator = false;
        $isRequest = false;
        $userInfo = [];
        $userManager = new UserManager();
        $projectOwner = $userManager->selectOneById($projectOwner['id']);
        $requestManager = new RequestManager();
        $requests = $requestManager->selectRequestForCollaboration($id);

        foreach ($collaborators as $collaborator) {
            if ($collaborator['user_id'] == $_SESSION['id']) {
                $isCollaborator = true;
            }
        }

        foreach ($requests as $request) {
            if ($request['user_id'] == $_SESSION['id']) {
                $isRequest = true;
            }
        }

        if (!empty($requests)) {
            foreach ($requests as $key => $request) {
                $userInfo[$key] = [
                    $userManager->selectOneById($request['user_id']),
                    $request
                ];
            }

            return $this->twig->render(
                'Project/show.html.twig',
                [
                    'project' => $project, 'id' => $id, 'currentProject' => $currentProject,
                    'similarProjects' => $similarProjects, 'projectOwner' => $projectOwner,
                    'isCollaborator' => $isCollaborator, 'userInfo' => $userInfo,
                    'isRequest' => $isRequest
                ]
            );
        }

        return $this->twig->render(
            'Project/show.html.twig',
            [
                'project' => $project, 'id' => $id, 'currentProject' => $currentProject,
                'similarProjects' => $similarProjects, 'projectOwner' => $projectOwner,
                'isCollaborator' => $isCollaborator, 'isRequest' => $isRequest
            ]
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

    public function manage($id)
    {
        $projectManager = new ProjectManager();
        $requestManager = new RequestManager();
        $requests = $requestManager->selectRequestForCollaboration($id);
        $project = $projectManager->selectOneById($id);
        $userManager = new UserManager();
        $projectOwner = $userManager->selectOneById($project['project_owner_id']);
        $userManager = new UserManager();
        $skillManager = new SkillManager();
        $messageMagager = new MessageManager();
        $messages = $messageMagager->selectByProject($id);
        $userInfo = [];
        $errorsArray = [];

        if (!empty($_POST)) {
            $postedMessage = [
                'author' => $_POST['author'],
                'to_project' => $_POST['to_project'],
                'message' => trim($_POST['message'])
            ];

            if (empty($postedMessage['message'])) {
                $errorsArray['empty'] = 'Champ requis';
            }

            if (empty($errorsArray)) {
                $messageMagager->createToProject($postedMessage);
                header("Location: /Project/manage/$id");
            }
        }

        if (!empty($requests)) {
            foreach ($requests as $key => $request) {
                $userInfo[$key] = $userManager->selectOneById($request['user_id']);
                $userInfo[$key]['skills'] = $skillManager->getAllForUser($request['user_id']);
            }
            return $this->twig->render(
                'Manage/index.html.twig',
                [
                    'requests' => $requests, 'userInfo' => $userInfo,
                    'project' => $project,
                    'projectOwner' => $projectOwner,
                    'messages' => $messages,
                    'errors' => $errorsArray
                ]
            );
        }

        return $this->twig->render(
            'Manage/index.html.twig',
            [
                'userInfo' => $userInfo,
                'project' => $project,
                'projectOwner' => $projectOwner,
                'messages' => $messages
            ]
        );
    }

    public function setCollaborator(int $collaboratorId, int $projectId, string $projectTitle, bool $isValidate)
    {
        $requestManager = new RequestManager();
        $messageManager = new MessageManager();
        if ($isValidate) {
            $requestManager->validateRequest($collaboratorId, $projectId);
            $message = [
                'author' => 1,
                'to_user' => $collaboratorId,
                'message' => 'Vous avez été accepté(e) sur le projet #' . urldecode($projectTitle)
            ];
            $messageManager->createToUser($message);
        } else {
            $requestManager->ignoreRequest($collaboratorId, $projectId);
        }

        header('Location: /Project/manage/' . $projectId . '/');
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
            $requestManager = new RequestManager();
            $userManager = new UserManager();
            $skillManager = new SkillManager();
            $project = $projectManager->selectOneById($id);
            $projectOwner = $project['project_owner_id'];
            $projectOwner = $projectManager->selectProjectOwner($projectOwner);
            $currentUserInfo = $userManager->getUserInfo($userId);
            $skills = $skillManager->selectAll();
            $errorsArray = [];

            if (!empty($_POST)) {
                if (empty($_POST['ask-message'])) {
                    $errorsArray['empty'] = "Champ requis";
                } else {
                    $message['message'] = trim($_POST['ask-message']);
                    $message['id'] = $userId;
                    $requestManager->askCollaboration($message, $id);
                    $messageManager = new MessageManager();
                    $message = [
                        'author' => 1,
                        'to_user' => $project['project_owner_id'],
                        'message' => $currentUserInfo[0]['first_name'] . ' ' .
                            $currentUserInfo[0]['last_name'] .
                            " souhaite collaborer sur le projet #" .
                            $project['title']
                    ];
                    $messageManager->createToUser($message);

                    header("Location: /project/show/$id");
                }
            }

            return $this->twig->render('Project/ask-collaboration.html.twig', ['project' => $project,
                'projectOwner' => $projectOwner, 'currentUserInfo' => $currentUserInfo,
                'skills' => $skills, 'errors' => $errorsArray]);
        }
    }
}
