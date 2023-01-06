<?php

namespace App\Form;

use App\Entity\Decision;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DecisionCreationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre :',
                'attr' => [
                    'placeholder' =>
                    'Passer une partie du parc automobile en électrique...'
                ]
            ])
            ->add('decision_start_time', DateType::class, [
                'label' => 'Date de départ :',
                'widget' => 'single_text',
            ])
            ->add('details', TextareaType::class, [
                'label' => 'Détails de la décision :',
                'attr' => [
                    'rows' => 10,
                    'placeholder' =>
                    'Réduire le nombre de Véhicule thermique pour 
                    les livreurs et les salariés possédant un véhicule de fonction...'
                ]
            ])
            ->add('impact', TextareaType::class, [
                'label' => 'Impacts de la décision :',
                'attr' => [
                    'rows' => 10,
                    'placeholder' =>
                    'L\'infrastructure devra être adaptée, avec notamment l\'installation de bornes de recharges...'
                ]
            ])
            ->add('gain', TextareaType::class, [
                'label' => 'Bénéfices de la décision :',
                'attr' => [
                    'rows' => 10,
                    'placeholder' =>
                    'Diminuer l\'émission de gaz à effet de serre, ne pas être impacté par la pénurie de carburants...'
                ]
            ])
            ->add('risk', TextareaType::class, [
                'label' => 'Risques potentiels de la décision :',
                'attr' => [
                    'rows' => 10,
                    'placeholder' =>
                    'Augmenter les frais d\'entretien des véhicules...'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Decision::class,
        ]);
    }
}
