<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Order;
use App\Form\ProfileFormType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/account")
 */

class AccountController extends AbstractController
{
    /**
     * @Route("/", name="account_index", methods={"GET"})
     */

    public function index()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if(empty($this->getUser())){
            return $this->redirectToRoute('app_login');
        }
        
        return $this->render('account/index.html.twig');
    }

   /**
    * @Route("/profile", name="account_profile")
    */
   public function profile(Request $request, User $user)
   {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(ProfileFormType::class, $user);
        $form->handleRequest($request);

        return $this->render('account/profile.html.twig', [
            'form' => $form->createView(),
        ]);
   }

    /**
    * @Route("/orders", name="account_orders")
    */
   public function orders(){

    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    $orders = $this->getDoctrine()
        ->getRepository(Order::class)
        ->findBy([
            'user_id'=>$this->getUser()->getId()
        ]);

    return $this->render('account/orders.twig', [
        'orders' => $orders
    ]);

   }

}
