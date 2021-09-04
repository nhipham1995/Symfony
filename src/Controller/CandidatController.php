<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Document;
use App\Form\CollabProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
     * Class CandidatController
     *
     * @IsGranted("ROLE_COMMERCIAL")
     *
     * @package App\Controller
*/

class CandidatController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/candidat/{user}', name: 'candidat_item')]
    public function index(Request $request, $user): Response
    {
        $candidat = $this->entityManager->getRepository(User::class)->find($user);
        return $this->render('candidat/index.html.twig', [
            'user' => $candidat,
        ]);
    }

        
    #[Route('/candidats/list', name: 'candidats_list')]
    public function index2(Request $request): Response
    {
        $candidats = $this->entityManager->getRepository(User::class)->findByRole( "ROLE_CANDIDAT");
        return $this->render('candidat/list.html.twig', [
            'user' => $candidats,
        ]);
    }

    #[Route('/candidat/profile/edit/{user}', name: 'candidat_profile_edit')]
    public function edit(Request $request, $user,  SluggerInterface $slugger)
    {
        $user2 = $this->entityManager->getRepository(User::class)->find($user);
        $id = $user2->getId();
        $form = $this->createForm(CollabProfileType::class, $user2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            


            /** @var UploadedFile $brochureFile */
            $file = $form->get('document')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('document_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents

                $document = new Document();
                $document->setUser($user2);
                $document->setOwner($user2);
                $document->setNom($newFilename);
                $document->setLabel('PDF');
                $user2->addDocument($document);


                $this->entityManager->persist($document);
                $this->entityManager->persist($user2);
                $this->entityManager->flush();

            }




            return $this->redirectToRoute('candidat_item', array('user' => $id));
        }

        return $this->render('collaborateur/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

 
    
}
