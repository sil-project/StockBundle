<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Sil\Bundle\StockBundle\Doctrine\ORM;

use Sil\Bundle\StockBundle\Domain\Repository\MovementRepositoryInterface;
use Blast\Bundle\ResourceBundle\Doctrine\ORM\Repository\ResourceRepository;

/**
 * Description of UomTypeRepository
 *
 * @author glenn
 */
class MovementRepository extends ResourceRepository implements MovementRepositoryInterface
{
    //put your code here
}
