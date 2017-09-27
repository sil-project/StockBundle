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
namespace Sil\Bundle\StockBundle\Domain\Service;

use Sil\Bundle\StockBundle\Domain\Repository\MovementRepositoryInterface;
use Sil\Bundle\StockBundle\Domain\Repository\StockUnitRepositoryInterface;
use Sil\Bundle\StockBundle\Domain\Factory\StockUnitFactoryInterface;
use Sil\Bundle\StockBundle\Domain\Factory\MovementFactoryInterface;
use Sil\Bundle\StockBundle\Domain\Entity\StockItem;
use Sil\Bundle\StockBundle\Domain\Entity\StockUnit;
use Sil\Bundle\StockBundle\Domain\Entity\UomQty;
use Sil\Bundle\StockBundle\Domain\Entity\Location;
use Sil\Bundle\StockBundle\Domain\Entity\Movement;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class MovementService implements MovementServiceInterface
{

    /**
     *
     * @var MovementRepositoryInterface 
     */
    private $movementRepository;

    /**
     *
     * @var StockUnitRepositoryInterface 
     */
    private $stockUnitRepository;

    /**
     *
     * @var MovementFactoryInterface 
     */
    private $movementFactory;

    /**
     *
     * @var StockUnitFactoryInterface 
     */
    private $stockUnitFactory;

    /**
     * 
     * @param MovementRepositoryInterface $movementRepository
     * @param StockUnitRepositoryInterface $stockUnitRepository
     * @param MovementFactoryInterface $movementFactory
     * @param StockUnitFactoryInterface $stockUnitFactory
     */
    public function __construct(MovementRepositoryInterface $movementRepository,
        StockUnitRepositoryInterface $stockUnitRepository,
        MovementFactoryInterface $movementFactory,
        StockUnitFactoryInterface $stockUnitFactory)
    {
        $this->movementRepository = $movementRepository;
        $this->stockUnitRepository = $stockUnitRepository;
        $this->movementFactory = $movementFactory;
        $this->stockUnitFactory = $stockUnitFactory;
    }

    /**
     * 
     * @param StockItem $item
     * @param UomQty $qty
     * @param Location $srcLoc
     * @param Location $destLoc
     * @param Batch $batch
     * 
     * @return Movement
     */
    public function createDraft(StockItem $item, UomQty $qty, Location $srcLoc,
        Location $destLoc, Batch $batch = null): Movement
    {
        $mvt = $this->movementFactory
            ->createDraft($item, $qty, $srcLoc, $destLoc);

        if ( null == $batch ) {
            $mvt->setBatch($mvt->getBatch());
        }

        $this->movementRepository->add($mvt);

        return $mvt;
    }

    /**
     * 
     * @param Movement $mvt
     */
    public function confirm(Movement $mvt): void
    {
        $mvt->beConfirmed();
    }

    /**
     * 
     * @param Movement $mvt
     * @throws \DomainException
     */
    public function reserveUnits(Movement $mvt): void
    {

        if ( !$mvt->getState()->isToDo() ) {
            throw new \DomainException('The Movement is not in the right state to be applied');
        }
        if ( $mvt->getState()->isAvailable() ) {
            return;
        }


        $availableUnits = $this->getAvailableStockUnits($mvt);

        //reserve needed StockUnits and split the last if necessary
        foreach ( $availableUnits as $srcUnit ) {
            $unit = $srcUnit;

            $remainingQtyToBeRes = $mvt->getRemainingQtyToBeReserved();

            if ( $unit->getQty()->isGreaterThan($remainingQtyToBeRes) ) {
                $unit = $this->splitAndGetNew($unit, $remainingQtyToBeRes);
                $this->stockUnitRepository->add($unit);
            }
            //reserve the unit 
            $mvt->reserve($unit);

            //check if all the qty is reserved
            if ( $mvt->isFullyReserved() ) {
                $mvt->beAvailable();
                return;
            }
        }
        //all the qty is not reserved yet, a new pass will be necessary
        $mvt->bePartiallyAvailable();
    }

    /**
     * 
     * @param Movement $mvt
     */
    public function apply(Movement $mvt): void
    {
        $reservedUnits = $mvt->getReservedStockUnits();

        foreach ( $reservedUnits as $srcUnit ) {
            $mvt->getSrcLocation()->removeStockUnit($srcUnit);

            $destUnit = $this->stockUnitFactory
                ->createFrom($srcUnit, $mvt->getDestLocation());

            $this->stockUnitRepository->remove($srcUnit);
            $this->stockUnitRepository->add($destUnit);
        }

        $mvt->beDone();
    }

    /**
     * 
     * @param Movement $mvt
     */
    public function cancel(Movement $mvt): void
    {
        $mvt->unreserveAllUnits();
        $mvt->beCancel();
    }

    /**
     * 
     * @param Movement $mvt
     * @return array
     */
    protected function getAvailableStockUnits(Movement $mvt): array
    {
        $item = $mvt->getStockItem();
        $srcLoc = $mvt->getSrcLocation();
        $outStrategy = $item->getOutputStrategy();

        $options = ['stockItem' => $item, 'location' => $srcLoc];

        if ( $mvt->withBatchTracking() ) {
            $options['batch'] = $mvt->getBatch();
        }

        return $this->stockUnitRepository->findAllAvailableBy(
                $options, $outStrategy->getOrderBy());
    }

    /**
     * Decrease current qty by $qty, create a new StockUnit of $qty and return it
     * 
     * @param UomQty $qty
     * @return StockUnit
     */
    public function splitAndGetNew(StockUnit $unit, UomQty $qty): StockUnit
    {
        $newQty = $unit->getQty()->decreasedBy($qty);
        $unit->setQty($newQty);

        return $this->stockUnitFactory->createNew(
                $unit->getStockItem(), $qty, $unit->getLocation(),
                $unit->getBatch());
    }

    /**
     * @debug
     * 
     * @param Movement $mvt
     * @return string
     */
    public function toString(Movement $mvt): string
    {
        $result = [];
        $result[] = 'created at: ' . $mvt->getCreatedAt()->format('Y-m-d H:i:s');
        $result[] = 'qty to be reserved: ' . $mvt->getQty();
        $result[] = 'remaining qty to be reserved: ' . $mvt->getRemainingQtyToBeReserved();

        foreach ( $mvt->getReservedStockUnits() as $unit ) {
            $result[] = $unit->getQty();
        }

        return implode("\n", $result);
    }
}
