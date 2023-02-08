<?php

namespace App\Form;

use App\Entity\Status;
use App\Entity\Decision;
use App\Service\AutomatedDates;
use App\Form\DecisionCreationType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DecisionEditionType extends AbstractType
{
    public function __construct(private AutomatedDates $automatedDates)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->remove('decisionStartTime')
                ->remove('category');
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $decision = $event->getData();
            $form = $event->getForm();

            if ($this->automatedDates->getDecisionStatus($decision) === Status::FIRST_DECISION) {
                $form->remove('title')
                    ->remove('interactions')
                    ->remove('details')
                    ->remove('impact')
                    ->remove('gain')
                    ->remove('risk')
                    ->add('firstDecision', CKEditorType::class, [
                        'label' => 'Première prise de décision :',
                    ]);
            } elseif ($this->automatedDates->getDecisionStatus($decision) === Status::FINAL_DECISION) {
                $form->remove('title')
                    ->remove('interactions')
                    ->remove('details')
                    ->remove('impact')
                    ->remove('gain')
                    ->remove('risk')
                    ->add('finalDecision', CKEditorType::class, [
                        'label' => 'Prise de décision finale :',
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
