<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Basket;
use App\Entity\Payment;
use App\Form\OrderType;
use App\Entity\Delivery;
use App\Entity\OrdersStatus;
use App\Repository\BasketRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order")
     */
    public function index(Request $request, ManagerRegistry $doctrine, BasketRepository $basketRepository): Response
    {
        
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');        

        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $user_id = $this->getUser()->getId();

            $order->setUserId($user_id);            
            //$order->setStatus(1);

            $em = $doctrine->getManager();
            $em->persist($order);
            $em->flush();

            
            $basket = $basketRepository->findBy(array('order_id'=>NULL, 'user_id' => $user_id));
            foreach($basket as $basketItem){
                $basketItem->setOrderId($order->getId());
                $em->persist($basketItem);
                $em->flush();    
            }

            return $this->redirectToRoute('orders_finish');
        }

        $payments = $this->getDoctrine()
            ->getRepository(Payment::class)
            ->findAll();

        //dd($payments);

        $deliverylist = $this->getDoctrine()
            ->getRepository(Delivery::class)
            ->findAll();

        return $this->render('order/index.html.twig', [
            'order' => $order,
            'payments'=>$payments,
            'deliverylist'=>$deliverylist,
            'form' => $form->createView(),
        ]);        

    }

    /**
     * @Route("/finish", name="orders_finish", methods={"GET","POST"})
     */
    public function finish(){
        return $this->render('order/order_finish.html.twig'); 
    }

}
