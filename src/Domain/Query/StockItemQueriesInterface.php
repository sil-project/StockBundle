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

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
interface StockItemQueriesInterface
{

    /**
     * 
     * @param StockItem $item
     * 
     * @return UomQty
     */
    public function getQty(StockItem $item): UomQty;

    /**
     * 
     * @param StockItem $item
     * @param Location $location
     * 
     * @return UomQty
     */
    public function getQtyByLocation(StockItem $item, Location $location): UomQty;
}
