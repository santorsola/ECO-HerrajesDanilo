<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
require_once "mp/lib/mercadopago.php";

$pasos=$_GET['pasos']; 
$num=(!is_numeric($_GET['num'])) ? 0 : $_GET['num'];

//retraso la ejecucion entre 0.5 y 2 segundos para evitar notificaciones simultaneas.
$i=rand(500000, 2000000);
usleep($i);

//Aca que levante de la tabla la configuracion del MP del cliente
$client_id=consultar_configuracion('MP_ID_CLIENTE');
$client_secret=consultar_configuracion('MP_CLAVE_SECRETA');

//$mp = new MP("6497958339843579", "6rlLC2HVHnp1hIb0fdp6j76noaPAg2fJ"); //mauronet
//$mp = new MP("7955707004340871", "ffm1J6wObAgDGK7FCLL4VH7w0Ni1igxk"); //test
$mp = new MP($client_id, $client_secret); //test

$preference_id=$_GET['preference_id'];//nro del envio de solicitud, el envio de solicitud, genera un pedido (merchant_order_id),ese pedido puede tener varios pagos(collection_id)
$collection_id=$_GET['collection_id'];//nro de pago
$external_reference=$_GET['external_reference'];//DDD_Nropedido
$collection_status=$_GET['collection_status'];//approved
$payment_type=$_GET['payment_type'];//credit_card
$merchant_order_id=$_GET['merchant_order_id'];//nro de pedido

$payment_info = $mp->get_payment_info($collection_id);

/*DEBUG

echo json_encode($payment_info);
echo "<br><br><br>Resto: <PRE>";
print_r ($payment_info);
echo "</PRE>";
exit;
*/

$num=(!is_numeric($_GET['num'])) ? 0 : $_GET['num'];
$tipo=consultar_configuracion('TIPO_PEDIDO');

$estado=$payment_info["response"]["status"];
$importe=(float)$payment_info["response"]["transaction_amount"];
$fecha_pago=$payment_info["response"]["date_created"];
$fecha_pago=substr($payment_info["response"]["date_created"], 0, 10);
$fecha_pago=str_replace('-', '', $fecha_pago);

sqlsrv_begin_transaction( $conn );

$sql="eco_anticipo_alta ";
$sql.="'".$tipo."',";
$sql.=$num.",";
$sql.=(int)$_SESSION['codigo'].",";
$sql.=($fecha_pago == '' ? "null" : "'".$fecha_pago."'").",";
$sql.=$importe.",";
$sql.=($fecha_pago == '' ? "null" : "'".$fecha_pago."'").",";
$sql.="'".$collection_id."',";
$sql.=($estado == '' ? "null" : "'".$estado."'");

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
	$existente =$row['existente'];
    //echo '<br>Anticipo: '.$ant_tipo.'-'.$ant_num.'<br>';

    sqlsrv_commit( $conn );
}


//guardo los datos del pago y si fallo el anticipo tb guardo el error 
if ($existente=='N'){
	$sql="eco_pagos_mp_alta ";
	$sql.="'".$tipo."',";
	$sql.=$num.",";
	$sql.=$importe.",";
	$sql.="'".$collection_id."',";
	$sql.="'".$collection_status."',";
	$sql.="'".$merchant_order_id."',";
	$sql.="'".$preference_id."',";
	$sql.="'".$payment_type."',";
	$sql.=($fecha_pago == '' ? "null" : "'".$fecha_pago."'").",";
	$sql.=($ant_tipo == '' ? "null" : "'".$ant_tipo."'").",";
	$sql.=($ant_num == '' ? "null" : $ant_num).",";
	$sql.=($error_sql == '' ? "null" : "'".$error_sql."'");

	$result=sqlsrv_query($conn,$sql);

	$row = sqlsrv_fetch_array($result);
	$num_pago =$row['secuen_pago'];
}
//DEBUG
//echo $sql."---------<br>";


if ($error_sql!='')
    $estado='error';
else
    $estado='ok';

header('Location: micarrito4.php?pasos='.$pasos."&num=".$num."&num_pago=".$num_pago."&estado=".$estado);
?>