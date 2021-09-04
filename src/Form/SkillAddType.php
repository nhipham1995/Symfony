<?php

namespace App\Form;

use App\Entity\Skill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkillAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class, [
                'label' => 'Compétence',
                'attr' => ['class'=> 'form-control mb-3 ']
            ])
            ->add('niveau',TextType::class, [
                'label' => 'Niveau',
                'attr' => ['class'=> 'form-control mb-3 ']
            ])
            ->add('likeOrNot', CheckboxType::class, [
                'label' => ' Like',
                'attr' => ['class'=> 'form-control mb-2 '],
                'required' => false,

            ])
            ->add('submit', SubmitType::class)
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Skill::class,
        ]);
    }
}
