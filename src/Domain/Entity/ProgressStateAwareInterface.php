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
interface ProgressStateAwareInterface
{

    /**
     * 
     * @return ProgressState
     */
    public function getState(): ProgressState;

    /**
     * 
     * @return void
     */
    public function beDraft(): void;

    /**
     * 
     * @return void
     */
    public function beConfirmed(): void;

    /**
     * 
     * @return void
     */
    public function bePartiallyAvailable(): void;

    /**
     * 
     * @return void
     */
    public function beAvailable(): void;

    /**
     * 
     * @return void
     */
    public function beDone(): void;

    /**
     * 
     * @return void
     */
    public function beCancel(): void;

    /**
     * 
     * @return bool
     */
    public function isDraft(): bool;

    /**
     * 
     * @return bool
     */
    public function isConfirmed(): bool;

    /**
     * 
     * @return bool
     */
    public function isPartiallyAvailable(): bool;

    /**
     * 
     * @return bool
     */
    public function isAvailable(): bool;

    /**
     * 
     * @return bool
     */
    public function isDone(): bool;

    /**
     * 
     * @return bool
     */
    public function isCancel(): bool;

    /**
     * 
     * @return bool
     */
    public function isToDo(): bool;

    /**
     * 
     * @return bool
     */
    public function isInProgress(): bool;
}
