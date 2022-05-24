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
     * @Route("/ticket/userForm", name="ticket_create")
     */
    /**
     * Il crée un nouveau ticket, définit la date de création et le statut actif sur vrai, crée un
     * formulaire, gère la demande, vérifie si le formulaire est soumis et valide, ajoute le ticket à la
     * base de données et redirige vers la page du ticket
     * @param Request  $request - L'objet de la requête.
     * 
     * Generated on 05/24/2022 Gwilymm
     */
    public function creatTicket(Request $request)
    {

        $ticket = new Ticket;

        $ticket->setIsActive(true)
            ->setCreatedAt(new \DateTimeImmutable());

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
                'title' => 'Création d\'un ticket'
            ]
        );
    }

    /**
     * @Route("/ticket/update/{id}", name="ticket_update",requirements={"id"="\d+"})
     *
     * @param Request $request
     *
     */
    public function updateTicket(Ticket $ticket, Request $request)
    {

        $form = $this->createForm(TicketType::class, $ticket, []);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->ticketRepository->update($ticket, true);
            return $this->redirectToRoute('app_ticket');
        }

        return $this->render(
            'ticket/userForm.html.twig',
            [
                'form' => $form->createView(),
                'title' => "Modification du ticket n° : {$ticket->getId()}"
            ]
        );
    }
}
