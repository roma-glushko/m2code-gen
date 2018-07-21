<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\System\Filesystem;

/**
 * Class DirectoryLocator
 */
class DirectoryLocator
{
    /**
     * @var string
     */
    protected $rootPath;

    /**
     * @param string $rootPath
     */
    public function __construct(string $rootPath)
    {
        $this->rootPath = $rootPath;
    }

    /**
     * @return string
     */
    public function getRootPath(): string
    {
        return $this->rootPath;
    }

    /**
     * @return string
     */
    public function getConfigPath(): string
    {
        return $this->rootPath . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;
    }

    /**
     * @return string
     */
    public function getTemplatePath(): string
    {
        return $this->rootPath . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR;
    }
}