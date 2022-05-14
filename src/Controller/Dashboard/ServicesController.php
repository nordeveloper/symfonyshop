<?php

namespace App\Controller\Dashboard;

use App\Entity\Services;
use App\Form\ServicesType;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/services")
 */
class ServicesController extends BaseController
{
    /**
     * @Route("/", name="dashboard_services_index", methods={"GET"})
     */
    public function index(): Response
    {
        $services = $this->getDoctrine()
            ->getRepository(Services::class)
            ->findAll();

        return $this->render('dashboard/services/index.html.twig', [
            'services' => $services, 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/new", name="services_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $service = new Services();
        $form = $this->createForm(ServicesType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $service->setCreatedBy( $this->getUser()->getId() );

            $previewImage = $request->files->get('service')['previewImage'];
            if($previewImage){
                $fileName = $fileUploader->upload($previewImage);
                $service->setPreviewImage($fileName);
            }

            $detailImage = $request->files->get('service')['detailImage'];
            if($detailImage){
                $fileName = $fileUploader->upload($detailImage);
                $service->setDetailImage($fileName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('services_index');
        }

        return $this->render('dashboard/services/new.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="dashboard_services_show", methods={"GET"})
     */
    public function show(Services $service): Response
    {
        return $this->render('dashboard/services/show.html.twig', [
            'service' => $service, 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}/edit", name="services_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Services $service, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(ServicesType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $previewImage = $request->files->get('service')['previewImage'];
            if($previewImage){
                $fileName = $fileUploader->upload($previewImage);
                $service->setPreviewImage($fileName);
            }

            $detailImage = $request->files->get('service')['detailImage'];
            if($detailImage){
                $fileName = $fileUploader->upload($detailImage);
                $service->setDetailImage($fileName);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dashboard_services_index', [
                'id' => $service->getId(),
            ]);
        }

        return $this->render('dashboard/services/edit.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="services_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Services $service): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($service);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dashboard_services_index');
    }
}
