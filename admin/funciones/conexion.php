<?

header("Content-Type: text/html; charset=ISO-8859-1");
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
?>
