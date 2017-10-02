<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sil\Bundle\StockBundle\Infrastructure\Doctrine\ORM;

use Sil\Bundle\StockBundle\Domain\Repository\UomTypeRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Description of UomTypeRepository
 *
 * @author glenn
 */
class UomTypeRepository extends EntityRepository implements UomTypeRepositoryInterface
{
    //put your code here
}
