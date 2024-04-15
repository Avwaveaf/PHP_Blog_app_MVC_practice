<?php
declare(strict_types=1);

namespace App\Controllers;

use App\View;

class Blogs
{
    public function index():string
    {
        return (string) View::make('blogs/index');
        
    }

    public function compose():string
    {

       return (string) View::make('blogs/compose');
    }

    public function store(): void
    {
        $title = $_POST["title"];
        var_dump($title);
    }
}