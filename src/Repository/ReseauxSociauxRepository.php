<?php

namespace App\Repository;

use App\Entity\ReseauxSociaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ReseauxSociaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReseauxSociaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReseauxSociaux[]    findAll()
 * @method ReseauxSociaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReseauxSociauxRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ReseauxSociaux::class);
    }

    // /**
    //  * @return ReseauxSociaux[] Returns an array of ReseauxSociaux objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReseauxSociaux
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
