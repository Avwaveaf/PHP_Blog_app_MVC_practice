<?php
declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;

class Router
{
    /**
     * Array of routes containning all registered routes
     * @var array
     */
    private array $routes;

    /**
     * registering the routes and stored it in routes array
     * with given key from route and actionable
     * @param string $route
     * @param callable $action
     * @return \App\Router -- return self class for chaining. 
     */
    public function register(string $method, string $route, callable|array $action):self
    {
        // setting the each route the $route as a key and callable as value
        $this ->routes[$method][$route] = $action;
        return $this;
    }
    public function get(string $route, callable|array $action): self
    {
        return $this->register('get', $route, $action);
    }
       public function post(string $route, callable|array $action): self
    {
        return $this->register('post', $route, $action);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function resolve(string $requestUri, string $method)
    {
        $route = parse_url($requestUri)['path'];

        // setting action based on routes
        $action = $this->routes[$method][$route] ?? null;

        if (!$action) {
            throw new RouteNotFoundException();
        }


        if (is_callable($action)) {
            return call_user_func($action);
        }

        if (is_array($action)) {
            [$qualifiedClass, $method] = $action;

            if (class_exists($qualifiedClass)) {
                // create a new instance
                $class = new $qualifiedClass();

                // check the method exists within the class
                if (method_exists($class, $method)) {
                    return call_user_func_array([$class, $method], []);
                }
            }
        }
        //if not an array nor callable
        throw new RouteNotFoundException();
    }
}