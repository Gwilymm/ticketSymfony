<?php

namespace App\Controller;

use App\Entity\Ticket;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    /**
     * @Route("/ticket", name="app_ticket")
     */
    public function index(ManagerRegistry $doctrine): Response
    {

        $repository = $doctrine->getRepository(Ticket::class);
        $tickets = $repository->findAll();
        dd($tickets);

        return $this->render('ticket/index.html.twig', [
            'controller_name' => 'TicketController',
        ]);
    }
}
