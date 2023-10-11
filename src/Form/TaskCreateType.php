<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Task;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['constraints'=>[new Length(min:4, max:20), new NotBlank(), new Regex(
                pattern: '/^[A-Za-z]*/', 
                message: 'Denumirea trebuie sa contina intre 4 si 20 de caractere.'
            )]])
            ->add('description')
            ->add('dueDate')
            ->add('category_id', EntityType::class, ['class'=>Category::class, 'choice_label'=>'name', 'constraints'=>(new Type('App\Entity\Category', 'Categoria nu este valida.'))])
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],

            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}