<?php


namespace MapUx\tests\Services;


use MapUx\Services\ColorConverterTrait;
use PHPUnit\Framework\TestCase;

class ColorConversionTest extends TestCase
{

    use ColorConverterTrait;

    public function testColorConversion()
    {
        $this->assertEquals('rgb(0,0,0)', $this->hex2rgba('#000000'));
        $this->assertEquals('rgb(0,0,0)', $this->hex2rgba('#000'));
        $this->assertEquals('rgb(255,255,255)', $this->hex2rgba('#FFF'));
        $this->assertEquals('rgb(255,255,255)', $this->hex2rgba('#fff'));
        $this->assertEquals('rgba(0,0,0,0.3)', $this->hex2rgba('#000', 0.3));
    }

}
