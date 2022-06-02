<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\User;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Registry;
use Symfony\Component\Workflow\WorkflowInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/{_locale}/ticket", requirements={"_locale": "en|fr"})
 */
class TicketController extends AbstractController
{

    protected TicketRepository $ticketRepository;

    protected TranslatorInterface $translator;

    protected MailerInterface $mailer;

    protected LoggerInterface $logger;


    /**
     * Undocumented function
     * @todo add something
     * @param TicketRepository $ticketRepository
     */

    public function __construct(
        TicketRepository $ticketRepository,
        Registry $registry,
        TranslatorInterface $translator,
        MailerInterface $mailer,
        LoggerInterface $logger

    ) {
        $this->ticketRepository = $ticketRepository;
        $this->translator = $translator;
        $this->registry = $registry;
        $this->translator = $translator;
        $this->mailer = $mailer;
        $this->logger = $logger;
    }



    /**
     * @Route("/", name="app_ticket")
     */
    public function index(TicketRepository $repository): Response
    {

        if ($this->getUser()) {

            $userMail = $this->getUser()->getUserIdentifier();
            $userPwd = $this->getUser()->getPassword();
            $userRole = $this->getUser()->getRoles();

            $this->logger->info('EMAIL', array($userMail));
            $this->logger->info('PASSWORD', array($userPwd));
            $this->logger->info('ROLE', array($userRole));
        }


        $user = $this->getUser();

        if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            $tickets = $this->ticketRepository->findAll();
        } else {
            $tickets = $this->ticketRepository->findBy(['user' => $user]);
        };

        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    /**
     * * I want to change the status of the ticket when it is consulted.
     * I want to change the currentPlace of initial to wip with the workflow.
     * 
     * @param Request  $request - The request object.
     * @param Ticket  $ticket - The object that will be used to initialize the form.
     * 
     * Generated on 05/30/2022 Gwilymm
     */
    /** 
     * @Route("/userForm", name="ticket_create")
     * @Route("/update/{id}", name="ticket_update",requirements={"id"="\d+"})
     * 
     */
    public function ticket(Request $request, Ticket $ticket = null)
    {
        $user = $this->getUser();

        if (!$ticket) {
            $ticket = new Ticket;

            $ticket->setTicketStatut("initial")
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUser($user);

            $title = $this->translator->trans("title.ticket.create");
        } else {

            $title = $this->translator->trans("title.ticket.update") . "{$ticket->getId()}";
            $workflow = $this->registry->get($ticket, 'ticketTraitement');
            if ($ticket->getTicketStatut() != "wip") {
                $workflow->apply($ticket, 'to_wip');
            }
        }


        $form = $this->createForm(TicketType::class, $ticket, []);

        // modifier le status du ticket quand il est consulté
        // changer le currentPlace de initial à wip avec le workflow


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->ticketRepository->add($ticket, true);
            if ($request->attributes->get('_route') === 'ticket_creation') {
                $this->addFlash(
                    'success',
                    'Votre ticket a bien été ajouté'
                );
                MailerController::sendEmail($this->mailer, "cornedecheval@BHN.bzh", "Ticket ajouté", " a bien été ajouté", $ticket);
            } else {
                $this->addFlash(
                    'info',
                    'Votre ticket a bien été mis à jour'
                );
                MailerController::sendEmail($this->mailer, "cornedecheval@BHN.bzh", "Ticket modifié", " a bien été modifié", $ticket);
            }



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

    public function deleteTicket(Ticket $ticket, MailerInterface $mailer): Response
    {

        if ($ticket->getTicketStatut() == 'finished') {
            # code...
            $this->ticketRepository->remove($ticket, true);
            $this->addFlash(
                'warning',
                'Votre ticket a bien été supprimé'
            );
            MailerController::sendEmail($this->mailer, "user1@test.fr", "Ticket Supprimé", " a bien été supprimé", $ticket);
        } else {
            $this->addFlash(
                'warning',
                'Votre ticket n\'est pas fermé'
            );
        }

        return $this->redirectToRoute('app_ticket');
    }





    /**
     * It closes a ticket
     * @param Ticket  $ticket - The object that is being passed through the workflow.
     * @returns A response object.
     * 
     * Generated on 05/30/2022 Gwilymm
     */
    /** 
     * @Route("/close/{id}", name="ticket_close",requirements={"id"="\d+"})
     */
    public function closeTicket(Ticket $ticket): Response
    {
        $workflow = $this->registry->get($ticket, 'ticketTraitement');
        $workflow->apply($ticket, 'to_finished');
        $this->ticketRepository->add($ticket, true);



        return $this->redirectToRoute('app_ticket');
    }
    /**
     * @Route("/details/{id}", name="ticket_detail", requirements={"id"="\d+"})
     */

    public function detailTicket(Ticket $ticket): Response
    {

        return $this->render('ticket/detail.html.twig', ['ticket' => $ticket]);
    }
}
