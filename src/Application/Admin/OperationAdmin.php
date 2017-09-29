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

use Blast\CoreBundle\Admin\CoreAdmin;
use Sil\Bundle\StockBundle\Domain\Factory\OperationFactoryInterface;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class OperationAdmin extends CoreAdmin
{

    protected $baseRouteName = 'admin_stock_operations';
    protected $baseRoutePattern = 'stock/operations';

    /**
     *
     * @var OperationFactoryInterface 
     */
    protected $operationFactory;

    public function getNewInstance()
    {
        return $this->operationFactory->createDraft();
    }

    /**
     * 
     * @param OperationFactoryInterface $operationFactory
     */
    public function setOperationFactory(OperationFactoryInterface $operationFactory): void
    {
        $this->operationFactory = $operationFactory;
    }
}
