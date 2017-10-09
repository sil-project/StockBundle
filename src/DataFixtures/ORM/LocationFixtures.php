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
use Sil\Bundle\StockBundle\Domain\Entity\Location;

/**
 * Description of WarehouseFixtures
 *
 * @author glenn
 */
class LocationFixtures extends Fixture implements ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function load(ObjectManager $manager)
    {
        $wh = $this->getReference('wh-1');
        
        $loc1 = Location::createDefault('SUPPLIER-1', 'Emplacement fournisseur');
        $wh->addLocation($loc1);

        $loc2 = Location::createDefault('STOCK-1', 'Emplacement Stock');
        $wh->addLocation($loc2);

        $manager->persist($loc1);
        $manager->persist($loc2);
        $manager->flush();

        // other fixtures can get this object using the 'admin-user' name
        $this->addReference('supplier-1', $loc1);
        $this->addReference('stock-1', $loc2);
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getDependencies()
    {
        return array(
            WarehouseFixtures::class,
        );
    }

}
