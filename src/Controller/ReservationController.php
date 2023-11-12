<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(Request $request, ManagerRegistry $doctrine, MailerInterface $mailer): Response
    {

        $reservation = new Reservation;
        $form = $this->createForm(ReservationFormType::class, $reservation);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $reservation->setAuthor($this->getUser());
            $em = $doctrine->getManager();
            $em->persist($reservation);
            $em->flush();
            // dd($reservation);
            // $email = (new Email())
            //     ->from($this->getUser()->getEmail())
            //     ->to('admin@gringoloco.com')
            //     ->subject('Réservation')
            //     ->html($reservation->getSpecialAsk(), 'Numéro de téléphone : ', $reservation->getNumTel());
            // $mailer->send($email);
            $this->addFlash('success', 'Demande de réservation prise en compte');
        }

        return $this->render('reservation/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
