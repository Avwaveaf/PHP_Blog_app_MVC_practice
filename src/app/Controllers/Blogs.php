<?php
declare(strict_types=1);

namespace App\Controllers;

use App\View;

class Blogs
{
    public function index():string
    {
        return View::make('blogs/index')->render(true);
        
    }

    public function compose():string
    {

       return View::make('blogs/compose')->render(true);
    }

    public function store(): void
    {
        $title = $_POST["title"];
        var_dump($title);
    }
}