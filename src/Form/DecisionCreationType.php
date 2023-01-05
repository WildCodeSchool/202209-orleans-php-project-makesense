<?php

namespace App\Form;

use App\Entity\Decision;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class DecisionCreationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre :'])
            ->add('decision_start_time', DateType::class, [
                'label' => 'Date de départ :',
                'widget' => 'single_text',
            ])
            ->add('details', CKEditorType::class, [
                'label' => 'Détails de la décision :',
            ])
            ->add('impact', CKEditorType::class, [
                'label' => 'Impacts de la décision :',
            ])
            ->add('gain', CKEditorType::class, [
                'label' => 'Bénéfices de la décision :',
            ])
            ->add('risk', CKEditorType::class, [
                'label' => 'Risques potentiels de la décision :',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Decision::class,
        ]);
    }
}
