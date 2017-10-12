<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Sil\Bundle\StockBundle\Application\Form\Type;

use Symfony\Component\Form\AbstractType;
use Sil\Bundle\StockBundle\Domain\Repository\LocationRepositoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Description of LocationChoiceFormType
 *
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class LocationChoiceFormType extends AbstractType
{

    /**
     *
     * @var LocationRepositoryInterface 
     */
    protected $locationRepository;

    public function __construct(LocationRepositoryInterface $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $repo = $this->getLocationRepository();
        $locations = $repo->findAll();
        $resolver->setDefaults(
            [
                'choices' => $locations,
                'choice_label' => 'getIndentedName',
                'choice_value' => 'id',
            ]
        );
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

    public function getLocationRepository(): LocationRepositoryInterface
    {
        return $this->locationRepository;
    }
}
