<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
include "funciones/funciones_carrito.php";
// header("Content-Type: text/plain; charset=ISO-8859-1");

$articulo=$_GET['articulo'];

$sql="eco_carrito_items_baja ";
$sql.="'".session_id()."',";
$sql.="'".$articulo."'";

$result=sqlsrv_query($conn,$sql);


consultar_cant_carrito();
?>
