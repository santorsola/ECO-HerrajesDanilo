<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
include "funciones/funciones_carrito.php";
// header("Content-Type: text/plain; charset=ISO-8859-1");

$sql="eco_carrito_cabe_guardar_proce ";
$sql.="'".session_id()."','".$_SESSION['usuario']."'";

$result=sqlsrv_query($conn,$sql);

//consultar_cant_carrito();
?>
