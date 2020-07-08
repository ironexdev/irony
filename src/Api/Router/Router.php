<?php

namespace App\Api\Router;

use App\Api\Request\Request;

class Router
{
    /**
     * @param Request $request
     * @param array $routes
     * @return array
     */
    public function match(Request $request, array $routes): array
    {
        $dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $routeCollector) use ($routes) {
            foreach($routes as $route => $routeDefinition)
            {
                foreach($routeDefinition as $method => $methodDefinition)
                {
                    $routeCollector->addRoute($method, $route, $methodDefinition);
                }
            }
        });

        return $dispatcher->dispatch($request->getMethod(), $request->getPath());
    }
}