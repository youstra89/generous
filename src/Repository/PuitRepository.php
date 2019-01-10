<?php

namespace App\Repository;

use App\Entity\Puit;
use App\Entity\PuitSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Puit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Puit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Puit[]    findAll()
 * @method Puit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PuitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Puit::class);
    }

    // /**
    //  * @return Puit[] Returns an array of Puit objects
    //  */
    public function myFindAllQuery(PuitSearch $search)
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.name', 'ASC');

        if($search->getNom()){
          $query = $query
            ->andWhere('p.name LIKE :nom')
            ->setParameter('nom', '%'.addcslashes($search->getNom(), '%_').'%');
        }

        if($search->getLocalisation()){
          $query = $query
            ->andWhere('p.localisation LIKE :localisation')
            ->setParameter('localisation', '%'.addcslashes($search->getLocalisation(), '%_').'%');
        }

        if($search->getUser()){
          $query = $query
            ->join('p.user', 'u')
            ->addSelect('u')
            ->andWhere('p.user = :user')
            ->setParameter('user', $search->getUser()->getId());
        }

        return $query->getQuery();
    }

    public function userPuits(int $id)
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.name', 'ASC')
            ->join('p.user', 'u')
            ->addSelect('u')
            ->andWhere('p.user = :user')
            ->setParameter('user', $id);

        return $query->getQuery();
    }

    /*
    public function findOneBySomeField($value): ?Puit
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
