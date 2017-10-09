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

use DomainException;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class ProgressState
{

    const DRAFT = 'draft';
    const CONFIRMED = 'confirmed';
    const PARTIALLY_AVAILABLE = 'partially_available';
    const AVAILABLE = 'available';
    const DONE = 'done';
    const CANCEL = 'cancel';

    /**
     *
     * @var string
     */
    private $value;

    /**
     * 
     * @return ProgressState
     */
    public static function draft(): ProgressState
    {
        return new self(self::DRAFT);
    }

    /**
     * 
     * @return ProgressState
     */
    public static function confirmed(): ProgressState
    {
        return new self(self::CONFIRMED);
    }

    /**
     * 
     * @return ProgressState
     */
    public static function partiallyAvailable(): ProgressState
    {
        return new self(self::PARTIALLY_AVAILABLE);
    }

    /**
     * 
     * @return ProgressState
     */
    public static function available(): ProgressState
    {
        return new self(self::AVAILABLE);
    }

    /**
     * 
     * @return ProgressState
     */
    public static function done(): ProgressState
    {
        return new self(self::DONE);
    }

    /**
     * 
     * @return ProgressState
     */
    public static function cancel(): ProgressState
    {
        return new self(self::CANCEL);
    }

    /**
     * @internal 
     * @return ProgressState
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * 
     * @return bool
     */
    public function isDraft(): bool
    {
        return $this->value == self::DRAFT;
    }

    /**
     * 
     * @return bool
     */
    public function isConfirmed(): bool
    {
        return $this->value == self::CONFIRMED;
    }

    /**
     * 
     * @return bool
     */
    public function isPartiallyAvailable(): bool
    {
        return $this->value == self::PARTIALLY_AVAILABLE;
    }

    /**
     * 
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->value == self::AVAILABLE;
    }

    /**
     * 
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->value == self::DONE;
    }

    /**
     * 
     * @return bool
     */
    public function isCancel(): bool
    {
        return $this->value == self::CANCEL;
    }

    /**
     * 
     * @return bool
     */
    public function isToDo(): bool
    {
        return !($this->isCancel() || $this->isDone() || $this->isDraft());
    }

    public function isInProgress(): bool
    {
        return ($this->isPartiallyAvailable() || $this->isAvailable());
    }

    /**
     * 
     * @return ProgressState
     * @throws DomainException
     */
    public function toDraft(): ProgressState
    {
        if ( $this->isDraft() ) {
            return $this;
        }

        if ( !$this->isConfirmed() ) {
            throw new DomainException('Movement with reserved units'
                    . ' cannot return in the DRAFT state');
        }
        return self::draft();
    }

    /**
     * 
     * @return ProgressState
     * @throws DomainException
     */
    public function toConfirmed(): ProgressState
    {
        if ( $this->isConfirmed() ) {
            return $this;
        }
        if ( !$this->isDraft() ) {
            throw new DomainException();
        }
        return self::confirmed();
    }

    /**
     * 
     * @return ProgressState
     * @throws DomainException
     */
    public function toPartiallyAvailable(): ProgressState
    {
        if ( $this->isPartiallyAvailable() ) {
            return $this;
        }
        if ( !$this->isConfirmed() && !$this->isPartiallyAvailable() ) {
            throw new DomainException('Movement which is not confirmed '
                    . 'or partially available cannot be marked as partially available');
        }
        return self::partiallyAvailable();
    }

    /**
     * 
     * @return ProgressState
     * @throws DomainException
     */
    public function toAvailable(): ProgressState
    {
        if ( $this->isAvailable() ) {
            return $this;
        }
        if ( !$this->isConfirmed() && !$this->isPartiallyAvailable() ) {
            throw new DomainException('Movement which is not confirmed '
                    . 'or partially available cannot be marked as available');
        }
        return self::available();
    }

    /**
     * 
     * @return ProgressState
     * @throws DomainException
     */
    public function toDone(): ProgressState
    {
        if ( $this->isDone() ) {
            return $this;
        }
        if ( !$this->isAvailable() ) {
            throw new DomainException('Movement which is not '
                    . 'available connot be done');
        }
        return self::done();
    }

    /**
     * 
     * @return ProgressState
     * @throws DomainException
     */
    public function toCancel(): ProgressState
    {
        if ( $this->isCancel() ) {
            return $this;
        }
        if ( $this->isDone() ) {
            throw new DomainException('Movement which is done cannot be cancelled');
        }
        return self::cancel();
    }

    /**
     * 
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * 
     * @return string
     */
    public function __toString(): string
    {
        return $this->getValue();
    }

}
