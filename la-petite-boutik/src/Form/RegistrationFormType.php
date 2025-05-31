<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre prénom.'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Prénom *'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre nom.'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Nom *'
                ]
            ])
            ->add('email', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre adresse Email.'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Email *'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => false,
                'first_options'  => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Mot de passe *'
                    ]
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Confirmer votre mot de passe *'
                    ]
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre mot de passe.'
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage'  => 'Votre mot de passe doit contenir au moins 8 caractères !',
                        'max' => 4096,
                    ]),
                    new Regex(array(
                        'pattern'   => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!#%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                        'match'     => true,
                        'message'   => 'Votre mot de passe doit contenir au moins un chiffre, un caractère spécial (@$!#%*?&), une lettre minuscule et une lettre majuscule !'
                    ))
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre téléphone.'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Téléphone *'
                ]
            ])


            ->add('address', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre adresse.'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Adresse *'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre ville.'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Ville *'
                ]
            ])
            ->add('zipcode', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre code postal.'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Code postal *'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
