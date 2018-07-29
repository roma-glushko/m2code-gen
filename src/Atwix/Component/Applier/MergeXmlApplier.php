<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\Component\Applier;

use Atwix\Component\Magento\Config\XmlConfigMerger;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class MergeXmlApplier
 */
class MergeXmlApplier implements ApplierInterface
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var XmlConfigMerger
     */
    protected $xmlConfigMerger;

    /**
     * @param Filesystem $filesystem
     * @param XmlConfigMerger $xmlConfigMerger
     */
    public function __construct(
        Filesystem $filesystem,
        XmlConfigMerger $xmlConfigMerger
    ) {
        $this->filesystem = $filesystem;
        $this->xmlConfigMerger = $xmlConfigMerger;
    }

    /**
     * @param string $modulePath
     * @param string $filePath
     * @param string $renderedSnippetFileContent
     *
     * @return void
     */
    public function apply(
        string $modulePath,
        string $filePath,
        string $renderedSnippetFileContent
    ) {
        $moduleFilePath = $modulePath . DIRECTORY_SEPARATOR . $filePath;

        if (!$this->filesystem->exists($moduleFilePath)) {
            // if there is nothing to merge

            $this->filesystem->dumpFile($moduleFilePath, $renderedSnippetFileContent);

            return;
        }

        $originalXml = file_get_contents($moduleFilePath);

        $mergedConfigXml = $this->xmlConfigMerger->merge($originalXml, $renderedSnippetFileContent);

        $this->filesystem->dumpFile($moduleFilePath, $mergedConfigXml);
    }

}