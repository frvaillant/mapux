<?php


namespace MapUx\tests\Services;


use PHPUnit\Framework\TestCase;
use MapUx\Services\HtmlBuilder\HtmlBuilder;

class HtmlBuilderTest extends TestCase
{

    public function testDiv()
    {
        $htmlBuilder = new HtmlBuilder();
        $htmlBuilder
            ->div([
                'attributes' => [
                    'class' => 'className',
                    'id'    => 'divId'
                ]
            ]);
        $this->assertEquals('div', $htmlBuilder->getOpenedElements()[0]);
        $htmlBuilder->close();
        $this->assertEquals('<div class="className" id="divId"></div>', $htmlBuilder);
    }

    public function testSpanWithContent()
    {
        $htmlBuilder = new HtmlBuilder();
        $htmlBuilder
            ->span([
                'attributes' => [
                    'class' => 'className',
                    'id'    => 'divId'
                ],
                'content' => 'I don\'t know what means "what you said"'
            ]);
        $this->assertEquals('span', $htmlBuilder->getOpenedElements()[0]);
        $htmlBuilder->close();
        $this->assertEquals('<span class="className" id="divId">I don\'t know what means "what you said"</span>', $htmlBuilder);
    }

    public function testSingleElement()
    {
        $htmlBuilder = new HtmlBuilder();
        $htmlBuilder
            ->img([
                'isSingle'   => true,
                'attributes' => [
                    'src' => 'my-url-to-picture',
                    'id'    => 'mypic-id'
                ]
            ]);
        $this->assertEquals([], $htmlBuilder->getOpenedElements());
        $this->assertEquals('<img src="my-url-to-picture" id="mypic-id" />', $htmlBuilder);

    }

    public function testIsSingleClosedException()
    {
        $htmlBuilder = new HtmlBuilder();
        try {
            $htmlBuilder
                ->img([
                    'isSingle' => true,
                    'attributes' => [
                        'src' => 'my-url-to-picture',
                        'id' => 'mypic-id'
                    ]
                ])
                ->close();
        } catch (\Exception $e) {
            $this->assertEquals('No element is opened. Can\'t use close() function', $e->getMessage());
        }

    }

    public function testSetContentException()
    {
        $htmlBuilder = new HtmlBuilder();
        try {
            $htmlBuilder
                ->img([
                    'isSingle' => true,
                    'attributes' => [
                        'src' => 'my-url-to-picture',
                        'id' => 'mypic-id'
                    ],
                    'content' => 'my beautiful poem'
                ]);
        } catch (\Exception $e) {
            $this->assertEquals('You can not set content in single element', $e->getMessage());
        }
    }
}
