<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\Service\Magento;

/**
 * Class MagentoDirectoryLocator
 *
 * Assuming that application is running from the Magento 2 root
 */
class GetMagentoPathService
{
    /**
     * @param string $path
     *
     * @return string
     */
    public function execute(string $path = ''): string
    {
        return getcwd() . DIRECTORY_SEPARATOR . $path;
    }
}