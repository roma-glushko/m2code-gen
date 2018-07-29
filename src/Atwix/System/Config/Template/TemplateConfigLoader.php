<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\System\Config\Template;

use Atwix\System\Filesystem\TemplateLocator;
use Symfony\Component\Config\FileLocator as ConfigFileLocator;
use Symfony\Component\Yaml\Yaml;

/**
 * Class TemplateConfigLoader
 */
class TemplateConfigLoader
{
    const TEMPLATE_CONFIG_FILE = 'template.yaml';

    /**
     * @var TemplateLocator
     */
    protected $templateLocator;

    /**
     * @param TemplateLocator $templateLocator
     */
    public function __construct(TemplateLocator $templateLocator)
    {
        $this->templateLocator = $templateLocator;
    }

    /**
     * @return string[]
     */
    public function load()
    {
        $configDirectories = $this->templateLocator->getTemplateDirectoryList();

        $fileLocator = new ConfigFileLocator($configDirectories);
        $templateFiles = $fileLocator->locate(static::TEMPLATE_CONFIG_FILE, null, false);

        $mergedTemplateConfig = [];

        foreach ($templateFiles as $templateFile) {
            $mergedTemplateConfig = array_merge($mergedTemplateConfig, $this->getTemplateConfig($templateFile));
        }

        return $mergedTemplateConfig;
    }

    /**
     * @param string $templateFile
     *
     * @return string[]
     */
    protected function getTemplateConfig(string $templateFile)
    {
        return Yaml::parseFile($templateFile);
    }
}