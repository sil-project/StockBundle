<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Sil\Bundle\StockBundle\Infrastructure\Doctrine\ORM;

use Sil\Bundle\StockBundle\Domain\Repository\OperationRepositoryInterface;
use Blast\Bundle\ResourceBundle\Doctrine\ORM\ResourceRepository;

/**
 * Description of UomTypeRepository
 *
 * @author glenn
 */
class OperationRepository extends ResourceRepository implements OperationRepositoryInterface
{
    //put your code here
}
