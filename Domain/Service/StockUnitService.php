<?php

/*
 * This file is part of the Sil Project.
 *
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU GPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Sil\Bundle\StockBundle\Domain\Service;

use Sil\Bundle\StockBundle\Domain\Repository\StockUnitRepositoryInterface;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class StockUnitService
{
    /**
     * @var StockUnitRepositoryInterface
     */
    private $stockUnitRepository;

    public function getStockUnitRepository(): StockUnitRepositoryInterface
    {
        return $this->stockUnitRepository;
    }

    public function setStockUnitRepository(StockUnitRepositoryInterface $stockUnitRepository)
    {
        $this->stockUnitRepository = $stockUnitRepository;
    }
}
