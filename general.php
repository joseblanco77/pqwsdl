<?php
const ENDPOINT = 'http://10.75.1.37:8083/';

date_default_timezone_set('America/Guatemala');

ini_set("log_errors", 1);
ini_set("error_log", getcwd() . "/log/port-ws-error.log");

$dbConfFile = (getenv("IP") === '0.0.0.0' ) ? '/db.dev.php' : '/db.php';
include_once(getcwd() . $dbConfFile);

require_once(getcwd() . '/db.class.php');
require_once(getcwd() . '/PortSoapClass.php');
require_once(getcwd() . '/PortManagerClass.php');

$db = DB::DB($pq_db_database,$pq_db_servername,$pq_db_username,$pq_db_password);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
} 
