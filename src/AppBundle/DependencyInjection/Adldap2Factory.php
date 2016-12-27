<?php
/*
 * This file is part of the sigu.
 *
 * (c) Sergio Gómez <sergio@uco.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DependencyInjection;


use Adldap\Adldap;
use Adldap\Connections\Provider;

class Adldap2Factory
{
    public static function createConnection(array $config)
    {
        $ad = new Adldap();
        $ad->addProvider('default', new Provider($config));
        try {
            $ad->connect('default');
        }
        catch (\Exception $e) {}

        return $ad;
    }
}
