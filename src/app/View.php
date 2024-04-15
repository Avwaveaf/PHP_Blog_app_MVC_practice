<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\ViewNotFoundException;

class View
{
    public function __construct(protected string $view, protected array $params = [])
    {
    }

    public static function make(string $view, array $params=[])
    {
        return new static($view, $params);
    }

    public function render()
    {
        $viewPath = VIEWS_PATH . $this->view . '.php';

        if (!is_file($viewPath)) {
            throw new ViewNotFoundException();
        }

        foreach ($this->params as $key => $value) {
            $$key = $value;
        }
        
        ob_start();
        include $viewPath;
        return (string)ob_get_clean();
    }

    public function __toString()
    {
        return $this->render();
    }

    public function __get(string $key)
    {
        return $this->params[$key] ?? null;   
    }
}