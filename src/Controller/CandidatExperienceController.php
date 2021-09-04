<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Experience;
use App\Form\ExpFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CandidatExperienceController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/candidat/experience', name: 'candidat_experience')]
    public function index(): Response
    {
        return $this->render('candidat_experience/index.html.twig', [
            'controller_name' => 'CandidatExperienceController',
        ]);
    }

    #[Route('/candidat/experience/add/{id}', name: 'candidat_exp_add')]
    public function add(Request $request, $id)
    {
        $user=  $this->entityManager->getRepository(User::class)->find($id);
        $exp = new Experience();

        $form    = $this->createForm(ExpFormType::class, $exp);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exp->addUser($user);
            
            $this->entityManager->persist($exp);
            $this->entityManager->flush();
            $this->addFlash('success', "Un expérience a bien été ajouté");

            return $this->redirectToRoute('candidat_item', array('user' => $id));
        }

        return $this->render('candidat_experience/index.html.twig', [
            'form' => $form->createView(),
            'user' => $user

        ]);
    }

    
    #[Route("/collab/exp/modify/{user}/{exp}", name:"candidat_exp_edit")] 
    public function edit(Request $request, $user, $exp)
    {
        $exp2 = $this->entityManager->getRepository(Experience::class)->find($exp);
        $form = $this->createForm(ExpFormType::class, $exp2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', "Un expérience a bien été modifié");

            return $this->redirectToRoute('candidat_item', array('user' => $user));
        }

        return $this->render('candidat_experience/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    
    #[Route("/compte/supprimer-exp-candidat/{user}/{id}", name:"candidat_exp_delete")]
     
    public function delete($user, $id)
    {
        $user2 =  $this->entityManager->getRepository(User::class)->find($user);
        $skill=  $this->entityManager->getRepository(Experience::class)->find($id);
        $skill->removeUser($user2);
        $this->entityManager->flush();
        $this->addFlash('danger', "Un expérience a bien été supprimé");
        
        return $this->redirectToRoute('candidat_item', array('user' => $user));
    }
}
