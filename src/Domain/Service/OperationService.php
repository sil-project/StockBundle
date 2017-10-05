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

use Sil\Bundle\StockBundle\Domain\Repository\OperationRepositoryInterface;
use Sil\Bundle\StockBundle\Domain\Service\MovementServiceInterface;
use Sil\Bundle\StockBundle\Domain\Factory\OperationFactoryInterface;
use Sil\Bundle\StockBundle\Domain\Entity\Operation;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class OperationService implements OperationServiceInterface
{

    /**
     *
     * @var OperationRepositoryInterface 
     */
    private $operationRepository;

    /**
     *
     * @var MovementServiceInterface
     */
    private $movementService;

    /**
     *
     * @var OperationFactoryInterface 
     */
    private $operationFactory;

    /**
     * 
     * @param OperationRepositoryInterface $operationRepository
     * @param MovementServiceInterface $movementService
     */
    public function __construct(OperationRepositoryInterface $operationRepository,
        MovementServiceInterface $movementService,
        OperationFactoryInterface $operationFactory)
    {
        $this->operationRepository = $operationRepository;
        $this->movementService = $movementService;
        $this->operationFactory = $operationFactory;
    }

    /**
     * 
     * @return Operation
     */
    public function createDraft(): Operation
    {
        $op = $this->operationFactory->createDraft();
        $this->operationRepository->add($op);
        return $op;
    }

    /**
     * 
     * @param Operation $op
     */
    public function confirm(Operation $op): void
    {
        foreach ( $op->getMovements() as $mvt ) {
            $this->movementService->confirm($mvt);
        }

        $op->beConfirmed();
    }

    /**
     * 
     * @param Operation $op
     */
    public function reserveUnits(Operation $op): void
    {
        foreach ( $op->getMovements() as $mvt ) {
            $this->movementService->reserveUnits($mvt);
        }

        if ( $op->isFullyReserved() ) {
            $op->beAvailable();
        } else {
            $op->bePartiallyAvailable();
        }
    }

    /**
     * 
     * @param Operation $op
     */
    public function apply(Operation $op): void
    {
        foreach ( $op->getMovements() as $mvt ) {
            $this->movementService->apply($mvt);
        }

        $op->beDone();
    }

    /**
     * 
     * @param Operation $op
     */
    public function cancel(Operation $op): void
    {
        foreach ( $op->getMovements() as $mvt ) {
            $this->movementService->cancel($mvt);
        }

        $op->beCancel();
    }
}
