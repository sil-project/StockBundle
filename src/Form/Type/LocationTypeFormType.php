<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Sil\Bundle\StockBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\BaseType;
use Sil\Bundle\StockBundle\Domain\Repository\UomRepositoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Sil\Bundle\StockBundle\Domain\Entity\StockItem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormInterface;
use Sil\Bundle\StockBundle\Domain\Entity\LocationType;

/**
 * @author glenn
 */
class LocationTypeFormType extends BaseType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(array(
            'empty_data' => function (FormInterface $form) {
                return LocationType::{$form->get('value')->getData()}();
            },
            'choices' => LocationType::getTypes(),
            'choice_value' => function($o) {
                return (null == $o ? LocationType::internal() : $o->getValue());
                 
            },
            'choice_label' => function($o) {
                return 'sil.stock.location_type.' . $o;
            },
        ));
    }

    public function getBlockPrefix()
    {
        return self::class;
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
