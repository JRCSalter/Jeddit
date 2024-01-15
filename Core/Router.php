<?php

declare(strict_types=1);

namespace Core;

use Core\Middleware\Middleware;
use Core\Response;

/**
 * Builds the router.
 */
class Router {
    /** @var array Holds all the specified routes. */
    private array $routes = [];

    /**
     * Adds a route to the router.
     * 
     * @param string $uri        The URI to add.
     * @param string $controller The controller to use.
     * @param string $method     The method by which to access the route.
     *     GET, POST, PUT, DELETE, etc.
     * 
     * @return static
     */
    private function add(string $uri, string $controller, string $method): static
    {
        $this->routes[] = [
            'uri'        => $uri,
            'controller' => $controller,
            'method'     => $method,
            'middleware' => NULL,
        ];

        return $this;
    }

    /**
     * Make a GET request to the router.
     * 
     * @param string $uri        The URI to get.
     * @param string $controller The controller to use.
     * 
     * @return static
     */
    public function get(string $uri, string $controller): static
    {
        return $this->add($uri, $controller, 'GET');
    }

    /**
     * Make a POST request to the router.
     * 
     * @param string $uri        The URI to get.
     * @param string $controller The controller to use.
     * 
     * @return static
     */
    public function post(string $uri, string $controller): static
    {
        return $this->add($uri, $controller, 'POST');
    }

    /**
     * Make a PATCH request to the router.
     * 
     * @param string $uri        The URI to get.
     * @param string $controller The controller to use.
     * 
     * @return static
     */
    public function patch(string $uri, string $controller): static
    {
        return $this->add($uri, $controller, 'PATCH');
    }

    /**
     * Make a DELETE request to the router.
     * 
     * @param string $uri        The URI to get.
     * @param string $controller The controller to use.
     * 
     * @return static
     */
    public function delete(string $uri, string $controller): static
    {
        return $this->add($uri, $controller, 'DELETE');
    }

    /**
     * Returns the relevant controller.
     * 
     * Aborts the script if it cannot find a route.
     * 
     * @param string $uri The URI to get.
     * @param string $method The method to use.
     * 
     * @return int
     */
    public function route(string $uri, string $method): int
    {
        // Trim the final '/', but we need to check the URI isn't pointing to HOME,
        // or it will remove the entire URI.
        if ($uri != getenv('HOME')) $uri = rtrim( $uri, " /");

        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                try {
                    Middleware::resolve($route['middleware']);
                } catch (\Exception $e) {
                    Log::insertAndAbort(
                        ['message' => $e->getMessage()],
                        Response::NOT_IMPLEMENTED
                    );
                }
                return require basePath($route['controller']);
            }
        }

        $this->abort(Response::NOT_FOUND);
    }

    /**
     * Adds middleware to the route.
     * 
     * @param string $key The key to use.
     * 
     * @return void
     */
    public function only(string $key): void
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;
    }

    /**
     * A helper function that simply passes 'auth' to $this->only().
     * 
     * @return void
     */
    public function auth(): void
    {
        $this->only('auth');
    }

    /**
     * A helper function that simply passes 'guest' to $this->only().
     * 
     * @return void
     */
    public function guest(): void
    {
        $this->only('guest');
    }

    /**
     * Abort the script and return an error page.
     * 
     * @param Response $code The HTTP status code to use.
     * 
     * @return void
     */
    private function abort(int $code = Response::NOT_FOUND): void
    {
        http_response_code($code);

        require basePath("views/errors/{$code}.php");

        die();
    }
}