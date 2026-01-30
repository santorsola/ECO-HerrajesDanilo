<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";

$sql="eco_carrito_cabe_baja ";
$sql.="'".session_id()."','N'";
$result=sqlsrv_query($conn,$sql);

logout();
header('Location: index.php');
?>
