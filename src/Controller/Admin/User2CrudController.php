<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Sonata\AdminBundle\Controller\CRUDController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;

class User2CrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('email')
            ->add('roles')
            ->add('nom')
        ;
    }
    public function configureFields(string $Profiles): iterable
    {
        return [
            IdField::new('id'),
            EmailField::new('email'),
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('address'),
            TextField::new('phone'),
            ArrayField::new('roles'), 
            ArrayField::new('experiences'),
            ArrayField::new('skills'),
        ];
    }
}
    
