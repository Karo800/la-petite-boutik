<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\ProductType;
use App\Form\CategoryType;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

final class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/products', name: 'admin_products')]
    public function product(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('admin/products.html.twig', [
            'products' => $products,
        ]);
    }


    // PRODUCT ADD
    #[Route('/admin/product/add', name: 'admin_product_add')]
    public function addProduct(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion de l'upload d'image
            $imageFile = $form->get('picture')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('uploads_directory'), // Défini dans services.yaml
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Erreur lors de l\'upload de l\'image');
                }

                $product->setPicture($newFilename);
            } else {
                $this->addFlash('danger', 'Une image est requise.');
                return $this->render('admin/add.product.html.twig', [
                    'form' => $form->createView(),
                ]);
            }

            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Produit ajouté avec succès !');
            return $this->redirectToRoute('admin_products');
        }

        return $this->render('admin/add.product.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    // PRODUCT EDIT
    #[Route('/admin/product/edit/{id}', name: 'admin_product_edit')]
    public function editProduct(
        Product $product,
        Request $request,
        EntityManagerInterface $em,
        SluggerInterface $slugger
    ): Response {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('picture')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Erreur lors de l\'upload de l\'image');
                    return $this->render('admin/edit.product.html.twig', [
                        'form' => $form->createView(),
                        'product' => $product,
                    ]);
                }

                $product->setPicture($newFilename);
            }

            $em->flush();

            $this->addFlash('success', 'Produit modifié avec succès !');
            return $this->redirectToRoute('admin_products');
        }

        return $this->render('admin/edit.product.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
        ]);
    }

    // PRODUCT DELETE
    #[Route('/admin/product/delete/{id}', name: 'admin_product_delete')]
    public function deleteProduct(
        Product $product,
        Request $request,
        EntityManagerInterface $em,
        SluggerInterface $slugger
    ): Response {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('picture')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Erreur lors de l\'upload de l\'image');
                    return $this->render('admin/delete.product.html.twig', [
                        'form' => $form->createView(),
                        'product' => $product,
                    ]);
                }

                $product->setPicture($newFilename);
            }

            $em->flush();

            $this->addFlash('success', 'Produit supprimé avec succès !');
            return $this->redirectToRoute('admin_products');
        }

        return $this->render('admin/delete.product.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
        ]);
    }

     
    
    // CATEGORIES
    #[Route('/admin/categories', name: 'admin_categories')]
    public function category(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('admin/categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/admin/categories/add', name: 'admin_categories_add')]
    public function addCategory(Request $request, EntityManagerInterface $em): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setCreatedAt(new \DateTimeImmutable());
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'La catégorie a été enregistrée.');
            return $this->redirectToRoute('admin_categories');
        }

        return $this->render('admin/add.category.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    // EDIT CATEGORY
    #[Route('/admin/categories/edit/{id}', name: 'admin_categories_edit')]
    public function editCategory(Category $category, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'La catégorie a été modifiée.');
            return $this->redirectToRoute('admin_categories');
        }

        return $this->render('admin/edit.category.html.twig', [
            'form' => $form->createView(),
            'category' => $category,
        ]);
    }


    // DELETE CATEGORY
    #[Route('/admin/categories/delete/{id}', name: 'admin_categories_delete')]
    public function deleteCategory(Category $category, EntityManagerInterface $em): Response
    {
        $em->remove($category);
        $em->flush();

        $this->addFlash('success', 'La catégorie a été supprimée.');
        return $this->redirectToRoute('admin_categories');
    }


    // USER
    #[Route('/admin/users', name: 'admin_users')]
    public function users(UserRepository $userRepository): Response
    {
        // va chercher ts les users de la BDD
        $users = $userRepository->findAll();

        // affiche le template admin/users en passant la liste des utilisateurs
        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }
}
