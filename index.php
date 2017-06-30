<?php

date_default_timezone_set('America/Guatemala');
$basepath = dirname(__FILE__);

ini_set("log_errors", 1);
ini_set("error_log", $basepath . "/log/port-ws-error.log");

require_once($basepath . '/PortSoapClass.php');

const ENDPOINT = 'http://10.75.1.37:8083/';

function testTestResponseMethod()
{
    $params = array(
        'endpoint' => ENDPOINT,
        'method' => 'test'
        );
    
    $response = PortSoap::getResponse($params);
    var_dump(date('Y-m-d H:i:s'), $params, $response);
    
}

function testGetResponseMethod()
{
    $xmlData = array(
        'numero_mic' => 335,
        'numero_contenedor' => 7896,
        'tipo_transaccion' => 1,
        'empresa_transmite' => 'copa',
        'login_usuario' => 'johndoe',
        'clave_usuario' => 'ds7KJdd6',
        'nombre_usuario' => 'John Doe'
        );
    
    $params = array(
        'endpoint' => ENDPOINT,
        'login' => 'johndoe',
        'password' => 'ds7KJdd6',
        'company' => 'PUERTO QUETZAL',
        'xml' => PortSoap::getXml('get', $xmlData),
        'method' => 'get'
        );
    
    $response = PortSoap::getResponse($params);
    var_dump(date('Y-m-d H:i:s'), $params, $response);
}

function testCheckResponseMethod()
{
    $xmlData = array(
        'numero_mic' => 335,
        'numero_contenedor' => 7896,
        'tipo_transaccion' => 1,
        'ubicacion_predio' => '42-65-3',
        'marchamo_aduana' => 7745,
        'marchamo_1' => 2346,
        'marchamo_2' => null,
        'marchamo_3' => null,
        'fecha_ciclo' => '05/04/2017 12:15:00',
        'num_ciclo' => 678,
        'vacio_lleno' => 4,
        'obse_activ2' => null,
        'peso_bruto_bascula' => 540,
        'danos' => 'rspado',
        'empresa_transmite' => 'copa',
        'login_usuario' => 'johndoe',
        'clave_usuario' => 'ds7KJdd6',
        'nombre_usuario' => 'John Doe'
        );
    
    $params = array(
        'endpoint' => ENDPOINT,
        'login' => 'johndoe',
        'password' => 'ds7KJdd6',
        'company' => 'PUERTO QUETZAL',
        'xml' => PortSoap::getXml('check', $xmlData),
        'method' => 'check'
        );
    
    $response = PortSoap::getResponse($params);
    var_dump(date('Y-m-d H:i:s'), $params, $response);
}

function testChangeResponseMethod()
{
    $xmlData = array(
        'numero_contenedor' => 7896,
        'ubicacion_predio' => '42-65-3',
        'empresa_transmite' => 'copa',
        'login_usuario' => 'johndoe',
        'clave_usuario' => 'ds7KJdd6',
        'nombre_usuario' => 'John Doe'
        );
    
    $params = array(
        'endpoint' => ENDPOINT,
        'login' => 'johndoe',
        'password' => 'ds7KJdd6',
        'company' => 'PUERTO QUETZAL',
        'xml' => PortSoap::getXml('change', $xmlData),
        'method' => 'change'
        );
    
    $response = PortSoap::getResponse($params);
    var_dump(date('Y-m-d H:i:s'), $params, $response);
}

// ProbarServicioWeb - PruebaSistema
// testTestResponseMethod();

// ConsultaInformacion - GetContieneEnPredio
// testGetResponseMethod();

// ProcesaInformacion - Verifica_Datos
// testCheckResponseMethod();

// CambioUbicacion - CambioUbicacion
// testChangeResponseMethod();
