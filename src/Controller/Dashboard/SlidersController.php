<?php

namespace App\Controller\Dashboard;

use App\Entity\Sliders;
use App\Form\SlidersType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\HttpFoundation\File\File;
use App\Service\FileUploader;

/**
 * @Route("/dashboard/sliders")
 */
class SlidersController extends BaseController
{
    /**
     * @Route("/", name="dashboard_sliders_index", methods={"GET"})
     */
    public function index(): Response
    {
        $sliders = $this->getDoctrine()
            ->getRepository(Sliders::class)
            ->findAll();

        return $this->render('dashboard/sliders/index.html.twig', [
            'sliders' => $sliders, 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/new", name="sliders_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $slider = new Sliders();
        $form = $this->createForm(SlidersType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $slider->setCreatedBy( $this->getUser()->getId() );

            $previewImage = $request->files->get('sliders')['previewImage'];
            if($previewImage){
                $fileName = $fileUploader->upload($previewImage);
                $slider->setPreviewImage($fileName); 
            }

            $detailImage = $request->files->get('sliders')['detailImage'];
            if($detailImage){
                $fileName = $fileUploader->upload($detailImage);
                $slider->setDetailImage($fileName); 
            }             
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($slider);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard_sliders_index');
        }

        return $this->render('dashboard/sliders/new.html.twig', [
            'slider' => $slider,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="dashboard_sliders_show", methods={"GET"})
     */
    public function show(Sliders $slider): Response
    {
        return $this->render('dashboard/sliders/show.html.twig', [
            'slider' => $slider, 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sliders_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sliders $slider, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(SlidersType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $slider->setCreatedBy( $this->getUser()->getId() );

            $previewImage = $request->files->get('sliders')['previewImage'];
            if($previewImage){
                $fileName = $fileUploader->upload($previewImage);
                $slider->setPreviewImage($fileName); 
            }

            $detailImage = $request->files->get('sliders')['detailImage'];
            if($detailImage){
                $fileName = $fileUploader->upload($detailImage);
                $slider->setDetailImage($fileName); 
            }  

            $this->getDoctrine()->getManager()->flush();

            /*
            return $this->redirectToRoute('dashboard_sliders_index', [
                'id' => $slider->getId(),
            ]);*/
        }

        return $this->render('dashboard/sliders/edit.html.twig', [
            'slider' => $slider,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="sliders_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sliders $slider): Response
    {
        if ($this->isCsrfTokenValid('delete'.$slider->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($slider);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dashboard_sliders_index');
    }
}
