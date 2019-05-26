<?php

namespace App\Repository;

use App\Entity\OpRecur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class OpRecurRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OpRecur::class);
    }

    public function getNotUsedInCourant() {
        $used = $this->createQueryBuilder('c1')->select('c1.idopRecur')->join('App\Entity\Courant', 'c2', 'WITH', 'c1.idopRecur = c2.opRecur');

        $notUsed = $this->createQueryBuilder('c3');
        $notUsed->where('c3.valeur <> 0')->andWhere($notUsed->expr()->notIn('c3.idopRecur', $used->getDQL()));

        return $notUsed->getQuery()->execute();
    }
}
