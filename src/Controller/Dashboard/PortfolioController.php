<?php

namespace App\Controller\Dashboard;

use App\Entity\Portfolio;
use App\Form\PortfolioType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;

/**
 * @Route("/dashboard/portfolio")
 */
class PortfolioController extends BaseController
{
    /**
     * @Route("/", name="dashboard_portfolio_index", methods={"GET"})
     */
    public function index(): Response
    {
        $portfolios = $this->getDoctrine()
            ->getRepository(Portfolio::class)
            ->findAll();

        return $this->render('dashboard/portfolio/index.html.twig', [
            'portfolios' => $portfolios, 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/new", name="portfolio_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $portfolio = new Portfolio();
        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $portfolio->setCreatedBy( $this->getUser()->getId() );

            $previewImage = $request->files->get('portfolio')['previewImage'];
            $detailImage = $request->files->get('portfolio')['detailImage'];

            if($detailImage){
                $fileName = $fileUploader->upload($detailImage);                
                $portfolio->setDetailImage($fileName);
                $portfolio->setPreviewImage($fileName);
            }else{
                if($previewImage){
                    $fileName = $fileUploader->upload($previewImage);
                    $portfolio->setPreviewImage($fileName);
                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($portfolio);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard_portfolio_index');
        }

        return $this->render('dashboard/portfolio/new.html.twig', [
            'portfolio' => $portfolio,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="dashboard_portfolio_show", methods={"GET"})
     */
    public function show(Portfolio $portfolio, FileUploader $fileUploader): Response
    {
        return $this->render('dashboard/portfolio/show.html.twig', [
            'portfolio' => $portfolio, 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}/edit", name="portfolio_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Portfolio $portfolio, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $previewImage = $request->files->get('portfolio')['previewImage'];
            $detailImage = $request->files->get('portfolio')['detailImage'];

            if($detailImage){
                $fileName = $fileUploader->upload($detailImage);                
                $portfolio->setDetailImage($fileName);
                $portfolio->setPreviewImage($fileName);
            }else{
                if($previewImage){
                    $fileName = $fileUploader->upload($previewImage);
                    $portfolio->setPreviewImage($fileName);
                }
            }         
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dashboard_portfolio_index', [
                'id' => $portfolio->getId(),
            ]);
        }

        return $this->render('dashboard/portfolio/edit.html.twig', [
            'portfolio' => $portfolio,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="portfolio_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Portfolio $portfolio): Response
    {
        if ($this->isCsrfTokenValid('delete'.$portfolio->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($portfolio);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dashboard_portfolio_index');
    }
}
