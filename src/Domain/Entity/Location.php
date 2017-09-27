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

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Blast\BaseEntitiesBundle\Entity\Traits\Guidable;
use InvalidArgumentException;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class Location
{

    use Guidable;

    /**
     *
     * @var string 
     */
    private $name;

    /**
     *
     * @var string 
     */
    private $code;

    /**
     *
     * @var Warehouse 
     */
    private $warehouse;

    /**
     *
     * @var Collection|StockUnit[]
     */
    private $stockUnits;

    /**
     * 
     * @param string $name
     * @param string $code
     */
    public function __construct(string $name, string $code)
    {
        $this->name = $name;
        $this->code = $code;
        $this->stockUnits = new ArrayCollection();
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
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * 
     * @return Warehouse
     */
    public function getWarehouse(): ?Warehouse
    {
        return $this->warehouse;
    }

    /**
     * 
     * @return Collection
     */
    public function getStockUnits(): Collection
    {
        return $this->stockUnits;
    }

    /**
     * 
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * 
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * 
     * @param Warehouse|null $warehouse
     * @return void
     */
    public function setWarehouse(?Warehouse $warehouse): void
    {
        $this->warehouse = $warehouse;
    }

    /**
     * 
     * @param Collection $stockUnits
     * @return void
     */
    public function setStockUnits(Collection $stockUnits): void
    {
        $this->stockUnits = $stockUnits;
    }

    /**
     * 
     * @param StockUnit $unit
     * @return bool
     */
    public function hasStockUnit(StockUnit $unit): bool
    {
        return $this->stockUnits->contains($unit);
    }

    /**
     * 
     * @param StockUnit $unit
     * @return void
     * @throws InvalidArgumentException
     */
    public function addStockUnit(StockUnit $unit): void
    {
        if ( $this->hasStockUnit($unit) ) {
            throw new InvalidArgumentException(
                'The same StockUnit cannot be added twice');
        }

        $this->stockUnits->add($unit);
    }

    public function removeStockUnit(StockUnit $unit): void
    {
        if ( !$this->hasStockUnit($unit) ) {
            throw new InvalidArgumentException(
                'The StockUnit is not at this Location and cannot be removed from there');
        }
        $this->stockUnits->removeElement($unit);
    }

    /**
     * @deprecated
     * @param StockItem $stockItem
     * @return boolean
     */
    public function hasStockItem(StockItem $stockItem): boolean
    {
        return $this->stockUnits->exists(
                function($i, $unit) use($stockItem) {
                return $unit->getStockItem() == $stockItem;
            });
    }

    /**
     * @deprecated
     * @return array|StockItem[]
     */
    public function getStockItems(): array
    {
        $items = array_map(
            $this->stockUnits->toArray(),
            function($unit) {
            return $unit->getStockItem();
        });

        return array_unique($items);
    }
}
