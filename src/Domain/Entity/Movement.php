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

use DateTimeInterface;
use Sil\Bundle\StockBundle\Domain\Entity\Operation;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Blast\BaseEntitiesBundle\Entity\Traits\Guidable;
use Blast\BaseEntitiesBundle\Entity\Traits\Timestampable;
use DomainException;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class Movement implements ProgressStateAwareInterface
{

    use Guidable,
        Timestampable,
        ProgressStateAwareTrait;

    /**
     *
     * @var string
     */
    private $code;

    /**
     *
     * @var DateTimeInterface 
     */
    private $createdAt;

    /**
     *
     * @var DateTimeInterface 
     */
    private $expectedAt;

    /**
     *
     * @var StockItemInterface 
     */
    private $stockItem;

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
     * @var Operation
     */
    private $operation;

    /**
     *
     * @var Location 
     */
    private $srcLocation;

    /**
     *
     * @var Location 
     */
    private $destLocation;

    /**
     *
     * @var string
     */
    private $stateValue;

    /**
     *
     * @var BatchInterface
     */
    private $batch;

    /**
     *
     * @var Collection|StockUnit[] 
     */
    private $reservedStockUnits;

    /**
     * @param string $code
     * @param StockItemInterface $stockItem
     * @param UomQty $qty
     */
    public static function createDefault(string $code, StockItemInterface $item,
        UomQty $qty)
    {
        $o = new self();
        $o->code = $code;
        $o->stockItem = $item;
        $o->setQty($qty);
        return $o;
    }

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->expectedAt = new DateTime();
        $this->setState(ProgressState::draft());
        $this->reservedStockUnits = new ArrayCollection();
    }

    /**
     * 
     * @return string
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * 
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * 
     * @return DateTimeInterface
     */
    public function getExpectedAt(): DateTimeInterface
    {
        return $this->expectedAt;
    }

    /**
     * 
     * @return Operation
     */
    public function getOperation(): Operation
    {
        return $this->operation;
    }

    /**
     * 
     * @return Location
     */
    public function getSrcLocation(): ?Location
    {
        return $this->srcLocation;
    }

    /**
     * 
     * @return Location
     */
    public function getDestLocation(): ?Location
    {
        return $this->destLocation;
    }

    /**
     * @return ProgressState
     */
    public function getState(): ProgressState
    {
        return new ProgressState($this->stateValue);
    }

    /**
     * 
     * @return StockItemInterface
     */
    public function getStockItem(): ?StockItemInterface
    {
        return $this->stockItem;
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
        return new UomQty($this->qtyUom, $this->qtyValue);
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
     * @return Collection
     */
    public function getReservedStockUnits(): Collection
    {
        return $this->reservedStockUnits;
    }

    /**
     * 
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * 
     * @param DateTimeInterface $createdAt
     * @return void
     */
    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * 
     * @param DateTimeInterface $expectedAt
     * @return void
     */
    public function setExpectedAt(DateTimeInterface $expectedAt): void
    {
        $this->expectedAt = $expectedAt;
    }

    /**
     * 
     * @param Operation $operation
     */
    public function setOperation(Operation $operation)
    {
        $this->operation = $operation;
    }

    /**
     * 
     * @param Location $srcLocation
     * @return void
     */
    public function setSrcLocation(Location $srcLocation): void
    {
        $this->srcLocation = $srcLocation;
    }

    /**
     * 
     * @param Location $destLocation
     * @return void
     */
    public function setDestLocation(Location $destLocation): void
    {
        $this->destLocation = $destLocation;
    }

    /**
     * 
     * @param StockItemInterface $stockItem
     * @return void
     */
    public function setStockItem(StockItemInterface $stockItem): void
    {
        $this->stockItem = $stockItem;
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
     * @param ProgressState $state
     */
    private function setState(ProgressState $state)
    {
        $this->stateValue = $state->getValue();
    }

    /**
     * 
     * @return bool
     */
    public function withBatchTracking(): bool
    {
        return null !== $this->batch;
    }

    /**
     * 
     * @param StockUnit $unit
     * @return void
     * @throws DomainException
     */
    public function reserve(StockUnit $unit): void
    {
        if ( $unit->isReserved() ) {
            throw new \DomainException('The StockUnit is already reserved');
        }
        $unit->beReservedByMovement($this);
        $this->reservedStockUnits->add($unit);
    }

    /**
     * 
     * @param StockUnit $unit
     * @return void
     * @throws DomainException
     */
    public function unreserve(StockUnit $unit): void
    {
        if ( !$unit->isReserved() ) {
            throw new \DomainException('The StockUnit is not reserved and cannot be unreserved');
        }
        if ( !$this->reservedStockUnits->contains($unit) ) {
            throw new \DomainException('The StockUnit is not reserved by this Movement');
        }
        $unit->beUnreserved();
        $this->reservedStockUnits->removeElement($unit);
    }

    /**
     * 
     * @return void
     */
    public function unreserveAllUnits(): void
    {
        foreach ( $this->reservedStockUnits as $unit ) {
            $this->unreserve($unit);
        }
    }

    /**
     * 
     * @return UomQty
     */
    public function getReservedQty(): UomQty
    {
        $qty = $this->getQty()->copyWithValue(0);

        foreach ( $this->reservedStockUnits as $unit ) {
            $qty = $qty->increasedBy($unit->getQty());
        }

        return $qty;
    }

    /**
     * 
     * @return UomQty
     */
    public function getRemainingQtyToBeReserved(): UomQty
    {
        return $this->getQty()->decreasedBy($this->getReservedQty());
    }

    /**
     * 
     * @return bool
     */
    public function isFullyReserved(): bool
    {
        return $this->getRemainingQtyToBeReserved()->isZero();
    }
}
