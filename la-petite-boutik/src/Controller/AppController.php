<?php

namespace App\Controller;
use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\NewsletterSubscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProductRepository;


final class AppController extends AbstractController
{

    // Accueil et prinipales pages
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('app/index.html.twig', []);
    }

    #[Route('/shop', name: 'app_shop')]
    public function shop(): Response
    {
        return $this->render('app/shop.html.twig', []);
    }

    // Produits
    #[Route('/girls', name: 'app_girls')]
    public function girls(ProductRepository $productRepository): Response
{
            $products = $productRepository->findByGender('fille');
   
        return $this->render('app/girls.html.twig', [
                'products' => $products,
                ]);
    }

    #[Route('/boys', name: 'app_boys')]
    public function boys(): Response
    {
        return $this->render('app/boys.html.twig', []);
    }


    #[Route('/admin/products', name: 'admin_products')]
    public function products(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('admin/products.html.twig', [
            'products' => $products,
        ]);
    }

#[Route('/admin/product/new', name: 'admin_product_new')]
public function new(Request $request, EntityManagerInterface $em): Response
{
    $product = new Product();
    $form = $this->createForm(ProductType::class, $product);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $product->setCreatedAt(new \DateTimeImmutable());

        $em->persist($product);
        $em->flush();

        $this->addFlash('success', 'Produit ajouté avec succès !');

        return $this->redirectToRoute('admin_products'); // ou une autre route
    }

    return $this->render('admin/product_new.html.twig', [
        'form' => $form->createView(),
    ]);
}
    
    // A propos
    #[Route('/our-story', name: 'app_our_story')]
    public function ourStory(): Response
    {
        return $this->render('app/our-story.html.twig', []);
    }


    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(): Response
    {
        return $this->render('app/inscription.html.twig', []);
    }


    // Pages Infos
    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('app/contact.html.twig', []);
    }

    #[Route('/find-us', name: 'app_find_us')]
    public function findUs(): Response
    {
        return $this->render('app/find-us.html.twig', []);
    }


    // Pages  Mentions Légales
    #[Route('/conditions-generales', name: 'app_cgv')]
    public function conditionsGenerales(): Response
    {
        return $this->render('app/conditions-generales.html.twig', []);
    }

    #[Route('/politique-de-confidentialite', name: 'app_pdc')]
    public function politiqueDeConfidentialite(): Response
    {
        return $this->render('app/politique-de-confidentialite.html.twig', []);
    }

    // Page Login
    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        return $this->render('app/login.html.twig');
    }

    // Page Mon Compte
    #[Route('/account', name: 'app_account')]
    public function account(): Response
    {
        return $this->render('app/account.html.twig', []);
    }


    // Page Newsletter
    #[Route('/newsletter', name: 'app_newsletter_subscribe', methods: ['POST'])]
    public function subscribe(Request $request, EntityManagerInterface $em): Response
    {
        $email = $request->request->get('email');

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addFlash('success', 'Votre inscription a bien été prise en compte.');
        } else {
            $this->addFlash('error', 'Email invalide. Veuillez réessayer.');
        }

        return $this->redirectToRoute('app_account');
    }
}
