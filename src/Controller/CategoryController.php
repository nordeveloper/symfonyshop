<?php

namespace App\Controller;

use App\Entity\Category;
//use App\Form\CategoryType;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="category_index", methods={"GET"})
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('category/index.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/{id}", name="category_show", methods={"GET"})
     */
    public function show(Category $category): Response
    {
        
        $products = $this->getDoctrine()
        ->getRepository(Product::class)
        ->findBy([
            'category_id'=>$category->getId(),
        ]);   
        
        //var_dump($products);

        return $this->render('category/products.twig', [
            'category' => $category,
            'products' => $products,    
        ]);

    }

}
