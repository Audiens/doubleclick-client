<?php

namespace Test\functional;

use Audiens\DoubleclickClient\service\TwigCompiler;
use Prophecy\Argument;
use Test\FunctionalTestCase;

/**
 * Class TwigCompilerTest
 */
class TwigCompilerTest extends FunctionalTestCase
{

    /**
     * @test
     */
    public function compile_will_return_a_compiled_string()
    {

        $twig = new TwigCompiler();

        $string = $twig->getTwig()->render(
            'revenue.xml.twig',
            [
                'clientCustomerId' => '457-396-0769',
                'developerToken' => 'Audiens',
                'userAgent' => 'Audiens',
                'dateMin' => '20160401',
                'dateMax' => '20160410',
            ]
        );

       // assertions ?
    }

}
