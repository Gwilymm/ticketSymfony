<?php

namespace App\Controller;

use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    protected TicketRepository $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * @Route("/{_locale}/", name="app_home", requirements={"_locale": "en|fr"})
     */
    public function index(): Response
    {
        // $countActiveTicket = count($this->ticketRepository->getAllActive());
        // $countNoActiveTicket = count($this->ticketRepository->getAllNoActive());
        $countActiveTicket = count($this->ticketRepository->findBy(['ticket_statut' => 'initial']));
        $countNoActiveTicket = count($this->ticketRepository->findBy(['ticket_statut' => 'finished']));

        $tabDep = [];
        $tabTickets = [];

        $countDepGroupBy = $this->ticketRepository->getAllDep();
        //$countDepGroupBy = $this->ticketRepository->findAll('ticket_statut');

        foreach ($countDepGroupBy as $key => $tickets) {
            $tabTickets[] = $tickets[1];
            $tabDep[] = "\"" . $tickets[2] . "\"";
        }

        return $this->render('home/index.html.twig', [
            'countActive' => $countActiveTicket,
            'countNoActive' => $countNoActiveTicket,
            'countDep' => $countDepGroupBy,
            'nbTickets' => $tabTickets,
            'nameDep' => implode(",", $tabDep),

        ]);

        return $this->render('home/index.html.twig', [
            'countActive' => $countActiveTicket,
            'countNoActive' => $countNoActiveTicket,
        ]);
    }

    /**
     *@Route("/")
     * 
     */
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('app_home', ['_locale' => 'fr']);
    }
}
