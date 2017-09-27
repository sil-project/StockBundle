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
namespace Sil\Bundle\StockBundle\Domain\Repository;

use Sil\Bundle\StockBundle\Domain\Entity\StockItemInterface;
use Sil\Bundle\StockBundle\Domain\Entity\Location;
use Sil\Bundle\StockBundle\Domain\Entity\Movement;

/**
 *
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
interface StockUnitRepositoryInterface
{

    /**
     * 
     * @param StockItemInterface $item

     * @return array|StockUnit[]
     */
    public function findByStockItem(StockItemInterface $item);

    /**
     * 
     * @param StockItemInterface $item
     * @param Location $location
     * @return array|StockUnit[]
     */
    public function findByStockItemAndLocation(StockItemInterface $item,
        Location $location);

    /**
     * 
     * @param array $criteria
     * @return array|StockUnit[]
     */
    public function findAllAvailableBy(array $criteria);

    /**
     * 
     * @param Movement $mvt
     * @return array|StockUnit[]
     */
    public function findAllReservedBy(Movement $mvt);
}
