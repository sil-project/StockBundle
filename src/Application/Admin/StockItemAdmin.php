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
namespace Sil\Bundle\StockBundle\Application\Admin;

use Blast\Bundle\ResourceBundle\Sonata\Admin\ResourceAdmin;
use Sil\Bundle\StockBundle\Domain\Query\StockItemQueriesInterface;
use Sil\Bundle\StockBundle\Domain\Repository\LocationRepositoryInterface;
use Sil\Bundle\StockBundle\Domain\Entity\StockItemInterface;
use Sil\Bundle\StockBundle\Domain\Entity\Location;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class StockItemAdmin extends ResourceAdmin
{

    protected $baseRouteName = 'admin_stock_items';
    protected $baseRoutePattern = 'stock/items';

    /**
     *
     * @var StockItemQueriesInterface 
     */
    protected $stockItemQueries;

    /**
     *
     * @var LocationRepositoryInterface 
     */
    protected $locationRepository;

    public function getQtyByItemAndLocation(StockItemInterface $item,
        Location $location)
    {
        return $this->getStockItemQueries()->getQtyByLocation($item, $location);
    }

    public function getLocationsByItem(StockItemInterface $item)
    {
        return $this->getLocationRepository()->findByOwnedItem($item);
    }

    public function getInStockQty(StockItemInterface $item)
    {
        return $this->getStockItemQueries()->getQty($item);
    }

    public function getReservedQty(StockItemInterface $item)
    {
        return $this->getStockItemQueries()->getReservedQty($item);
    }

    public function getAvailableQty(StockItemInterface $item)
    {
        return $this->getStockItemQueries()->getAvailableQty($item);
    }

    public function getLocationRepository(): LocationRepositoryInterface
    {
        return $this->locationRepository;
    }

    public function setLocationRepository(LocationRepositoryInterface $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function getStockItemQueries(): StockItemQueriesInterface
    {
        return $this->stockItemQueries;
    }

    public function setStockItemQueries(StockItemQueriesInterface $stockItemQueries)
    {
        $this->stockItemQueries = $stockItemQueries;
    }

    public function toString($item)
    {
        return $item->getCode() . ' | ' . $item->getName();
    }
}
