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

namespace Sil\Bundle\StockBundle\Domain\Entity;

use Blast\BaseEntitiesBundle\Entity\Traits\Guidable;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class UomType
{

    use Guidable;

    /**
     *
     * @var string 
     */
    private $name;

    /**
     * 
     * @param string $name
     */
    public static function createDefault(string $name)
    {
        $o = new self();
        $o->name = $name;
        return $o;
    }

    /**
     * 
     */
    public function __construct()
    {
        
    }

    /**
     * 
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

}
