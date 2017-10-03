<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sil\Bundle\StockBundle\Application\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\BaseType;
use Sil\Bundle\StockBundle\Domain\Repository\UomRepositoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Description of UomQtyType
 *
 * @author glenn
 */
class UomQtyType extends BaseType
{

    /**
     *
     * @var UomRepositoryInterface 
     */
    protected $uomRepository;

    /**
     * @param UomRepositoryInterface $manager
     */
    public function __construct(UomRepositoryInterface $uomRepository)
    {
        $this->uomRepository = $uomRepository;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(array(
            'data_class' => 'Sil\Bundle\StockBundle\Domain\Entity\UomQty'
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->addEventListener(FormEvents::PRE_SET_DATA,
                [$this, 'buildUomTypeChoices']);


        $builder->add('value', NumberType::class);
    }

    public function buildUomTypeChoices(FormEvent $event)
    {
        $uomQty = $event->getData();
        $form = $event->getForm();
        $choices = [];
       
        if(null !== $form->getParent()->getData()){
            print_r($form->getParent()->getData()->getStockItem());
    }
        
        
        $uoms = $this->uomRepository->findAll();
        foreach ( $uoms as $uom ) {
            $choices[$uom->getName()] = $uom->getId();
        }

        $form->add('uom', ChoiceType::class,
                ['choices' => $choices]);
    }

    public function getBlockPrefix()
    {
        return self::class;
    }

}
