<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\ProjectManager;
use App\Model\UserManager;

class HomeController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {

        $projectManager = new ProjectManager();
        $projects = $projectManager->selectAll();
       
        $userManager = new UserManager();
        $users = $userManager->selectAll();
        $nbUsers = count($users);
        $skills = $userManager->getSkills();

        return $this->twig->render(
            'Home/index.html.twig',
            ['users' => $users, 'nbUsers' => $nbUsers, 'skills' => $skills, 'projects'=>$projects]
        );
    }

    public function search()
    {
        $is_searched = true;
        $errorsArray = [];

        if (!empty($_POST)) {
            $keyword = trim($_POST['search']);

            if (empty($keyword)) {
                $errorsArray['keyword'] = '1 caractère minimum';
            }

            $projectManager = new ProjectManager();
            $projects = $projectManager->selectByWord($keyword);

            $userManager = new UserManager();
            $skills = $userManager->getSkills();
            $users = $userManager->selectByWord($keyword);

            return $this->twig->render(
                'Home/index.html.twig',
                ['users' => $users, 'skills' => $skills, 'is_searched' => $is_searched, 'projects' => $projects]
            );
        }
    }
}
