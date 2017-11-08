<?php

declare(strict_types=1);

/*
 * This file is part of the Sil Project.
 *
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU GPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Sil\Bundle\StockBundle\Admin;

use Blast\Bundle\ResourceBundle\Sonata\Admin\ResourceAdmin;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class UomTypeAdmin extends ResourceAdmin
{
    protected $baseRouteName = 'admin_stock_uomtype';
    protected $baseRoutePattern = 'stock/uomtype';
}
