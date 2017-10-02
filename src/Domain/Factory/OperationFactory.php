<?php

declare(strict_types=1);
/*
 * This file is part of the Blast Project package.
 *
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Sil\Bundle\StockBundle\Domain\Factory;

use Sil\Bundle\StockBundle\Domain\Entity\Operation;
use Sil\Bundle\StockBundle\Domain\Generator\OperationCodeGeneratorInterface;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class OperationFactory implements OperationFactoryInterface
{

    /**
     *
     * @var OperationCodeGeneratorInterface  
     */
    private $codeGenerator;

    /**
     * 
     * @param OperationCodeGeneratorInterface $codeGenerator
     */
    public function __construct(OperationCodeGeneratorInterface $codeGenerator)
    {
        $this->codeGenerator = $codeGenerator;
    }

    /**
     * 
     * @return Operation
     */
    public function createDraft(): Operation
    {
        return new Operation();
    }

}
