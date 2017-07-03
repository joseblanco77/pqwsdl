<?php
const ENDPOINT = 'http://10.75.1.37:8083/';

date_default_timezone_set('America/Guatemala');

ini_set("log_errors", 1);
ini_set("error_log", getcwd() . "/log/port-ws-error.log");

require_once(getcwd() . '/PortSoapClass.php');
require_once(getcwd() . '/PortManagerClass.php');
