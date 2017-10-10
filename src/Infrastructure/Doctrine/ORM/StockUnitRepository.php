<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Sil\Bundle\StockBundle\Infrastructure\Doctrine\ORM;

use Sil\Bundle\StockBundle\Domain\Repository\StockUnitRepositoryInterface;
use Blast\Bundle\ResourceBundle\Doctrine\ORM\Repository\ResourceRepository;
use Sil\Bundle\StockBundle\Domain\Entity\Movement;
use Sil\Bundle\StockBundle\Domain\Entity\StockItemInterface;
use Sil\Bundle\StockBundle\Domain\Entity\Location;
use Sil\Bundle\StockBundle\Domain\Entity\LocationType;
use Sil\Bundle\StockBundle\Domain\Entity\BatchInterface;

/**
 * Description of UomTypeRepository
 *
 * @author glenn
 */
class StockUnitRepository extends ResourceRepository implements StockUnitRepositoryInterface
{

    private function createInternalStockQueryBuilder($alias, $indexBy = null)
    {
        return $this->createQueryBuilder($alias, $indexBy)
                ->leftJoin('su.location', 'l')
                ->andWhere('l.name = :locationType')
                ->setParameter('locationType', LocationType::INTERNAL);
    }

    //put your code here
    public function findAvailableByStockItem(StockItemInterface $item,
        ?BatchInterface $batch, array $orderBy = []): array
    {
        $q = $this->createInternalStockQueryBuilder('su')
            ->andWhere('su.reservationMovement IS NULL')
            ->andWhere('su.stockItem = :item')
            ->setParameter('item', $item);

        if ( null !== $batch ) {
            $q
                ->addWhere('su.batch = :batch')
                ->setParameter('item', $item);
        }

        if ( count($orderBy) ) {
            $q->orderBy('su.batch = :batch');
        }

        return $q->getQuery()->getResult();
    }

    public function findReservedByStockItem(StockItemInterface $item): array
    {

        return $this->createInternalStockQueryBuilder('su')
                ->andWhere('su.reservationMovement IS NOT NULL')
                ->andWhere('su.stockItem = :item')
                ->setParameter('item', $item)
                ->getQuery()->getResult();
    }

    public function findReservedByMovement(Movement $mvt): array
    {
        return $this->createInternalStockQueryBuilder('su')
                ->andWhere('su.reservationMovement = :mvt')
                ->setParameter('mvt', $mvt)
                ->getQuery()->getResult();
    }

    public function findByStockItem(StockItemInterface $item): array
    {
        return $this->createInternalStockQueryBuilder('su')
                ->andWhere('su.stockItem = :item')
                ->setParameter('item', $item)
                ->getQuery()->getResult();
    }

    public function findByStockItemAndLocation(StockItemInterface $item,
        Location $location): array
    {
        return $this->createQueryBuilder('su')
                ->andWhere('su.stockItem = :item')
                ->andWhere('su.location = :location')
                ->setParameter('item', $item)
                ->setParameter('location', $location)
                ->getQuery()->getResult();
    }
}
