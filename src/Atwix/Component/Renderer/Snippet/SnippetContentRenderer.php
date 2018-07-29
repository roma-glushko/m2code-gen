<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\Component\Renderer\Snippet;

use Atwix\System\Twig\TwigEnvironmentWrapper;

/**
 * Class SnippetContentRenderer
 */
class SnippetContentRenderer
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
     * @param string $snippetTemplateFilePath
     * @param array $variables
     *
     * @return string
     */
    public function render(string $snippetTemplateFilePath, array $variables): string
    {
        return $this->twigEnvironment->render($snippetTemplateFilePath, $variables);
    }
}