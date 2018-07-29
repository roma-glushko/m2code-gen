<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\System\Twig;

use Atwix\System\Filesystem\DirectoryLocator;
use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_Template;

/**
 * Class TwigEnvironmentWrapper
 *
 * Injectable wrapper for Twig_Environment class
 */
class TwigEnvironmentWrapper
{
    /**
     * @var Twig_Environment
     */
    protected $twigEnvironment;

    /**
     * @var TwigLoader
     */
    protected $twigLoader;

    /**
     * @var DirectoryLocator
     */
    protected $directoryLocator;

    /**
     * @param DirectoryLocator $directoryLocator
     * @param TwigLoader $twigLoader
     */
    public function __construct(DirectoryLocator $directoryLocator, TwigLoader $twigLoader)
    {
        $this->directoryLocator = $directoryLocator;
        $this->twigEnvironment = $twigLoader->load($directoryLocator->getTemplatePath());
    }

    /**
     * @param string $name
     * @param array $context
     *
     * @return string
     */
    public function render($name, array $context = [])
    {
        return $this->twigEnvironment->render($name, $context);
    }

    /**
     * @param string $templateContent
     *
     * @return Twig_Template
     */
    public function createTemplate($templateContent)
    {
        return $this->twigEnvironment->createTemplate($templateContent);
    }
}