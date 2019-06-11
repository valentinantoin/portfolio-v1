<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Comments;
use App\Entity\Projects;
use App\Form\Type\CommentType;
use App\Form\Type\ProjectType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
}
