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
class OutputStrategy
{

    use Guidable;

    /**
     *
     * @var string 
     */
    private $name;

    /**
     *
     * @var string 
     */
    private $description;

    /**
     *
     * @var array 
     */
    private $orderBy;

    /**
     * 
     * @param string $name
     * @param string $orderBy
     */
    public function __construct(string $name, array $orderBy)
    {
        $this->name = $name;
        $this->orderBy = $orderBy;
    }

    /**
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * 
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * 
     * @return array
     */
    public function getOrderBy(): array
    {
        return $this->orderBy;
    }

    /**
     * 
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * 
     * @param string|null $description
     * @return void
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * 
     * @param array $orderBy
     * @return void
     */
    public function setOrderBy(array $orderBy): void
    {
        $this->orderBy = $orderBy;
    }

}
