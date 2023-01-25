<?php

namespace App\Form;

use App\Entity\Interaction;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InteractionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'user',
                EntityType::class,
                [
                    'class' => User::class,
                    'label' => 'Nom de famille',
                    'choice_label' => 'lastname'
                ],
            )
            ->add(
                'decisionRole',
                ChoiceType::class,
                [
                    'choices' => [
                        Interaction::DECISION_IMPACTED => Interaction::DECISION_IMPACTED,
                        Interaction::DECISION_EXPERT => Interaction::DECISION_EXPERT,
                    ],
                    'label' => 'Impacté ou expert ?'
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Interaction::class,
        ]);
    }
}
