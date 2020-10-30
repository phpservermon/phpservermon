<?php

namespace psm\Module\Consult;

use psm\Module\ModuleInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ConsultModule implements ModuleInterface
{

    public function load(ContainerBuilder $container)
    {
    }

    public function getControllers()
    {
        return array(
            'consult' => __NAMESPACE__ . '\Controller\ConsultController',
            'server' => __NAMESPACE__ . '\Controller\ServerController',
            'log' => __NAMESPACE__ . '\Controller\LogController',
            'status' => __NAMESPACE__ . '\Controller\StatusController',
            'update' => __NAMESPACE__ . '\Controller\UpdateController',
        );
    }
}