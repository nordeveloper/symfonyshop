<?php

namespace App\Controller\Dashboard;

use App\Entity\News;
use App\Form\NewsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;

/**
 * @Route("/dashboard/news")
 */
class NewsController extends BaseController
{
    /**
     * @Route("/", name="dashboard_news_index", methods={"GET"})
     */
    public function index(): Response
    {
        $news = $this->getDoctrine()
            ->getRepository(News::class)
            ->findAll();

        return $this->render('dashboard/news/index.html.twig', [
            'news' => $news, 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/new", name="news_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            //$news->setCreatedBy( $this->getUser()->getId() );
            
            $previewImage = $request->files->get('news')['preview_image'];
            $detailImage = $request->files->get('news')['detail_image'];

            if($detailImage){
                $fileName = $fileUploader->upload($detailImage);                
                $news->setDetailImage($fileName);
                $news->setPreviewImage($fileName);
            }else{
                if($previewImage){
                    $fileName = $fileUploader->upload($previewImage);
                    $news->setPreviewImage($fileName);
                }
            }          
           
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($news);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard_news_index');
        }

        return $this->render('dashboard/news/new.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="dashboard_news_show", methods={"GET"})
     */
    public function show(News $news): Response
    {
        return $this->render('dashboard/news/show.html.twig', [
            'news' => $news, 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}/edit", name="news_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, News $news, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $previewImage = $request->files->get('news')['preview_image'];
            $detailImage = $request->files->get('news')['detail_image'];

            if($detailImage){
                $fileName = $fileUploader->upload($detailImage);                
                $news->setDetailImage($fileName);
                $news->setPreviewImage($fileName);
            }else{
                if($previewImage){
                    $fileName = $fileUploader->upload($previewImage);
                    $news->setPreviewImage($fileName);
                }
            }            
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dashboard_news_index', [
                'id' => $news->getId(),
            ]);
        }

        return $this->render('dashboard/news/edit.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="news_delete", methods={"DELETE"})
     */
    public function delete(Request $request, News $news): Response
    {
        if ($this->isCsrfTokenValid('delete'.$news->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($news);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dashboard_news_index');
    }
}
