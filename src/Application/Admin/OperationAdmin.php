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
namespace Sil\Bundle\StockBundle\Application\Admin;

use Blast\Bundle\ResourceBundle\Admin\ResourceAdmin;
use Sil\Bundle\StockBundle\Domain\Factory\OperationFactoryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\FormInterface;
use Sil\Bundle\StockBundle\Application\Form\DataMapper\OperationDataMapper;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class OperationAdmin extends ResourceAdmin
{


    protected $baseRouteName = 'admin_stock_operations';
    protected $baseRoutePattern = 'stock/operations';

    /**
     *
     * @var OperationFactoryInterface 
     */
    protected $operationFactory;

    /**
     * {@inheritdoc}
     */
    public function getFormBuilder()
    {
        $builder = parent::getFormBuilder();
        $builder->setDataMapper(new OperationDataMapper());
        return $builder;
        
    }
/*
    protected function configureFormFields(FormMapper $mapper)
    {
        parent::configureFormFields($mapper);
        $this->getFormBuilder();
        $builder = $mapper->getFormBuilder();
        $builder->setDataMapper(new OperationDataMapper());
        
        
    }
*/
    /**
     * 
     * @param OperationFactoryInterface $operationFactory
     */
    public function setOperationFactory(OperationFactoryInterface $operationFactory): void
    {
        $this->operationFactory = $operationFactory;
    }

    /**
     * 
     * @return OperationFactoryInterface
     */
    public function getOperationFactory(): OperationFactoryInterface
    {
        return $this->operationFactory;
    }
}
