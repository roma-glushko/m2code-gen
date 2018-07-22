<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\Processor\Snippet;

use Atwix\System\Twig\TwigEnvironmentWrapper;

/**
 * Class TwigSnippetFileProcessor
 */
class TwigSnippetFileProcessor
{
    /**
     * @var TwigEnvironmentWrapper
     */
    protected $twigEnvironment;

    /**
     * @param TwigEnvironmentWrapper $twigEnvironment
     */
    public function __construct(TwigEnvironmentWrapper $twigEnvironment)
    {
        $this->twigEnvironment = $twigEnvironment;
    }

    /**
     * @param string $snippetFileTemplatePath
     * @param array $variables
     *
     * @return string
     */
    public function process(string $snippetFileTemplatePath, array $variables): string
    {
        return $this->twigEnvironment->render($snippetFileTemplatePath, $variables);
    }
}