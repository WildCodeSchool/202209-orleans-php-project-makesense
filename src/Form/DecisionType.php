<?php

namespace App\Form;

use App\Entity\Decision;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DecisionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('decisionStartTime')
            ->add('details')
            ->add('impact')
            ->add('gain')
            ->add('risk')
            ->add('firstDecisionEndDate')
            ->add('conflictEndDate')
            ->add('finalDecisionEndDate')
            ->add('firstDecision')
            ->add('finalDecision')
            ->add('category')
            ->add('creator')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Decision::class,
        ]);
    }
}
