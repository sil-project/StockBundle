<?php
/*
 * This file is part of the Blast Project package.
 *
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */
namespace Sil\Bundle\StockBundle\Domain\Repository\InMemory;

use Sil\Bundle\StockBundle\Domain\Repository\StockUnitRepositoryInterface;
use Sil\Bundle\StockBundle\Domain\Entity\StockUnit;
use Sil\Bundle\StockBundle\Domain\Entity\StockItemInterface;
use Sil\Bundle\StockBundle\Domain\Entity\Location;
use Sil\Bundle\StockBundle\Domain\Entity\Movement;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class StockUnitRepository extends InMemoryRepository implements StockUnitRepositoryInterface
{

    public function __construct()
    {
        parent::__construct(StockUnit::class);
    }

    /**
     * 
     * @param StockItemInterface $item
     * @param Location $location
     * @return array|StockUnit[]
     */
    public function findByStockItem(StockItemInterface $item)
    {
        return array_filter($this->findAll()
            ,
            function($su) use($item) {
            return $su->getStockItem() == $item;
        });
    }

    /**
     * 
     * @param StockItemInterface $item
     * @return array|StockUnit[]
     */
    public function findByStockItemAndLocation(StockItemInterface $item,
        Location $location)
    {
        return array_filter($this->findAll()
            ,
            function($su) use($item, $location) {
            return $su->getLocation() == $location && $su->getStockItem() == $item;
        });
    }

    /**
     * 
     * @param array $criteria
     * @return array|StockUnit[]
     */
    public function findAllAvailableBy(array $criteria)
    {
        return array_filter($this->findBy($criteria),
            function($su) {
            return !$su->isReserved();
        });
    }

    /**
     * 
     * @param Movement $mvt
     * @return array|StockUnit[]
     */
    public function findAllReservedBy(Movement $mvt)
    {
        return array_filter($this->findAll(),
            function($su) use($mvt) {
            return $su->isReserved() && $su->getReservationMovement() == $mvt;
        });
    }
}
