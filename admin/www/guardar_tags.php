<?
include "../funciones/conexion.php";
include "../funciones/funciones_generales.php";
header("Content-Type: text/plain; charset=ISO-8859-1");

if (comprobar_sesson()==false){
  logout();
  header('Location: signin.php?error=2');
  exit();
}

$id=($_POST['id']==""?0:$_POST['id']);
$seccion=$_POST['seccion'];
$tipo=$_POST['tipo'];
$nombre=$_POST['nombre'];
$content=$_POST['content'];

sqlsrv_begin_transaction( $conn );


$sql="eco_metatags_actua ".$id.",";
$sql.=($seccion=="" ? "null" : "'".$seccion."'").",";
$sql.=($tipo=="" ? "null" : "'".$tipo."'").",";
$sql.=($nombre=="" ? "null" : "'".$nombre."'").",";
$sql.=($content=="" ? "null" : "'".$content."'");


$result=sqlsrv_query($conn,$sql);

if(!$result){
    if( ($errors = sqlsrv_errors() ) != null) {
    	sqlsrv_rollback( $conn );
        mostrar_error_sql($errors);
        }
    exit();
}


$row=sqlsrv_fetch_array($result);
$id=$row['id'];

sqlsrv_commit( $conn );

echo "ok^".$id;
?>