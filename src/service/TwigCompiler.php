<?php

namespace Audiens\DoubleclickClient\service;

/**
 * Class TwigCompiler
 */
class TwigCompiler
{

    /**
 * @var  \Twig_Environment 
*/
    protected $twig;


    /**
     * TwigCompiler constructor.
     *
     * @param string $templatePath
     */
    public function __construct($templatePath = 'src/reports')
    {

        $loader = new \Twig_Loader_Filesystem($templatePath);
        $this->twig = new \Twig_Environment($loader);
    }

    /**
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }
}
