<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/register', name: 'register')]
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            // Encoder le mot de passe
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $user->setNom(strtoupper($user->getNom()));
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash('success', 'You\'re successfully created an account!');
            return $this->redirect($this->generateUrl('home'));
        } elseif ($form->isSubmitted()) {
            $this->addFlash('danger', 'Please recreate your inscription!');
        }



        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);

    }

}
