<?php

class Portmanager {
    
    public static $inst = null;
    
    private $type;
    
    private $post;
    
    private $db;

    private $idStock;
    
    private $params;
    
    private $method;
    
    private function __construct($type, $post, $idStock, $db) 
    {
        $this->type = ucfirst(strtolower($type));
        $this->post = $post;
        $this->method = 'get' . $this->type . 'Params';
        $this->db = $db;
        $this->idStock = $idStock;
        $this->params = $this->{$this->method}();
    }
    
    public static function getInstance($type, $post, $idStock, $db)
    {
        if($inst === null) {
            $inst = new Portmanager($type,$post,$idStock,$db);
        }
        return $inst;
    }
    
    public static function retryWsdl($params,$idWsdl,$idStock,$db)
    {
        if($inst === null) {
            $inst = new Portmanager($params['method'],array(),$idStock,$db);
        }
        
        $inst->params = $params;
        $response = PortSoap::getResponse($inst->params);
        return $inst->updateResponse($response,$idWsdl);
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

    private function updateResponse($response,$idWsdl)
    {
        $jsonResponse = json_encode($response);
        $jsonParams = json_encode($this->params);
        if($response['status'==='ok']) {
            $date = date('Y-m-d H:i:s');
            $query = "UPDATE `pqwsdl` SET `status`='{$response['status']}', `response`='{$jsonResponse}',`ts`='{$date}' WHERE `id_wsdl`={$idWsdl};";
            $this->db->query($query);
        }
        return array(
            'id_wsdl' => $idWsdl,
            'id_stock' => $this->idStock,
            'response' => $response
            );
    }

}