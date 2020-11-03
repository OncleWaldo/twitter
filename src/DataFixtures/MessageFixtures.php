<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Message;




class MessageFixtures extends Fixture 
{


    public function load(ObjectManager $manager)
    
    {

        $message = new Message();
        $message->setSenderId("tony");
        $message->setReceiverId("dupond");
        $message->setContent("yoyoyo");
        $message->setSentAt(new \DateTime("2020-11-01 08:00"));
        $manager->persist($message);

        // $post = new Post();
        // $post->setTitle("tony");
        // $post->setContent("dupond");
        // $post->setPostedAt(new \DateTime("2020-11-01 08:00"));
        // $post->setComments("hgfhfg");
        // $post->setLikes("ciool");
        // $manager->persist($post);
        
        
        $manager->flush();
        
    }
    
}