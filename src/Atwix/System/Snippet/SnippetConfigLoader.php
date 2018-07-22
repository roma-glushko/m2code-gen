<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\System\Snippet;

use Atwix\System\Filesystem\DirectoryLocator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

/**
 * Class SnippetConfigLoader
 */
class SnippetConfigLoader
{
    /**
     * @var DirectoryLocator
     */
    protected $directoryLocator;

    /**
     * @param DirectoryLocator $directoryLocator
     */
    public function __construct(DirectoryLocator $directoryLocator)
    {
        $this->directoryLocator = $directoryLocator;
    }

    /**
     * @param string $snippetConfigName
     *
     * @return array
     */
    public function load(string $snippetConfigName)
    {
        $snippetConfigFileName = sprintf('%s.yaml', $snippetConfigName);
        $snippetConfigPath = $this->directoryLocator->getSnippetConfigPath($snippetConfigFileName);

        return Yaml::parseFile($snippetConfigPath);
    }
}