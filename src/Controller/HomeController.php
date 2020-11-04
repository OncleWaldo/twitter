<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;
use App\Entity\Comment;
use App\Repository\PostRepository;
use App\Form\HomeType;


class HomeController extends AbstractController
{
    

    /**
    * @Route("/", name="root", methods={"GET","POST"})
    */
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();   
        $posts = $em->getRepository(Post::class)->findAll();
        
        $submittedToken = $request->request->get('token');
        $submittedContent = $request->request->get('content');
        $submittedPostId = $request->request->get('postid');

        $comment = new Comment();
      

        if ($this->isCsrfTokenValid('comment_new', $submittedToken) && $submittedPostId !== NULL ) {

                $post = $em->getRepository(Post::class)->find((int) $submittedPostId);
                $comment->setContent($submittedContent);
                $comment->setUser($this->getUser());
                $comment->setPost($post);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($comment);
                $entityManager->flush();
                return $this->redirectToRoute('root');
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            "posts" => $posts,
        ]);
    }
}


