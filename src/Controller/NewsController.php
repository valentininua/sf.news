<?php

namespace App\Controller;

use App\Entity\News;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{

//    public function __construct(
//        private NewsRepository $newsRepository
//    )
//    {
//    }
//
//    #[Route('/news', name: 'app_news')]
//    public function index(): Response
//    {
////        dd($this->newsRepository->test());
//
////            dd($this->newsRepository->findAll());
////        public function findAllField(): ?News
//
//
//        return $this->render('news/index.html.twig', [
//            'controller_name' => 'NewsController',
//        ]);
//    }

    #[Route('/news', defaults: ['page' => '1', '_format' => 'html'], methods: ['GET'], name: 'news_index')]
    #[Route('/news/page/{page<[1-9]\d*>}', defaults: ['_format' => 'html'], methods: ['GET'], name: 'news_index_paginated')]
    #[Cache(smaxage: 10)]
    public function index(int $page, NewsRepository $news): Response
    {
        $latestPosts = $news->findLatest($page);

        return $this->render('news/index.html.twig', [
            'paginator' => $latestPosts,
        ]);
    }

    /**
     * Deletes a Post entity.
     */
    #[Route('/news/{id}/delete', name: 'news_post_delete', methods: ['POST'])]
    #[IsGranted("ROLE_ADMIN", message: "not found", statusCode: 404)]
    public function delete(Request $request, News $news, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('news_index');
        }
//
//        // Delete the tags associated with this blog post. This is done automatically
//        // by Doctrine, except for SQLite (the database used in this application)
//        // because foreign key support is not enabled by default in SQLite
//        //$post->getTags()->clear();
//
        $entityManager->remove($news);
        $entityManager->flush();
////
////        $this->addFlash('success', 'post.deleted_successfully');
//
        return $this->redirectToRoute('news_index');
    }
}
