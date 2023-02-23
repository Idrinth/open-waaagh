<?php

namespace De\Idrinth\WAAAGHde;

use Twig\Environment;

class Twig
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
    public function render(string $template, array $context = []): string
    {
        return $this->twig->render("$template.twig", $context);
    }
}
