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
    public function listAction()
    {
        $posts = $this->getDoctrine()->getRepository('AppBundle\Entity\RedditPost')->findAll();
        return $this->render('reddit/index.html.twig', ['posts' => $posts]);
    }

    /**
     * @Route("/scraper", name="scraper")
     */
    public function scraperAction()
    {
        $result = $this->get('reddit_scraper')->scrape();

        dump($result);

        return $this->render('reddit/index.html.twig', []);
    }



}
