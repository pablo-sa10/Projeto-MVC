<?php

namespace App\Http;

use \Closure;
use \Exception;

class Router{

    private $url = '';
    private $prefix = '';
    private $routes = [];
    private $request;
    
    public function __construct($url)
    {
        $this->request = new Request();
        $this->url = $url;
        $this->setPrefix();
    }

    private function setPrefix(){
        $parseUrl = parse_url($this->url);
        $this->prefix = $parseUrl['path'] ?? '';
    }

    private function addRoute($method, $route, $params = []){
        //validações dos parametros
        foreach($params as $key=>$value){
            if($value instanceof Closure){
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        $params['variables'] = [];

        $patternVariable = '/{{.*?}}/';
        if(preg_match($patternVariable, $route, $matches)){
            echo "<pre>";
            print_r($matches);
            echo "</pre>"; exit;
        }

        $patternRoute = '/^'.str_replace('/','\/', $route). '$/';
        $this->routes[$patternRoute][$method] = $params;
    }

    public function get($route, $params = []){
        return $this->addRoute('GET', $route, $params);
    }

    public function post($route, $params = []){
        return $this->addRoute('POST', $route, $params);
    }

    public function put($route, $params = []){
        return $this->addRoute('PUT', $route, $params);
    }

    public function delete($route, $params = []){
        return $this->addRoute('DELETE', $route, $params);
    }

    //metodo responsavel por retornar a uri desconsiderando o prefixo
    private function getUri(){
        $uri = $this->request->getUri();
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
        
        return end($xUri);
    }

    //reaponsável por retornar os dados da rota atual
    private function getRoute(){
        //URI
        $uri = $this->getUri();
        $httpMethod = $this->request->getHttpMethod();
        foreach($this->routes as $patternRoute=>$methods){
            //verifica se a uri bate com o padrão
            if(preg_match($patternRoute, $uri)){
                //verifica o metodo
                if($methods[$httpMethod]){
                    return $methods[$httpMethod];
                }
                //metodo não permitido
                throw new Exception("Método não permitido", 405);
            }
        }
         //Url naõ encontrada
         throw new Exception("Url não encontrada", 404);
    }

    public function run(){
        try{
            //Obtém a rota atual
            $route = $this->getRoute();
            //verifica o controlador
            if(!isset($route['controller'])){
                throw new Exception("A URL não pde ser processada", 500);
            }

            //argumentos da função
            $args = [];

            return call_user_func_array($route['controller'],$args);
           

        }catch(Exception $e){
            return new Response($e->getCode(), $e->getMessage());
        }
    }

}