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
     * @param string $path
     *
     * @return string
     */
    public function getRootPath(string $path = ''): string
    {
        return $this->rootPath . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function getConfigPath(string $path = ''): string
    {
        return $this->getRootPath('config') . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function getSnippetConfigPath(string $path = ''): string
    {
        return $this->getConfigPath('snippet') . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function getTemplatePath(string $path = ''): string
    {
        return $this->getRootPath('template') . DIRECTORY_SEPARATOR . $path;
    }
}