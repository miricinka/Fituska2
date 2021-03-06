<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Question;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Title*",
            ])
            ->add('description', TextareaType::class, [
                'label' => "Question*",
                'attr' => array(
                    'placeholder' => "Write your whole question here",
                ),
                'required' => true
            ])
            ->add('category', EntityType::class, [
                'label' => "Category*",
                'class' => Category::class
            ])
            ->add('image', FileType::class,[
                'label' => 'Image file',
                'required' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ask now!',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
