<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
header("Content-Type: text/plain; charset=ISO-8859-1");

if (comprobar_sesson()==false){
	logout();
	header('Location: index.php?mje_tipo=3');
	exit();
}

  
$usuario_web=$_SESSION['usuario'];
$nueva=$_POST['nueva'];
$actual=$_POST['actual'];
$repetida=$_POST['repetida'];



$sql="eco_usuarios_cambiar_pass ";
$sql.="'".$usuario_web."',";
$sql.="'".$actual."',";
$sql.="'".$nueva."',";
$sql.="'".$repetida."'";

$rs =  sqlsrv_query( $conn, $sql );

if(!$rs){
    if( ($errors = sqlsrv_errors() ) != null) {
        mostrar_error_sql($errors);
        }
    exit();
}

echo "OK"; 
?>
