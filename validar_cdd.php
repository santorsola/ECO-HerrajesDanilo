<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
header("Content-Type: text/plain; charset=ISO-8859-1");

$cdd=$_GET['cdd'];

$sql="eco_validar_cdd_consul ";
$sql.="'".$cdd."',";
$sql.=$_SESSION['codigo'];

$result=sqlsrv_query($conn,$sql);

if(!$result){
    if( ($errors = sqlsrv_errors() ) != null) {
        sqlsrv_rollback( $conn );
        mostrar_error_sql($errors);
        }
    exit();
}

$row = sqlsrv_fetch_array($result);
$porcen =$row['porcen_descuen'];
$marcas =$row['marcas'];

echo "OK^".$porcen."^".$marcas;
?>