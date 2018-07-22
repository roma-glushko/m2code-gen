<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\Command;

use Atwix\Service\Snippet\GenerateSnippetService;
use Atwix\System\VarRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GenerateAdminhtmlAclCommand
 */
class GenerateAdminhtmlAclCommand extends Command
{
    const SNIPPET_NAME = 'adminhtml-acl';

    /**
     * @var string
     */
    protected static $defaultName = 'adminthml:acl';

    /**
     * @var VarRegistry
     */
    protected $varRegistry;

    /**
     * @var GenerateSnippetService
     */
    protected $generateSnippetService;

    /**
     * @param GenerateSnippetService $generateSnippetService
     * @param VarRegistry $varRegistry
     * @param null|string $name
     */
    public function __construct(
        GenerateSnippetService $generateSnippetService,
        VarRegistry $varRegistry,
        ?string $name = null
    ) {
        parent::__construct($name);

        $this->varRegistry = $varRegistry;
        $this->generateSnippetService = $generateSnippetService;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('adminhtml:acl');
        $this->setDescription('Create a new ACL');

        $this->addArgument(
            'module-name',
            InputArgument::REQUIRED,
            'Module Name <info>(format: Vendor_Module)</info>'
        );
        $this->addArgument(
            'module-root-dir',
            InputArgument::OPTIONAL,
            'Path to module directory',
            'app/code/'
        );

        $this->addUsage('adminhtml:acl Atwix_GoogleAnalytics');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $moduleName = $input->getArgument('module-name');

        $this->varRegistry->set('module-full-name', $moduleName);
        $this->varRegistry->set('module-root-dir', $input->getArgument('module-root-dir'));

        $this->generateSnippetService->execute(static::SNIPPET_NAME, $this->varRegistry);

        $output->writeln(sprintf('✅ <info>ACL</info> has been created for %s module', $moduleName));
    }
}
