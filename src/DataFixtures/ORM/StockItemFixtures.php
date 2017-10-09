<?php

namespace Sil\Bundle\StockBundle\DataFixtures\ORM;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sil\Bundle\StockBundle\Domain\Entity\StockItem;

/**
 * Description of WarehouseFixtures
 *
 * @author glenn
 */
class StockItemFixtures extends Fixture implements ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function load(ObjectManager $manager)
    {
        $uomKg = $this->getReference('uom-kg');
        $outs = $this->getReference('outs-default');

        $item1 = StockItem::creatDefault('ART-1','Item 1', $uomKg, $outs);

        $manager->persist($item1);
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getDependencies()
    {
        return array(
            LocationFixtures::class,
            UomFixtures::class,
            OutputStrategyFixtures::class
        );
    }

}
