<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\User;
use App\Entity\Ticket;
use App\Form\TicketType;
use Psr\Log\LoggerInterface;
use App\Controller\MailerController;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\Workflow\Registry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\WorkflowInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    /**
     * @Route("/pdf", name="ticket_pdf")
     */
    public function pdf(): Response
    {
        //Données utiles
        $user = $this->getUser();
        $tickets = $this->ticketRepository->findBy(['user' => $user]);

        //Configuration de Dompdf
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        //Instantiation de Dompdf
        $dompdf = new Dompdf($pdfOptions);

        //Récupération du contenu de la vue
        $html = $this->renderView('ticket/pdf.html.twig', [
            'tickets' => $tickets,
            'title' => "Bienvenue sur notre page PDF"
        ]);

        //Ajout du contenu de la vue dans le PDF
        $dompdf->loadHtml($html);

        //Configuration de la taille et de la largeur du PDF
        $dompdf->setPaper('A4', 'portrait');

        //Récupération du PDF
        $dompdf->render();

        //Création du fichier PDF
        $dompdf->stream("ticket.pdf", [
            "Attachment" => true
        ]);

        return new Response('', 200, [
            'Content-Type' => 'application/pdf'
        ]);
    }
    /**
     * @Route("/excel", name="ticket_excel")
     */
    public function excel(): Response
    {

        //Données utiles
        $user = $this->getUser();
        $tickets = $this->ticketRepository->findBy(['user' => $user]);


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Liste des tickets pour l\'utilisateur : ' . $user->getUsername());
        $sheet->mergeCells('A1:E1');
        $sheet->setTitle("Liste des tickets");

        //Set Column names
        $columnNames = [
            'Id',
            'Objet',
            'Date de création',
            'Department',
            'Statut',
        ];
        $columnLetter = 'A';
        foreach ($columnNames as $columnName) {
            $sheet->setCellValue($columnLetter . '3', $columnName);
            $sheet->getColumnDimension($columnLetter)->setAutoSize(true);
            $columnLetter++;
        }
        foreach ($tickets as $key => $ticket) {
            $sheet->setCellValue('A' . ($key + 4), $ticket->getId());
            $sheet->setCellValue('B' . ($key + 4), $ticket->getObject());
            $sheet->setCellValue('C' . ($key + 4), $ticket->getCreatedAt()->format('d/m/Y'));
            $sheet->setCellValue('D' . ($key + 4), $ticket->getDepartement()->getName());
            $sheet->setCellValue('E' . ($key + 4), $ticket->getTicketStatut());
        }
        //Création du fichier xlsx
        $writer = new Xlsx($spreadsheet);

        //Création d'un fichier temporaire
        $fileName = "Export_Tickets.xlsx";
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // -- Style de la feuille de calcul --
        $styleArrayHead = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                ],
                'vertical' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FFA0A0A0',
                ],
                'endColor' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
        ];

        $styleArrayBody = [
            'alignement' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                ],
                'vertical' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'horizontal' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->getStyle('A1:E1')->applyFromArray($styleArray);
        $sheet->getStyle('A3:E3')->applyFromArray($styleArrayHead);
        $sheet->getStyle('A4:E' . (count($tickets) + 3))->applyFromArray($styleArrayBody);

        //Création du fichier xlsx
        $writer = new Xlsx($spreadsheet);


        //créer le fichier excel dans le dossier tmp du systeme
        $writer->save($temp_file);

        //Renvoie le fichier excel
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
