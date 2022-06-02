<?php

namespace App\Repository;

use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ticket>
 *
 * @method Ticket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ticket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ticket[]    findAll()
 * @method Ticket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketRepository extends ServiceEntityRepository
{
    /**
     * Cette fonction ajoute un nouveau ticket à la base de données.
     * 
     * @param ManagerRegistry registry Le registre de la Doctrine.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    public function add(Ticket $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Cette fonction supprime un ticket de la base de données.
     * 
     * @param Ticket entity Entité à supprimer.
     * @param bool flush Si vrai, le gestionnaire d'entités videra les modifications dans la base de
     * données.
     */
    public function remove(Ticket $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getAllDep()
    {
        return $this->createQueryBuilder('t')
            ->select('COUNT(t.departement), (d.name)')
            ->join('App\Entity\Departement', 'd', 'WITH', 't.departement = d.id')
            ->groupBy('t.departement')
            ->getQuery()
            ->getResult();
    }

    /**
     * Obtenez tous les tickets actifs.
     * 
     * @return array tableau d'objets.
     */
    public function getAllActive()
    {
        return $this->createQueryBuilder('t')
            ->where("t.ticketStatut = 'initial'")
            ->getQuery()
            ->getResult();
    }

    /**
     * Il renvoie tous les enregistrements où le champ isActive est égal à 0.
     * 
     * @return array tableau d'objets.
     */
    public function getAllNoActive()
    {
        return $this->createQueryBuilder('t')
            ->where("t.ticketStatut = 'finished'")
            ->getQuery()
            ->getResult();
    }

   /**
    * Obtenez tous les billets avec un statut spécifique
    * 
    * @param value la valeur du statut que vous souhaitez obtenir
    * 
    * @return array tableau d'objets Ticket.
    */
    public function getAllWithStatus($value): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.ticketStatut = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Ticket[] Returns an array of Ticket objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Ticket
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
