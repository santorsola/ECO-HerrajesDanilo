<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
header("Content-Type: text/plain; charset=ISO-8859-1");

$mail=trim($_POST['mail']);
$nombre=trim($_POST['razon']);
$asunto_mje=trim($_POST['asunto']);
$cuerpo_mje=trim($_POST['cuerpo']);


$telefono=trim($_POST['telefono']);
$empresa=trim($_POST['empresa']);
$formulario=trim($_POST['formulario']);


if($nombre==''){
    echo "Debe completar su Nombre y Apellido.";
    exit();
}

if($mail==''){
    echo "Debe completar su mail.";
    exit();
}

if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
    echo "Dirección de correo con formato inválido.";
    exit();
}

if($asunto_mje=='' && $formulario!='home'){
    echo "Debe completar el asunto.";
    exit();
}

if($cuerpo_mje==''){
    echo "El mensaje esta vacio.";
    exit();
}

if($formulario!='home'){
    $cuerpo='<b>Asunto:</b> '.$asunto_mje.'<br>';
    $cuerpo.='<b>Teléfono:</b> '.$telefono.'<br>';
}else{
    $cuerpo='<b>Empresa:</b> '.$empresa.'<br>';
    $cuerpo.='<b>Teléfono:</b> '.$telefono.'<br>';
}

$cuerpo_mje=str_replace("\n", "<br>", $cuerpo_mje);

$sql="select razon_social,path_logo,mail,mail_firma,path_empresa from empresa";
$result=sqlsrv_query($conn,$sql);
$row=sqlsrv_fetch_array($result);

$empresa=$row['razon_social'];
$path_logo=$row['path_logo'];
$path_empresa=$row['path_empresa'];
$mail_empresa=$row['mail'];



$asunto='Nueva consulta recibida';
$cuerpo = '
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<font size=2 face=verdana>Se ha recibido una nueva consulta.</font>
<p><font size=2 face=verdana>

<b>Nombre y apellido:</b>  '.$nombre.' <br>
<b>E-Mail:</b> '.$mail.'<br>
'.$cuerpo.'
<b>Mensaje:</b><br>'.$cuerpo_mje.'
</p>

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


$mail_destino=str_replace(";", ",", $mail_empresa);

if(EnviarMail($mail_destino,$asunto,$cuerpo,$error)==false){
	$sql="insert into eco_auditoria_mails(asunto,mail_destino,cuerpo,headers,codigo,fecha) select ";
	$sql.="'".$asunto."','".$mail_destino."','".$cuerpo."','".$headers."','NO ENVIADO',getdate()";
	$rs=sqlsrv_query($conn,$sql);
	echo "Ocurrió un error y no se pudo enviar su consulta.";
}
else {
	$sql="insert into eco_auditoria_mails(asunto,mail_destino,cuerpo,headers,codigo,fecha) select ";
	$sql.="'".$asunto."','".$mail_destino."','".$cuerpo."','".$headers."','OK',getdate()";
	$rs=sqlsrv_query($conn,$sql);
	echo "OK";
}

?>
