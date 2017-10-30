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
namespace Sil\Bundle\StockBundle\Admin;

use Blast\Bundle\ResourceBundle\Sonata\Admin\ResourceAdmin;
use Sil\Bundle\StockBundle\Domain\Generator\OperationCodeGeneratorInterface;
use Sil\Bundle\StockBundle\Domain\Generator\MovementCodeGeneratorInterface;
use Sonata\AdminBundle\Route\RouteCollection;
use Sil\Bundle\StockBundle\Domain\Repository\OperationTypeRepositoryInterface;
use Sil\Bundle\StockBundle\Domain\Repository\LocationRepositoryInterface;
use Sil\Bundle\StockBundle\Domain\Entity\OperationType;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class OperationAdmin extends ResourceAdmin
{

    protected $baseRouteName = 'admin_stock_operation';
    protected $baseRoutePattern = 'stock/operation';

    /**
     *
     * @var MovementCodeGeneratorInterface 
     */
    protected $movementCodeGenerator;

    /**
     *
     * @var OperationCodeGeneratorInterface 
     */
    protected $operationCodeGenerator;

    /**
     *
     * @var OperationTypeRepositoryInterface 
     */
    protected $operationTypeRepository;

    /**
     *
     * @var LocationRepositoryInterface 
     */
    protected $locationRepository;

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('cancel', $this->getRouterIdParameter() . '/cancel');
        $collection->add('confirm', $this->getRouterIdParameter() . '/confirm');
        $collection->add('reserve', $this->getRouterIdParameter() . '/reserve');
        $collection->add('unreserve',
            $this->getRouterIdParameter() . '/unreserve');
        $collection->add('apply', $this->getRouterIdParameter() . '/apply');

        $collection->add('create_by_type', 'create/{type}');
    }

    /**
     * {@inheritdoc}
     */
    public function configureFormFields(\Sonata\AdminBundle\Form\FormMapper $mapper)
    {
        parent::configureFormFields($mapper);
        $type = $this->getSubject()->getType();
        /**
         * @todo filter locations (src & dest) using type 
         */
    }

    /**
     * 
     * @return array|OperationType[]
     */
    public function getOperationTypes()
    {

        return OperationType::getTypes();
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($operation)
    {

        $this->preUpdate($operation);
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        //generate code for the operation and the related movements
        $code = $this->getOperationCodeGenerator()->generate();
        $object->setCode($code);

        foreach ( $object->getMovements() as $m ) {
            $mCode = $this->getMovementCodeGenerator()->generate(
                $m->getStockItem(), $m->getQty());
            $m->setCode($mCode);
        }

        parent::preUpdate($object);
    }

    /**
     * 
     * @return OperationCodeGeneratorInterface
     */
    public function getOperationCodeGenerator(): OperationCodeGeneratorInterface
    {
        return $this->operationCodeGenerator;
    }

    /**
     * 
     * @param OperationCodeGeneratorInterface $operationCodeGenerator
     */
    public function setOperationCodeGenerator(OperationCodeGeneratorInterface $operationCodeGenerator)
    {
        $this->operationCodeGenerator = $operationCodeGenerator;
    }

    /**
     * 
     * @return MovementCodeGeneratorInterface
     */
    public function getMovementCodeGenerator(): MovementCodeGeneratorInterface
    {
        return $this->movementCodeGenerator;
    }

    /**
     * 
     * @param MovementCodeGeneratorInterface $codeGenerator
     */
    public function setMovementCodeGenerator(MovementCodeGeneratorInterface $codeGenerator)
    {
        $this->movementCodeGenerator = $codeGenerator;
    }

    
    /**
     * 
     * @return LocationRepositoryInterface
     */
    public function getLocationRepository(): LocationRepositoryInterface
    {
        return $this->locationRepository;
    }

    /**
     * 
     * @param LocationRepositoryInterface $locationRepository
     */
    public function setLocationRepository(LocationRepositoryInterface $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function toString($operation)
    {
        return sprintf('[%s] %s', $operation->getCode(),
            $operation->getType()->getName());
    }
}
