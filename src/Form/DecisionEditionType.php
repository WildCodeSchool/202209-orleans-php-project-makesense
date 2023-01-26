<?php

namespace App\Form;

use App\Entity\Decision;
use App\Form\DecisionCreationType;
use App\Service\AutomatedDates;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DecisionEditionType extends AbstractType
{
    public function __construct(private AutomatedDates $automatedDates)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->remove('decisionStartTime');
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $decision = $event->getData();
            $form = $event->getForm();

            if ($this->automatedDates->getDecisionStatus($decision) === Decision::FIRST_DECISION) {
                $form->remove('title')
                    ->remove('interactions')
                    ->remove('details')
                    ->remove('impact')
                    ->remove('gain')
                    ->remove('risk')
                    ->add('firstDecision', CKEditorType::class, [
                        'label' => 'Première prise de décision :',
                    ]);
            }
        });
    }

    public function getParent(): string
    {
        return DecisionCreationType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Decision::class,
        ]);
    }
}
