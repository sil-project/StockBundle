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

/**
 * Description of UomTypeRepository
 *
 * @author glenn
 */
class StockUnitRepository extends ResourceRepository implements StockUnitRepositoryInterface
{

    //put your code here
    public function findAllAvailableBy(array $criteria)
    {

        return $this->findBy(array_merge($criteria, ['reservationMovement' => null]));
    }

    public function findAllReservedBy(Movement $mvt)
    {
        
    }

    public function findByStockItem(StockItemInterface $item)
    {
        
    }

    public function findByStockItemAndLocation(StockItemInterface $item,
            Location $location)
    {
        
    }

}
