<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
header("Content-Type: text/plain; charset=ISO-8859-1");


$num=$_GET['num'];




$sql="eco_copiar_carrito_proce ";
$sql.=(session_id() == '' ? "null" : "'".session_id()."'").",";
$sql.=("'".$_SESSION['usuario']."'").",";;
$sql.=($num == '' ? "null" : $num).",";
$sql.=("'".$_SESSION['codigo']."'");


//echo $sql."---------";
$result=sqlsrv_query($conn,$sql);

if(!$result){
    if( ($errors = sqlsrv_errors() ) != null) {
        mostrar_error_sql($errors);
        }
    exit();
}


header('Location: micarrito.php');

?>