<?
include "../funciones/conexion.php";
include "../funciones/funciones_generales.php";
header("Content-Type: text/plain; charset=ISO-8859-1");

if (comprobar_sesson()==false){
  logout();
  header('Location: signin.php?error=2');
  exit();
}

$secuen=$_GET['secuen'];
$accion=$_GET['accion'];


$sql="eco_sliders_cambiar_orden ";
$sql.=($secuen == '' ? "null" : $secuen).",";
$sql.=($accion=="" ? "null" : "'".$accion."'");

$result=sqlsrv_query($conn,$sql);

if(!$result){
    if( ($errors = sqlsrv_errors() ) != null) {
    	sqlsrv_rollback( $conn );
        mostrar_error_sql($errors);
        }
    exit();
}

header('Location: sliders.php');
?>