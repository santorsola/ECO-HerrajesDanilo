<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
header("Content-Type: text/plain; charset=ISO-8859-1");

$mail_empresa_activar_usuario=consultar_configuracion('MAIL_EMPRESA_ACTIVAR_USUARIO');


$tipo=$_GET['tipo'];

if ($tipo!='R'){
    if (comprobar_sesson()==false){
        logout();
        header('Location: index.php?mje_tipo=3');
        exit();
    }
    $usuario_web=$_SESSION['usuario'];
}else{
    $usuario_web=$_POST['mail'];
}


$razon=$_POST['razon'];
$telefono=$_POST['telefono'];
$iva=$_POST['iva'];
$agru2=$_POST['agru2'];
$agru1=$_POST['agru1'];
$cuit=$_POST['cuit'];
$domicilio=$_POST['domicilio'];
$localidad=$_POST['localidad'];
$cp=$_POST['cp'];
$provincia=$_POST['provincia'];
$pass=$_POST['pass'];
$repetida=$_POST['repetida'];
$mail=$_POST['mail'];





$sql="eco_clientes_alta ";
$sql.=($tipo == '' ? "null" : "'".$tipo."'").",";
$sql.=($usuario_web == '' ? "null" : "'".$usuario_web."'").",";
$sql.=($razon == '' ? "null" : "'".$razon."'").",";
$sql.=($telefono == '' ? "null" : "'".$telefono."'").",";
$sql.=($iva == '' ? "null" : "'".$iva."'").",";
$sql.=($agru1 == '' ? "null" : "'".$agru1."'").",";  //tipo cliente
$sql.=($agru2 == '' ? "null" : "'".$agru2."'").",";  //profesion   
$sql.=($cuit == '' ? "null" : "'".$cuit."'").",";
$sql.=($domicilio == '' ? "null" : "'".$domicilio."'").",";
$sql.=($localidad == '' ? "null" : "'".$localidad."'").",";
$sql.=($cp == '' ? "null" : "'".$cp."'").",";
$sql.=($provincia == '' ? "null" : "'".$provincia."'").",";
$sql.=($mail == '' ? "null" : "'".$mail."'").",";
$sql.=($pass == '' ? "null" : "'".$pass."'").",";
$sql.=($repetida == '' ? "null" : "'".$repetida."'");


//echo $sql."---------";
$result=sqlsrv_query($conn,$sql);

if(!$result){
    if( ($errors = sqlsrv_errors() ) != null) {
        mostrar_error_sql($errors);
        }
    exit();
}

$row=sqlsrv_fetch_array($result);
$codigo_activacion=$row['codigo_activacion'];
//$codigo_activacion='010000001EC4829D3059A9BC91618C74A3D0F6ABC49414D8427392F3D73400D6CCB82A8DA34BCFDAD84753F7';
if ($codigo_activacion!=''){

    $sql="select razon_social,path_logo,mail,mail_firma,path_empresa from empresa";
    $result=sqlsrv_query($conn,$sql);
    $row=sqlsrv_fetch_array($result);

    $empresa=$row['razon_social'];
    $path_logo=$row['path_logo'];
    $path_empresa=$row['path_empresa'];
    $mail_empresa=$row['mail'];
    $mail_firma=$row['mail_firma'];

    $mail_firma=str_replace('-BR-','<br>',$mail_firma);

    $sql="eco_provincias_consul '".$provincia."'";
    $result_prov = sqlsrv_query($conn,$sql);
    $row_prov=sqlsrv_fetch_array($result_prov);
    $provincia=$row_prov['nombre'];  

    if ($mail_empresa_activar_usuario!='' && $tipo=='R'){
        /*Como esta configurado para que la empresa active el usuario, no se manda el mail al usuario sino 
        al mail configurado con el link de activación.*/

        switch ($iva) {
            case '1':
                $iva='Responsable Inscripto';
                break;
            case '2':
                $iva='Responsable No Inscripto';
                break;
            case '3':
                $iva='Exento';
                break;
            case '4':
                $iva='Consumidor Final';
                break;
            case '5':
                $iva='Monotributo';
                break;
        }

        $asunto = "Activación de nuevo usuario";

        $cuerpo = '
        <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        </head>
        <body>
        <p><font size=2 face=verdana>
        Se ha dado de alta un nuevo usuario, pendiente de activación.<br><br>
        Sus datos son:<br>
        <b>Nombre</b>: '.$razon.' <br>
        <b>Mail:</b> '.$usuario_web.' <br>
        <b>CUIT:</b> '.$cuit.' <br>
        <b>IVA:</b> '.$iva.' <br>
        <b>Teléfono:</b> '.$telefono.' <br>
        <b>Domicilio:</b> '.$domicilio.' <br>
        <b>Localidad:</b> '.$localidad.' <br>
        <b>Provincia:</b> '.$provincia.' <br>
        <br><br>
        Para realizar la activación del usuario, haga clic en el siguiente link:<br>
        <a href="'.$path_empresa.'/activar_usuario.php?usuario='.$usuario_web.'&avisar=s&codigo='.$codigo_activacion.'">Activar usuario web</a><br>
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


        $mail_destino=str_replace(";", ",", $mail_empresa_activar_usuario);

    }
    else{

        $asunto = "Validación de Usuario";

        $cuerpo = '
        <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        </head>
        <body>
        <font size=2 face=verdana>Estimado/a '.$razon.':</font>
        <p><font size=2 face=verdana>

        Para realizar la activación de su usuario, haga clic en el siguiente link:<br>
        <a href="'.$path_empresa.'/activar_usuario.php?usuario='.$usuario_web.'&codigo='.$codigo_activacion.'">Activar usuario web</a><br>
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


        $mail_destino=str_replace(";", ",", $usuario_web);

    }

    //guardo en auditoria

    if(EnviarMail($mail_destino,$asunto,$cuerpo,$error)==false){
        $sql="insert into eco_auditoria_mails(tipo,num,asunto,mail_destino,cuerpo,headers,codigo,fecha) select null,null,";
        $sql.="'".$asunto."','".$mail_destino."','".$cuerpo."','".$error."','NO ENVIADO',getdate()";
        $rs=sqlsrv_query($conn,$sql);
    }
    else {
        $sql="insert into eco_auditoria_mails(tipo,num,asunto,mail_destino,cuerpo,headers,codigo,fecha) select null,null,";
        $sql.="'".$asunto."','".$mail_destino."','".$cuerpo."','".$error."','OK',getdate()";
        $rs=sqlsrv_query($conn,$sql);
    }
}




if ($tipo=='M')
    $_SESSION['nombre_usuario'] = $razon;

if ($tipo=='R' and $mail_empresa_activar_usuario=='')
    echo "OK^R"; //Lo activa el usuario desde su mail
if ($tipo=='R' and $mail_empresa_activar_usuario!='')
    echo "OK^E"; //esperar el mail xq lo activa la empresa
if ($tipo=='M' and $codigo_activacion!='')
    echo "OK^MM";//modificacio de mail
if ($tipo=='M' and $codigo_activacion=='')
    echo "OK^M"; //modificacion de datos pero no de mail
?>
