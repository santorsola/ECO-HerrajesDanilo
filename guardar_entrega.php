<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
header("Content-Type: text/plain; charset=ISO-8859-1");


$tipo_entrega=$_POST['tipo_entrega'];
$obser=$_POST['obser'];

$sucur=$_POST['sucur'];

$domicilio=$_POST['domicilio'];
$localidad=$_POST['localidad'];
$cp=$_POST['cp'];
$provincia=$_POST['provincia'];
$telefono=$_POST['telefono'];
$cdd=$_POST['cdd'];

if ($tipo_entrega=="sucur")
    $leyenda_horario="";
    //LOC $leyenda_horario="Horario de retiro de mercadería: lunes a viernes de 9.30 a 13 y 14 a 17.30 hs.";



sqlsrv_begin_transaction( $conn );


$sql="eco_pedido_alta ";
$sql.=(session_id() == '' ? "null" : "'".session_id()."'").",";
$sql.=($tipo_entrega == '' ? "null" : "'".$tipo_entrega."'").",";
$sql.=($sucur == '' ? "null" : "'".$sucur."'").",";
$sql.=($domicilio == '' ? "null" : "'".$domicilio."'").",";
$sql.=($localidad == '' ? "null" : "'".$localidad."'").",";
$sql.=($cp == '' ? "null" : "'".$cp."'").",";
$sql.=($provincia == '' ? "null" : "'".$provincia."'").",";
$sql.=($telefono == '' ? "null" : "'".$telefono."'").",";
$sql.=($obser == '' ? "null" : "'".$obser."'").",";
$sql.=($cdd == '' ? "null" : "'".$cdd."'")."";


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
$tipo =$row['tipo'];
$num =$row['num'];


$sql="eco_pedi_cabe_consul ";
$sql.="'".$_SESSION['codigo']."',".$num;
$result=sqlsrv_query($conn,$sql);
$row=sqlsrv_fetch_array($result);
$nombre_cliente=$row['razon'];
$total=$row['total'];
$descuen_cabe=cdouble($row['porcen_descuen']);
$subtotal_sin_dto=$row['subtotal_sin_dto'];
$impor_descuen_cabe=$row['importe_dto'];
$mail=$row['mail'];
$mone=$row['mone'];
$entrega=$row['datos_entrega'];
$obser=$row['obser_gral'];
//echo $sql."---------";
if($row['tipo']==''){
    sqlsrv_rollback( $conn );
    echo 'Se produjo un error y su pedido no pudo ser grabado.';
    exit();
}



sqlsrv_commit( $conn );
//goto Salir; //debug

//------------------------------Mail a la cliente--------------------------------------



    $sql="select razon_social,path_logo,mail,mail_firma,path_empresa from empresa";
    $result=sqlsrv_query($conn,$sql);
    $row=sqlsrv_fetch_array($result);
    $empresa=$row['razon_social'];
    $path_logo=$row['path_logo'];
    $path_empresa=$row['path_empresa'];
    $mail_empresa=$row['mail'];
    $mail_firma=$row['mail_firma'];

    $mail_firma=str_replace('-BR-','<br>',$mail_firma);

    $asunto = "Nuevo Pedido";

    $cuerpo = '
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style>
        table {
            width:auto;
        }
        table, th, td {
            border-bottom: 1px solid black;
            border-collapse: collapse;
            text-align:right;
        }
        th, td {
            padding: 10px;
        }
        </style>

    </head>
    <body>
    <font size=2 face=verdana>Estimado/a '.$nombre_cliente.':</font>
    <p><font size=2 face=verdana>

    Se ha creado el Pedido Nro. '.$num.'<br><br>
    '.$entrega.'<br><br>
    Observaciones: '.$obser.'<br><br>
    Los artículos de su pedido son:<br>
    </p>
     
    <table>';

    $sql="eco_pedi_items_consul ";
    $sql.="'".$_SESSION['codigo']."',".$num;
    $result=sqlsrv_query($conn,$sql);

    $i=0;
    while ( $row = sqlsrv_fetch_array($result)){
        $i++;

        //Solo la 1ra vez pongo los titulos con o sin dto
        if($i==1){
            if($row['hay_dto_item']=='S'){
                $hay_dto_item='S';
                $cuerpo.='
                <tr>
                    <th style="width:60%;text-align:left;">Artículo</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>% Dto.</th>
                    <th>Subtotal</th>
                </tr>';
            }else{
                $hay_dto_item='N';
                $cuerpo.='
                <tr>
                    <th style="width:60%;text-align:left;">Artículo</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>';
            }
        }

        $renglones='<tr>';
        $renglones.='<td style="text-align:left;">'.$row['descrip_arti'].'<br>'.$row['desc_adicional'].'<br>'.$row['stock'].'</td>';
        $renglones.='<td>'.$row['canti'].'</td>';
        $renglones.='<td>'.$mone.' '.cdouble($row['precio']).'</td>';

        if($row['hay_dto_item']=='S'){
            $renglones.='<td>'.cdouble($row['porcen_descuen']).'%</td>';
        }

        $renglones.='<td>'.$mone.' '.cdouble($row['subtotal_con_dto']).'</td>';
        $renglones.='</tr>';
        $cuerpo.=$renglones;
    }


    if($descuen_cabe!=0){
       $cuerpo.='
        <tr>
            <th colspan="2"></th>
            <th>Subtotal</th>
            <th>'.$subtotal_sin_dto.'</th>
        </tr> 
        <tr>
            <th colspan="2"></th>
            <th>Dto. Gral ('.$descuen_cabe.'%)</th>
            <th>'.$impor_descuen_cabe.'</th>
        </tr>';
    }


    $cuerpo.='
        <tr>
            <th colspan="2"></th>
            <th>Total</th>
            <th>'.$total.'</th>
        </tr>
    </table>
    <br><br>'.$leyenda_horario.'<br>
    <br>

    '.$mail_firma.'
    <br>
    <br>
        <img src="'.$path_logo.'" />
    </body>
    </html>
    ';

    if($hay_dto_item=='S'){
        $cuerpo=str_replace('colspan="2"', 'colspan="3"', $cuerpo);
    }

    //para el envío en formato HTML
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";

    //dirección del remitente
    $headers .= "From: ".$mail_empresa." <".MAIL_RTA.">\r\n";
    //Direccion de respuesta
    $headers .= "Reply-To: ".$mail_empresa."\r\n";


    $mail_destino=str_replace(";", ",", $mail);

    if($mail_destino=='')
        goto Avanzar;


    if(EnviarMail($mail_destino,$asunto,$cuerpo,$error)==false){
        $sql="insert into eco_auditoria_mails(tipo,num,secuen,asunto,mail_destino,cuerpo,headers,codigo,fecha) select '".$tipo."',";
        $sql.=$num.",NULL,'".$asunto."','".$mail_destino."','".$cuerpo."','".$headers."','NO ENVIADO',getdate()";
        $rs=sqlsrv_query($conn,$sql);
    }
    else {
        $sql="insert into eco_auditoria_mails(tipo,num,secuen,asunto,mail_destino,cuerpo,headers,codigo,fecha) select '".$tipo."',";
        $sql.=$num.",NULL,'".$asunto."','".$mail_destino."','".$cuerpo."','".$headers."','OK',getdate()";
        $rs=sqlsrv_query($conn,$sql);
    }



//------------------------------Mail a la empresa--------------------------------------

Avanzar:

    $mail=$mail_empresa; //ventas@luftikus.com.ar o mail de empresa configurada
    if($mail=='')
        goto Salir;

    $asunto = "Se registro el Pedido Nro: ".$num." - ".$nombre_cliente;

    $cuerpo = '
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style>
        table {
            width:auto;
        }
        table, th, td {
            border-bottom: 1px solid black;
            border-collapse: collapse;
            text-align:right;
        }
        th, td {
            padding: 10px;
        }
        </style>

    </head>
    <body>
    <p><font size=2 face=verdana>
    El cliente '.$nombre_cliente.' ha creado el Pedido Nro. '.$num.'<br><br>
    '.$entrega.'<br><br>
    Observaciones: '.$obser.'<br><br>
    Los artículos del pedido son:<br>
    </p>
     
    <table>';

    $sql="eco_pedi_items_consul ";
    $sql.="'".$_SESSION['codigo']."',".$num;
    $result=sqlsrv_query($conn,$sql);

    $i=0;
    while ( $row = sqlsrv_fetch_array($result)){
        $i++;

        //Solo la 1ra vez pongo los titulos con o sin dto
        if($i==1){
            if($row['hay_dto_item']=='S'){
                $hay_dto_item='S';
                $cuerpo.='
                <tr>
                    <th style="width:60%;text-align:left;">Artículo</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>% Dto.</th>
                    <th>Subtotal</th>
                </tr>';
            }else{
                $hay_dto_item='N';
                $cuerpo.='
                <tr>
                    <th style="width:60%;text-align:left;">Artículo</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>';
            }
        }

        $renglones='<tr>';
        $renglones.='<td style="text-align:left;">'.$row['descrip_arti'].'<br>'.$row['desc_adicional'].'<br>'.$row['stock'].'</td>';
        $renglones.='<td>'.$row['canti'].'</td>';
        $renglones.='<td>'.$mone.' '.cdouble($row['precio']).'</td>';

        if($row['hay_dto_item']=='S'){
            $renglones.='<td>'.cdouble($row['porcen_descuen']).'%</td>';
        }

        $renglones.='<td>'.$mone.' '.cdouble($row['subtotal_con_dto']).'</td>';
        $renglones.='</tr>';
        $cuerpo.=$renglones;
    }


    if($descuen_cabe!=0){
       $cuerpo.='
        <tr>
            <th colspan="2"></th>
            <th>Subtotal</th>
            <th>'.$subtotal_sin_dto.'</th>
        </tr> 
        <tr>
            <th colspan="2"></th>
            <th>Dto. Gral ('.$descuen_cabe.'%)</th>
            <th>'.$impor_descuen_cabe.'</th>
        </tr>';
    }


    $cuerpo.='
        <tr>
            <th colspan="2"></th>
            <th>Total</th>
            <th>'.$total.'</th>
        </tr>
    </table>
    <br>
    <br>

    '.$mail_firma.'
    <br>
    <br>
    <img src="'.$path_logo.'" />
    </body>
    </html>
    ';

    if($hay_dto_item=='S'){
        $cuerpo=str_replace('colspan="2"', 'colspan="3"', $cuerpo);
    }
    
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
        $sql="insert into eco_auditoria_mails(tipo,num,secuen,asunto,mail_destino,cuerpo,headers,codigo,fecha) select '".$tipo."',";
        $sql.=$num.",NULL,'".$asunto."','".$mail_destino."','".$cuerpo."','".$headers."','OK',getdate()";
        $rs=sqlsrv_query($conn,$sql);
    }

Salir:

echo "OK^".$tipo."^".$num;

?>
