<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{


    protected TicketRepository $ticketRepository;


    /**
     * Undocumented function
     * @todo add something
     * @param TicketRepository $ticketRepository
     */

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }



    /**
     * @Route("/ticket", name="app_ticket")
     */
    public function index(TicketRepository $repository): Response
    {


        $tickets = $repository->findAll();


        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    /**
     * @Route("/ticket/create", name="ticket_create")
     */
    public function creatTicket(Request $request)
    {

        $ticket = new Ticket;

        $form = $this->createForm(TicketType::class, $ticket, []);



        return $this->render(
            'ticket/create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
