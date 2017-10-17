<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Sil\Bundle\StockBundle\Doctrine\ORM;

use Sil\Bundle\StockBundle\Domain\Repository\StockItemRepositoryInterface;
use Blast\Bundle\ResourceBundle\Doctrine\ORM\Repository\ResourceRepository;
use Sil\Bundle\StockBundle\Domain\Entity\Location;

/**
 * Description of UomTypeRepository
 *
 * @author glenn
 */
class StockItemRepository extends ResourceRepository implements StockItemRepositoryInterface
{

    public function findByLocation(Location $location)
    {
        $qb = $this->createQueryBuilder('si')
            ->leftJoin('Sil\Bundle\StockBundle\Domain\Entity\StockUnit', 'su',
                'WITH', 'su.stockItem = si.id')
            ->leftJoin('su.location', 'l')
            ->andWhere('l.treeLft >= :treeLeft')
            ->andWhere('l.treeRgt <= :treeRight')
            ->setParameter('treeLeft', $location->getTreeLft())
            ->setParameter('treeRight', $location->getTreeRgt());


        return $qb->getQuery()->getResult();
    }
}
