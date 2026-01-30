<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
header("Content-Type: text/plain; charset=ISO-8859-1");

$sql="eco_validar_stock_proce ";
$sql.="'".session_id()."'";

$result=sqlsrv_query($conn,$sql);
if(!$result){
    if( ($errors = sqlsrv_errors() ) != null) {
        sqlsrv_rollback( $conn );
        mostrar_error_sql($errors);
        }
    exit();
}

echo "OK";
?>
