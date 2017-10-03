<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Sil\Bundle\StockBundle\Application\Form\ChoiceLoader;

use Symfony\Component\Form\ChoiceList\Loader\ChoiceLoaderInterface;
use Sil\Bundle\StockBundle\Domain\Repository\UomTypeRepositoryInterface;
use Symfony\Component\Form\ChoiceList\ChoiceListInterface;
use Symfony\Component\Form\ChoiceList\ArrayChoiceList;

/**
 * Description of UomTypeChoiceLoader
 *
 * @author glenn
 */
class UomTypeChoiceLoader implements ChoiceLoaderInterface
{

    /**
     * @param UomTypeRepositoryInterface $manager
     * @param array         $options
     */
    public function __construct(UomTypeRepositoryInterface $uomTypeRepository)
    {
        $this->uomTypeRepository = $uomTypeRepository;
    }

    //put your code here
    public function loadChoiceList($value = null): ChoiceListInterface
    {

        $uomTypes = $this->uomTypeRepository->findAll();
       
        return new ArrayChoiceList($uomTypes, function($ut){$ut->getId();});
    }

    public function loadChoicesForValues(array $values, $value = null): array
    {
        throw new \Exception();
        return [];
    }

    public function loadValuesForChoices(array $choices, $value = null): array
    {
        print_r($value);
        return [];
    }
}
