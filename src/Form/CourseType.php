<?php

namespace App\Form;

use App\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', TextType::class, [
                'label' => "ID*",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please fill in ID',
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 4,
                    ]),
                ],
            ])
            ->add('title', TextType::class, [
                'label' => "Title*",
            ])
            ->add('description', TextareaType::class, [
                'label' => "Short description of your course*",
                'attr' => array(
                    'placeholder' => "The best course in the whole world",
                )
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create course',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
