<?
include "../funciones/conexion.php";
include "../funciones/funciones_generales.php";

if (comprobar_sesson()==false){ 
  logout();
  header('Location: signin.php?error=2');
  exit();
}

$id=($_POST['id']==""?0:$_POST['id']);

$sql="delete eco_metatags where id=".$id."";


$result=sqlsrv_query($conn,$sql);

if(!$result){
    if( ($errors = sqlsrv_errors() ) != null) {
    	sqlsrv_rollback( $conn );
        mostrar_error_sql($errors);
        }
    exit();
}


echo 'ok';
?>