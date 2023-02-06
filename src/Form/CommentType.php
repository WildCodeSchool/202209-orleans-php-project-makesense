<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\Status;
use App\Service\TimelineManager;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CommentType extends AbstractType
{
    public function __construct(private TimelineManager $timelineManager)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('comment', CKEditorType::class, [
                'label' => 'Laisser un commentaire',
                'label_attr' => [
                    'class' => 'fw-bold fs-4 mb-2',
                ]
            ]);
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $comment = $event->getData();
            $form = $event->getForm();

            if ($this->timelineManager->checkDecisionStatus($comment->getDecision()) === Status::CONFLICT_PERIOD) {
                $form->add('inConflict', CheckboxType::class, [
                    'label' =>
                    'Seul les personnes impactées ou 
                    expertes peuvent entrer en conflit avec la première prise de décision',
                    'label_attr' => [
                        'class' => 'form-check-label',
                        'for' => 'flexSwitchCheckDefault'
                    ],
                    'attr' => [
                        'class' => 'form-check-input',
                        'role' => 'switch',
                        'id' => 'flexSwitchCheckDefault'
                    ],
                    'required' => false,
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
