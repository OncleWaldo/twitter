<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Post;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;




class PostFixtures extends Fixture 
{


    public function load(ObjectManager $manager)
    
    {

        $post = new Post();
        $post->setTitle("tony");
        $post->setContent("dupond");
        $post->setPostedAt(new \DateTime("2020-11-01 08:00"));
        $post->setComments("gfdg");
        $post->setLikes("gdfg");
        $manager->persist($post);

        $post = new Post();
        $post->setTitle("tony");
        $post->setContent("dupond");
        $post->setPostedAt(new \DateTime("2020-11-01 08:00"));
        $post->setComments("hgfhfg");
        $post->setLikes("ciool");
        $manager->persist($post);
        
        
        $manager->flush();
        
    }
    
}