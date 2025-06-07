<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference', TextType::class, [
                'label' => "Référence",
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => "Veuillez saisir une référence"])
                ]
            ])
            ->add('name', TextType::class, [
                'label' => "Nom",
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => "Veuillez saisir un nom"])
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description",
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => "Veuillez saisir une description"])
                ],
                'attr' => ['rows' => 10]
            ])
            ->add('color', ChoiceType::class, [
                'label' => "Couleur",
                'choices' => [
                    'Blanc' => 'blanc',
                    'Noir' => 'noir',
                    'Bleu' => "bleu",
                    'Rose' => "rose",
                    'Lilas'=> "lilas",
                    'Rouge'=> 'rouge',
                    'Marine'=> 'marine',
                    'Ciel'=> 'ciel',
                    'Marine & Blanc'=>'marine & blanc',
                    'Ciel & Blanc'=> 'ciel & blanc'

                ]
            ])
            ->add('size', ChoiceType::class, [
                'label' => "Taille",
                'choices' => [
                    '0-3 mois' => '0-3',
                    '0-6 mois' => '0-6',
                    '6-12 mois' => '6-12'
                ]
            ])
            ->add('gender', ChoiceType::class, [
                'label' => "Genre",
                'choices' => [
                    'Fille' => 'fille',
                    'Garçon' => 'garçon',
                    'Mixte' => 'mixte'
                ]
            ])
            ->add('picture', FileType::class, [
                'label' => "Photo produit",
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '10M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'],
                        'mimeTypesMessage' => "Formats autorisés : jpg/jpeg/png/webp"
                    ])
                ]
            ])
            ->add('stock', TextType::class, [
                'label' => "Stock",
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => "Veuillez saisir un stock"])
                ]
            ])
            ->add('price', TextType::class, [
                'label' => "Prix",
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => "Veuillez saisir un prix"])
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Catégorie'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
