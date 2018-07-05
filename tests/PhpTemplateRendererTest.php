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

use ProgMinerUtils\TemplateRenderer\PhpTemplateRenderer;

use Symfony\Component\Config\FileLocator;

class PhpTemplateRendererTest extends TestCase {

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testSupportsOnlyExistingTemplates() {
        $renderer = new PhpTemplateRenderer(
            new FileLocator(__DIR__.'/Resources/PhpTemplateRenderer')
        );

        $this->assertTrue($renderer->supports('template.php'));
        $this->assertFalse($renderer->supports('foobar.php'));

        $this->assertEquals($renderer->render('template.php', ['str' => 'php']), 'php');
        $renderer->render('foobar.php');
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testSupportsOnlyPhpTemplates() {
        $renderer = new PhpTemplateRenderer(
            new FileLocator(__DIR__.'/Resources/PhpTemplateRenderer')
        );

        $this->assertTrue($renderer->supports('template.php'));
        $this->assertFalse($renderer->supports('template.txt'));

        $this->assertEquals($renderer->render('template.php', ['str' => 'php']), 'php');
        $renderer->render('template.txt', ['str' => 'txt']);
    }

    public function testSupportsPhtmlTemplates() {
        $renderer = new PhpTemplateRenderer(
            new FileLocator(__DIR__.'/Resources/PhpTemplateRenderer')
        );

        $this->assertTrue($renderer->supports('template.phtml'));
        $this->assertEquals($renderer->render('template.phtml', ['str' => 'phtml']), 'phtml');
    }

    public function testNotBreaksIfTemplateHaveNotExtension() {
        $renderer = new PhpTemplateRenderer(
            new FileLocator(__DIR__.'/Resources/PhpTemplateRenderer')
        );

        $this->assertFalse($renderer->supports('template'));
    }
}
