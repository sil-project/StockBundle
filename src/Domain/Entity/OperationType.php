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

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class OperationType
{
    const INTERNAL_TRANSFER = 'internal_transfer';
    const RECEIPT = 'receipt';
    const SHIPPING = 'shipping';

    /**
     * @var string
     */
    private $value;

    public static function internalTransfer()
    {
        return new self(self::INTERNAL_TRANSFER);
    }

    public static function receipt()
    {
        return new self(self::RECEIPT);
    }

    public static function shipping()
    {
        return new self(self::SHIPPING);
    }

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public static function getTypes()
    {
        return [
            self::internalTransfer(),
            self::receipt(),
            self::shipping(),
        ];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getValue();
    }
}
