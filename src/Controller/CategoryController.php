<?php

namespace App\Controller;

use App\Entity\Product;
//use App\Form\CategoryType;
use App\Entity\Category;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/search", name="category_search", methods={"GET"})
    */
    public function search(Request $request,  ManagerRegistry $doctrine){


        $products = $doctrine->getRepository(Product::class)
            ->createQueryBuilder('p')
            ->where('p.title LIKE :title')
            ->setParameter('title', '%'.$request->get('q').'%')
            ->getQuery()
            ->getResult();

        //dd($products);

        return $this->render('category/products.twig',[
            'products'=>$products
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
