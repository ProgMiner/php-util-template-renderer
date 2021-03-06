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

namespace ProgMinerUtils\TemplateRenderer;

/**
 * Template renderer for Twig templates
 *
 * @author Eridan Domoratskiy
 */
class TwigTemplateRenderer implements ITemplateRenderer {

    /**
     * @var \Twig_Environment Twig
     */
    protected $twig;

    /**
     * @param \Twig_Environment $twig Twig
     */
    public function __construct(\Twig_Environment $twig) {
        $this->twig = $twig;
    }

    /**
     * {@inheritdoc}
     */
    public function render(string $template, array $variables = []): string {
        if (!$this->supports($template)) {
            throw new \UnexpectedValueException("Template \"$template\" is not supported");
        }

        return $this->twig->render($template, $variables);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(string $template): bool {
        $ext = pathinfo($template, PATHINFO_EXTENSION);

        if ('twig' !== $ext) {
            return false;
        }

        try {
            $this->twig->loadTemplate($template);
        } catch (\Twig_Error $e) {
            return false;
        }

        return true;
    }
}
