<?php

namespace App\Controller\Dashboard;

use App\Entity\OrdersStatus;
use App\Form\OrdersStatusType;
use App\Repository\OrdersStatusRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/orders_status")
 */
class OrdersStatusController extends BaseController
{
    /**
     * @Route("/", name="orders_status_index", methods={"GET"})
     */
    public function index(OrdersStatusRepository $ordersStatusRepository): Response
    {
        return $this->render('dashboard/orders_status/index.html.twig', [
            'orders_statuses' => $ordersStatusRepository->findAll(), 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/new", name="orders_status_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ordersStatus = new OrdersStatus();
        $form = $this->createForm(OrdersStatusType::class, $ordersStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ordersStatus);
            $entityManager->flush();

            return $this->redirectToRoute('orders_status_index');
        }

        return $this->render('dashboard/orders_status/new.html.twig', [
            'orders_status' => $ordersStatus,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="orders_status_show", methods={"GET"})
     */
    public function show(OrdersStatus $ordersStatus): Response
    {
        return $this->render('dashboard/orders_status/show.html.twig', [
            'orders_status' => $ordersStatus,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="orders_status_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OrdersStatus $ordersStatus): Response
    {
        $form = $this->createForm(OrdersStatusType::class, $ordersStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('orders_status_index', [
                'id' => $ordersStatus->getId(),
            ]);
        }

        return $this->render('dashboard/orders_status/edit.html.twig', [
            'orders_status' => $ordersStatus,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="orders_status_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OrdersStatus $ordersStatus): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ordersStatus->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ordersStatus);
            $entityManager->flush();
        }

        return $this->redirectToRoute('orders_status_index');
    }
}
