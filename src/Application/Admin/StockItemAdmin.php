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

    public function getInStockQty($object)
    {
        return $this->getStockItemQueries()->getQty($object);
    }
    
    
    
    public function getReservedQty($object)
    {
        return $this->getStockItemQueries()->getReservedQty($object);
    }
    
    public function getAvailableQty($object)
    {
        return $this->getStockItemQueries()->getAvailableQty($object);
    }

    public function getStockItemQueries(): StockItemQueriesInterface
    {
        return $this->stockItemQueries;
    }

    public function setStockItemQueries(StockItemQueriesInterface $stockItemQueries)
    {
        $this->stockItemQueries = $stockItemQueries;
    }
}
