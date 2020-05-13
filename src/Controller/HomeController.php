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
        $skills = $userManager->getSkills();

        return $this->twig->render(
            'Home/index.html.twig',
            ['users' => $users, 'skills' => $skills, 'projects'=>$projects]
        );
    }


    public function search()
    {
        $isSearched = true;
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
                [
                    'users' => $users, 'skills' => $skills, 'isSearched' => $isSearched,
                    'projects' => $projects, 'keyword' => $keyword
                ]
            );
        }
    }

    public function cgu()
    {
        return $this->twig->render(
            'Home/cgu.html.twig'
        );
    }

    public function notFound()
    {
        return $this->twig->render(
            'Home/404.html.twig'
        );
    }
}
