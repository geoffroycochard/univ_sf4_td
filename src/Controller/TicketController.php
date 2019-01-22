<?php

namespace App\Controller;

use App\Entity\Ticket;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TicketController extends AbstractController
{
    /**
     * @Route("/ticket", name="ticket")
     */
    public function index()
    {

        $tickets = $this->getDoctrine()
            ->getRepository(Ticket::class)
            ->findAll();

        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets
        ]);
    }

    /**
     * @Route("/ticket/{id}", name="ticket_single")
     */
    public function single(Ticket $ticket)
    {
        return $this->render('ticket/single.html.twig', [
            'ticket' => $ticket
        ]);
    }
}
