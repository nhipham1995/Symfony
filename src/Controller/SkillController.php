<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Form\SkillAddType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/skill', name: 'skill')]
    public function index(Request $request): Response
    {
        $skill = new Skill();
        $form = $this->createForm(SkillAddType::class, $skill);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skill = $form->getData();
            // Encoder le mot de passe
            $skill->setLikeOrNot(strval($skill->getLikeOrNot()));

            $this->entityManager->persist($skill);
            $this->entityManager->flush();
            $this->addFlash('success', 'You\'re successfully created a new skill!');
        } elseif ($form->isSubmitted()) {
            $this->addFlash('danger', 'Please recreate your new skill!');
        }



        return $this->render('skill/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
