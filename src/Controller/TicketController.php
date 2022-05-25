<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/ticket")
 */
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
     * @Route("/", name="app_ticket")
     */
    public function index(TicketRepository $repository): Response
    {
        $user = $this->getUser();

        $tickets = $repository->findAll();


        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }



    /**
     * @Route("/userForm", name="ticket_create")
     *  @Route("/update/{id}", name="ticket_update",requirements={"id"="\d+"})
     * 
     */


    public function ticket(Request $request, Ticket $ticket = null)
    {
        if (!$ticket) {
            $ticket = new Ticket;
            $ticket->setIsActive(true)
                ->setCreatedAt(new \DateTimeImmutable());
            $title = 'Création d\'un ticket';
        } else {
            $title = "Modification du ticket n° : {$ticket->getId()}";
        }



        $form = $this->createForm(TicketType::class, $ticket, []);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->ticketRepository->add($ticket, true);
            return $this->redirectToRoute('app_ticket');
        }

        return $this->render(
            'ticket/userForm.html.twig',
            [
                'form' => $form->createView(),
                'title' => $title
            ]
        );
    }
    /**
     * @Route("/delete/{id}",name="ticket_delete",requirements={"id"="\d+"})
     *
     * @param Ticket $ticket
     * @return Reponse
     */
    public function deleteTicket(Ticket $ticket): Response
    {
        $this->ticketRepository->remove($ticket, true);

        return $this->redirectToRoute('app_ticket');
    }
}
