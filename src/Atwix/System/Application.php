<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\System;

use Atwix\Command\GenerateNewModuleCommand;
use Atwix\System\Filesystem\DirectoryLocator;
use Atwix\System\Twig\TwigLoader;
use Exception;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\CommandLoader\ContainerCommandLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class Application
 */
class Application
{
    const APP_NAME = 'm2code-gen';

    const APP_VERSION = '0.1.0';

    /**
     * @var string
     */
    protected $rootDir;

    /**
     * @var DirectoryLocator
     */
    protected $directoryLocator;

    /**
     * @var ContainerBuilder
     */
    protected $containerBuilder;

    /**
     * @var ConsoleApplication
     */
    protected $consoleApplication;

    /**
     * @param string $rootDir
     */
    public function __construct($rootDir) {
        $this->rootDir = $rootDir;

        $this->directoryLocator = new DirectoryLocator($this->rootDir);
    }

    /**
     * @todo decouple
     * @return void
     * @throws Exception
     */
    public function lunch()
    {
        $this->containerBuilder = $this->getDiContainer();
        $this->containerBuilder->setParameter('env.rootPath', $this->rootDir);

        $this->containerBuilder->compile();

        $this->consoleApplication = $this->getConsoleApplication();
        $this->consoleApplication->run();
    }

    /**
     * @return ContainerBuilder
     */
    protected function getDiContainer()
    {
        $diLoader = new DiLoader($this->directoryLocator);

        $containerBuilder = $diLoader->load('services.yaml');

        return $containerBuilder;
    }

    /**
     * @return ConsoleApplication
     */
    protected function getConsoleApplication()
    {
        $consoleApplication = new ConsoleApplication(static::APP_NAME, static::APP_VERSION);

        $commandLoader = new ContainerCommandLoader($this->containerBuilder, [
            'module:new' => GenerateNewModuleCommand::class,
        ]);

        $consoleApplication->setCommandLoader($commandLoader);

        return $consoleApplication;
    }
}