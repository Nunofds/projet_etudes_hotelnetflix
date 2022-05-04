<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Booking $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Booking $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Booking[] Returns an array of Booking objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
// src/Repository/ProductRepository.php

// ...
/*    public function findBookingsByCheckin(date $checkin, bool $includeUnavailableProducts = false): array
    {
        // automatically knows to select exsiting booking where checkin falls between 2 provided dates as parameters
        // the "p" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('b')
            ->where('b.checkin < :checkin')
            ->andwhere('b.checkout > :checkin')
            ->setParameter('checkin', $checkin)
            ->setParameter('checkout', $checkout)

            ->orderBy('b.checkin', 'ASC');

        if (!$includeUnavailableProducts) {
            $qb->andWhere('b.available = TRUE');
        }

        $query = $qb->getQuery();

        return $query->execute();

        // to get just one result:
        // $product = $query->setMaxResults(1)->getOneOrNullResult();
    }
    */

    public function findOneBookingByCheckin($checkin, $serie, $formule): ?Booking
    {
        return $this->createQueryBuilder('b')
            ->where('b.serie = :serie')
            ->andwhere('b.formule = :formule')
            ->andwhere('b.checkin <= :checkin')
             ->andwhere('b.checkout >= :checkin')
             ->setParameter('checkin', $checkin)
             ->setParameter('serie', $serie)
             ->setParameter('formule', $formule)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
        ;
    }
    public function findOneBookingByCheckout($checkout, $serie, $formule): ?Booking
    {
        return $this->createQueryBuilder('b')
        ->where('b.serie = :serie')
        ->andwhere('b.formule = :formule')
         ->andwhere('b.checkin <= :checkout')
             ->andwhere('b.checkout >= :checkout')
             ->setParameter('checkout', $checkout)
             ->setParameter('serie', $serie)
             ->setParameter('formule', $formule)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
        ;
    }

    public function findOneBookingByBoth($checkin, $checkout, $serie, $formule): ?Booking
    {
        return $this->createQueryBuilder('b')
        ->where('b.serie = :serie')
        ->andwhere('b.formule = :formule')
         ->andwhere('b.checkin >= :checkin')
             ->andwhere('b.checkout <= :checkout')
             ->setParameter('checkin', $checkin)   
             ->setParameter('checkout', $checkout)
             ->setParameter('serie', $serie)
             ->setParameter('formule', $formule)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
        ;
    }



}
