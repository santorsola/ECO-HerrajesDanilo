<?
include "../funciones/conexion.php";
include "../funciones/funciones_generales.php";

if (comprobar_sesson()==false){
  logout();
  header('Location: signin.php?error=2');
  exit();
}

$id_zona=$_POST['id_zona'];
$nombre=$_POST['nombre'];
$cod_articulo_envio=$_POST['cod_articulo_envio'];
$precio_envio=$_POST['precio_envio'];
$bonificado_desde=$_POST['bonificado_desde'];
$orden=$_POST['orden'];
$tiempo=$_POST['tiempo'];
$obser2=$_POST['obser2'];

$sql="eco_zonas_abm_actua ";
$sql.=($id_zona == '' ? "null" : $id_zona).",";
$sql.=($nombre == '' ? "null" : "'".$nombre."'").",";
$sql.=($cod_articulo_envio == '' ? "null" : "'".$cod_articulo_envio."'").",";
$sql.=($precio_envio == '' ? "null" : $precio_envio).",";
$sql.=($bonificado_desde == '' ? "null" : $bonificado_desde).",";
$sql.=($orden == '' ? "null" : $orden).",";
$sql.=($tiempo == '' ? "null" : "'".$tiempo."'").",";
$sql.=($obser2 == '' ? "null" : "'".$obser2."'")."";

$result =  sqlsrv_query( $conn, $sql );

if(!$result){
    if( ($errors = sqlsrv_errors() ) != null) {
        mostrar_error_sql($errors);
        }
    exit();
}

echo '1';
?>
    