<?php

/* MIT License

Copyright (c) 2018 Eridan Domoratskiy

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE. */

use PHPUnit\Framework\TestCase;

use ProgMinerUtils\TemplateRenderer\DelegatingTemplateRenderer;
use ProgMinerUtils\TemplateRenderer\CallableTemplateRenderer;

class DelegatingTemplateRendererTest extends TestCase {

    public function testCanHaveNotTemplateRenderers() {
        $this->assertInstanceOf(
            DelegatingTemplateRenderer::class,
            new DelegatingTemplateRenderer([])
        );
    }

    public function testSupportsOnlyTemplateRenderers() {
        $this->assertInstanceOf(
            DelegatingTemplateRenderer::class,
            $renderer = new DelegatingTemplateRenderer([new CallableTemplateRenderer([
                'callable' => function() { echo 'Test'; }
            ])])
        );

        $this->assertTrue($renderer->supports('callable'));
        $this->assertEquals($renderer->render('callable'), 'Test');

        $this->expectException(\InvalidArgumentException::class);
        new DelegatingTemplateRenderer(['']);
    }

    public function testSupportsAllTemplatesOfRenderers() {
        $renderer = new DelegatingTemplateRenderer([
            new CallableTemplateRenderer([
                'callable1' => function() { echo 'Test'; }
            ]),
            new CallableTemplateRenderer([
                'callable2' => function() { echo 'Test'; }
            ])
        ]);

        $this->assertTrue($renderer->supports('callable1'));
        $this->assertEquals($renderer->render('callable1'), 'Test');

        $this->assertTrue($renderer->supports('callable2'));
        $this->assertEquals($renderer->render('callable2'), 'Test');
    }

    public function testSupportsOnlyTemplatesOfRenderers() {
        $renderer = new DelegatingTemplateRenderer([
            new CallableTemplateRenderer([
                'callable' => function() { echo 'Test'; }
            ])
        ]);

        $this->assertTrue($renderer->supports('callable'));
        $this->assertEquals($renderer->render('callable'), 'Test');

        $this->assertFalse($renderer->supports((string) rand()));

        $this->expectException(\UnexpectedValueException::class);
        $renderer->render((string) rand());
    }

    public function testSavesOrderOfTemplateRenderers() {
        $renderer = new DelegatingTemplateRenderer([
            new CallableTemplateRenderer([
                'callable' => function() { echo 'Test1'; }
            ]),
            new CallableTemplateRenderer([
                'callable' => function() { echo 'Test2'; }
            ])
        ]);

        $this->assertEquals($renderer->render('callable'), 'Test1');
    }
}
