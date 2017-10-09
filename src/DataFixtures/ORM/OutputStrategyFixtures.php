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
use Sil\Bundle\StockBundle\Domain\Entity\OutputStrategy;

/**
 * Description of WarehouseFixtures
 *
 * @author glenn
 */
class OutputStrategyFixtures extends Fixture implements ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function load(ObjectManager $manager)
    {


        $outStrat = new OutputStrategy('default', ['createdAt' => 'ASC']);

        $manager->persist($outStrat);
        $manager->flush();
        
        
        $this->addReference('outs-default', $outStrat);
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

}
