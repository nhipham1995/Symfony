<?php

namespace App\Form;

use App\Entity\Experience;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
        ->add('dateDebut',DateType::class, [
            'label' => 'Date Début',
            'attr' => ['class'=> 'form-control mb-3 ']
        ])
        ->add('dateFin',BirthdayType::class, [
            'label' => 'Date à la Fin',
            'attr' => ['class'=> 'form-control mb-3 ']
        ])
        ->add('entreprise')
        ->add('detail', TextareaType::class, [
            'label' => 'Detail',
            'attr' => ['class'=> 'form-control mb-2 ']
        ])
        ->add('submit', SubmitType::class)
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Experience::class,
        ]);
    }
}
