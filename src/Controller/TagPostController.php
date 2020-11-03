<?php

namespace App\Controller;

use App\Entity\TagPost;
use App\Form\TagPostType;
use App\Repository\TagPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tag_post")
 */
class TagPostController extends AbstractController
{
    /**
     * @Route("/", name="tag_post_index", methods={"GET"})
     */
    public function index(TagPostRepository $tagPostRepository): Response
    {
        return $this->render('tag_post/index.html.twig', [
            'tag_posts' => $tagPostRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tag_post_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tagPost = new TagPost();
        $form = $this->createForm(TagPostType::class, $tagPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tagPost);
            $entityManager->flush();

            return $this->redirectToRoute('tag_post_index');
        }

        return $this->render('tag_post/new.html.twig', [
            'tag_post' => $tagPost,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tag_post_show", methods={"GET"})
     */
    public function show(TagPost $tagPost): Response
    {
        return $this->render('tag_post/show.html.twig', [
            'tag_post' => $tagPost,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tag_post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TagPost $tagPost): Response
    {
        $form = $this->createForm(TagPostType::class, $tagPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tag_post_index');
        }

        return $this->render('tag_post/edit.html.twig', [
            'tag_post' => $tagPost,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tag_post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TagPost $tagPost): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tagPost->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tagPost);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tag_post_index');
    }
}
