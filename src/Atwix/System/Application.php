<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\System;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class Application
{
    /**
     * @var ContainerBuilder
     */
    protected $containerBuilder;

    /**
     * @var string
     */
    protected $rootDir;

    /**
     * @param string $rootDir
     */
    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function lunch()
    {
        $diLoader = new DiLoader();

        $this->containerBuilder = $diLoader->load($this->rootDir . '/etc/', 'di.yaml');

        echo 'M2CODE-GEN is running..';
    }
}