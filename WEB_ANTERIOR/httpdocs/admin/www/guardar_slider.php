<?
include "../funciones/conexion.php";
include "../funciones/funciones_generales.php";
header("Content-Type: text/plain; charset=ISO-8859-1");

if (comprobar_sesson()==false){
  logout();
  header('Location: signin.php?error=2');
  exit();
}

$orden=$_POST['orden'];
$link=$_POST['link'];
  
$sql="eco_sliders_consul 'S'";
$result = sqlsrv_query($conn,$sql);
$row = sqlsrv_fetch_array($result);



$partes_ruta=pathinfo($_SERVER['PHP_SELF']);
$capeta_sistema = explode("/", $partes_ruta['dirname']); /* Ej --> /tanyx/admin/www --> $capeta_sistema[1]=tanyx*/

//Si esta en nuestros server, [1] es la carpeta, pero si es server de ellos poner [0]
if ($capeta_sistema[1]=='admin')
  $ruta = $_SERVER['DOCUMENT_ROOT'].'/'.$capeta_sistema[0].'/img/'; //server ellos
else
  $ruta = $_SERVER['DOCUMENT_ROOT'].'/'.$capeta_sistema[1].'/img/'; // server nuestro

$extencion=substr($_FILES['archivo']['name'], strrpos($_FILES['archivo']['name'],'.'));


if(!file_exists($ruta)){
    mkdir ($ruta);
}


$extencion=strtolower($extencion);

$nombre_archivo='slider_'.$row['proximo'].$extencion;
$url='img/'.$nombre_archivo;

$mje="ok";

// Hacemos una condicion en la que solo permitiremos que se suban imagenes y que sean menores a 20 KB
if ((
     ($extencion == ".png") ||
     ($extencion == ".jpg") ||
     ($extencion == ".jpeg") 
     ) && ($_FILES["archivo"]["size"] <= 0.8*1024*1024)) {
        //Si es que hubo un error en la subida, mostrarlo, de la variable $_FILES podemos extraer el valor de [error], que almacena un valor booleano (1 o 0).
        if ($_FILES["archivo"]["error"] > 0) {
            $mje=$_FILES["archivo"]["error"] . "";
        } else {
            // Si no hubo ningun error, hacemos otra condicion para asegurarnos que el archivo no sea repetido
            if (file_exists($ruta. $nombre_archivo)) {
                 unlink($ruta. $nombre_archivo);
                } 
            // Si no es un archivo repetido y no hubo ningun error, procedemos a subir a la carpeta /archivos, seguido de eso mostramos la imagen subida
            move_uploaded_file($_FILES["archivo"]["tmp_name"],
            $ruta . $nombre_archivo);
            
            }
} else {
    // Si el usuario intenta subir algo que no es una imagen o una imagen que pesa mas de 20 KB mostramos este mensaje
    $mje="Tipo de archivo no permitido.<br>Solo se permiten .png,.jpg,.jpeg y menores a 500KB.";
}


if($mje=="ok"){
    $sql="eco_sliders_actua ";
    $sql.=($orden == '' ? "null" : $orden).",";
    $sql.=($url == '' ? "null" : "'".$url."'").",";
    $sql.=($link == '' ? "null" : "'".$link."'");

    $result =  sqlsrv_query( $conn, $sql );

    if(!$result){
        if( ($errors = sqlsrv_errors() ) != null) {
            mostrar_error_sql($errors);
            }
        exit();
    }

    $mje="ok^";

}

echo $mje;
?>
