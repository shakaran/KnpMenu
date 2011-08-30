<?php

namespace Knp\Menu\Tests\Provider;

use Knp\Menu\Provider\PimpleProvider;

class PimpleProviderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!class_exists('Pimple')) {
            $this->markTestSkipped('Pimple is not available');
        }
    }

    public function testHas()
    {
        $provider = new PimpleProvider(new \Pimple(), array('first' => 'first', 'second' => 'dummy'));
        $this->assertTrue($provider->has('first'));
        $this->assertTrue($provider->has('second'));
        $this->assertFalse($provider->has('third'));
    }

    public function testGetExistentRenderer()
    {
        $pimple = new \Pimple();
        $menu = $this->getMock('Knp\Menu\ItemInterface');
        $pimple['menu'] = function() use ($menu) {
            return $menu;
        };
        $provider = new PimpleProvider($pimple, array('default' => 'menu'));
        $this->assertSame($menu, $provider->get('default'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetNonExistentRenderer()
    {
        $provider = new PimpleProvider(new \Pimple());
        $provider->get('non-existent');
    }
}
