<?php

namespace App\Http;

class Request{

    private $httpMethod;
    private $uri;
    private $querryParams = [];
    private $postVars = [];
    private $headers = [];
    

    public function __construct()
    {
        $this->querryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getAllheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    }

    public function getHttpMethod(){
        return $this->httpMethod;
    }

    public function getUri(){
        return $this->uri;
    }

    public function getHeaders(){
        return $this->headers;
    }

    public function getQuerryParams(){
        return $this->querryParams;
    }

    public function getPostVars(){
        return $this->postVars;
    }
}