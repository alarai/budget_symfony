<?php

namespace App\Repository;

use App\Entity\Courant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CourantRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Courant::class);
    }

    public function getByCategorie() {
        $qb = $this->createQueryBuilder('c')
            ->select("ABS(SUM(c.valeur)) AS y, cat.nom AS name")
            ->innerJoin('App\Entity\Categories', 'cat', 'WITH', 'c.categorie = cat.idcategories')
            ->groupBy('c.categorie')
            ->where('c.opRecur IS NULL')
            ->andWhere('c.valeur < 0')
            ->getQuery();

        return $qb->execute();
    }

    public function getRemainingPassed() {
        $qb = $this->createQueryBuilder('c')
            ->select("SUM(c.valeur) AS valeur")
            ->andWhere('c.surcompte = 1')
            ->getQuery();

        return $qb->execute()[0];
    }

    public function getRemainingTotal() {
        $qb = $this->createQueryBuilder('c')
            ->select("SUM(c.valeur) AS valeur")
            ->getQuery();

        return $qb->execute()[0];
    }
}
