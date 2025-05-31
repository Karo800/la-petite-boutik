<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
  #[Route('/admin/produits', name: 'admin_product_index')]
public function index(ProductRepository $productRepository): Response
{
    $products = $productRepository->findAll();

    return $this->render('admin/product/products.html.twig', [
        'products' => $products,
    ]);
} 

#[Route('/admin/produit/ajouter', name: 'admin_product_new')]
public function new(Request $request, EntityManagerInterface $em): Response
{
    $product = new Product();

    $form = $this->createForm(ProductType::class, $product);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($product);
        $em->flush();

        $this->addFlash('success', 'Produit ajouté avec succès !');
        return $this->redirectToRoute('admin_product_index');
    }

    return $this->render('admin/product/new.html.twig', [
        'form' => $form->createView(),
    ]);
}



}