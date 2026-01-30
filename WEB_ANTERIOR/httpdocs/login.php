<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
header("Content-Type: text/plain; charset=ISO-8859-1");

$usuario_web=$_POST['usuario'];
$pass=$_POST['pass'];



$sql="eco_clientes_consul ";
$sql.="@usuario_web='".$usuario_web."',";
$sql.="@pass_web='".$pass."',";
$sql.="@estado='A'";

$result=sqlsrv_query($conn,$sql);
if(!$result){
    if( ($errors = sqlsrv_errors() ) != null) {
        mostrar_error_sql($errors);
        }
    exit();
}

$row=sqlsrv_fetch_array($result);

if (strtolower($row['usuario_web'])==strtolower($usuario_web) && $usuario_web<>''){
    secure_session_start();

    $_SESSION['usuario'] = $row['usuario_web'];
    $_SESSION['nombre_usuario'] = $row['razon'];
    $_SESSION['codigo'] = $row['num_cliente'];

    $sql="eco_carrito_cabe_alta ";
    $sql.="'".session_id()."',";
    $sql.="'".$_SESSION['usuario']."'";
    $result=sqlsrv_query($conn,$sql);

    // $sql="insert into log_ingresos (usuario,fecha)
    //     values ('".$usuario_web."',getdate())";
    // $result2=sqlsrv_query($conn,$sql);

    // $sql="update usuarios set ultimo_ingreso=getdate() where usuario='".$usuario_web."'";
    // $result2=sqlsrv_query($conn,$sql);
//    header('Location: index.php');
    echo "OK";
}
else{
    echo "Error al iniciar sesión.<br>Verifique su usuario y contraseña.";
}

?>
