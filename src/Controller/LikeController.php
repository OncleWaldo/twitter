<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Comment;
use App\Entity\Post;
use App\Form\LikeType;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/like")
 */
class LikeController extends AbstractController
{
    /**
     * @Route("/", name="like_index", methods={"GET"})
     */
    public function index(LikeRepository $likeRepository): Response
    {
        return $this->render('like/index.html.twig', [
            'likes' => $likeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="like_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        // retrieve Entity Manager from doctrine
        $em = $this->getDoctrine()->getManager(); 

        // retrieve the current user
        $user = $this->getUser();

        if ($user != NULL) {
            // get params from query string and set o a variable
            $postId = $request->query->get("postid");
            $commentId = $request->query->get("commentid");
            // printf($postId);
            // Create new Like object
            $like = new Like();
            
            // Create the form for the CRUD view
            $form = $this->createForm(LikeType::class, $like);
            $form->handleRequest($request);
        
            // check if post id exist before going to DB to avoid constraint violation 
            if (isset($postId)) {
                // get back the current Post Object
                $post = new Post();
                $post =  $em->getRepository(Post::class)->find((int) $postId);  

                // Check if one exist  already for a user/like/comment set 
                $like =  $em->getRepository(Like::class)->findOneBy(array(
                    "post" => $post,
                    "user" => $user
                ));  
                if (!isset($like)) {
                    $like = new Like();
                }
                // Set the Like object with the current Post Object 
                $like->setPost($post);
                $like->setUser($user);
                // Check if a comment id exist before going to DB to avoid constraint violation 
                if (isset($commentId)) {
                    // Get back the current Comment Object
                    $comment = new Comment();
                    $comment =  $em->getRepository(Comment::class)->find( (int) $commentId);  
                    $like =  $em->getRepository(Like::class)->findOneBy(array(
                        "post" => $post,
                        "user" => $user,
                        "comment" => $comment
                    ));  
                    // Set the Comment Object to the like Object
                    $like->setComment($comment);
                }
                // Persist In DB => SQL = INSERT INTO 
                $em->persist($like);
                $em->flush();
    
                // redirect after action all OK
                return $this->redirectToRoute('root');
            } 

            
    
            // redirect if no post id (meaning that we go on the crud page) 
            return $this->render('like/new.html.twig', [
                'like' => $like,
                'form' => $form->createView(),
            ]);
        }

        // redirect in case the user is not connect 
        $this->addFlash('danger', 'You are not connected to do this action');
        return $this->redirectToRoute('root');
    }

    /**
     * @Route("/{id}", name="like_show", methods={"GET"})
     */
    public function show(Like $like): Response
    {
        return $this->render('like/show.html.twig', [
            'like' => $like,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="like_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Like $like): Response
    {
        $form = $this->createForm(LikeType::class, $like);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('like_index');
        }

        return $this->render('like/edit.html.twig', [
            'like' => $like,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="like_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Like $like): Response
    {
        if ($this->isCsrfTokenValid('delete'.$like->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($like);
            $entityManager->flush();
        }

        return $this->redirectToRoute('like_index');
    }
}
