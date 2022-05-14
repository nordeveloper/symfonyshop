<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\Product;
use App\Form\BasketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @Route("/basket")
 */
class BasketController extends AbstractController
{
    /**
     * @Route("/", name="basket_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $em): Response
    {
        
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if( !empty( $this->getUser() ) ){
            $user_id = $this->getUser()->getId();
        }else{
            $user_id = session_id();
        }

        $result = $em->getRepository(Basket::class)
            ->findBy(array('user_id' => $user_id, 'order_id'=>null));

        return $this->render('basket/index.html.twig', [
            'basket' => $result,
        ]);
    }

    /**
     * @Route("/add", name="basket_add", methods={"GET","POST"})
     */
    public function add(Request $request): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $basket = new Basket();
        
        $poductID = $request->query->get('id');
        
        if( $poductID >0 ){

            if( !empty( $this->getUser() ) ){
                $user_id = $this->getUser()->getId();
            }else{
                $user_id = session_id();
            }

            $repository = $this->getDoctrine()->getRepository(Product::class);
            $product = $repository->find($poductID);        

            $basket->setProductId( $poductID );
            $basket->setProductName( $product->getTitle() );
            $basket->setPrice( $product->getPrice() );
            $basket->setQuantity(1);
            $basket->setProductImage( $product->getPreviewImage() );
            $basket->setProductUrl( 'product/'. $product->getId() );
            $basket->setUserId( $user_id );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($basket);
            $entityManager->flush();
        }
  
        //return $this->render('base.html.twig');
        return $this->redirectToRoute('basket_index');
        
    }

    /**
     * @Route("/{id}", name="basket_delete", methods={"POST"})
     */
    public function delete(Request $request, Basket $basket): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->isCsrfTokenValid('delete'.$basket->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($basket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('basket_index');
    }

}
