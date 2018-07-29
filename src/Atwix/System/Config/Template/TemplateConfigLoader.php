<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\System\Config\Template;

use Symfony\Component\Config\FileLocator as ConfigFileLocator;
use Atwix\System\Filesystem\DirectoryLocator;
use Symfony\Component\Yaml\Yaml;

/**
 * Class TemplateConfigLoader
 */
class TemplateConfigLoader
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
        $configDirectories = [
            $this->directoryLocator->getTemplatePath(),
        ];

        $fileLocator = new ConfigFileLocator($configDirectories);
        $yamlUserFiles = $fileLocator->locate('template.yaml', null, false);
    }
}