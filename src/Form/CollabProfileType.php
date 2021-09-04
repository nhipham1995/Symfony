<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class CollabProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
       
        ->add('nom',TextType::class, [
            'label' => 'Votre Nom',
            'attr' => ['class'=> 'form-control mb-2 ']
        ])
        ->add('prenom', TextType::class, [
            'label' => 'Votre Prénom',
            'attr' => ['class'=> 'form-control mb-2 ']
        ])
        ->add('address', TextType::class, [
            'label' => 'Votre Addresse',
            'attr' => ['class'=> 'form-control mb-2 ']
        ])
        ->add('phone', TextType::class, [
            'label' => 'Your Numéro de Téléphone',
            'attr' => ['class'=> 'form-control mb-2 ']
        ])   

        ->add('document', FileType::class, [
            'label' => 'Document (PDF file)',

            // unmapped means that this field is not associated to any entity property
            'mapped' => false,

            // make it optional so you don't have to re-upload the PDF file
            // every time you edit the Product details
            'required' => false,

            // unmapped fields can't define their validation using annotations
            // in the associated entity, so you can use the PHP constraint classes
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'application/pdf',
                        'application/x-pdf',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid PDF document',
                ])
            ],
        ])
        ->add('disponibilite', CheckboxType::class, [
            'label'    => 'Disponibilité',
            'required' => false,
        ])
        ->add('Update', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
