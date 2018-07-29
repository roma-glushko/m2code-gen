<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\Command;

use Atwix\Service\Template\GenerateTemplateService;
use Atwix\System\VarRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GenerateNewFrontendPluginCommand
 */
class GenerateNewFrontendPluginCommand extends Command
{
    const SNIPPET_NAME = 'frontend-plugin-new';

    /**
     * @var string
     */
    protected static $defaultName = 'frontend:plugin:new';

    /**
     * @var VarRegistry
     */
    protected $varRegistry;

    /**
     * @var GenerateTemplateService
     */
    protected $generateTemplateService;

    /**
     * @param GenerateTemplateService $generateTemplateService
     * @param VarRegistry $varRegistry
     * @param null|string $name
     */
    public function __construct(
        GenerateTemplateService $generateTemplateService,
        VarRegistry $varRegistry,
        ?string $name = null
    ) {
        parent::__construct($name);

        $this->varRegistry = $varRegistry;
        $this->generateTemplateService = $generateTemplateService;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName(static::$defaultName);
        $this->setDescription('Create a new Magento 2 module');

        $this->addArgument(
            'module-name',
            InputArgument::REQUIRED,
            'Module Name <info>(format: Vendor_Module)</info>'
        );
        $this->addArgument(
            'type-class',
            InputArgument::REQUIRED,
            'Type Class that should be plugged in (e.g. Magento\Catalog\Api\ProductRepositoryInterface)'
        );
        $this->addArgument(
            'domain',
            InputArgument::REQUIRED,
            'Domain that will be plugged in (e.g. Customer, Category, Product)'
        );
        $this->addArgument(
            'plugin-class',
            InputArgument::REQUIRED,
            'Plugin Classname (e.g. LoadWebsiteToCustomEntityPlugin)'
        );
        $this->addArgument(
            'module-root-dir',
            InputArgument::OPTIONAL,
            'Path to module directory',
            'app/code/'
        );

        $this->addUsage(
            'frontend:plugin:new Atwix_OrderSender Magento\Sales\Api\OrderRepositoryInterface Order SaveIsSentFlagPlugin'
        );
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pluginClassName = $input->getArgument('plugin-class');

        $this->varRegistry->set('module-full-name', $input->getArgument('module-name'));
        $this->varRegistry->set('module-root-dir', $input->getArgument('module-root-dir'));
        $this->varRegistry->set('type-class', $input->getArgument('type-class'));
        $this->varRegistry->set('domain', $input->getArgument('domain'));
        $this->varRegistry->set('plugin-class', $pluginClassName);

        $this->generateTemplateService->execute(static::SNIPPET_NAME, $this->varRegistry);

        $output->writeln(sprintf('✅ <info>%s</info> plugin has been created', $pluginClassName));
    }
}
