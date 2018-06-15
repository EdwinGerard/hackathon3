<?php

namespace App\Repository;

use App\Entity\Liked;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Liked|null find($id, $lockMode = null, $lockVersion = null)
 * @method Liked|null findOneBy(array $criteria, array $orderBy = null)
 * @method Liked[]    findAll()
 * @method Liked[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikedRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Liked::class);
    }

//    /**
//     * @return Like[] Returns an array of Like objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Like
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
