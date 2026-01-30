<?
if($ws!='S'){
	session_start();
	//Esto si esta en el include del WS hace que no funciones
	header("Content-Type: text/html; charset=ISO-8859-1");
}


// Se define la cadena de conexión

if (!function_exists('sqlsrv_connect')) {
  exit( "Solo disponible para PHP 5.3 o superior" );
}


$connectionInfo = array( "Database"=>"factu_ispama", "UID"=>"eco_danilo", "PWD"=>"Danilo_2025!");
$serverName = "190.183.146.211,50128\RPSISTEMAS";



// Se realiza la conexón con los datos especificados anteriormente
$conn = sqlsrv_connect( $serverName, $connectionInfo);


if( $conn === false )
{
     echo "No se pudo realizar la conexion.\n";
     die( print_r( sqlsrv_errors(), true));
}


/*
$sql="eco_session_log_actua ";
$sql.="'".session_id()."',";
$sql.="'".$_SERVER["REMOTE_ADDR"]."',";
$sql.="'".print_r( $_SESSION, true)."'";
$result=sqlsrv_query($conn,$sql);*/

ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
//Constante para los from de los headers de los mails
define('MAIL_RTA',   "xxx@xxx.com.ar"); //--DATOS--
?>
