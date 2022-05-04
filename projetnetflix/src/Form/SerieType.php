<?php

namespace App\Form;

use App\Entity\Serie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom serie',
                ],
                'label' => 'Nom',
            ])
            ->add('hotel', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Hotel',
                ],
                'label' => 'Hotel'
            ])
            ->add('adress', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Adresse hotel',
                ],
                'label' => 'Adresse'
            ])
            ->add('image_serie', FileType::class, [
                'label' => 'Image de la serie',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Image de la serie',
                ],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif'
                        ],
                        'mimeTypesMessage' => ['Les formats autorisés sont : .gif, .gpg, .png'],
                        'maxSize' => '2048k',
                        'maxSizeMessage' => ['Le fichier ne peut pas peser plus de 2Mo'],
                    ])
                ]
            ])
            ->add('image_basic', FileType::class, [
                'label' => 'Image de la chambre Basic',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Image basic',
                ],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif'
                        ],
                        'mimeTypesMessage' => ['Les formats autorisés sont : .gif, .gpg, .png'],
                        'maxSize' => '2048k',
                        'maxSizeMessage' => ['Le fichier ne peut pas peser plus de 2Mo'],
                    ])
                ],
            ])
            ->add('image_immersive', FileType::class, [
                'label' => 'Image de la chambre Immersive',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Image immersive',
                ],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif'
                        ],
                        'mimeTypesMessage' => ['Les formats autorisés sont : .gif, .gpg, .png'],
                        'maxSize' => '2048k',
                        'maxSizeMessage' => ['Le fichier ne peut pas peser plus de 2Mo'],
                    ])
                ]
            ])
            ->add('image_deluxxe', FileType::class, [
                'label' => 'Image de la chambre Deluxxe',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif'
                        ],
                        'mimeTypesMessage' => ['Les formats autorisés sont : .gif, .gpg, .png'],
                        'maxSize' => '2048k',
                        'maxSizeMessage' => ['Le fichier ne peut pas peser plus de 2Mo'],
                    ])
                ]
            ])
            ->add('image_hotel', FileType::class, [
                'label' => 'Image de l\'hotel',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Image hotel',
                ],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif'
                        ],
                        'mimeTypesMessage' => ['Les formats autorisés sont : .gif, .gpg, .png'],
                        'maxSize' => '2048k',
                        'maxSizeMessage' => ['Le fichier ne peut pas peser plus de 2Mo'],
                    ])
                ],
            ])
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Titre',
                ],
                'label' => 'Titre'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
        ]);
    }

}

