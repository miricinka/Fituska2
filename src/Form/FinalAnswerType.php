<?php

namespace App\Form;

use App\Entity\FinalAnswer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FinalAnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text', TextareaType::class, [
                'label' => "Write final answer! *This action will CLOSE this question.",
                'attr' => array(
                    'placeholder' => "What is the final answer? ",
                ),
                'required' => true
            ])
            ->add('image', FileType::class,[
                'label' => 'Image file',
                'required' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Close question',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FinalAnswer::class,
        ]);
    }
}
