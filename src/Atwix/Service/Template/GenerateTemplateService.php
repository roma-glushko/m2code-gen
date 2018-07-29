<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\Service\Template;

use Atwix\Component\Renderer\Snippet\SnippetContentRenderer;
use Atwix\Component\Renderer\Snippet\SnippetVariableProcessor;
use Atwix\Service\Module\ResolveModulePathService;
use Atwix\Service\Snippet\GenerateSnippetService;
use Atwix\System\Config\Template\TemplateConfigLoader;
use Atwix\System\VarRegistry;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class GenerateTemplateService
 */
class GenerateTemplateService
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var TemplateConfigLoader
     */
    protected $snippetConfigLoader;

    /**
     * @var ResolveModulePathService
     */
    protected $resolveModulePathService;

    /**
     * @var SnippetContentRenderer
     */
    protected $snippetContentRenderer;

    /**
     * @var SnippetVariableProcessor
     */
    protected $processVariablesService;

    /**
     * @var GenerateSnippetService
     */
    protected $generateSnippetService;

    /**
     * @param ContainerInterface $container
     * @param TemplateConfigLoader $snippetConfigLoader
     * @param GenerateSnippetService $generateSnippetService
     */
    public function __construct(
        ContainerInterface $container,
        TemplateConfigLoader $snippetConfigLoader,
        GenerateSnippetService $generateSnippetService
    ) {
        $this->snippetConfigLoader = $snippetConfigLoader;
        $this->container = $container;
        $this->generateSnippetService = $generateSnippetService;
    }

    /**
     * @param string $templateName
     * @param VarRegistry $variableRegistry
     *
     * @return void
     */
    public function execute(string $templateName, VarRegistry $variableRegistry)
    {
        $snippetConfig = $this->snippetConfigLoader->load($templateName);

        $snippets = $snippetConfig['snippets'] ?? [];
        $templatePath = $snippetConfig['templateName'] ?? null;

        // validate generating snippet
        //foreach ($snippetFiles as $snippetFilePath => $snippetFileConfig) {
        //}

        // apply snippet
        foreach ($snippets as $snippetFilePath => $snippetFileConfig) {
            // $this->generateSnippetService->execute();
        }
    }
}