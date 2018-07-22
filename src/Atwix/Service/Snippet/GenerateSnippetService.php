<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\Service\Snippet;

use Atwix\Applier\ApplierInterface;
use Atwix\Processor\Snippet\TwigSnippetFileProcessor;
use Atwix\Service\Module\ResolveModulePathService;
use Atwix\System\Snippet\SnippetConfigLoader;
use Atwix\System\VarRegistry;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class GenerateSnippetService
 */
class GenerateSnippetService
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var SnippetConfigLoader
     */
    protected $snippetConfigLoader;

    /**
     * @var ResolveModulePathService
     */
    protected $resolveModulePathService;

    /**
     * @var TwigSnippetFileProcessor
     */
    protected $twigSnippetFileProcessor;

    /**
     * @var ProcessVariablesService
     */
    protected $processVariablesService;

    /**
     * @param ContainerInterface $container
     * @param SnippetConfigLoader $snippetConfigLoader
     * @param ResolveModulePathService $resolveModulePathService
     * @param TwigSnippetFileProcessor $twigSnippetFileProcessor
     * @param ProcessVariablesService $processVariablesService
     */
    public function __construct(
        ContainerInterface $container,
        SnippetConfigLoader $snippetConfigLoader,
        ResolveModulePathService $resolveModulePathService,
        TwigSnippetFileProcessor $twigSnippetFileProcessor,
        ProcessVariablesService $processVariablesService
    ) {
        $this->snippetConfigLoader = $snippetConfigLoader;
        $this->resolveModulePathService = $resolveModulePathService;
        $this->container = $container;
        $this->twigSnippetFileProcessor = $twigSnippetFileProcessor;
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
        foreach ($snippetFiles as $snippetFilePath => $snippetFileConfig) {

        }

        // apply snippet
        foreach ($snippetFiles as $snippetFilePath => $snippetFileConfig) {
            /** @var ApplierInterface $applier */
            $applier = $this->container->get($snippetFileConfig['applier']);
            $snippetFileTemplatePath = sprintf('%s/%s.twig', $snippetTemplatePath, $snippetFilePath);

            $renderedSnippetFileContent = $this->twigSnippetFileProcessor->process(
                $snippetFileTemplatePath,
                $variables
            );

            $applier->apply($modulePath, $snippetTemplatePath, $snippetFilePath, $renderedSnippetFileContent);
        }
    }
}