<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CandidatFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CandidatInfoController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/candidattest/add', name: 'candidat_add')]
    public function index(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(CandidatFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            // Encoder le mot de passe
            $user->setPassword('12345');
            $user->setRoles( array('ROLE_CANDIDAT') );
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash('success', 'You\'re successfully created a profile Candidat!');
            return $this->redirect($this->generateUrl('home'));
        } elseif ($form->isSubmitted()) {
            $this->addFlash('danger', 'Please recreate your profile!');
        }

        return $this->render('candidat_info/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

  
}
