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

namespace Sil\Bundle\StockBundle\Application\Admin;

use Blast\CoreBundle\Admin\CoreAdmin;

/**
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class LocationAdmin extends CoreAdmin
{

    protected $baseRouteName = 'admin_stock_locations';
    protected $baseRoutePattern = 'stock/locations';

}
