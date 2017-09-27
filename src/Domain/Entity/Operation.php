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
     * @var ProgressState 
     */
    private $state;

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
     * @var Collection|Movement[]
     */
    private $movemements;

    public function __construct(string $code)
    {
        $this->code = $code;
        $this->createdAt = new DateTime();
        $this->state = ProgressState::draft();
        $this->movemements = new ArrayCollection();
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
     * 
     * @return ProgressState
     */
    public function getState(): ProgressState
    {
        return $this->state;
    }

    /**
     * 
     * @return Location
     */
    public function getSrcLocation(): Location
    {
        return $this->srcLocation;
    }

    /**
     * 
     * @return Location
     */
    public function getDestLocation(): Location
    {
        return $this->destLocation;
    }

    /**
     * 
     * @return Collection
     */
    public function getMovemements(): Collection
    {
        return $this->movemements;
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
     * @param ProgressState $state
     */
    private function setState(ProgressState $state)
    {
        $this->state = $state;
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
     * @param Movement $mvt
     * @return bool
     */
    public function hasMovement(Movement $mvt): bool
    {
        return $this->movemements->contains($mvt);
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

        $this->movemements->add($mvt);
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
        $this->movemements->removeElement($mvt);
    }

    /**
     * 
     * @return bool
     */
    public function isFullyReserved(): bool
    {
        return $this->getMovemements()->forAll(function($mvt) {
                return $mvt->isFullyReserved();
            });
    }
}
