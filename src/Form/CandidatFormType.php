<?php

namespace App\Form;

use App\Entity\Skill;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('email', EmailType::class ,[
                'label' => 'Email',
                'attr' => ['class'=> 'form-control mb-3 ']
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class'=> 'form-control mb-3 ']
            ])
            ->add('prenom', TextType::class , [
                'label' => 'Prénom',
                'attr' => ['class'=> 'form-control mb-3 ']
            ])
            ->add('address', TextType::class , [
                'label' => 'Address',
                'attr' => ['class'=> 'form-control mb-3 ']
            ])
            ->add('phone', TextType::class , [
                'label' => 'Numéro de téléphone',
                'attr' => ['class'=> 'form-control mb-3 ']
            ])
            ->add('skills', null, [
                'label' => 'Compétence',
                'attr' => ['class'=> 'form-control mb-3 ']
            ])
            ->add('experiences', null, [
                'label' => 'Expérience',
                'attr' => ['class'=> 'form-control mb-3 ']
            ])
            ->add('disponibilite', CheckboxType::class, [
                'label'    => 'Disponibilité',
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'attr' =>['class' => 'btn btn-outline-primary float-end']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
