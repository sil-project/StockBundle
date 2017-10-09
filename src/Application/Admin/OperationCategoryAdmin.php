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

use Blast\Bundle\ResourceBundle\Sonata\Admin\ResourceAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class OperationCategoryAdmin extends ResourceAdmin
{

    protected $baseRouteName = 'admin_stock_operationcategories';
    protected $baseRoutePattern = 'stock/operationcategories';

    /**
     * @param ListMapper $mapper
     */
    protected function configureListFields(ListMapper $mapper)
    {
        $mapper
                ->addIdentifier('name');
    }

    /**
     * @param ListMapper $mapper
     */
    protected function configureShowFields(ShowMapper $mapper)
    {
        $mapper
                ->tab('general')
                ->with('info')
                ->add('name');
    }
    
     /**
     * @param ListMapper $mapper
     */
    protected function configureFormFields(FormMapper $mapper)
    {
        $mapper
                ->tab('general')
                ->with('info')
                ->add('name');
    }

}
