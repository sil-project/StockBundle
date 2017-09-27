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

use Sil\Bundle\StockBundle\Domain\Entity\Movement;
use Sil\Bundle\StockBundle\Domain\Generator\MovementCodeGeneratorInterface;
use Sil\Bundle\StockBundle\Domain\Entity\StockItem;
use Sil\Bundle\StockBundle\Domain\Entity\UomQty;
use Sil\Bundle\StockBundle\Domain\Entity\Location;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class MovementFactory implements MovementFactoryInterface
{

    /**
     *
     * @var MovementCodeGeneratorInterface  
     */
    private $codeGenerator;

    /**
     * 
     * @param MovementCodeGeneratorInterface $codeGenerator
     */
    public function __construct(MovementCodeGeneratorInterface $codeGenerator)
    {
        $this->codeGenerator = $codeGenerator;
    }

    /**
     * 
     * @param StockItem $stockItem
     * @param UomQty $qty
     * @param Location $srcLocation
     * @param Location $destLocation
     * @param Batch $batch
     * @return Movement
     */
    public function createDraft(StockItem $stockItem, UomQty $qty,
        Location $srcLocation, Location $destLocation): Movement
    {
        $code = $this->codeGenerator->generate($stockItem, $qty, $srcLocation,
            $destLocation);
        return new Movement($code, $stockItem, $qty, $srcLocation, $destLocation);
    }
}
