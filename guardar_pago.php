<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
header("Content-Type: text/plain; charset=ISO-8859-1");


$pago=$_POST['pago'];
$num=(!is_numeric($_POST['num'])) ? 0 : $_POST['num'];

sqlsrv_begin_transaction( $conn );

$sql="eco_pedi_cabe_pago_actua ";
$sql.="'".$_SESSION['codigo']."',";
$sql.=$num.",";
$sql.=($pago == '' ? "null" : "'".$pago."'");


//echo $sql."---------";
$result=sqlsrv_query($conn,$sql);

if(!$result){
    if( ($errors = sqlsrv_errors() ) != null) {
        sqlsrv_rollback( $conn );
        mostrar_error_sql($errors);
        }
    exit();
}

$row = sqlsrv_fetch_array($result);
$importe =$row['total'];
$nombre_cliente=$row['razon'];
$mail=$row['mail'];
/*
if($mail==''){
    sqlsrv_rollback( $conn );
    echo 'Se produjo un error y su forma de pago no pudo ser grabada.<br>Igualmente el pedido esta registrado.';
    exit();
}*/

sqlsrv_commit( $conn );


if($pago=='depo'){
    $sql="select razon_social,path_logo,mail,mail_firma,path_empresa from empresa";
    $result=sqlsrv_query($conn,$sql);
    $row=sqlsrv_fetch_array($result);
    $empresa=$row['razon_social'];
    $path_logo=$row['path_logo'];
    $path_empresa=$row['path_empresa'];
    $mail_empresa=$row['mail'];
    $mail_firma=$row['mail_firma'];


    $sql="eco_bancos_cuentas_consul ";
    $result=sqlsrv_query($conn,$sql);

    $mail_firma=str_replace('-BR-','<br>',$mail_firma);

    $asunto = "Información para realizar depósito";

    $cuerpo = '
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
    <font size=2 face=verdana>Estimado/a '.$nombre_cliente.':</font>
    <p><font size=2 face=verdana>

    Le hacemos llegar los datos de nuestras cuentas bancarias para que pueda realizar el pago de su Pedido Nº '.$num.' por un total '.$importe.'
    <br>

    Banco Francés<br>
    CBU: 01700145 20000001649129<br>
    Cta Cte $ Nro:  014/0016491/2<br>
    Titular: Pugliese Gustavo Hernán<br>
    CUIT: 20-23939582-2<br>
     <br><br>
     

    <b>Los pedidos que nos son abonados dentro de las 24hs de realizados se dan de baja automáticamente.</b>
    <br><br>
    <b>Por favor de aviso del pago a '.MAIL_RTA.' para gestionar el pedido.</b>

 

    </p>';



     
    $cuerpo.='<br><br>'.$mail_firma.'
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


    $mail_destino=str_replace(";", ",", $mail);




    if(EnviarMail($mail_destino,$asunto,$cuerpo,$error)==false){
        $sql="insert into eco_auditoria_mails(tipo,num,secuen,asunto,mail_destino,cuerpo,headers,codigo,fecha) select '".$tipo."',";
        $sql.=$num.",NULL,'".$asunto."','".$mail_destino."','".$cuerpo."','".$headers."','NO ENVIADO',getdate()";
        $rs=sqlsrv_query($conn,$sql);
    }
    else {
        $sql="insert into auditoria_mails(tipo,num,secuen,asunto,mail_destino,cuerpo,headers,codigo,fecha) select '".$tipo."',";
        $sql.=$num.",NULL,'".$asunto."','".$mail_destino."','".$cuerpo."','".$headers."','OK',getdate()";
        $rs=sqlsrv_query($conn,$sql);
    }
}



echo "OK";

?>
