<?
include "../funciones/conexion.php";
include "../funciones/funciones_generales.php";

if (comprobar_sesson()==false){
  logout();
  header('Location: signin.php?error=2');
  exit();
}

  
$secuen=$_POST['secuen'];



$sql="eco_sliders_consul null, ";
$sql.=($secuen == '' ? "null" : $secuen);

$result =  sqlsrv_query( $conn, $sql );

if(!$result){
    if( ($errors = sqlsrv_errors() ) != null) {
        mostrar_error_sql($errors);
        }
    exit();
}

$row=sqlsrv_fetch_array($result);
$archivo=$row['archivo'];



$partes_ruta=pathinfo($_SERVER['PHP_SELF']);
$capeta_sistema = explode("/", $partes_ruta['dirname']); /* Ej --> /tanyx/admin/www --> $capeta_sistema[1]=tanyx*/
$ruta = $_SERVER['DOCUMENT_ROOT'].'/'.$capeta_sistema[1].'/'.$archivo;;

if (file_exists($ruta)) {
    if (!unlink($ruta)){
        $mje="Error al eliminar el archivo.";
        echo $mje;
        exit();
    }
}


$sql="eco_sliders_baja ";
$sql.=($secuen == '' ? "null" : $secuen);

$result =  sqlsrv_query( $conn, $sql );

if(!$result){
    if( ($errors = sqlsrv_errors() ) != null) {
        mostrar_error_sql($errors);
        }
    exit();
}

echo 'ok';

?>
