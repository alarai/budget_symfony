<?php

namespace App\Repository;

use App\Entity\Historique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class HistoriqueRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Historique::class);
    }

    public function getMonthList() {
        $qb = $this->createQueryBuilder('h')
                    ->select(['h.annee', 'h.mois'])
                    ->groupBy('h.annee')
                    ->addGroupBy('h.mois')
                    ->orderBy('h.annee', 'DESC')
                    ->addOrderBy('h.mois', 'DESC')
                    ->getQuery();

        return $qb->execute();
    }

    public function getMonthListByCat($year, $month) {
        $qb = $this->createQueryBuilder('h')
            ->select("ABS(SUM(h.valeur)) AS y, cat.nom AS name")
            ->innerJoin('App\Entity\Categories', 'cat', 'WITH', 'h.categorie = cat.idcategories')
            ->groupBy('h.categorie')
            ->where('h.annee = ?1')
            ->andWhere('h.mois = ?2')
            ->andWhere('h.opRecur IS NULL')
            ->andWhere('h.valeur < 0')
            ->setParameter(1, $year)
            ->setParameter(2, $month)
            ->getQuery();

        return $qb->execute();
    }
}
