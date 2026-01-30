<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
header("Content-Type: text/plain; charset=ISO-8859-1");

$usuario_web=$_GET['usuario'];

$sql="eco_clientes_consul ";
$sql.="@usuario_web='".$usuario_web."'";

$result=sqlsrv_query($conn,$sql);
$row=sqlsrv_fetch_array($result);


$nombre=$row['razon'];
$mail_destino=$row['mail'];
$pass=$row['pass_web'];

if ($row['usuario_web']==$usuario_web){

    $sql="select razon_social,path_logo,mail,mail_firma,path_empresa from empresa";
    $result=sqlsrv_query($conn,$sql);
    $row=sqlsrv_fetch_array($result);

    $empresa=$row['razon_social'];
    $path_logo=$row['path_logo'];
    $path_empresa=$row['path_empresa'];
    $mail_empresa=$row['mail'];
    $mail_firma=$row['mail_firma'];

	$mail_firma=str_replace('-BR-','<br>',$mail_firma);

	$asunto = "Recupero de Contraseña";

	$cuerpo = '
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>
	<body>
	<font size=2 face=verdana>Estimado/a '.$nombre.':</font>
	<p><font size=2 face=verdana>

	Los datos para ingresar al sistema de pedidos web son: <br>
	Usuario: '.$usuario_web.'<br>
	Contraseña: '.$pass.'
	</p>
	 
	'.$mail_firma.'
	<br>
	<br>
	<img src="'.$path_logo.'" />
	</body>
	</html>
	';
 

	//para el envío en formato HTML
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8\r\n";

	//dirección del remitente
	$headers .= "From: ".$mail_empresa." <".MAIL_RTA.">\r\n";
	//Direccion de respuesta
	$headers .= "Reply-To: ".$mail_empresa."\r\n";


	$mail_destino=str_replace(";", ",", $mail_destino);

	if(EnviarMail($mail_destino,$asunto,$cuerpo,$error)==false){
		$sql="insert into eco_auditoria_mails(asunto,mail_destino,cuerpo,headers,codigo,fecha) select ";
		$sql.="'".$asunto."','".$mail_destino."','".$cuerpo."','".$headers."','NO ENVIADO',getdate()";
		$rs=sqlsrv_query($conn,$sql);
	}
	else {
		$sql="insert into eco_auditoria_mails(asunto,mail_destino,cuerpo,headers,codigo,fecha) select ";
		$sql.="'".$asunto."','".$mail_destino."','".$cuerpo."','".$headers."','OK',getdate()";
		$rs=sqlsrv_query($conn,$sql);
	}


	header('Location: index.php?mje_tipo=5');
}
else{
    header('Location: index.php?mje_tipo=4');
}

?>
