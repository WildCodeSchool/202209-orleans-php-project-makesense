<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('comment', CKEditorType::class, [
                'label' => 'Laisser un commentaire',
                'label_attr' => [
                    'class' => 'fw-bold fs-4 mb-2',
                ]
            ])
            ->add('inConflict', CheckboxType::class, [
                'label' =>
                'Seul les personnes impactées ou expertes peuvent entrer en conflit avec la première prise de décision',
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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
