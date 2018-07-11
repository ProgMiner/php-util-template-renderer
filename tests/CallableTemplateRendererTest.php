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

use ProgMinerUtils\TemplateRenderer\CallableTemplateRenderer;

class CallableTemplateRendererTest extends TestCase {

    public function testCanHaveNotTemplates() {
        $this->assertInstanceOf(CallableTemplateRenderer::class, new CallableTemplateRenderer([]));
    }

    public function testSupportsOnlyCallableTemplates() {
        $renderer = new CallableTemplateRenderer([
            'callable' => function() { echo 'Test'; }
        ]);

        $this->assertTrue($renderer->supports('callable'));
        $this->assertEquals($renderer->render('callable'), 'Test');

        $this->expectException(\InvalidArgumentException::class);
        new CallableTemplateRenderer([
            'not-callable' => 'argh'
        ]);
    }

    public function testSupportsOnlyProvidedTemplates() {
        $renderer = new CallableTemplateRenderer([
            'callable' => function() { echo 'Test'; }
        ]);

        $this->assertTrue($renderer->supports('callable'));
        $this->assertEquals($renderer->render('callable'), 'Test');

        $this->assertFalse($renderer->supports((string) rand()));

        $this->expectException(\UnexpectedValueException::class);
        $renderer->render((string) rand());
    }

    public function testSupportsAllTypesOfCallableTemplates() {
        $templates = [
            'lambda' => function($vars) { echo $vars['str']; },

            'string1' => 'functionTemplate',
            'string2' => 'ObjectTemplate::staticTemplate',

            'array1' => [ObjectTemplate::class, 'staticTemplate'],
            'array2' => [new ObjectTemplate(), 'template'],

            'object' => new ObjectTemplate()
        ];

        $renderer = new CallableTemplateRenderer($templates);

        foreach ($templates as $key => $value) {
            $this->assertTrue($renderer->supports($key));
            $this->assertEquals($renderer->render($key, ['str' => $key]), $key);
        }
    }
}

function functionTemplate() { ?>string1<?php }

class ObjectTemplate {

    public function template($vars) { echo $vars['str']; }

    public function __invoke($vars) { echo $vars['str']; }

    public static function staticTemplate($vars) { echo $vars['str']; }
}
