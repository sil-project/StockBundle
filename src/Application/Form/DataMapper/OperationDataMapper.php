<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Sil\Bundle\StockBundle\Application\Form\DataMapper;

use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\DataMapper\PropertyPathMapper;
use Sil\Bundle\StockBundle\Domain\Entity\Operation;
use Sil\Bundle\StockBundle\Domain\Factory\OperationFactory;
use Sil\Bundle\StockBundle\Domain\Generator\OperationCodeGenerator;

/**
 * Description of OperationDataMapper
 *
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class OperationDataMapper extends PropertyPathMapper
{

    public function mapDataToForms($data, $forms)
    {
        return parent::mapDataToForms($data, $forms);
    }

    public function mapFormsToData($forms, &$data)
    {
        $factory = new OperationFactory(new OperationCodeGenerator());
        $forms = iterator_to_array($forms);

        if ( null === $data->getId() ) {
            $srcLocation = $forms['destLocation']->getData();
            $destLocation = $forms['srcLocation']->getData();
            
            $data = $factory->createDraft($srcLocation, $destLocation);
           
        } else {
            parent::mapFormsToData($forms, $data);
        }
    }
}
