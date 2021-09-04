<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Document;
use App\Form\CollabProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
     * Class CollaborateurController
     *
     * @IsGranted("ROLE_COLLABORATEUR")
     *
     * @package App\Controller
*/
class CollaborateurController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/collaborateur/profile', name: 'collab_profile')]
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        //dd($user);
        return $this->render('collaborateur/index.html.twig', [
            'user' => $user,
        ]);
    }
    
    #[Route('/collaborateur/list', name: 'collab_list')]
    public function index4(Request $request): Response
    {
        $collab = $this->entityManager->getRepository(User::class)->findByRole( "ROLE_COLLABORATEUR");

        return $this->render('collaborateur/list.html.twig', [
            'user' => $collab,
        ]);
    }
    #[Route('/collaborateur/profile/edit', name: 'collab_profile_edit')]
    public function edit(Request $request, SluggerInterface $slugger)
    {
        $user = $this->getUser();
        $form = $this->createForm(CollabProfileType::class, $user);
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
                $document->setUser($user);
                $document->setOwner($user);
                $document->setNom($newFilename);
                $document->setLabel('PDF');
                $user->addDocument($document);


                $this->entityManager->persist($document);
                $this->entityManager->persist($user);
                $this->entityManager->flush();

            }





            return $this->redirectToRoute('collab_profile');
        }

        return $this->render('collaborateur/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/collab/profile/edit/{user}', name: 'collab_profile_edit_item')]
    public function edit2(Request $request, $user, SluggerInterface $slugger)
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

            return $this->redirectToRoute('collab_profile_item', array('user' => $id));
        }

        return $this->render('collaborateur/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/collaborateur/{user}', name: 'collab_profile_item')]
    public function index2(Request $request, $user): Response
    {
        $collab = $this->entityManager->getRepository(User::class)->find($user);
        return $this->render('collaborateur/item.html.twig', [
            'user' => $collab,
        ]);
    }





    
}
