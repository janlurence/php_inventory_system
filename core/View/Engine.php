<?php

declare(strict_types=1);

namespace Core\View;

use RuntimeException;

final readonly class Engine
{
    public function __construct(private string $viewsPath)
    {
    }

    public function render(string $view, array $data = [], string $layout = 'layout'): string
    {
        $content = $this->evaluate($view, $data);

        return $this->evaluate($layout, [...$data, 'content' => $content]);
    }

    private function evaluate(string $view, array $data): string
    {
        $path = $this->viewsPath . '/' . str_replace('.', '/', $view) . '.php';

        if (! file_exists($path)) {
            throw new RuntimeException("View [{$view}] not found.");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $path;

        return (string) ob_get_clean();
    }
}
