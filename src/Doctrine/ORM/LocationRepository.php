<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Sil\Bundle\StockBundle\Doctrine\ORM;

use Sil\Bundle\StockBundle\Domain\Repository\LocationRepositoryInterface;
use Blast\Bundle\ResourceBundle\Doctrine\ORM\Repository\ResourceRepository;
use Sil\Bundle\StockBundle\Domain\Entity\Location;
use Sil\Bundle\StockBundle\Domain\Entity\LocationType;
use Sil\Bundle\StockBundle\Domain\Entity\StockItemInterface;

/**
 * @author glenn
 */
class LocationRepository extends ResourceRepository implements LocationRepositoryInterface
{

    public function createQueryBuilder($alias, $indexBy = null)
    {
        $qb = parent::createQueryBuilder($alias, $indexBy);
        $qb->orderBy($alias . '.treeRoot', 'ASC')
            ->orderBy($alias . '.treeLft', 'ASC');


        return $qb;
    }

    public function findAll()
    {
        return $this->createQueryBuilder('o')->getQuery()->getResult();
    }

    public function findInternals(): array
    {
        $qb = $this->createQueryBuilder('l')
            ->where('l.typeValue = :type')
            ->setParameter('type', LocationType::INTERNAL);

        return $qb->getQuery()->getResult();
    }

    public function findByOwnedItem(StockItemInterface $item,
        ?string $locationType = null)
    {
        $qb = $this->createQueryBuilder('l')
            ->Join('Sil\Bundle\StockBundle\Domain\Entity\StockUnit', 'su',
                'WITH', 'su.location = l.id')
            ->where('su.stockItem = :item')
            ->setParameter('item', $item);

        if ( null !== $locationType ) {
            $qb
                ->andWhere('l.typeValue = :locationType')
                ->setParameter('locationType', $locationType);
        }
        return $qb->getQuery()->getResult();
    }
}
