<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sil\Bundle\StockBundle\Application\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of UomQtyType
 *
 * @author glenn
 */
class UomQtyType extends AbstractType
{
    public function __construct()
    {
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'uom_type_id' => null,
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $uomTypeId = $options['uom_type_id'];
        
        if(null == $uomTypeId){
            throw new \InvalidArgumentException('The "uom_type_id" options is required');
        }
        
        $builder->add('qtyUom',  ChoiceType::class, ['choice_loader' => null]);
        $builder->add('qtyValue');
    }

}
