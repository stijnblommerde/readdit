<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RedditPost;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RedditController extends Controller
{
    /**
     * @Route("/", name="list")
     */
    public function indexAction()
    {
        $posts = $this->getDoctrine()->getRepository('AppBundle\Entity\RedditPost')->findAll();
        return $this->render('reddit/index.html.twig', ['posts' => $posts]);
    }

    /**
     * @Route("/create/{text}", name="create")
     */
    public function createAction($text)
    {
        // em = Entity Manager
        $em = $this->getDoctrine()->getManager();

        $post = new RedditPost();
        $post->setTitle('Hello ' . $text);

        $em->persist($post);
        $em->flush();

        return $this->redirectToRoute('list');
    }

    /**
     * @Route("/update/{id}/{text}", name="update")
     */
    public function updateAction($id, $text)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $this->getDoctrine()->getRepository('AppBundle\Entity\RedditPost')->find($id);

        if (!$post) {
            throw $this->createNotFoundException(
                'No post found for id ' . $id
            );
        }
        $post->setTitle($text);
        $em->flush();

        return $this->redirectToRoute('list');
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $this->getDoctrine()->getRepository('AppBundle\Entity\RedditPost')->find($id);

        if (!$post) {
            throw $this->createNotFoundException(
                'No post found for id ' . $id
            );
        }
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('list');
    }

}
