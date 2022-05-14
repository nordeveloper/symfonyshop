<?php

namespace App\Controller\Dashboard;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\HttpFoundation\File\File;
use App\Service\FileUploader;

/**
 * @Route("/dashboard/products")
 */
class ProductController extends BaseController
{
    /**
     * @Route("/", name="dashboard_products_index", methods={"GET"})
     */
    public function index(): Response
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        return $this->render('dashboard/product/index.html.twig', [
            'products' => $products, 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$product->setCreatedBy( $this->getUser()->getId() );

            $previewImage = $request->files->get('product')['previewImage'];
            $detailImage = $request->files->get('product')['detailImage'];

            if($detailImage){
                $fileName = $fileUploader->upload($detailImage);                
                $product->setDetailImage($fileName);
                $product->setPreviewImage($fileName);
            }else{
                if($previewImage){
                    $fileName = $fileUploader->upload($previewImage);
                    $product->setPreviewImage($fileName);
                }
            }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard_products_index');
        }

        return $this->render('dashboard/product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="dashboard_product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('dashboard/product/show.html.twig', [
            'product' => $product, 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $previewImage = $request->files->get('product')['previewImage'];
            $detailImage = $request->files->get('product')['detailImage'];

            if($detailImage){                
                $fileName = $fileUploader->upload($detailImage);
                $product->setDetailImage($fileName);
                $product->setPreviewImage($fileName);
            }         

            if( !$detailImage and $previewImage){
                $fileName = $fileUploader->upload($previewImage);
                $product->setPreviewImage($fileName); 
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dashboard_products_index');
        }

        return $this->render('dashboard/product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dashboard_product_index');
    }

}
