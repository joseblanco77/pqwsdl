<?php

class PortSoap
{
    private $portWsEndpoint;

    private $portWsLogin;

    private $portWsPassword;

    private $portWsCompany;

    private $portWsXml;
    
    private $url;
    
    private $methods = array(
        'test'   => 'testPortWs',
        'get'    => 'inContainerYard',
        'check'  => 'checkData',
        'change' => 'changeLocation'
        );

    public static $client = null;

    private function __construct($params)
    {
        $this->portWsEndpoint = trim(ENDPOINT, '/') . '/';
        $this->portWsLogin    = $params['login'];
        $this->portWsPassword = $params['password'];
        $this->portWsCompany  = $params['company'];
        $this->portWsXml      = $params['xml'];
        $this->portWsMethod   = $params['method'];
    }
    
    private function getOptions()
    {
        return array(
            'Login_Usuario' => $this->portWsLogin,
            'Clave_Usuario' => $this->portWsPassword,
            'Empresa_Transmite' => $this->portWsCompany,
            'XML' => $this->portWsXml,
        );
    }

    /**
     * Call this method to get a proccessed data
     * @param $params Array of parameters
     * @return $response String or XML response
     */
    public static function getResponse($params)
    {
        if ($client === null) {
            $client = new PortSoap($params);
        }
        $response = $client->proccessRequest();
        
        return $response;
    }

    private function proccessRequest()
    {
        $errorMessage = 'Bad method';
        $method = $this->methods[$this->portWsMethod];
        
        if ($method === null) {
            error_log($errorMessage);
            return array(
                'status' => 'error',
                'message' => $errorMessage
                );
        }
        $portWsResponse = $this->{$method}();
        $response = $this->proccessResponse($portWsResponse);
        
        return $response;
    }
    
    private function proccessResponse($response)
    {
        if (!$response) {
            return array(
                'status' => 'error',
                'message' => 'Failed to call ' . $this->url
                );
        }
        
        if (is_string($response)) {
            return array(
                'status' => 'ok',
                'message' => $response
                );
        }
        
        try {
            if ($response->MSG_RESPUESTA->MENSAJE->RESULTADO === '01') {
                return array(
                    'status' => 'ok',
                    'message' => $response->MSG_RESPUESTA->MENSAJE->RESULTADO . ' - ' . $response->MSG_RESPUESTA->MENSAJE->DESCRIPCION
                    );
            }
            return array(
                'status' => 'error',
                'message' => $response->MSG_RESPUESTA->MENSAJE->RESULTADO . ' - ' . $response->MSG_RESPUESTA->MENSAJE->DESCRIPCION
                );
        } catch (Exception $e) {
            return array(
                'status' => 'error',
                'message' => $e->getMessage()
                );
        }
        
        return array(
            'status' => 'error',
            'message' => 'Invalid response'
            );
        ;
    }

    private function testPortWs()
    {
        $this->url = $this->portWsEndpoint . 'ProbarServicioWeb.asmx?WSDL';
        try {
            $portWsClient = new SoapClient($this->url);
            return $portWsClient->PruebaSistema();
        } catch (Exception $e) {
            error_log($e->getTraceAsString());
            return false;
        }
    }

    private function inContainerYard()
    {
        $this->url = $this->portWsEndpoint . 'ConsultaInformacion.asmx?WSDL';
        $options = $this->getOptions();
        try {
            $portWsClient = new SoapClient($this->url, $options);
            return $portWsClient->GetContieneEnPredio();
        } catch (Exception $e) {
            error_log($e->getTraceAsString());
            return false;
        }
    }

    private function checkData()
    {
        $this->url = $this->portWsEndpoint . 'ProcesaInformacion.asmx?WSDL';
        $options = $this->getOptions();
        try {
            $portWsClient = new SoapClient($this->url, $options);
            return $portWsClient->Verifica_Datos();
        } catch (Exception $e) {
            error_log($e->getTraceAsString());
            return false;
        }
    }

    private function changeLocation()
    {
        $this->url = $this->portWsEndpoint . 'CambioUbicacion.asmx?WSDL';
        $options = $this->getOptions();
        try {
            $portWsClient = new SoapClient($this->url, $options);
            return $portWsClient->CambioUbicacion();
        } catch (Exception $e) {
            error_log($e->getTraceAsString());
            return false;
        }
    }
    
    
    
    /**
     * Facade for XML generator
     * @param string  $type Method to call
     * @param array   $data Data to parse in XML
     * @return string       Generated XML
     */
    public static function getXml($type, $data)
    {
        $method = 'getXmlFor' . ucfirst(strtolower($type)) . 'method';
        try {
            return call_user_func('self::' . $method, $data);
        } catch (Exception $e) {
            error_log($e->getTraceAsString());
            return 'Invalid method for XML generator.';
        }
    }
    
    private static function getXmlForGetMethod($data)
    {
        $xml = <<<PORT
<MSG_EPQ_DEPO>
    <DOC_CONT>
        <NUMERO_MIC>{$data['numero_mic']}</NUMERO_MIC>
        <NUMERO_CONTENEDOR>{$data['numero_contenedor']}</NUMERO_CONTENEDOR>
        <TIPO_TRANSACCION>{$data['tipo_transaccion']}</TIPO_TRANSACCION>
    </DOC_CONT>
    <INFO_USUARIO>
        <EMPRESA_TRANSMITE>{$data['empresa_transmite']}</EMPRESA_TRANSMITE>
        <LOGIN_USUARIO>{$data['login_usuario']}</LOGIN_USUARIO>
        <CLAVE_USUARIO>{$data['clave_usuario']}</CLAVE_USUARIO>
        <NOMBRE_USUARIO>{$data['nombre_usuario']}</NOMBRE_USUARIO>
    </INFO_USUARIO>
</MSG_EPQ_DEPO>
PORT;
        
        return $xml;
    }

    private static function getXmlForCheckMethod($data)
    {
        $xml = <<<PORT
<MSG_EPQ_DEPO>
    <DOC_CONT>
        <NUMERO_MIC>{$data['numero_mic']}</NUMERO_MIC>
        <NUMERO_CONTENEDOR>{$data['numero_contenedor']}</NUMERO_CONTENEDOR>
        <TIPO_TRANSACCION>{$data['tipo_transaccion']}</TIPO_TRANSACCION>
        <UBICACION_PREDIO>{$data['ubicacion_predio']}</UBICACION_PREDIO>
        <MARCHAMO_ADUANA>{$data['marchamo_aduana']}</MARCHAMO_ADUANA>
        <MARCHAMO_1>{$data['marchamo_1']}</MARCHAMO_1>
        <MARCHAMO_2>{$data['marchamo_2']}</MARCHAMO_2>
        <MARCHAMO_3>{$data['marchamo_3']}</MARCHAMO_3>
        <FECHA_CICLO>{$data['fecha_ciclo']}</FECHA_CICLO>
        <NUM_CICLO>{$data['num_ciclo']}</NUM_CICLO>
        <VACIO_LLENO>{$data['vacio_lleno']}</VACIO_LLENO>
        <OBSE_ACTIV2>{$data['obse_activ2']}</OBSE_ACTIV2>
        <PESO_BRUTO_BASCULA>{$data['peso_bruto_bascula']}</PESO_BRUTO_BASCULA>
        <DANOS>{$data['danos']}</DANOS>
    </DOC_CONT>
    <INFO_USUARIO>
        <EMPRESA_TRANSMITE>{$data['empresa_transmite']}</EMPRESA_TRANSMITE>
        <LOGIN_USUARIO>{$data['login_usuario']}</LOGIN_USUARIO>
        <CLAVE_USUARIO>{$data['clave_usuario']}</CLAVE_USUARIO>
        <NOMBRE_USUARIO>{$data['nombre_usuario']}</NOMBRE_USUARIO>
    </INFO_USUARIO>
</MSG_EPQ_DEPO>
PORT;
        
        return $xml;
    }

    private static function getXmlForChangeMethod($data)
    {
        $xml = <<<PORT
<MSG_EPQ_DEPO>
    <DOC_CONT>
        <NUMERO_CONTENEDOR>{$data['numero_contenedor']}</NUMERO_CONTENEDOR>
        <UBICACION_PREDIO>{$data['ubicacion_predio']}</UBICACION_PREDIO>
    </DOC_CONT>
    <INFO_USUARIO>
        <EMPRESA_TRANSMITE>{$data['empresa_transmite']}</EMPRESA_TRANSMITE>
        <LOGIN_USUARIO>{$data['login_usuario']}</LOGIN_USUARIO>
        <CLAVE_USUARIO>{$data['clave_usuario']}</CLAVE_USUARIO>
        <NOMBRE_USUARIO>{$data['nombre_usuario']}</NOMBRE_USUARIO>
    </INFO_USUARIO>
</MSG_EPQ_DEPO>
PORT;
        
        return $xml;
    }
}