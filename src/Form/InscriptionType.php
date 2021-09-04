<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Your Email',
                'attr' => ['class'=> 'form-control mb-3 ',
                    'placeholder' => "mille@gmail.com "]
            ])
            ->add('nom',TextType::class, [
                'label' => 'Your Name',
                'attr' => ['class'=> 'form-control mb-3 ',
                    'placeholder' => "Jullien "]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Your First Name',
                'attr' => ['class'=> 'form-control mb-3 ',
                           'placeholder' => "Milles "]
            ])
            ->add('address', TextType::class, [
                'label' => 'You Address',
                'attr' => ['class'=> 'form-control mb-3 ',
                           'placeholder' => "2 Allée de Etoile, 37300 Joué-lès-Tours, France "]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'attr' => ['class'=> 'form-control mb-3 ']
            ])
            ->add('save', SubmitType::class, [
                'attr' =>['class' => 'btn btn-outline-primary mx-auto']
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
