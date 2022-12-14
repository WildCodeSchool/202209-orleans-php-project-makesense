<?php

namespace App\Form;

use App\Entity\Decision;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PddCreationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre :'])
            ->add('decision_start_time', DateType::class, [
                'label' => 'Date de départ :',
                'widget' => 'single_text',
            ])
            ->add('details', TextareaType::class, [
                'label' => 'Détails de la décision :',
                'attr' => [
                    'rows' => 10,
                ]
            ])
            ->add('impact', TextareaType::class, [
                'label' => 'Impacts de la décision :',
                'attr' => [
                    'rows' => 10,
                ]
            ])
            ->add('gain', TextareaType::class, [
                'label' => 'Bénéfices de la décision :',
                'attr' => [
                    'rows' => 10,
                ]
            ])
            ->add('risk', TextareaType::class, [
                'label' => 'Risques potentiels de la décision :',
                'attr' => [
                    'rows' => 10,
                ]
            ])
            ->add('creator', HiddenType::class, ['data' => '1'])
            ->add('isFinished', HiddenType::class, ['data' => 'false'])
            ->add('isAbandonned', HiddenType::class, ['data' => 'false'])
            ->add('isLate', HiddenType::class, ['data' => 'false']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Decision::class,
        ]);
    }
}
