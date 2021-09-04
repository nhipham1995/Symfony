<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Experience;
use App\Form\ExpFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;


class CollabExperienceController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/collab/experience', name: 'collab_experience')]
    public function index(): Response
    {
        return $this->render('collab_experience/index.html.twig', [
            'controller_name' => 'CollabExperienceController',
        ]);
    }


    #[Route('/collab/experience/add', name: 'collab_exp_add')]
    public function add(Request $request)
    {
        $exp = new Experience();
        $user = $this->getUser();

        $form    = $this->createForm(ExpFormType::class, $exp);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exp->addUser($user);
            
            $this->entityManager->persist($exp);
            $this->entityManager->flush();
            $this->addFlash('success', "Un expérience a bien été ajouté");

            return $this->redirectToRoute('collab_profile');
        }

        return $this->render('collab_experience/index.html.twig', [
            'form' => $form->createView(),
            'user' => $user

        ]);
    }

    
    #[Route("/collab/exp/modify/{user}", name:"collab_exp_edit")] 
    public function edit(Request $request, $user)
    {
        //dd($user);
        $exp = $this->entityManager->getRepository(Experience::class)->find($user);
        $form = $this->createForm(ExpFormType::class, $exp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', "Un expérience a bien été modifié");

            return $this->redirectToRoute('collab_profile');
        }

        return $this->render('collab_experience/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    
    #[Route("/compte/supprimer-exp-collab/{id}", name:"collab_exp_delete")]
     
    public function delete($id)
    {
        $user = $this->getUser();
        $skill=  $this->entityManager->getRepository(Experience::class)->find($id);
        $skill->removeUser($user);
        $this->entityManager->flush();
        $this->addFlash('danger', "Un expérience a bien été supprimé");
        
        return $this->redirectToRoute('collab_profile');
    }


    // FOR COMMERICAL_ROLE MODIFICATION

    #[Route('/collab/experience/add/{id}', name: 'commercial_add_exp_collab')]
    public function add2(Request $request, $id)
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

            return $this->redirectToRoute('collab_profile_item', array('user' => $id));
        }

        return $this->render('collab_experience/index.html.twig', [
            'form' => $form->createView(),
            'user' => $user

        ]);
    }

    
    #[Route("/collab/exp/modify/{user}/{exp}", name:"commercial_edit_exp_collab")] 
    public function edit2(Request $request, $user, $exp)
    {
        $exp2 = $this->entityManager->getRepository(Experience::class)->find($exp);
        $form = $this->createForm(ExpFormType::class, $exp2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', "Un expérience a bien été modifié");

            return $this->redirectToRoute('collab_profile_item', array('user' => $user));
        }

        return $this->render('collab_experience/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    
    #[Route("/compte/supprimer-exp-candidat/{user}/{id}", name:"commercial_delete_exp_collab")]
     
    public function delete2($user, $id)
    {
        $user2 =  $this->entityManager->getRepository(User::class)->find($user);
        $skill=  $this->entityManager->getRepository(Experience::class)->find($id);
        $skill->removeUser($user2);
        $this->entityManager->flush();
        $this->addFlash('danger', "Un expérience a bien été supprimé");
        
        return $this->redirectToRoute('collab_profile_item', array('user' => $user));
    }
}
