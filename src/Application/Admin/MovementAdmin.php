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
use Sil\Bundle\StockBundle\Domain\Factory\MovementFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class MovementAdmin extends ResourceAdmin
{

    protected $baseRouteName = 'admin_stock_movements';
    protected $baseRoutePattern = 'stock/movements';

    /**
     *
     * @var MovementFactoryInterface 
     */
    protected $movementFactory;

    /**
     * 
     * @return MovementFactoryInterface
     */
    public function getMovementFactory(): MovementFactoryInterface
    {
        return $this->movementFactory;
    }

    public function setMovementFactory(MovementFactoryInterface $movementFactory): void
    {
        $this->movementFactory = $movementFactory;
    }
}
