<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sil\Bubdle\StockBundle\Application\Form\ChoiceLoader;

use Symfony\Component\Form\ChoiceList\Loader\ChoiceLoaderInterface;
use Sil\Bundle\StockBundle\Domain\Repository\UomTypeRepositoryInterface;
use Symfony\Component\Form\ChoiceList\ChoiceListInterface;

/**
 * Description of UomTypeChoiceLoader
 *
 * @author glenn
 */
class UomTypeChoiceLoader implements ChoiceLoaderInterface
{

    /**
     * @param EntityManager $manager
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

        $choices = $repository->findBy(['label' => $field]);
        $choiceList = [];
        foreach ($choices as $choice) {
            $choiceList[$choice->getValue()] = $choice->getValue();
        }
        $this->choiceList = new ArrayChoiceList($choiceList, $value);

        return $this->choiceList;
    }

    public function loadChoicesForValues(string $values, $value = null): array
    {
        
    }

    public function loadValuesForChoices(array $choices, $value = null): array
    {
        $values = array();
        foreach ($choices as $key => $choice) {
            if (is_callable($value)) {
                $values[$key] = (string) call_user_func($value, $choice, $key);
            } else {
                $values[$key] = $choice;
            }
        }
        $this->choiceList = new ArrayChoiceList($values, $value);

        return $values;
    }

}
