<?
include "../funciones/conexion.php";
include "../funciones/funciones_generales.php";

$usuario=$_POST['usuario'];
$pass=$_POST['pass'];


$sql="eco_admin_usuarios_consul @usuario='".$usuario."',@pass='".$pass."'";

$result=sqlsrv_query($conn,$sql);
$row=sqlsrv_fetch_array($result);

if ($row['usuario_web']==$usuario){
    secure_session_start();

    $_SESSION['usuario'] = $row['usuario_web'];
    $_SESSION['nombre_usuario'] = $row['razon'];
    $_SESSION['codigo'] = $row['codigo']; //factu

	header('Location: sliders.php');
}else{
    header('Location: signin.php?error=1');
}

?>
