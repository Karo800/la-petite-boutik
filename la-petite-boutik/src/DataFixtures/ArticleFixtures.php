<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

// class ArticleFixtures extends Fixture
// {
//     public function load(ObjectManager $manager): void
//     {
//         // $product = new Product();
//         // $manager->persist($product);

//         $manager->flush();
//     }
// }
class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

   $category = new Category();
        $category->setName('Barboteuses');
        $manager->persist($category);

        $product = new Product();
        $product->setName('Test Barboteuse');
        $product->setReference('REF001');
        $product->setDescription('Produit pour bébé fille');
        $product->setColor('Rose');
        $product->setSize('6 mois');
        $product->setGender('fille');
        $product->setPrice(25.90);
        $product->setStock(10);
        $product->setPicture('barboteuse-test.jpg');
        // $product->setCreatedAt(new \DateTimeImmutable());
      $product->setCategory($category);

        $manager->persist($product);
        $manager->flush();
    }
    
}