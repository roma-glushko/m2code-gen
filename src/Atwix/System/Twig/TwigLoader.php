<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\System\Twig;

use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Class TwigLoader
 */
class TwigLoader
{
    /**
     * @param string $templateDirPath
     *
     * @return Twig_Environment
     */
    public function load(string $templateDirPath): Twig_Environment
    {
        $twigLoader = new Twig_Loader_Filesystem($templateDirPath);
        $twigEnvironment = new Twig_Environment($twigLoader);

        return $twigEnvironment;
    }
}