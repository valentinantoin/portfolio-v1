<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Projects;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Abraham\TwitterOAuth\TwitterOAuth;


class AdminController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function Index()
    {
        return $this->render('home/home.html.twig');
    }

    /**
     * @Route("/admin/dashboard", name="dashboard")
     */
    public function adminIndex()
    {
        $repoProject = $this->getDoctrine()->getRepository(Projects::class);
        $projects = $repoProject->findAll();

        $repoUser = $this->getDoctrine()->getRepository(Users::class);
        $users = $repoUser->findAll();

        return $this->render('admin/dashboard.html.twig', [
            'projects' => $projects,
            'users' => $users
        ]);
    }
}
