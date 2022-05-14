<?php

namespace App\Controller\Dashboard;

use App\Entity\Delivery;
use App\Form\DeliveryType;
use App\Repository\DeliveryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/delivery")
 */
class DeliveryController extends BaseController
{
    /**
     * @Route("/", name="dashboard_delivery_index", methods={"GET"})
     */
    public function index(DeliveryRepository $deliveryRepository): Response
    {
        return $this->render('dashboard/delivery/index.html.twig', [
            'deliveries' => $deliveryRepository->findAll(),'user'=>$this->user
        ]);
    }

    /**
     * @Route("/new", name="dashboard_delivery_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $delivery = new Delivery();
        $form = $this->createForm(DeliveryType::class, $delivery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($delivery);
            $entityManager->flush();

            return $this->redirectToRoute('delivery_index');
        }

        return $this->render('dashboard/delivery/new.html.twig', [
            'delivery' => $delivery,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="dashboard_delivery_show", methods={"GET"})
     */
    public function show(Delivery $delivery): Response
    {
        return $this->render('dashboard/delivery/show.html.twig', [
            'delivery' => $delivery,'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dashboard_delivery_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Delivery $delivery): Response
    {
        $form = $this->createForm(DeliveryType::class, $delivery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('delivery_index', [
                'id' => $delivery->getId(),
            ]);
        }

        return $this->render('dashboard/delivery/edit.html.twig', [
            'delivery' => $delivery,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="dashboard_delivery_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Delivery $delivery): Response
    {
        if ($this->isCsrfTokenValid('delete'.$delivery->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($delivery);
            $entityManager->flush();
        }

        return $this->redirectToRoute('delivery_index');
    }
}
