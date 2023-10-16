<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleFormType;
use App\Form\CommentFormType;
use Doctrine\ORM\EntityManager;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ArticleController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function articles(ArticleRepository $articleRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $data = $articleRepository->findBy([], ['id' => 'DESC']);
        $articles = $paginatorInterface->paginate(
            $data,
            $request->query->getInt('page', 1),
            5
        );


        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/articles/ajouter', name: 'app_add_articles')]
    public function addArticle(Request $request, ManagerRegistry $doctrine): Response
    {
        $comment = new Comment;
        $form = $this->createForm(ArticleFormType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setAuthor($this->getUser());
            $em = $doctrine->getManager();
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('app_articles');
        }

        return $this->render('article/add-article.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/articles/editer/{slug}', name: 'app_edit_articles')]
    public function articlesEdit(Article $article, Request $request, ManagerRegistry $doctrine): Response
    {
        //ParamConverter avec le slug
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('app_articles');
        }

        $this->addFlash(
            'edit',
            'Article modifier avec succès'
        );

        return $this->render('article/add-article.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/article/suppression/{slug}', name: 'app_delete_articles', methods: ['GET'])]
    public function delete(ManagerRegistry $doctrine, Article $article, Request $request, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $token = new CsrfToken('delete-article', $request->query->get('_csrf_token'));
        if ($this->getUser() !== $article->getAuthor()) {
            return $this->redirectToRoute("app_login");
        }
        if ($csrfTokenManager->isTokenValid($token)) {
            $em = $doctrine->getManager();
            $em->remove($article);
            $em->flush();
        }

        $this->addFlash(
            'delete',
            'Article supprimer avec succès'
        );

        return $this->redirectToRoute('app_articles');
    }

    #[Route('/articles/{slug}', name: 'app_view_articles')]
    public function articlesView(Article $article, EntityManagerInterface $entityManager, Request $request): Response
    {
        //ParamConverter avec le slug
        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setAuthor($this->getUser());
            $comment->setArticle($article);
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('app_view_articles', ['slug' => $article]);
        }
        return $this->render('article/view-article.html.twig', [
            'articles' => $article,
            'comments' => $article->getComments(),
            'createComment' => $form->createView(),
            // 'comments' => $comments
        ]);
    }
}
