<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Cocktail;
use App\Entity\Comment;
use App\Entity\Gallery;
use App\Entity\Ingredient;
use App\Entity\Reservation;
use App\Entity\User;
use App\Repository\CommentRepository;
use App\Repository\ReservationRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private ReservationRepository $reservationRepository;
    private CommentRepository $commentRepository;

    public function __construct(ReservationRepository $reservationRepository, CommentRepository $commentRepository)
    {
        $this->reservationRepository = $reservationRepository;
        $this->commentRepository = $commentRepository;
    }


    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {


        $getAllReservations = $this->reservationRepository->findAll();
        $getAllComments = $this->commentRepository->findAll();
        // dd($getAllReservations);

        return $this->render('admin/dashboard.html.twig', [
            'getAllReservations' => $getAllReservations,
            'getAllComments' => $getAllComments
        ]);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Gringo Logo')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        // Gestion des utilisateurs
        yield MenuItem::section('Gestion des utilisateurs', 'fas fa-users');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);

        // Gestion du contenu
        yield MenuItem::section('Gestion du contenu', 'fas fa-cog');
        yield MenuItem::linkToCrud('Articles', 'fas fa-newspaper', Article::class);
        yield MenuItem::linkToCrud('Gallerie', 'fas fa-image', Gallery::class);
        yield MenuItem::linkToCrud('Cocktails', 'fas fa-cocktail', Cocktail::class);
        yield MenuItem::linkToCrud('Ingredients', 'fas fa-list', Ingredient::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-table-columns', Category::class);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-comment', Comment::class);

        // Réservation
        yield MenuItem::section('Réservation', 'fas fa-calendar');
        yield MenuItem::linkToCrud('Réservation', 'fas fa-calendar-days', Reservation::class);

        // Retour au site public
        yield MenuItem::section('Retourner sur le site', 'fas fa-right-from-bracket');
        yield MenuItem::linkToUrl('Retourner sur le site', 'fa fa-globe', '/');
    }
}
