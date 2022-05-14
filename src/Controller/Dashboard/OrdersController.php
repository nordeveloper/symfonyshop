<?php

namespace App\Controller\Dashboard;

use App\Entity\Order;
use App\Form\OrdersType;
use App\Entity\Basket;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/orders")
 */
class OrdersController extends BaseController
{
    /**
     * @Route("/", name="dashboard_orders_index", methods={"GET"})
     */
    public function index(): Response
    {
        $orders = $this->getDoctrine()
            ->getRepository(Order::class)
            ->findAll();

        return $this->render('dashboard/orders/index.html.twig', [
            'orders' => $orders, 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/new", name="dashboard_order_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $order = new Order();
        $form = $this->createForm(OrdersType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard_orders_index');
        }

        return $this->render('dashboard/orders/new.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="dashboard_order_show", methods={"GET"})
     */
    public function show(Order $order): Response
    {
        
        /*
        $repository = $this->getDoctrine()->getRepository(Basket::class);
        $baskets = $repository->find(14); 
        */

        $baskets = $this->getDoctrine()
            ->getRepository(Basket::class)
            ->findAll();

        return $this->render('dashboard/orders/show.html.twig', [
            'order' => $order,
            'baskets' => $baskets,
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dashboard_order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Order $order): Response
    {
        $form = $this->createForm(OrdersType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dashboard_orders_index', [
                'id' => $order->getId(),
            ]);
        }

        return $this->render('dashboard/orders/edit.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="dashboard_order_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Order $order): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dashboard_orders_index');
    }
}
