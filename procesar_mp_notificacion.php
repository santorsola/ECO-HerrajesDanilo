<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
require_once "mp/lib/mercadopago.php";

$notificacion=file_get_contents('php://input');
$json = json_decode($notificacion, true);


if(!isset($json['type'])){
	//{"resource":"90197169634","topic":"payment"}
	$id=$json['resource']; 
	$topic=$json['topic'];
}
else{
	//{"action":"payment.created","api_version":"v1","data":{"id":"90192638834"},"date_created":"2024-10-10T19:07:14Z","id":116309796121,"live_mode":true,"type":"payment","user_id":"144605892"}
	$id=$json['data']['id']; 
	$topic=$json['type']; 
}

if ($topic!="payment"){

	$sql="insert into eco_mp_log values(getdate(),'".$topic."','".$notificacion."','no es payment no entro')";
	$result=sqlsrv_query($conn,$sql);

	header("HTTP/1.1 200 OK");
	exit(0);
}
//retraso la ejecucion entre 0.5 y 2 segundos para evitar notificaciones simultaneas.
$i=rand(500000, 2000000);
usleep($i);

//Aca que levante de la tabla la configuracion del MP del cliente
$client_id=consultar_configuracion('MP_ID_CLIENTE');
$client_secret=consultar_configuracion('MP_CLAVE_SECRETA');

$mp = new MP($client_id, $client_secret); //test

$payment_info = $mp->get_payment_info($id);

$sql="insert into eco_mp_log values(getdate(),'".$topic."','".$notificacion."','')";
$result=sqlsrv_query($conn,$sql);


if ($payment_info["status"] != 200){ //no se proceso
	header("HTTP/1.1 200 OK");
	exit(0);
}
//print_r ($payment_info);

//$preference_id=$_GET['preference_id'];//nro del envio de solicitud, el envio de solicitud, genera un pedido (merchant_order_id),ese pedido puede tener varios pagos(collection_id)
$preference_id="Notificacion";
$collection_id=$id;//nro de pago
$external_reference=$payment_info["response"]["external_reference"];//DDD_Nropedido
$collection_status=$payment_info["response"]["status"];//approved
$payment_type=$payment_info["response"]["payment_type_id"];//credit_card
$merchant_order_id=$payment_info["response"]["order"]["id"];//nro de pedido

$pedido=explode("_",$external_reference);

$tipo=$pedido[0];
$num=$pedido[1];

$fecha=substr($payment_info["response"]["date_created"], 0, 10);
$fecha=str_replace('-', '', $fecha_pago);

$cliente =0;// se obtiene desde el pedido de referencia
$transaction_amount=(float)$payment_info["response"]["transaction_amount"];

/*DEBUG
echo "<br><br><br><PRE>";
print_r ($payment_info);
echo "</PRE>";
*/



sqlsrv_begin_transaction( $conn );

$sql="eco_anticipo_alta ";
$sql.="'".$tipo."',";
$sql.=$num.",";
$sql.=$cliente.",";
$sql.=($fecha == '' ? "null" : "'".$fecha."'").",";
$sql.=$transaction_amount.",";
$sql.=($fecha == '' ? "null" : "'".$fecha."'").",";
$sql.="'".$collection_id."',";
$sql.=($collection_status == '' ? "null" : "'".$collection_status."'");

//DEBUG
//echo $sql."---------<br>";
$result=sqlsrv_query($conn,$sql);

if(!$result){
    if( ($errors = sqlsrv_errors() ) != null) {
        sqlsrv_rollback( $conn );
        $error_sql=devolver_error_sql($errors); //No muestro, devuelvo el error
        }
}else{

    $row = sqlsrv_fetch_array($result);
    $ant_tipo =$row['tipo'];
    $ant_num =$row['num'];
	$cliente =$row['cliente'];
	$existente =$row['existente'];

    sqlsrv_commit( $conn ); 
}

/*
$sql="insert into eco_mp_log values(getdate(),'sql1','".str_replace("'","''",$sql)."','')";
$result=sqlsrv_query($conn,$sql);
*/
//guardo los datos del pago y si fallo el anticipo tb guardo el error
if ($existente=='N'){
	$sql="eco_pagos_mp_alta ";
	$sql.="'".$tipo."',";
	$sql.=$num.",";
	$sql.=$transaction_amount.",";
	$sql.="'".$collection_id."',";
	$sql.="'".$collection_status."',";
	$sql.="'".$merchant_order_id."',";
	$sql.="'".$preference_id."',";
	$sql.="'".$payment_type."',";
	$sql.=($fecha == '' ? "null" : "'".$fecha."'").",";
	$sql.=($ant_tipo == '' ? "null" : "'".$ant_tipo."'").",";
	$sql.=($ant_num == '' ? "null" : $ant_num).",";
	$sql.=($error_sql == '' ? "null" : "'Notificacion>".$error_sql."'");

	$result=sqlsrv_query($conn,$sql);

/*
$sql="insert into eco_mp_log values(getdate(),'sql1','".str_replace("'","''",$sql)."','')";
$result=sqlsrv_query($conn,$sql);
*/
	$sql="eco_pedi_cabe_pago_actua ";
	$sql.="".$cliente.","; 
	$sql.=$num.",'tc'";
	$result=sqlsrv_query($conn,$sql);
}

//DEBUG
//echo $sql."---------<br>";

header("HTTP/1.1 200 OK");
?>
