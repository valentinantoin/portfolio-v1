<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\ProjectLike;
use App\Entity\Projects;
use App\Form\Type\ProjectType;
use App\Repository\ProjectLikeRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProjectsController
 * @package App\Controller
 */
class ProjectsController extends AbstractController
{
    /**
     * @Route("/projects", name="projects")
     */
    public function projects()
    {
        $repo = $this->getDoctrine()->getRepository(Projects::class);
        $projects = $repo->findAll();

        return $this->render('projects/projects.html.twig', [
            'projects' => $projects
        ]);
    }

    /**
     * @Route("/project/{id}", name="project")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function project($id)
    {
        $repoProject = $this->getDoctrine()->getRepository(Projects::class);
        $project = $repoProject->find($id);

        $repoComment = $this->getDoctrine()->getRepository(Comments::class);
        $comments = $repoComment->findBy(['projectId' => $id]);

        return $this->render('projects/project.html.twig', [
            'project' => $project,
        'comments' => $comments
        ]);
    }

    /**
     * @Route("/admin/create", name="create")
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createProject(Request $request, ObjectManager $manager)
    {
        if($this->isGranted('ROLE_ADMIN')) {

        $project = new Projects();

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($project);
            $manager->flush();

            $this->addFlash('notice', 'Votre projet est bien enregistré !');

            $this->redirectToRoute('dashboard');
        }

        return $this->render('admin/create.html.twig', [
            'form' => $form->createView()
        ]);

        }else {

            return $this->redirectToRoute('connection');
        }
    }

    /**
     * @Route("/admin/delete/{id}", name="delete")
     * @param Projects $project
     *@return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteProject(Projects $project)
    {
        if($this->isGranted('ROLE_ADMIN')) {

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($project);

        $manager->flush();

        return $this->redirectToRoute('projects');

        }else {
            return $this->redirectToRoute('connection');
        }
    }

    /**
     * @Route("/admin/update/{id}", name="update")
     * @param Request $request
     * @param ObjectManager $manager
     * @param Projects $project
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateProject(Request $request,ObjectManager $manager, Projects $project)
    {
        if($this->isGranted('ROLE_ADMIN')) {

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager->flush();

            $this->addFlash('update', 'Votre projet est bien modifié !');

            $this->redirectToRoute('dashboard');
        }

        return $this->render('admin/update.html.twig', [
            'project' => $project,
            'form' => $form->createView()
        ]);
    }else {
            return $this->redirectToRoute('connection');
          }
    }

    /**
     *
     * @Route("/project/{id}/like", name="project_like")
     * @param Projects $Project
     * @param ProjectLikeRepository $likeRepo
     * @param ObjectManager $manager
     * @return Response
     */
    public function like(Projects $Project, ProjectLikeRepository $likeRepo, ObjectManager $manager): Response
    {
        $user = $this->getUser();

        if(!$user)
        {
            return $this->json([
                'code' => 403,
                'message' => 'Connectez vous pour liker'
            ], 403);
        }

        else if($Project->isLikedByUser($user))
        {
            $like = $likeRepo->findOneBy([
                'Project' => $Project,
                'user' => $user
            ]);

            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like bien supprimé',
                'likes' => $likeRepo->count(['Project' => $Project])
            ], 200);

        } else {
            $like = new ProjectLike();

            $like->setProject($Project)
                 ->setUser($user);

            $manager->persist($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like bien ajouté',
                'likes' => $likeRepo->count(['Project' => $Project])
            ], 200);
        }
    }
}
