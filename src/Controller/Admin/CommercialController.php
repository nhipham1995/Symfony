<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Entreprise;
use App\Entity\Skill;
use App\Entity\Document;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommercialController extends AbstractDashboardController
{

    /**
     * @Route("/commercial", name="commercial")
     */
    public function index2(): Response
    {
        return parent::index();
    }

    public function configureDashboard2(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ECFSYMFONY');
    }

    public function configureMenuItems2(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }



    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ECFSYMFONY');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('User');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        yield MenuItem::section('Details');
        yield MenuItem::linkToCrud('Entreprises', 'fas fa-building', Entreprise::class);
        yield MenuItem::linkToCrud('Skill', 'fas fa-award', Skill::class);
        yield MenuItem::linkToCrud('Document', 'fas fa-file', Document::class);

        yield MenuItem::section('Profile');
        yield MenuItem::linkToUrl('All Profiles', 'fas fa-id-card', '/commercial/dashboard');
            // ->setController(User2CrudController::class);


    }
   
    
    
}


