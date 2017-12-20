<?php

declare(strict_types=1);

/*
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Sil\Bundle\StockBundle\Domain\Entity;

use Sil\Bundle\UomBundle\Entity\Uom;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
interface StockItemInterface
{
    /**
     * @return string
     */
    public function getName(): ?string;

    /**
     * @return string
     */
    public function getCode(): ?string;

    /**
     * @return Uom
     */
    public function getUom(): ?Uom;

    /**
     * @return OutputStrategy
     */
    public function getOutputStrategy(): ?OutputStrategy;
}
