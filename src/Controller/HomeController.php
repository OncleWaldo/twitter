<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;
use App\Repository\PostRepository;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="root")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();   
        $posts = $em->getRepository(Post::class)->findAllWithComments();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            "posts" => $posts
        ]);
    }
}
