<?php

declare(strict_types = 1);

namespace Core\Html;

use Core\Interfaces\Renderable;

class View implements Renderable
{
    protected mixed $templatePath;

    protected mixed $viewPath;

    public function __construct(
        public string $template = 'default'
    ) {
        $config = require base_path('config/views.php');

        $this->templatePath = $config['template_path'];
        $this->viewPath     = $config['view_path'];
    }

    public function withTemplate(string $template): static
    {
        $this->template = $template;

        return $this;
    }

    public function render(string $view, array $data = []): string
    {
        $data = array_merge([
            'view' => $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php',
        ], $data);

        ob_start();
        extract($data);
        include $this->templatePath . DIRECTORY_SEPARATOR . $this->template . '.php';

        return ob_get_clean();
    }
}