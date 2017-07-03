<?php

class Portmanager {
    
    public static $inst = null;
    
    private $type;
    
    private $post;
    
    private function __construct($type, $post) 
    {
        $this->type = ucfirst(strtolower($type));
        $this->post = $post;
        $this->method = 'get' . $this->type . 'Params';
        $this->params = $this->{$this->method}();
    }
    
    public function getInstance($type, $post = array())
    {
        if($inst === null) {
            $inst = new Portmanager($type,$post);
        }
        return $inst;
    }
    
    public function getResponse()
    {
        return PortSoap::getResponse($this->params);
    }
    
    public function getParams()
    {
        return $this->params;
    }

    private function getTestParams()
    {
        $params = array(
            'endpoint' => ENDPOINT,
            'method' => 'test'
            );
            
        return $params;
    }
    
    private function getGetParams()
    {
        $params = array(
            'endpoint' => ENDPOINT,
            'login' => $this->post['login_usuario'],
            'password' => $this->post['clave_usuario'],
            'company' => $this->post['empresa_transmite'],
            'xml' => PortSoap::getXml('get', $this->post),
            'method' => 'get'
            );
        
        return $params;
    }
    
    private function getCheckParams()
    {
        $params = array(
            'endpoint' => ENDPOINT,
            'login' => $this->post['login_usuario'],
            'password' => $this->post['clave_usuario'],
            'company' => $this->post['empresa_transmite'],
            'xml' => PortSoap::getXml('check', $this->post),
            'method' => 'check'
            );
        
        return $params;
    }
    
    private function getChangeParams()
    {
        $params = array(
            'endpoint' => ENDPOINT,
            'login' => $this->post['login_usuario'],
            'password' => $this->post['clave_usuario'],
            'company' => $this->post['empresa_transmite'],
            'xml' => PortSoap::getXml('change', $this->post),
            'method' => 'change'
            );
        
        return $params;
    }

}