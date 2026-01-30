<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";

$usuario=$_GET['usuario'];
$codigo_activacion=$_GET['codigo'];
$avisar=$_GET['avisar']; //Viene en Si si el usuario es activado desde la empresa, para mandarle un mail dando aviso


$sql="eco_usuarios_validar_mail ";
$sql.=($usuario == '' ? "null" : "'".$usuario."'").",";
$sql.=($codigo_activacion == '' ? "null" : "'".$codigo_activacion."'");
//echo $sql;
$rs =  sqlsrv_query( $conn, $sql );

if(!$rs){
    if( ($errors = sqlsrv_errors() ) != null) {
        mostrar_error_sql($errors);
        }
    exit();
}

$row=sqlsrv_fetch_array($rs);

if ($avisar!='s'){
	if ($row['validado']=='S')
		header('Location: index.php?mje_tipo=1');
	else
	    header('Location: index.php?mje_tipo=2');
}
else{

    $sql="select razon_social,path_logo,mail,mail_firma,path_empresa from empresa";
    $result=sqlsrv_query($conn,$sql);
    $row=sqlsrv_fetch_array($result);

    $empresa=$row['razon_social'];
    $path_logo=$row['path_logo'];
    $path_empresa=$row['path_empresa'];
    $mail_empresa=$row['mail'];
    $mail_firma=$row['mail_firma'];

    $mail_firma=str_replace('-BR-','<br>',$mail_firma);

        
    $sql="eco_clientes_consul ";
    $sql.="@usuario_web='".$usuario."'";

    $result = sqlsrv_query($conn,$sql);
    $row_cliente=sqlsrv_fetch_array($result);
    $razon=$row_cliente['razon'];
    $mail=$row_cliente['mail'];
    $pass_web=$row_cliente['pass_web'];
    
    $asunto = "Usuario Activado";

    $cuerpo = '
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
    <font size=2 face=verdana>Estimado/a '.$razon.':</font>
    <p><font size=2 face=verdana>

    Su usuario ya se encuentra activo para poder utilizar nuestro sitio.<br><br>
    Sus datos son: <br>
	<b>Usuario</b>: '.$mail.' <br>
	<b>Contraseña:</b> '.$pass_web.' <br>
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
    //dirección CC
    // if(consultar_configuracion('MAIL_CC_EMPRESA')=='S'){
    //     $mails_cc=consultar_configuracion('MAILS_CC');
    //     $headers .= "Bcc: ".$mails_cc."\r\n";
    // }
    //Direccion de respuesta
    $headers .= "Reply-To: ".$mail_empresa."\r\n";


    $mail_destino=str_replace(";", ",", $mail);

    

    //guardo en auditoria

    if(EnviarMail($mail_destino,$asunto,$cuerpo,$error)==false){
        $sql="insert into eco_auditoria_mails(tipo,num,asunto,mail_destino,cuerpo,headers,codigo,fecha) select null,null,";
        $sql.="'".$asunto."','".$mail_destino."','".$cuerpo."','".$headers."','NO ENVIADO',getdate()";
        $rs=sqlsrv_query($conn,$sql);
    }
    else {
        $sql="insert into eco_auditoria_mails(tipo,num,asunto,mail_destino,cuerpo,headers,codigo,fecha) select null,null,";
        $sql.="'".$asunto."','".$mail_destino."','".$cuerpo."','".$headers."','OK',getdate()";
        $rs=sqlsrv_query($conn,$sql);
    }
    header('Location: mensajes.php?tipo_mje=1');
}


?>