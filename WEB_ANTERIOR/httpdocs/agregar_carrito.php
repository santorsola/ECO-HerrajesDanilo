<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
include "funciones/funciones_carrito.php";
// header("Content-Type: text/plain; charset=ISO-8859-1");

$articulo=$_GET['articulo'];
$cantidad=$_GET['cantidad'];
 
if (!isset($_GET['cantidad']))
	$cantidad=1;

if ($_GET['cantidad']=="")
	$cantidad=1;

$sql="eco_carrito_cabe_alta ";
$sql.="'".session_id()."',";
$sql.="'".$_SESSION['usuario']."'";

$result=sqlsrv_query($conn,$sql);

$sql="eco_carrito_items_actua ";
$sql.="'".session_id()."',";
$sql.="'".$articulo."',";
$sql.=$cantidad.",";//canti
$sql.="@sumar_uno='S'";
$sql.=",@usuario='".$_SESSION['usuario']."'";

$result=sqlsrv_query($conn,$sql);


consultar_cant_carrito();
?>
