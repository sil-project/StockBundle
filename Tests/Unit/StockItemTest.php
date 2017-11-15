<?php

/*
 *
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Sil\Bundle\StockBundle\Tests\Unit;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class StockItemTest extends AbstractStockTestCase
{
    /**
     * A StockItem might be contained in several locations.
     */
    public function testHasLocations()
    {
    }

    /**
     * Units of a StockItem should be updated when the Uom is changed.
     */
    public function testUpdateUnitsUom()
    {
        $this->markTestSkipped(
            'Not working due to 18 come from nowhere.'
        );
        $qty = $this->stockItemQueries->getQty($this->stockItem);
        /* @todo should never use assertTrue to compare value (other usefull assert exist) */
        $this->assertTrue($qty->getValue() == 18);

        $this->uomService->updateUomForStockItem($this->stockItem, $this->uomGr);

        $convertedQty = $this->stockItemQueries->getQty($this->stockItem);

        $this->assertTrue($convertedQty->getValue() == 18000);

        $this->assertTrue($this->stockItem->getUom() == $this->uomGr);
    }
}
