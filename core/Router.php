<?php

namespace Core;
/**
 * Router
 *
 */

class Router
{

    protected $routes = [
        'GET' => [],
        'POST' => []
    ];

     /**
     * get - adds routes of type get to $this->routes GET array
     *
     * @param   string  $uri         url path 
     * @param   string  $controller  the correspondent controller and method
     *
     * @return  void               
     */

    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    /**
     * post - adds routes of type get to $this->routes POST array
     *
     * @param   string  $uri         url path 
     * @param   string  $controller  the correspondent controller and method
     *
     * @return  void               
     */

    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

     /**
     * Dispatch the route, creating the controller object and running the
     * method
     *
     * @return void
     */
    public function dispatch() 
    {
        $uri = $_SERVER['REQUEST_URI'];
        $url = '';

       

        if ($uri != '' && strpos($uri, '?')) {
            $url = explode('?', $uri)[0];
        } else {
            $url = $uri;
        }

        $requestType = $_SERVER['REQUEST_METHOD'];
       
        if (array_key_exists($url, $this->routes[$requestType])) {
            $controller = explode('@', $this->routes[$requestType][$url])[0];
            $method = explode('@', $this->routes[$requestType][$url])[1];

            $controller = 'App\Controllers\\' .  $controller;
           
            if (class_exists($controller)) {
                $controller_object = new $controller;
                $controller_object->$method();
            } else {
                throw new \Exception('No controller matched.', 404);
            }
            

        } else {
            throw new \Exception('No route matched.', 404);
        }
    }
}
