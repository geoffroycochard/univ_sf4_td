<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/ticket-crud")
 */
class TicketCrudController extends AbstractController
{
    /**
     * @Route("/", name="ticket_crud_index")
     */
    public function index(EntityManagerInterface $manager)
    {
        $tickets = $manager->getRepository('App:Ticket')->findAll();
        
        return $this->render('ticket_crud/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    /**
     * @Route("/search", name="ticket_crud_search")
     */
    public function search(Request $request, EntityManagerInterface $manager)
    {
        
        $s = $request->get('search');

        $qb = $manager->getRepository('App:Ticket')->createQueryBuilder('t');

        $qb
            ->leftJoin('t.users', 'u')
            ->leftJoin('t.category', 'c');

        $orX = $qb->expr()->orX();
        $orX->add($qb->expr()->like('t.title', ':search'));
        $orX->add($qb->expr()->like('t.description', ':search'));
        $orX->add($qb->expr()->like('u.name', ':search'));
        $orX->add($qb->expr()->like('c.name', ':search'));
        $qb->where($orX);
        $qb->setParameter('search', '%'.$request->get('search').'%');
        
        $tickets = $qb->getQuery()->getResult();

        $this->addFlash(
            'warning',
            sprintf('Ticket filtered by <strong>%s</strong>!', $request->get('search'))
        );
        
        return $this->render('ticket_crud/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    /**
     * @Route("/view/{ticket}", name="ticket_crud_view")
     */
    public function view(Ticket $ticket)
    {
        return $this->render('ticket_crud/view.html.twig', [
            'ticket' => $ticket
        ]);
    }

    /**
     * @Route("/create", name="ticket_crud_create")
     */
    public function create(Request $request, ObjectManager $manager) 
    {
        $form = $this->createForm(TicketType::class);

        $form->handleRequest($request);

        if ($form->issubmitted() && $form->isValid()) {
            $ticket = $form->getData();
            $manager->persist($ticket);
            $manager->flush();
            $this->addFlash(
                'info',
                'Ticket created!'
            );
            //
            return $this->redirectToRoute('ticket_crud_view', ['ticket' => $ticket->getId()]);
        }

        return $this->render('ticket_crud/create.html.twig', 
        [
            'form' => $form->createView()
        ]); 
    }

    /**
     * @Route("/update/{ticket}", name="ticket_crud_update")
     */
    public function update(Ticket $ticket, Request $request, ObjectManager $manager) 
    {
        $form = $this->createForm(TicketType::class, $ticket);

        $form->handleRequest($request);

        if ($form->issubmitted() && $form->isValid()) {
            $ticket = $form->getData();
            $manager->persist($ticket);
            $manager->flush(); $this->addFlash(
                'info',
                'Ticket updated!'
            );
            //
            return $this->redirectToRoute('ticket_crud_view', ['ticket' => $ticket->getId()]);
        }

        return $this->render('ticket_crud/update.html.twig', 
        [
            'form' => $form->createView()
        ]); 
    }

    /**
     * @Route("/delete/{ticket}", name="ticket_crud_delete")
     */
    public function delete(Ticket $ticket, ObjectManager $manager) 
    {
        $manager->remove($ticket);
        $manager->flush();

        return $this->redirectToRoute('ticket_crud_index');
    }
    

}
