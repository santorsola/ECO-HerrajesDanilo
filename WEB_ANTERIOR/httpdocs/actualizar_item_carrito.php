<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
include "funciones/funciones_carrito.php";
// header("Content-Type: text/plain; charset=ISO-8859-1");

$articulo=$_GET['articulo'];
$canti=$_GET['canti']==''?0:$_GET['canti'];

$sql="eco_carrito_items_actua ";
$sql.="'".session_id()."',";
$sql.="'".$articulo."',";
$sql.=$canti.",";
$sql.="@sumar_uno='N'";
$sql.=",@usuario='".$_SESSION['usuario']."'";

$result=sqlsrv_query($conn,$sql);

consultar_cant_carrito();
?>
