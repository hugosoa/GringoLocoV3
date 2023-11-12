<?php

namespace App\Controller;

use GMP;
use App\Entity\Gallery;
use App\Form\GalleryFormType;
use App\Repository\GalleryRepository;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GalleryController extends AbstractController
{
    #[Route('/galerie', name: 'app_gallery')]
    public function index(GalleryRepository $galleryRepository): Response
    {
        $gallery = $galleryRepository->findBy([], ['id' => 'DESC']);

        return $this->render('gallery/index.html.twig', [
            'galleries' => $gallery,
        ]);
    }

    #[Route('/galerie/ajouter', name: 'app_add_gallery')]
    public function addGallery(Request $request, ManagerRegistry $doctrine): Response
    {
        $gallery = new Gallery;
        $form = $this->createForm(GalleryFormType::class, $gallery);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $gallery->setAuthor($this->getUser());
            $em = $doctrine->getManager();
            $em->persist($gallery);
            $em->flush();

            $this->addFlash(
                'success',
                'La photo a été ajoutée avec succès'
            );

            return $this->redirectToRoute('app_gallery');
        }

        return $this->render('gallery/add-gallery.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/galerie/suppression/{id}', name: 'app_delete_gallery', methods: ['GET'])]
    public function delete(ManagerRegistry $doctrine, Gallery $gallery, Request $request, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $token = new CsrfToken('delete-gallery', $request->query->get('_csrf_token'));
        if ($this->getUser() !== $gallery->getAuthor()) {
            return $this->redirectToRoute("app_login");
        }
        if ($csrfTokenManager->isTokenValid($token)) {
            $em = $doctrine->getManager();
            $em->remove($gallery);
            $em->flush();

            $this->addFlash(
                'delete',
                'La photo a été supprimée avec succès'
            );
        }


        return $this->redirectToRoute('app_gallery');
    }
}
