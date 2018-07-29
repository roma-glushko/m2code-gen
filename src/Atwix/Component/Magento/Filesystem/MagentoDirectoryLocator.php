<?php
/**
 * Created by PhpStorm.
 * User: glushko
 * Date: 7/29/18
 * Time: 3:32 PM
 */

namespace Atwix\Component\Magento\Filesystem;

class MagentoDirectoryLocator
{
    /**
     * @param string $path
     *
     * @return string
     */
    public function getRootDirectory(string $path = ''): string
    {
        return getcwd() . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * @return string
     */
    public function getModuleDirectory(string $moduleName, string $codePath = 'app/code/'): string
    {
        $modulePath = str_replace('_', DIRECTORY_SEPARATOR, $moduleName);

        return rtrim($this->getRootDirectory($codePath) . DIRECTORY_SEPARATOR . $modulePath);
    }
}