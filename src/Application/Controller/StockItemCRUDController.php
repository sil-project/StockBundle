<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Sil\Bundle\StockBundle\Application\Controller;

use Blast\CoreBundle\Controller\CRUDController;
use Sil\Bundle\StockBundle\Domain\Entity\StockUnit;
use Sil\Bundle\StockBundle\Application\Form\Type\StockUnitFormType;

/**
 * Description of MovementController
 *
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class StockItemCRUDController extends CRUDController
{

    public function updateStockAction()
    {

        $form = $this->createForm(StockUnitFormType::class, null,
            array('method' => 'POST'));

        $view = $form->createView();

        return $this->render($this->admin->getTemplate('edit'),
                array(
                    'action' => 'create',
                    'form' => $view,
                    'object' => new StockUnit(),
                ), null);
    }
}
