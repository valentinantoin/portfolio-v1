<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Projects;
use App\Form\Type\ProjectType;


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
