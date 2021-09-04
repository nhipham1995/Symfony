<?php

namespace App\Controller;

use App\Entity\User;
use App\Data\SearchData;
use App\Form\SearchType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
     * Class CommercialController
     *
     * @IsGranted("ROLE_COMMERCIAL")
     *
     * @package App\Controller
*/
class CommercialController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/commercial/dashboard', name: 'commercial_dashboard')]
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $candidat = $this->entityManager->getRepository(User::class)->findByRole( "ROLE_CANDIDAT");
        $collab = $this->entityManager->getRepository(User::class)->findByRole( "ROLE_COLLABORATEUR");
        

        return $this->render('commercial/index.html.twig', [
            'user'      => $user,
            'candidat'  => $candidat,
            'collab'    => $collab,
        ]);
    }

    #[Route('/commercial/dashboard/list', name: 'list_search')]
    public function search(Request $request, UserRepository $repository): Response
    {
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);
        $nom = $request->query->get('nom');
        $skill = $request->query->get('skills');
        $data->nom = $nom;
        $data->skills = $skill;
        $resultats = $repository->findSearch($data);

        return $this->render('commercial/list.html.twig', [
            'resultats'  => $resultats,
            'form' => $form->createView(),
        ]);
    }

}
