<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\Service\Template;

use Atwix\Component\Renderer\Snippet\SnippetVariableProcessor;
use Atwix\Service\Snippet\GenerateSnippetService;
use Atwix\System\Config\Template\TemplateConfigLoader;
use Atwix\System\VarRegistry;
use Exception;
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
    protected $templateConfigLoader;

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
     * @param TemplateConfigLoader $templateConfigLoader
     * @param SnippetVariableProcessor $processVariablesService
     * @param GenerateSnippetService $generateSnippetService
     */
    public function __construct(
        ContainerInterface $container,
        TemplateConfigLoader $templateConfigLoader,
        SnippetVariableProcessor $processVariablesService,
        GenerateSnippetService $generateSnippetService
    ) {
        $this->templateConfigLoader = $templateConfigLoader;
        $this->container = $container;
        $this->generateSnippetService = $generateSnippetService;
        $this->processVariablesService = $processVariablesService;
    }

    /**
     * @param string $templateName
     * @param VarRegistry $variableRegistry
     *
     * @return void
     * @throws Exception
     */
    public function execute(string $templateName, VarRegistry $variableRegistry)
    {
        $templateConfigs = $this->templateConfigLoader->load();

        if (!array_key_exists($templateName, $templateConfigs)) {
            throw new Exception(sprintf('"%s" template is not found', $templateName));
        }

        $templateConfig = $templateConfigs[$templateName];

        $snippets = $templateConfig['snippets'] ?? [];
        $variables = $this->processVariablesService->execute($variableRegistry);

        // todo: validate generating snippet
        //foreach ($snippetFiles as $snippetFilePath => $snippetFileConfig) {
        //}

        // apply snippet
        foreach ($snippets as $snippetPath => $snippetConfig) {
            $this->generateSnippetService->execute(
                $templateConfig,
                $snippetPath,
                $snippetConfig,
                $variables
            );
        }
    }
}