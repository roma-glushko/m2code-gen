<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\Service\Snippet;

use Atwix\Component\Applier\ApplierInterface;
use Atwix\Component\Magento\Filesystem\MagentoDirectoryLocator;
use Atwix\Component\Renderer\Snippet\SnippetContentRenderer;
use Atwix\Component\Renderer\Snippet\SnippetPathRenderer;
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
     * @var SnippetContentRenderer
     */
    protected $snippetContentRenderer;

    /**
     * @var MagentoDirectoryLocator
     */
    protected $magentoDirectoryLocator;

    /**
     * @var VarRegistry
     */
    protected $varRegistry;

    /**
     * @var SnippetPathRenderer
     */
    protected $snippetPathRenderer;

    /**
     * @param ContainerInterface $container
     * @param SnippetContentRenderer $snippetContentRenderer
     * @param SnippetPathRenderer $snippetPathRenderer
     * @param MagentoDirectoryLocator $magentoDirectoryLocator
     * @param VarRegistry $varRegistry
     */
    public function __construct(
        ContainerInterface $container,
        SnippetContentRenderer $snippetContentRenderer,
        SnippetPathRenderer $snippetPathRenderer,
        MagentoDirectoryLocator $magentoDirectoryLocator,
        VarRegistry $varRegistry
    ) {
        $this->container = $container;
        $this->snippetContentRenderer = $snippetContentRenderer;
        $this->magentoDirectoryLocator = $magentoDirectoryLocator;
        $this->snippetPathRenderer = $snippetPathRenderer;
        $this->varRegistry = $varRegistry;
    }

    /**
     * @param array $templateConfig
     * @param string $snippetPath
     * @param array $snippetConfig
     * @param array $variables
     *
     * @return void
     */
    public function execute(
        array $templateConfig,
        string $snippetPath,
        array $snippetConfig,
        array $variables
    ) {
        /** @var ApplierInterface $applier */
        $applier = $this->container->get($snippetConfig['applier']);

        $templateName = $templateConfig['templateName'];
        $templateSnippetDir = sprintf('%s/snippets', $templateName);

        $moduleName = $this->varRegistry->get('module-full-name');
        $moduleRootDir = $this->varRegistry->get('module-root-dir');

        $modulePath = $this->magentoDirectoryLocator->getModuleDirectory($moduleName, $moduleRootDir);

        $snippetFilePath = sprintf('%s/%s.twig', $templateSnippetDir, $snippetPath);

        $renderedSnippetContent = $this->snippetContentRenderer->render(
            $snippetFilePath,
            $variables
        );

        $filePath = $this->snippetPathRenderer->render($snippetPath, $variables);

        $applier->apply($modulePath, $filePath, $renderedSnippetContent);
    }
}