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
        $oauth = new TwitterOAuth("example", "example");
        $accessToken = $oauth->oauth2('oauth2/token', ['grant_type' => 'client_credentials']);

        $twitter = new TwitterOAuth("example", "example", null, $accessToken->access_token);
        $tweets = $twitter->get('statuses/user_timeline', ['screen_name' => 'example', 'exclude_replies' => 'true', 'count' => '5']);

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
