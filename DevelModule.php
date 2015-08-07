<?php

namespace v3knet\module\devel;

use Pimple\Container;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\RoutingServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Symfony\Component\HttpKernel\Profiler\FileProfilerStorage;
use v3knet\module\Module;

class DevelModule extends Module
{

    protected $machineName = 'devel';
    protected $name        = 'Devel Module';

    /**
     * {@inheritdoc}
     */
    public function register(Container $c)
    {
        if (!isset($c['fragment.handler'])) {
            $c->register(new HttpFragmentServiceProvider());
        }

        if (!isset($c['twig'])) {
            $c->register(new TwigServiceProvider());
        }

        if (!isset($c['url_generator'])) {
            $c->register(new RoutingServiceProvider());
        }

        if (!isset($c['profiler.mount_prefix'])) {
            $c->register(new WebProfilerServiceProvider(), [
                'profiler.storage' => function (Container $c) {
                    return new FileProfilerStorage('file:' . $c['app.root'] . '/files/cache/profiler');
                },
            ]);
        }

        if (!class_exists(ServiceControllerServiceProvider::class, false)) {
            $c->register(new ServiceControllerServiceProvider());
        }
    }

}
