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
use DomainException;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class StockUnit
{

    use Guidable;

    /**
     *
     * @var string 
     */
    private $code;

    /**
     *
     * @var float 
     */
    private $qtyValue = 0;

    /**
     *
     * @var Uom 
     */
    private $qtyUom;

    /**
     *
     * @var StockItemInterface 
     */
    private $stockItem;

    /**
     *
     * @var Location 
     */
    private $location;

    /**
     *
     * @var BatchInterface 
     */
    private $batch;

    /**
     *
     * @var Movement 
     */
    private $reservationMovement;

    /**
     * 
     * @param string $code
     * @param StockItemInterface $item
     * @param UomQty $qty
     * @param Location $location
     * @param BatchInterface $batch
     */
    public function __construct($code, StockItemInterface $item, UomQty $qty,
            Location $location, BatchInterface $batch = null)
    {
        $this->code = $code;
        $this->qty = $qty->convertTo($item->getUom());
        $this->stockItem = $item;
        $this->location = $location;
        $this->batch = $batch;
        $location->addStockUnit($this);
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
     * @return UomQty
     */
    public function getQty(): ?UomQty
    {
        if ( null == $this->qtyUom ) {
            return null;
        }
        return new UomQty($this->qtyUom, floatval($this->qtyValue));
    }


    /**
     * 
     * @return StockItemInterface
     */
    public function getStockItem(): StockItemInterface
    {
        return $this->stockItem;
    }

    /**
     * 
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * 
     * @return BatchInterface|null
     */
    public function getBatch(): ?BatchInterface
    {
        return $this->batch;
    }

    /**
     * 
     * @return Movement|null
     */
    public function getReservationMovement(): ?Movement
    {
        return $this->reservationMovement;
    }

    /**
     * 
     * @param UomQty $qty
     * @return void
     */
    public function setQty(UomQty $qty): void
    {
        $this->qtyValue = $qty->getValue();
        $this->qtyUom = $qty->getUom();
    }

    /**
     * 
     * @param BatchInterface|null $batch
     * @return void
     */
    public function setBatch(?BatchInterface $batch): void
    {
        $this->batch = $batch;
    }

    /**
     * 
     * @param Movement $reservationMovement
     * @return void
     * @throws DomainException
     */
    public function beReservedByMovement(Movement $reservationMovement): void
    {
        if ( $this->isReserved() ) {
            throw new DomainException('The StockUnit is already reserved');
        }
        $this->reservationMovement = $reservationMovement;
    }

    /**
     * 
     * @return void
     */
    public function beUnreserved(): void
    {
        $this->reservationMovement = null;
    }

    /**
     * 
     * @return bool
     */
    public function isReserved(): bool
    {
        return null !== $this->reservationMovement;
    }

}
