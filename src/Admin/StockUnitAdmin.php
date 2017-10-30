<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sil\Bundle\StockBundle\Admin;

use Blast\Bundle\ResourceBundle\Sonata\Admin\ResourceAdmin;
use Sil\Bundle\StockBundle\Domain\Generator\StockUnitCodeGeneratorInterface;
use Sonata\AdminBundle\Route\RouteCollection;
/**
 * Description of StockUnitAdmin
 *
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class StockUnitAdmin extends ResourceAdmin
{

    protected $baseRouteName = 'admin_stock_unit';
    protected $baseRoutePattern = 'stock/unit';

    /**
     *
     * @var StockUnitCodeGeneratorInterface 
     */
    protected $stockUnitCodeGenerator;

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('update_stock',  'updatestock/{item_id}');
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($stockUnit)
    {
        $code = $this->getStockUnitCodeGenerator()->generate(
                $stockUnit->getStockItem(), $stockUnit->getQty(),
                $stockUnit->getLocation(), $stockUnit->getBatch());

        $stockUnit->setCode($code);

        parent::prePersist($stockUnit);
    }

    public function getStockUnitCodeGenerator(): StockUnitCodeGeneratorInterface
    {
        return $this->stockUnitCodeGenerator;
    }

    public function setStockUnitCodeGenerator(StockUnitCodeGeneratorInterface $stockUnitCodeGenerator)
    {
        $this->stockUnitCodeGenerator = $stockUnitCodeGenerator;
    }

}
