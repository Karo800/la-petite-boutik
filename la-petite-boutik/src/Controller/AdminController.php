<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\CategoryType;
// use App\Form\ProductFormType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_home')]
    public function index(): Response
    {
        return $this->render('admin/index.admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/products', name: 'admin_products')]
    public function products(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();       
         
        return $this->render('admin/products.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/admin/orders', name: 'admin_orders')]
    public function orders(): Response
    {
        return $this->render('admin/orders.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/category', name: 'admin_category')]
    public function category(CategoryRepository $categoryRepository): Response
    {
          $categories = $categoryRepository->findAll();
          
        return $this->render('admin/category.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/admin/users', name: 'admin_users')]
    public function users(): Response
    {
        return $this->render('admin/users.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
