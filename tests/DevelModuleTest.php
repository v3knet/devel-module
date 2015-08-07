<?php

namespace v3knet\module\tests;

use Silex\Application;
use Silex\Controller;
use v3knet\module\devel\DevelModule;

class DevelModuleTest extends \PHPUnit_Framework_TestCase
{

    protected function getContainer()
    {
        $c = new Application(['app.root' => '/tmp']);
        $c->register(new DevelModule());

        return $c;
    }

    public function testModule()
    {
        $this->assertNotNull(new DevelModule(), 'The class is created without issue.');
    }

    /**
     * Make sure WebProfilerServiceProvider is registered & booted.
     */
    public function testWebProfiler()
    {
        $c = $this->getContainer();
        $c->boot();
        $this->assertInstanceOf(Controller::class, $c['controllers']->match('/_profiler/search'));
    }

}
