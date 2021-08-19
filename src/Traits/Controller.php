<?php

namespace Phisolutions\Traits;

use Psr\Container\ContainerInterface;


Trait Controller
{
    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
}