<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\Component\Applier;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Class CopyFileApplier
 */
class CopyFileApplier implements ApplierInterface
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(
        Filesystem $filesystem
    ) {
        $this->filesystem = $filesystem;
    }

    /**
     * @param string $modulePath
     * @param string $snippetPath
     * @param string $snippetFilePath
     * @param string $renderedSnippetFileContent
     *
     * @return void
     */
    public function apply(
        string $modulePath,
        string $snippetPath,
        string $snippetFilePath,
        string $renderedSnippetFileContent
    ) {
       $moduleFilePath = $modulePath . DIRECTORY_SEPARATOR . $snippetFilePath;

       $this->filesystem->dumpFile($moduleFilePath, $renderedSnippetFileContent);
    }
}