<?php
/**
 * Created by PhpStorm.
 * User: stijnblommerde
 * Date: 12/03/17
 * Time: 20:52
 */

namespace AppBundle\Service;


use AppBundle\Entity\RedditAuthor;
use AppBundle\Entity\RedditPost;
use Doctrine\ORM\EntityManagerInterface;

class RedditScraper
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function scrape()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.reddit.com/r/php.json');
        $contents = json_decode($response->getBody()->getContents(), true);

        foreach($contents['data']['children'] as $child) {
            $redditPost = new RedditPost();
            $redditPost->setTitle($child['data']['title']);
            $redditAuthor = new RedditAuthor();
            $redditAuthor->setName($child['data']['author']);

            $this->em->persist($redditPost);
            $this->em->persist($redditAuthor);
        }

        $this->em->flush();
    }
}