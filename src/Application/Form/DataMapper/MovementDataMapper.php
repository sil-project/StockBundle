<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Sil\Bundle\StockBundle\Application\Form\DataMapper;

use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\DataMapper\PropertyPathMapper;
use Sil\Bundle\StockBundle\Domain\Entity\Movement;
use Sil\Bundle\StockBundle\Domain\Factory\MovementFactory;
use Sil\Bundle\StockBundle\Domain\Generator\MovementCodeGenerator;

/**
 * Description of OperationDataMapper
 *
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class MovementDataMapper extends PropertyPathMapper
{

    public function mapDataToForms($data, $forms)
    {
        return parent::mapDataToForms($data, $forms);
    }

    public function mapFormsToData($forms, &$data)
    {
        $factory = new MovementFactory(new MovementCodeGenerator());
        $forms = iterator_to_array($forms);

        if ( null === $data ) {
            $item = $forms['stockItem']->getData();
            $qty = $forms['qty']->getData();
            
            $data = $factory->createDraft($item, $qty);
           
        } else {
            parent::mapFormsToData($forms, $data);
        }
    }
}
