<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\Component\Applier;

/**
 * Interface ApplierInterface
 */
interface ApplierInterface
{
    /**
     * @param string $modulePath
     * @param string $filePath
     * @param string $renderedSnippetFileContent
     * @return
     */
    public function apply(
        string $modulePath,
        string $filePath,
        string $renderedSnippetFileContent
    );
}