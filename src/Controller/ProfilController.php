<?php

namespace App\Controller;

use App\Form\EditPasswordFormType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\GalleryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(ArticleRepository $articleRepository, GalleryRepository $galleryRepository, CommentRepository $commentRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_register');
        }

        return $this->render(
            'profil/index.html.twig',
            [
                'user' => $this->getUser(),
                'galleries' => $galleryRepository->findBy([], ['id' => 'DESC']),
                'articles' => $articleRepository->findBy([], ['id' => 'DESC']),
                'comments' => $commentRepository->findBy([], ['id' => 'DESC'])
            ]

        );
    }
    #[Route('/profil/editer/motdepasse', name: 'app_edit_password')]
    public function editPassword(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();
        $form = $this->createForm(EditPasswordFormType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('oldPassword')->getData();
            $newPassword = $form->get('newPassword')->getData();
            if ($userPasswordHasher->isPasswordValid($user, $oldPassword)) {
                $this->addFlash(
                    'success',
                    'Mot de passe mis à jour'
                );
                $user->setPassword($userPasswordHasher->hashPassword($user, $newPassword));
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('app_profil');
            } else {
                $this->addFlash(
                    'warning',
                    "L'ancien mot de passe est incorrect"
                );
                return $this->redirectToRoute('app_edit_password');
            }
        }
        // else {
        // $this->addFlash(
        //         'warning',
        //         'Mot de passe actuel invalide '
        //     );
        //     // return $this->redirectToRoute('app_edit_password');
        // }


        return $this->render('profil/edit-password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
