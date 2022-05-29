<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Registry;
use Symfony\Component\Workflow\WorkflowInterface;

/**
 * @Route("/ticket")
 */
class TicketController extends AbstractController
{

    protected TicketRepository $ticketRepository;

    private WorkflowInterface $ticketTraitement;


    /**
     * Undocumented function
     * @todo add something
     * @param TicketRepository $ticketRepository
     */

    public function __construct(TicketRepository $ticketRepository, Registry $registry)
    {
        $this->ticketRepository = $ticketRepository;
        $this->registry = $registry;
    }



    /**
     * @Route("/", name="app_ticket")
     */
    public function index(TicketRepository $repository): Response
    {
        $user = $this->getUser();

        $tickets = $repository->findAll();

        

        //dd($tickets);


        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    /**
     * @Route("/userForm", name="ticket_create")
     * @Route("/update/{id}", name="ticket_update",requirements={"id"="\d+"})
     * 
     */


    public function ticket(Request $request, Ticket $ticket = null)
    {
        if (!$ticket) {
            $ticket = new Ticket;

            $ticket->setIsActive(true)
                ->setCreatedAt(new \DateTimeImmutable());
            $title = 'Création d\'un ticket';
            $this->ticketTraitement->apply($ticket, 'to_wip');
        } else {
            $title = "Modification du ticket n° : {$ticket->getId()}";
        }


        $form = $this->createForm(TicketType::class, $ticket, []);

        // modifier le status du ticket quand il est consulté
        // changer le currentPlace de initial à wip avec le workflow
        $workflow = $this->registry->get($ticket, 'ticketTraitement');
        // erreur sur le type reçu par la method
        //$workflow->apply($ticket, 'to_client');
        dump($ticket);

        dd($workflow);

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

    /**
     * @Route("/update/{id}/{to}", name="ticket_workflow")
     */
    public function changeTicketWorkflow(Ticket $ticket, String $to, EntityManagerInterface $entityManager)
    {
        $this->ticketTraitement->apply($ticket, $to);

        $entityManager->persist($ticket);
        $entityManager->flush();

        $this->addFlash('success', "Ticket pris en charge !");

        return $this->redirectToRoute('ticket_update');
    }
}
