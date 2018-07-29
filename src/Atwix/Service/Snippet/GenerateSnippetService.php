<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\Service\Snippet;

use Atwix\Applier\ApplierInterface;
use Atwix\Component\Renderer\Snippet\SnippetContentRenderer;
use Atwix\Service\Module\ResolveModulePathService;
use Atwix\Component\Renderer\Snippet\SnippetVariableProcessor;
use Atwix\System\Config\Template\TemplateConfigLoader;
use Atwix\System\VarRegistry;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class GenerateTemplateService
 */
class GenerateSnippetService
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
     * @param ContainerInterface $container
     * @param ResolveModulePathService $resolveModulePathService
     * @param SnippetContentRenderer $snippetContentRenderer
     * @param SnippetVariableProcessor $processVariablesService
     */
    public function __construct(
        ContainerInterface $container,
        //ResolveModulePathService $resolveModulePathService,
        SnippetContentRenderer $snippetContentRenderer,
        SnippetVariableProcessor $processVariablesService
    ) {
        //$this->resolveModulePathService = $resolveModulePathService;
        $this->container = $container;
        $this->snippetContentRenderer = $snippetContentRenderer;
        $this->processVariablesService = $processVariablesService;
    }

    /**
     * @param string $snippetName
     * @param VarRegistry $variableRegistry
     *
     * @return void
     */
    public function execute(string $snippetName, VarRegistry $variableRegistry)
    {
        $moduleName = $variableRegistry->get('module-full-name');
        $moduleRootDir = $variableRegistry->get('module-root-dir');

        $modulePath = $this->resolveModulePathService->execute($moduleName, $moduleRootDir);
        $variables = $this->processVariablesService->execute($variableRegistry);

        $snippetConfig = $this->snippetConfigLoader->load($snippetName);

        $snippetFiles = $snippetConfig['files'] ?? [];
        $snippetTemplatePath = $snippetConfig['templatePath'] ?? null;

        // validate generating snippet
        //foreach ($snippetFiles as $snippetFilePath => $snippetFileConfig) {
        //}

        // apply snippet
        foreach ($snippetFiles as $snippetFilePath => $snippetFileConfig) {
            /** @var ApplierInterface $applier */
            $applier = $this->container->get($snippetFileConfig['applier']);
            $snippetFileTemplatePath = sprintf('%s/%s.twig', $snippetTemplatePath, $snippetFilePath);

            $renderedSnippetContent = $this->snippetContentRenderer->render(
                $snippetFileTemplatePath,
                $variables
            );

            $applier->apply($modulePath, $snippetTemplatePath, $snippetFilePath, $renderedSnippetContent);
        }
    }
}