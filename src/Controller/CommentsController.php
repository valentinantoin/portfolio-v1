<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Projects;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class CommentsController
 * @package App\Controller
 */
class CommentsController extends AbstractController
{
    /**
     * @Route("/createcomment/{id}", name="createComment")
     * @param Request $request
     * @param ObjectManager $manager
     * @param Security $security
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function createComment(Request $request, ObjectManager $manager, Security $security, $id)
    {
        $comment = new Comments();

        if($request->isMethod('post')){
            $content = $request->request->get("content");

            /**$user = $this->get('session')->get('username');*/
            $user = $security->getUser();

            $repoProject = $this->getDoctrine()->getRepository(Projects::class);
            $project = $repoProject->find($id);

            $comment->setContent($content)
                    ->setProjectId($project)
                    ->setUsername($user)
                    ->setCreationDate(new \Datetime());

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('project',['id' => $id]);

            }else {

            return $this->render('home/home.html.twig');
        }
    }
}
