<?php
declare(strict_types=1);
/*
 * This file is part of the Blast Project package.
 *
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */
namespace Sil\Bundle\StockBundle\Domain\Query;

use Sil\Bundle\StockBundle\Domain\Entity\StockItem;
use Sil\Bundle\StockBundle\Domain\Entity\Location;
use Sil\Bundle\StockBundle\Domain\Entity\Uom;
use Sil\Bundle\StockBundle\Domain\Entity\UomQty;
use Sil\Bundle\StockBundle\Domain\Repository\StockUnitRepositoryInterface;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class StockItemQueries
{

    /**
     *
     * @var StockUnitRepositoryInterface
     */
    private $stockUnitRepository;

    /**
     * 
     * @param StockUnitRepositoryInterface $stockUnitRepository
     */
    public function __construct(StockUnitRepositoryInterface $stockUnitRepository)
    {
        $this->stockUnitRepository = $stockUnitRepository;
    }

    /**
     * 
     * @param StockItem $item
     * @return UomQty
     */
    public function getQty(StockItem $item): UomQty
    {
        $units = $this->stockUnitRepository
            ->findByStockItem($item);

        return $this->computeQtyForUnits($item->getUom(), $units);
    }

    /**
     * 
     * @param StockItem $item
     * @param Location $location
     * @return UomQty
     */
    public function getQtyByLocation(StockItem $item, Location $location): UomQty
    {
        $units = $this->stockUnitRepository
            ->findByStockItemAndLocation($item, $location);

        return $this->computeQtyForUnits($item->getUom(), $units);
    }

    /**
     * 
     * @param Uom $uom
     * @param array|StockUnit[] $stockUnits
     * @return UomQty
     */
    protected function computeQtyForUnits(Uom $uom, $stockUnits): UomQty
    {
        $unitQties = array_map(function($q) {
            return $q->getQty()->getValue();
        }, $stockUnits);
        $sumQty = array_sum($unitQties);

        return new UomQty($uom, $sumQty);
    }
}
