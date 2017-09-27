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

namespace Sil\Bundle\StockBundle\Domain\Entity;

use Blast\BaseEntitiesBundle\Entity\Traits\Guidable;
use InvalidArgumentException;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class Uom
{

    use Guidable;

    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var UomType
     */
    private $type;

    /**
     *
     * @var float
     */
    private $factor;

    /**
     * Rounding precision
     * 
     * @var int
     */
    private $rounding;

    /**
     * Enable/disable the unit of measure without deleting it
     * 
     * @var bool
     */
    private $active;

    /**
     * 
     * @param UomType $type
     * @param string $name
     * @param float $factor
     */
    public function __construct(UomType $type, string $name, float $factor)
    {
        $this->type = $type;
        $this->name = $name;
        $this->factor = $factor;
    }

    /**
     * 
     * @param float $value
     * @param Uom $toUom
     * @return float
     * @throws InvalidArgumentException
     */
    public function convertValueTo(float $value, Uom $toUom): float
    {
        if ( $toUom->getType() != $this->getType() ) {
            throw new \InvalidArgumentException(
                    "Conversion cannot be made between different type of Uom");
        }
        return ($value / $this->factor) * $toUom->factor;
    }

    /**
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * 
     * @return UomType
     */
    public function getType(): UomType
    {
        return $this->type;
    }

    /**
     * 
     * @return float
     */
    public function getFactor(): float
    {
        return $this->factor;
    }

    /**
     * 
     * @return int
     */
    public function getRounding(): int
    {
        return $this->rounding;
    }

    /**
     * 
     * @return bool
     */
    public function getActive(): bool
    {
        return $this->active;
    }

    /**
     * 
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * 
     * @param UomType $type
     * @return void
     */
    public function setType(UomType $type): void
    {
        $this->type = $type;
    }

    /**
     * 
     * @param float $factor
     * @return void
     */
    public function setFactor(float $factor): void
    {
        $this->factor = $factor;
    }

    /**
     * 
     * @param int $rounding
     * @return void
     */
    public function setRounding(int $rounding): void
    {
        $this->rounding = $rounding;
    }

    /**
     * 
     * @param bool $active
     * @return void
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

}
