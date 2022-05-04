<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Serie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('formule', ChoiceType::class, [
                'choices'  => [
                    'Netflix & Chill 200€/nuit' => 'Netflix & Chill',
                    'Immersive Adventure 400€/nuit' => 'Immersive Adventure',
                    'Deluxe 800€/nuit' => 'Deluxe',
                ],
            ])
            ->add('checkin', DateType::class, [
                'widget'    => 'single_text',
                'label'     => 'Date début',
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => 'today',
                        'message' => "impossible de faire la réservation"
                    ])
                ],

            ])
            ->add('checkout', DateType::class, [
                'widget'    => 'single_text',
                'label'     => 'Date Fin'
            ])
            ->add('pax', IntegerType::class, [
                'label' => 'N° de personnes',
                'attr' => [
                    'placeholder' => 'N° de personnes',
                ],
                'constraints' => [
                    new LessThanOrEqual([
                        'value' => '8',
                        'message' => '8 personnes maximum'
                    ]),
                    new GreaterThanOrEqual([
                        'value' => '1',
                        'message' => '1 personne minimum'
                    ])
                ],

            ])
            ->add('serie', EntityType::class, [
                'class'         => Serie::class,
                'choice_label'  => 'name',
                'placeholder'   => 'Choisir serie...',
                'required'      => true,
                'label'         => 'Serie'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
