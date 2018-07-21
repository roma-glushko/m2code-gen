<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\System;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class DiLoader
 */
class DiLoader
{
    /**
     * @param string $configPath
     * @param string $configFileName
     *
     * @return ContainerBuilder
     * @throws \Exception
     */
    public function load(string $configPath, string $configFileName)
    {
        $containerBuilder = new ContainerBuilder();
        $loader = new YamlFileLoader($containerBuilder, new FileLocator($configPath));

        $loader->load($configFileName);

        return $containerBuilder;
    }
}