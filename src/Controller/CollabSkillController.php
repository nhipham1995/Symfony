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


class CollabSkillController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/collab/skill', name: 'collab_skill')]
    public function index(): Response
    {
        return $this->render('collab_skill/index.html.twig', [
            'controller_name' => 'CollabSkillController',
        ]);
    }

    
    #[Route('/collab/skill/add', name: 'collab_skill_add')]

    public function add(Request $request)
    {
        $skill = new Skill();
        $user = $this->getUser();

        $form    = $this->createForm(SkillAddType::class, $skill);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skill->addUser($user);
            
            $this->entityManager->persist($skill);
            $this->entityManager->flush();


           

            return $this->redirectToRoute('collab_profile');
        }

        return $this->render('collab_skill/index.html.twig', [
            'form' => $form->createView(),
            'user' => $user

        ]);
    }

    
    #[Route("/collab/skill/modify/{user}", name:"collab_skill_edit")]
    
    public function edit(Request $request, $user)
    {
        //dd($user);
        $skill = $this->entityManager->getRepository(Skill::class)->find($user);
        $form = $this->createForm(SkillAddType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('collab_profile');
        }

        return $this->render('collab_skill/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    #[Route("/compte/supprimer-skill-collab/{id}", name:"collab_skill_delete")]
     
    public function delete($id)
    {
        $user = $this->getUser();
        $skill=  $this->entityManager->getRepository(Skill::class)->find($id);
        $skill->removeUser($user);
        $this->entityManager->flush();
        $this->addFlash('danger', "Un compétence a bien été supprimé");
        
        return $this->redirectToRoute('collab_profile');
    }



    // FOR COMMERCIAL MODIFICATION
    #[Route('/collabs/skill/add/{id}', name: 'commercial_add_skill_collab')]

    public function add2(Request $request, $id)
    {
        $skill = new Skill();
        $user = $this->entityManager->getRepository(User::class)->find($id);

        $form    = $this->createForm(SkillAddType::class, $skill);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skill->addUser($user);
            
            $this->entityManager->persist($skill);
            $this->entityManager->flush();


           

            return $this->redirectToRoute('collab_profile_item', array('user' => $id));
        }

        return $this->render('collab_skill/index.html.twig', [
            'form' => $form->createView(),
            'user' => $user

        ]);
    }


    #[Route("/collabss/skill/modify/{user}/{id}", name:"commercial_edit_skill_collab")]
    
    public function edit2(Request $request, $user, $id)
    {
        $user2= $this->entityManager->getRepository(User::class)->find($user);
        $skill = $this->entityManager->getRepository(Skill::class)->find($id);
        $form = $this->createForm(SkillAddType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('collab_profile_item', array('user'=> $user));
        }

        return $this->render('collab_skill/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    #[Route("/compte/supprimer-skill-collab/{user}/{id}", name:"commercial_delete_skill_collab")]
     
    public function delete2($user, $id)
    {
        $user2= $this->entityManager->getRepository(User::class)->find($user);
        $skill=  $this->entityManager->getRepository(Skill::class)->find($id);
        $skill->removeUser($user2);
        $this->entityManager->flush();
        $this->addFlash('danger', "Un compétence a bien été supprimé");
        
        return $this->redirectToRoute('collab_profile_item', array('user'=> $user));
    }
}





