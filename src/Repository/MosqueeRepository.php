<?php

namespace App\Repository;

use App\Entity\Mosquee;
use App\Entity\MosqueeSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Mosquee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mosquee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mosquee[]    findAll()
 * @method Mosquee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MosqueeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Mosquee::class);
    }

    public function myFindAllQuery(MosqueeSearch $search)
    {
        $query = $this->createQueryBuilder('m')
            ->orderBy('m.name', 'ASC');

        if($search->getNom()){
          $query = $query
            ->andWhere('m.name LIKE :nom')
            ->setParameter('nom', '%'.addcslashes($search->getNom(), '%_').'%');
        }

        if($search->getLocalisation()){
          $query = $query
            ->andWhere('m.localisation LIKE :localisation')
            ->setParameter('localisation', '%'.addcslashes($search->getLocalisation(), '%_').'%');
        }

        if($search->getUser()){
          $query = $query
            ->join('m.user', 'u')
            ->addSelect('u')
            ->andWhere('m.user = :user')
            ->setParameter('user', $search->getUser()->getId());
        }

        return $query->getQuery();
    }

    public function userMosquees(int $id)
    {
        $query = $this->createQueryBuilder('m')
            ->orderBy('m.name', 'ASC')
            ->join('m.user', 'u')
            ->addSelect('u')
            ->andWhere('m.user = :user')
            ->setParameter('user', $id);
            
        return $query->getQuery();
    }

    /*
    public function findOneBySomeField($value): ?Mosquee
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
