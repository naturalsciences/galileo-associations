<?php
/**
 * Created by PhpStorm.
 * User: duchesne
 * Date: 27/12/16
 * Time: 17:18
 */

namespace tests\AppBundle\Utils;

use AppBundle\Utils\Util;

class UtilTest extends \PHPUnit_Framework_TestCase
{
    public function testAlphaRange() {
        $util = new Util();
        $alphaRange = $util::alphaRange();

        $this->assertCount(28,$alphaRange);
        $this->assertArrayHasKey('*', $alphaRange);
        $this->assertArrayHasKey('#', $alphaRange);
        $this->assertArrayHasKey('Z', $alphaRange);
        $this->assertArrayNotHasKey('x', $alphaRange);
    }
}
