<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Projects;
use App\Form\Type\ProjectType;
use Abraham\TwitterOAuth\TwitterOAuth;
use Twitter\Text\Autolink;


class AdminController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function Index()
    {
        $oauth = new TwitterOAuth("example", "example");
        $accessToken = $oauth->oauth2('oauth2/token', ['grant_type' => 'client_credentials']);

        $twitter = new TwitterOAuth("example", "example", null, $accessToken->access_token);
        $tweets = $twitter->get('statuses/user_timeline', ['screen_name' => 'screen_name', 'exclude_replies' => 'true', 'count' => '5']);


        return $this->render('home/home.html.twig', [
            'tweets' => $tweets
        ]);
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
