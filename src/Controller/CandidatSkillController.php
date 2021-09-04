<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Entity\User;
use App\Form\SkillAddType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CandidatSkillController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/candidat/skill', name: 'candidat_skill')]
    public function index(): Response
    {
        return $this->render('candidat_skill/index.html.twig', [
            'controller_name' => 'CandidatSkillController',
        ]);
    }

    #[Route('/candidats/skill/add/{id}', name: 'candidat_skill_add')]

    public function add(Request $request, $id)
    {
        $skill = new Skill();
        $user = $this->entityManager->getRepository(User::class)->find($id);

        $form    = $this->createForm(SkillAddType::class, $skill);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skill->addUser($user);
            
            $this->entityManager->persist($skill);
            $this->entityManager->flush();


           

            return $this->redirectToRoute('candidat_item', array('user' => $id));
        }

        return $this->render('candidat_skill/index.html.twig', [
            'form' => $form->createView(),
            'user' => $user

        ]);
    }

    
    #[Route("/candidats/skill/modify/{user}/{id}", name:"candidat_skill_edit")]
    
    public function edit(Request $request, $user, $id)
    {
        $user2= $this->entityManager->getRepository(User::class)->find($user);
        $skill = $this->entityManager->getRepository(Skill::class)->find($id);
        $form = $this->createForm(SkillAddType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('candidat_item', array('user'=> $user));
        }

        return $this->render('candidat_skill/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    #[Route("/compte/supprimer-skill-candidat/{user}/{id}", name:"candidat_skill_delete")]
     
    public function delete($user, $id)
    {
        $user2= $this->entityManager->getRepository(User::class)->find($user);
        $skill=  $this->entityManager->getRepository(Skill::class)->find($id);
        $skill->removeUser($user2);
        $this->entityManager->flush();
        $this->addFlash('danger', "Un compétence a bien été supprimé");
        
        return $this->redirectToRoute('candidat_item', array('user'=> $user));
    }

}
