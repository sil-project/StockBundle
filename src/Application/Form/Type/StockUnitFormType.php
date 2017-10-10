<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Sil\Bundle\StockBundle\Application\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\BaseType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Sil\Bundle\StockBundle\Domain\Repository\LocationRepositoryInterface;

/**
 *
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class StockUnitFormType extends BaseType
{

    /**
     *
     * @var LocationRepositoryInterface 
     */
    protected $locationRepository;

    /**
     * @param LocationRepositoryInterface $locationRepository
     */
    public function __construct(LocationRepositoryInterface $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $locations = $this->locationRepository->findAll();

        $builder->add('location', EntityType::class,
            [
                'label' => false,
                'class' => 'Sil\Bundle\StockBundle\Domain\Entity\Location',
                'choices' => $locations,
                'choice_label' => 'name',
        ]);

        $builder->add('qty', UomQtyFormType::class);
    }

    public function getBlockPrefix()
    {
        return 'stock_unit_form';
    }
    
   
    public function getName()
    {
        return 'stock_unit_form';
    }
}
