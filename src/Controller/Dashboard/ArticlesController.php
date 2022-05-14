<?php

namespace App\Controller\Dashboard;

use App\Entity\Article;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;

/**
 * @Route("/dashboard/articles")
 */
class ArticlesController extends BaseController
{
    /**
     * @Route("/", name="dashboard_articles_index", methods={"GET"})
     */
    public function index(ArticlesRepository $articlesRepository): Response
    {
        return $this->render('dashboard/articles/index.html.twig', [
            'articles' => $articlesRepository->findAll(), 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/new", name="dashboard_articles_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$article->setCreatedBy( $this->getUser()->getId() );

            $previewImage = $request->files->get('articles')['preview_image'];
            $detailImage = $request->files->get('articles')['detail_image'];

            if($detailImage){
                $fileName = $fileUploader->upload($detailImage);                
                $article->setDetailImage($fileName);
                $article->setPreviewImage($fileName);
            }else{
                if($previewImage){
                    $fileName = $fileUploader->upload($previewImage);
                    $article->setPreviewImage($fileName);
                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard_articles_index');
        }

        return $this->render('dashboard/articles/new.html.twig', [
            'item' => $article,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="dashboard_articles_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('dashboard/articles/show.html.twig', [
            'article' => $article, 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dashboard_articles_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $previewImage = $request->files->get('articles')['preview_image'];
            $detailImage = $request->files->get('articles')['detail_image'];

            if($detailImage){
                $fileName = $fileUploader->upload($detailImage);                
                $article->setDetailImage($fileName);
                $article->setPreviewImage($fileName);
            }else{
                if($previewImage){
                    $fileName = $fileUploader->upload($previewImage);
                    $article->setPreviewImage($fileName);
                }
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dashboard_articles_index', [
                'id' => $article->getId(),
            ]);
        }

        return $this->render('dashboard/articles/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="articles_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('articles_index');
    }
}
