<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Skill;
use App\Data\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label'     => false,
                'required'  =>  false,
                'attr'      => [
                    'placeholder'   => 'Rechercher Par Nom',
                    'class'         =>  'form-control mb-3 ',
                ] 
            ])
            ->add('skills', EntityType::class, [
                'label'     => false,
                'required'  => false,
                'class'     => Skill::class,
                'expanded'  => true,
                'multiple'  => true,
                'attr'      => [
                    'class'         =>  'form-control mb-3 ',
                ] 
            ])
            // ->add('submit',  SubmitType::class)
            // ->add('roles')
            // ->add('password')
            // ->add('nom')
            // ->add('prenom')
            // ->add('address')
            // ->add('phone')
            // ->add('disponibilite')
            // ->add('skills')
            // ->add('experiences')
        ;
    }

    public function configureOptions(OptionsResolver $resolver) 
    {
        $resolver->setDefaults([
            'data_class'      => SearchData::class,
            'method'          => 'GET',
            'csrf_protection' => false,

        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
  

   
}
