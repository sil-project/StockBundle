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
use Blast\BaseEntitiesBundle\Entity\Traits\Timestampable;
use DateTimeInterface;
use DateTime;
use InvalidArgumentException;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class Operation implements ProgressStateAwareInterface
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
    private $expectedAt;

    /**
     *
     * @var string
     */
    private $stateValue;

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
     * @var OperationCategory 
     */
    private $category;

    /**
     *
     * @var Collection|Movement[]
     */
    private $movements;

    public static function createDefault(string $code, Location $srcLocation,
            Location $destLocation)
    {
        $o = new self();
        $o->code = $code;
        $o->srcLocation = $srcLocation;
        $o->destLocation = $destLocation;
        return $o;
    }

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->expectedAt = new DateTime();
        $this->setState(ProgressState::draft());
        $this->movements = new ArrayCollection();
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
     * @return DateTimeInterface
     */
    public function getExpectedAt(): DateTimeInterface
    {
        return $this->expectedAt;
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
     * 
     * @return OperationCategory
     */
    public function getCategory(): ?OperationCategory
    {
        return $this->category;
    }

    /**
     * 
     * @return Collection|Movement[]
     */
    public function getMovements(): Collection
    {
        return $this->movements;
    }

    /**
     * 
     * @param DateTimeInterface $expectedAt
     */
    public function setExpectedAt(DateTimeInterface $expectedAt)
    {
        $this->expectedAt = $expectedAt;
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
     * @param ProgressState $state
     */
    private function setState(ProgressState $state)
    {
        $this->stateValue = $state->getValue();
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
     * @param OperationCategory $category
     */
    public function setCategory(OperationCategory $category)
    {
        $this->category = $category;
    }

    /**
     * 
     * @param Movement $mvt
     * @return bool
     */
    public function hasMovement(Movement $mvt): bool
    {
        return $this->movements->contains($mvt);
    }

    /**
     * 
     * @param Movement $mvt
     * @return void
     * @throws InvalidArgumentException
     */
    public function addMovement(Movement $mvt): void
    {

        if ( !$mvt->getState()->isDraft() ) {
            throw new \InvalidArgumentException(
                    'Only Draft Movement can be added');
        }

        if ( $this->hasMovement($mvt) ) {
            throw new \InvalidArgumentException(
                    'The same Movement cannot be added twice');
        }

        $mvt->setOperation($this);
        $this->movements->add($mvt);
    }

    /**
     * 
     * @param Movement $mvt
     * @return void
     * @throws InvalidArgumentException
     */
    public function removeMovement(Movement $mvt): void
    {
        if ( !$this->hasMovement($mvt) ) {
            throw new \InvalidArgumentException(
                    'The Movement is not part of this Operation and cannot be removed from there');
        }
        $this->movements->removeElement($mvt);
    }

    /**
     * 
     * @return bool
     */
    public function isFullyReserved(): bool
    {
        return $this->getMovements()->forAll(function($i, $mvt) {
                    return $mvt->isFullyReserved();
                });
    }

    public function hasReservedStockUnits(): bool
    {
        $noStockUnitReserved = $this->getMovements()->forAll(function($i, $mvt) {
            return !$mvt->hasReservedStockUnits();
        });

        return ($noStockUnitReserved == false);
    }

}
