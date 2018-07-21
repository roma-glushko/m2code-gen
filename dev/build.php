<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

/**
 * Class BuildPhar
 */
class BuildPhar
{
    /**
     * @var int
     */
    protected $signatureAlgorithmType = Phar::SHA1;

    /**
     * @var int
     */
    protected $compressionType = Phar::GZ;

    /**
     * @var string
     */
    protected $rootDirPath;

    /**
     * @var string
     */
    protected $srcDirPath;

    /**
     * @var string
     */
    protected $buildDirPath;

    /**
     * @var string
     */
    protected $pharFilePath;

    /**
     * @var string
     */
    protected $gzPharFilePath;

    /**
     * @var string
     */
    protected $stubFilePath;

    /**
     * @param string $currentDirectory
     */
    public function __construct(string $currentDirectory)
    {
        $this->rootDirPath = realpath($currentDirectory . DIRECTORY_SEPARATOR . '..') . DIRECTORY_SEPARATOR;

        $this->srcDirPath = $this->rootDirPath . 'src' . DIRECTORY_SEPARATOR;
        $this->buildDirPath = $this->rootDirPath . 'build' . DIRECTORY_SEPARATOR;

        $this->pharFilePath = $this->buildDirPath . 'm2code-gen.phar';
        $this->gzPharFilePath = $this->buildDirPath . 'm2code-gen.phar.gz';

        $this->stubFilePath = $this->rootDirPath . 'dev' . DIRECTORY_SEPARATOR . 'stub.php';
    }

    /**
     *
     */
    public function build()
    {
        $this->cleanPrevBuilds();

        $this->getPharBuilder();
    }

    /**
     * @return void
     */
    protected function cleanPrevBuilds()
    {
        if (file_exists($this->pharFilePath)) {
            unlink($this->pharFilePath);
        }
    }

    /**
     * @return Phar
     */
    protected function getPharBuilder()
    {
        $pharBuilder = new Phar($this->pharFilePath);

        $pharBuilder->setSignatureAlgorithm($this->signatureAlgorithmType);

        $pharBuilder->setStub(file_get_contents($this->stubFilePath));
        $pharBuilder->buildFromDirectory($this->srcDirPath);

        $pharBuilder->compressFiles($this->compressionType);

        return $pharBuilder;
    }
}

$buildPharTask = new BuildPhar(__DIR__);
$buildPharTask->build();