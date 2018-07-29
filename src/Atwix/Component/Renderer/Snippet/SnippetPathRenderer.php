<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\Component\Renderer\Snippet;

use Atwix\System\Twig\TwigEnvironmentWrapper;

/**
 * Class SnippetPathRenderer
 */
class SnippetPathRenderer
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
     * @param string $snippetFilePathTemplate
     * @param array $variables
     *
     * @return string
     */
    public function render(string $snippetFilePathTemplate, array $variables): string
    {
        $template = $this->twigEnvironment->createTemplate($snippetFilePathTemplate);

        return $template->render($variables);
    }
}