<?php

namespace App\Controller\Dashboard;

use App\Entity\Certificates;
use App\Form\CertificatesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;

/**
 * @Route("/dashboard/certificates")
 */
class CertificatesController extends BaseController
{
    /**
     * @Route("/", name="dashboard_certificates_index", methods={"GET"})
     */
    public function index(): Response
    {
        $certificates = $this->getDoctrine()
            ->getRepository(Certificates::class)
            ->findAll();

        return $this->render('dashboard/certificates/index.html.twig', [
            'certificates' => $certificates, 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/new", name="certificates_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $certificate = new Certificates();
        $form = $this->createForm(CertificatesType::class, $certificate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $certificate->setCreatedBy( $this->getUser()->getId() );
            
            $previewImage = $request->files->get('certificates')['previewImage'];
            if($previewImage){
                $fileName = $fileUploader->upload($previewImage);
                $certificate->setPreviewImage($fileName); 
            }

            $detailImage = $request->files->get('certificates')['detailImage'];
            if($detailImage){
                $fileName = $fileUploader->upload($detailImage);
                $certificate->setDetailImage($fileName); 
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($certificate);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard_certificates_index');
        }

        return $this->render('dashboard/certificates/new.html.twig', [
            'certificate' => $certificate,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="dashboard_certificates_show", methods={"GET"})
     */
    public function show(Certificates $certificate): Response
    {
        return $this->render('dashboard/certificates/show.html.twig', [
            'certificate' => $certificate, 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}/edit", name="certificates_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Certificates $certificate, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(CertificatesType::class, $certificate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $certificate->setCreatedBy( $this->getUser()->getId() );
            
            $previewImage = $request->files->get('certificates')['previewImage'];
            if($previewImage){
                $fileName = $fileUploader->upload($previewImage);
                $certificate->setPreviewImage($fileName); 
            }

            $detailImage = $request->files->get('certificates')['detailImage'];
            if($detailImage){
                $fileName = $fileUploader->upload($detailImage);
                $certificate->setDetailImage($fileName); 
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dashboard_certificates_index', [
                'id' => $certificate->getId(),
            ]);
        }

        return $this->render('dashboard/certificates/edit.html.twig', [
            'certificate' => $certificate,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="certificates_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Certificates $certificate): Response
    {
        if ($this->isCsrfTokenValid('delete'.$certificate->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($certificate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dashboard_certificates_index');
    }
}
