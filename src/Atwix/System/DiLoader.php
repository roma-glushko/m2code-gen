<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\System;

use Atwix\System\Filesystem\DirectoryLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class DiLoader
 */
class DiLoader
{
    /**
     * @var DirectoryLocator
     */
    protected $directoryLocator;

    /**
     * @var string
     */
    protected $configFileName;

    /**
     * @param DirectoryLocator $directoryLocator
     */
    public function __construct(
        DirectoryLocator $directoryLocator
    ) {
        $this->directoryLocator = $directoryLocator;
    }

    /**
     * @param string $configFileName
     *
     * @return ContainerBuilder
     */
    public function load(string $configFileName): ContainerBuilder
    {
        $containerBuilder = new ContainerBuilder();
        $configPath = $this->directoryLocator->getConfigPath();

        $loader = new YamlFileLoader($containerBuilder, new FileLocator($configPath));

        $loader->load($configFileName);

        return $containerBuilder;
    }
}