<?php

class Portmanager {
    
    public static $inst = null;
    
    private $type;
    
    private $post;
    
    private $db;

    private $idStock;
    
    private function __construct($type, $post, $idStock, $db) 
    {
        $this->type = ucfirst(strtolower($type));
        $this->post = $post;
        $this->method = 'get' . $this->type . 'Params';
        $this->db = $db;
        $this->idStock = $idStock;
        $this->params = $this->{$this->method}();
    }
    
    public function getInstance($type, $post = array(), $idStock, $db)
    {
        if($inst === null) {
            $inst = new Portmanager($type,$post,$idStock,$db);
        }
        return $inst;
    }
    
    public function getResponse()
    {
        $response = PortSoap::getResponse($this->params);
        $this->saveResponse($response);
        return $response;
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
    
    private function saveResponse($response)
    {
        $jsonResponse = json_encode($response);
        $jsonParams = json_encode($this->params);
        $query = "INSERT INTO `pqwsdl` (`id_stock`,`response`,`status`,`params`) VALUES ({$this->idStock}, '{$jsonResponse}', '{$response['status']}', '{$jsonParams}');";
        $this->db->query($query);
    }

}