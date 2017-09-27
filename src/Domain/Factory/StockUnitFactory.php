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
namespace Sil\Bundle\StockBundle\Domain\Factory;

use Sil\Bundle\StockBundle\Domain\Generator\StockUnitCodeGeneratorInterface;
use Sil\Bundle\StockBundle\Domain\Entity\StockUnit;
use Sil\Bundle\StockBundle\Domain\Entity\StockItem;
use Sil\Bundle\StockBundle\Domain\Entity\UomQty;
use Sil\Bundle\StockBundle\Domain\Entity\Location;
use Sil\Bundle\StockBundle\Domain\Entity\Batch;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class StockUnitFactory implements StockUnitFactoryInterface
{

    /**
     *
     * @var StockUnitCodeGeneratorInterface  
     */
    private $codeGenerator;

    /**
     * 
     * @param StockUnitCodeGeneratorInterface $codeGenerator
     */
    public function __construct(StockUnitCodeGeneratorInterface $codeGenerator)
    {
        $this->codeGenerator = $codeGenerator;
    }

    /**
     * 
     * @param StockItem $item
     * @param UomQty $qty
     * @param Location $location
     * @param Batch $batch
     * @return StockUnit
     */
    public function createNew(StockItem $item, UomQty $qty, Location $location,
        Batch $batch = null): StockUnit
    {
        $code = $this->codeGenerator->generate($item, $qty, $location, $batch);
        return new StockUnit($code, $item, $qty, $location, $batch);
    }

    /**
     * 
     * @param StockUnit $srcUnit
     * @param Location $location
     * @return StockUnit
     */
    public function createFrom(StockUnit $srcUnit, Location $location): StockUnit
    {
        $code = $this->codeGenerator->generate($srcUnit->getStockItem(),
            $srcUnit->getQty(), $location, $srcUnit->getBatch());
        return new StockUnit($code, $srcUnit->getStockItem(),
            $srcUnit->getQty(), $location, $srcUnit->getBatch());
    }
}
