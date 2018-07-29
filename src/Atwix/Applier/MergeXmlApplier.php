<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\Applier;

use Atwix\System\Magento\Config\XmlConfigMerger;
use DOMDocument;
use SimpleXMLElement;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class MergeXmlApplier
 */
class MergeXmlApplier implements ApplierInterface
{
    /**
     * Prefix which will be used for root namespace
     */
    const ROOT_NAMESPACE_PREFIX = 'x';

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