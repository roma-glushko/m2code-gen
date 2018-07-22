<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\Service\Module;

use Atwix\Service\Magento\GetMagentoPathService;

/**
 * Class ResolveModulePathService
 */
class ResolveModulePathService
{
    /**
     * @var GetMagentoPathService
     */
    protected $getMagentoPathService;

    /**
     * @param GetMagentoPathService $getMagentoPathService
     */
    public function __construct(GetMagentoPathService $getMagentoPathService)
    {
        $this->getMagentoPathService = $getMagentoPathService;
    }

    /**
     * @return string
     */
    public function execute(string $moduleName, string $codePath = 'app/code/'): string
    {
        $modulePath = str_replace('_', DIRECTORY_SEPARATOR, $moduleName);

        return rtrim($this->getMagentoPathService->execute($codePath) . DIRECTORY_SEPARATOR . $modulePath);
    }
}