<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sil\Bundle\StockBundle\Infrastructure\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Blast\Bundle\ResourceBundle\DependencyInjection\Configuration\ResourceConfigurationTrait;
use Sil\Bundle\StockBundle\Domain\Entity;

class Configuration implements ConfigurationInterface
{

    use ResourceConfigurationTrait;

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sil_stock');
        
        $this->addResourcesSection($rootNode);
        return $treeBuilder;
    }
    
     private function addResourceDefinitions(NodeBuilder $resourceNode)
    {
        $this->addResourceDefinition($resourceNode, 'batch', Entity\Batch::class);
        $this->addResourceDefinition($resourceNode, 'location', Entity\Location::class);
        $this->addResourceDefinition($resourceNode, 'movement', Entity\Movement::class);
        $this->addResourceDefinition($resourceNode, 'operation', Entity\Operation::class);
        $this->addResourceDefinition($resourceNode, 'output_strategy', Entity\OutputStrategy::class);
        $this->addResourceDefinition($resourceNode, 'stock_item', Entity\StockItem::class);
        $this->addResourceDefinition($resourceNode, 'uom', Entity\Uom::class);
        $this->addResourceDefinition($resourceNode, 'uom_type', Entity\UomType::class);
        $this->addResourceDefinition($resourceNode, 'warehouse', Entity\Warehouse::class);
        
    }

}
