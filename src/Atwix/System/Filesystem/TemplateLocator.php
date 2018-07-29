<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\System\Filesystem;

use Symfony\Component\Finder\Finder;

/**
 * Class TemplateLocator
 */
class TemplateLocator
{
    /**
     * @var DirectoryLocator
     */
    protected $directoryLocator;

    /**
     * @param DirectoryLocator $directoryLocator
     */
    public function __construct(DirectoryLocator $directoryLocator)
    {
        $this->directoryLocator = $directoryLocator;
    }

    /**
     * @return string[]
     */
    public function getTemplateDirectoryList()
    {
        $directoryList = [];
        $templateFinder = new Finder();
        $templateDirectory = $this->directoryLocator->getTemplatePath();

        $templateFinder->directories()->in($templateDirectory);

        foreach ($templateFinder as $directory) {
            $directoryList[] = $directory->getRealPath();
        }

        return $directoryList;
    }
}