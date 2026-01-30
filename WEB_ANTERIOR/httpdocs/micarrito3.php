<? 
include ("header.php");
require_once "mp/lib/mercadopago.php";

$num=(!is_numeric($_GET['num'])) ? 0 : $_GET['num'];
$tipo=consultar_configuracion('TIPO_PEDIDO');


//Este parametro viene desde mis pedidos, para hacer el pago desde ahi y no muestra los pasos
$pasos=$_GET['pasos']; 


//Aca que levante de la tabla la configuracion del MP del cliente
$client_id=consultar_configuracion('MP_ID_CLIENTE');
$client_secret=consultar_configuracion('MP_CLAVE_SECRETA');

if($client_secret=='' || $client_id==''){
    $usa_mp='N';
}
else{
    $usa_mp='S';
}

$sql="select path_empresa from empresa";
$result = sqlsrv_query($conn,$sql);
$row=sqlsrv_fetch_array($result);
$url_web=$row['path_empresa'];



//Verifico que el pedido exista y sea del cliente logueado
$sql="eco_pedi_cabe_consul ";
$sql.="'".$_SESSION['codigo']."',".$num;    

$result = sqlsrv_query($conn,$sql);

if (!sqlsrv_has_rows($result)){?>
    <main class="main-carrito">
        <section class="contenido-carrito2">
            <p class="info-pasos">
                <b>Error: El pedido <?=$num;?> no se ha encontrado.</b>
            </p>
        </section>
    </main>
    <?
    exit();
}

//Verifico si ya tiene guardada la forma de pago, asi no la puede cambiar.
$row = sqlsrv_fetch_array($result);
if($row['datos_pago']<>'' && $row['datos_pago']<>'PENDIENTE DE PAGO / SIN PAGOS REGISTRADOS'){?>
    <main class="main-carrito">
        <section class="contenido-carrito2">
            <p class="info-pasos">
                <b>El pedido <?=$num;?> ya tiene guardada una forma de pago. (<?=$row['datos_pago']?>)</b>
            </p>

            <div class="pago-botones">
                <input type="button" class="btn-rojo" onclick="document.location='index.php';" id="btn-continuar" value="Seguir comprando" style="width: 150px;">
            </div>
        </section>
    </main>
    <?exit();  
}


if ($usa_mp=='S'){
    //$mp = new MP("6497958339843579", "6rlLC2HVHnp1hIb0fdp6j76noaPAg2fJ"); //mauronet
    //$mp = new MP("7955707004340871", "ffm1J6wObAgDGK7FCLL4VH7w0Ni1igxk"); //test
    $mp = new MP($client_id, $client_secret); //test

    //Verifico si este pedido tiene pagos en MP, si es asi no muestro la forma de pago.

    $searchResult = $mp->get("/v1/payments/search?external_reference=".$tipo."_".$num."&status=approved");
    if ($searchResult["response"]["paging"]["total"]<>0){?>
        <main class="main-carrito">
            <section class="contenido-carrito2">
                <p class="info-pasos">
                    <b>Ya existe un pago en Mercado Pago para el Pedido Nro. <?=$num;?></b>
                </p>

                <div class="pago-botones">
                    <input type="button" class="btn-rojo" onclick="document.location='index.php';" id="btn-continuar" value="Seguir comprando" style="width: 150px;">
                </div>
            </section>
        </main>
        <?exit();  
    }


    $mp_mone=$row['mp_mone'];
    $mp_total=(float)$row['mp_total'];

    switch ($mp_mone) {
        case 'PES':
            $mp_mone='ARS';
            break;
        case 'U$S':
            $mp_mone='USD';
            break;
        case 'EUR':
            $mp_mone='EUR';
            break;        
    }

    /*
    Monedas: USD, ARG, EUR
    */

    $mp->sandbox_mode(FALSE); //modo prueba

    $preference_data = array(
        "items" => array(
            array(
                "title" => "Pedido".$num."xxxCliente".$_SESSION['codigo']."xxx",
                "currency_id" => $mp_mone, // Available currencies at: https://api.mercadopago.com/currencies
                "category_id" => "Category",
                "quantity" => 1,
                "unit_price" => $mp_total
            )
        ),
        "back_urls" => array(
            "success" => $url_web."/procesar_mp.php?pasos=".$pasos."&num=".$num,
            "failure" => $url_web."/micarrito4.php?estado=fallo&pasos=".$pasos."&num=".$num,
            "pending" => $url_web."/micarrito4.php?estado=pend&pasos=".$pasos."&num=".$num
        ),
        "notification_url" => $url_web."/procesar_mp_notificacion.php",
        "external_reference" => $tipo."_".$num,
        "expires" => false,
        "expiration_date_from" => null,
        "expiration_date_to" => null
    );

    $preference = $mp->create_preference($preference_data);
}//fin usa mp
?>
    

<script>
$(document).ready(function(){

    $( "#btn-finalizar").click(function() {
        $.post("guardar_pago.php", {num: <?=$num?>, pago: $( "input[name=tipo_pago]:checked" ).val() } ,function(data){
            if(data=='OK')
            {
                document.location="micarrito4.php?num=<?=$num?>";
            }else{
                $(".mje-result").fadeTo(200,0.1,function(){
                    $(this).html(data).fadeTo(500,1);
                });
            }
        });
    });

    $( "input[name=tipo_pago]").change(function() {
        motrar_pagos();
    });

    motrar_pagos();
}); //document.ready

function motrar_pagos(){
    if ($( "input[name=tipo_pago]:checked" ).val()=='tc'){
        $(".pago-tc").css('display','block');
        $(".pago-depo").css('display','none');
        $("#btn-finalizar").css('display','none');
    }
    if ($( "input[name=tipo_pago]:checked" ).val()=='depo'){
        $(".pago-tc").css('display','none');
        $(".pago-depo").css('display','block');
        $("#btn-finalizar").css('display','block');
    }
    if ($( "input[name=tipo_pago]:checked" ).val()=='ef'){
        $(".pago-tc").css('display','none');
        $(".pago-depo").css('display','none');
        $("#btn-finalizar").css('display','block');
    }

}

</script>


    <main class="main-carrito">
        <?
        if ($pasos!="N"){
        ?>

        <div class="pasos">
            <section class="pasos-compra" style="border-top-left-radius: 3px;border-bottom-left-radius: 3px;">
                <h2>Artículos</h2>
                <figure class="titulo-carrito">
                    <i class="material-icons" style="font-size: 30px;">chevron_right</i>
                </figure>
            </section>
            <section class="pasos-compra">
                <h2>Datos de entrega</h2>
                <figure class="titulo-carrito">
                    <i class="material-icons" style="font-size: 30px;">chevron_right</i>
                </figure>
            </section>
            <section class="pasos-compra paso-activo" style="border-top-right-radius: 3px;border-bottom-right-radius: 3px;">
                <h2>Confirmá tu compra</h2>
                <figure class="titulo-carrito">
                    <i class="material-icons" style="font-size: 30px;">chevron_right</i>
                </figure>
            </section>
        </div>
        <?}?>

        <section class="contenido-carrito2">
            <?if ($pasos!="N"){?>
            <p class="info-pasos">
                Su pedido ya ha sido registrado correctamente.<br>
                <b>Nro de pedido asignado: <?=$num;?><br></b>
                Recibirá un mail con la información del pedido.<br>
                <b>El total de su pedido es: <?
                    echo $row['total'];
                    if($row['hay_descuentos']=='S'){
                        echo ' (se aplicaron descuentos)';
                    }?>
                </b>
                <br>
            </p>
            <?}?>
            <div class="pago-cuerpo">
                <div class="pago-tipo">
                    <h2>Forma de Pago</h2>
                    <input type="radio" name="tipo_pago" value="ef" checked> Efectivo / Cheque al retirar<br>
                    <input type="radio" name="tipo_pago" value="depo"> Depósito / Transferencia<br>
                    <?if ($usa_mp=='S'){?>
                        <input type="radio" name="tipo_pago" value="tc"> MercadoPago / Tarjeta de crédito<br>
                    <?}?>
                </div>

                <div class="pago-datos">
                    <div class="pago-depo">
                        <h2>Datos de cuenta</h2>
                        <p>Recibira un mail con los datos de nuestras cuentas para realizar el pago.</p>
                    </div>

                    <?if ($usa_mp=='S'){?>
                        <div class="pago-tc">
                            <h2>Pagar a través de Mercado Pago</h2>
							<a href="<?php echo $preference["response"]["init_point"]; ?>" name="MP-Checkout" class="red-M-Ov-ArOn" mp-mode="redirect">Pagar</a>
						<!--https://www.mercadopago.com.ar/developers/es/solutions/payments/basic-checkout/receive-payments/render-js/-->
                        </div>
                    <?}?>

                    <div class="mje-result"></div>
                </div>
            </div>
            <div class="pago-botones">
                <input type="button" class="btn-rojo" id="btn-finalizar" value="Finalizar" style="width: 150px;">
            </div>
        </section>
    </main>
	
<!-- Pega este código antes de cerrar la etiqueta </body> -->
<script type="text/javascript">
(function(){function $MPC_load(){window.$MPC_loaded !== true && (function(){var s = document.createElement("script");s.type = "text/javascript";s.async = true;s.src = document.location.protocol+"//secure.mlstatic.com/mptools/render.js";var x = document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);window.$MPC_loaded = true;})();}window.$MPC_loaded !== true ? (window.attachEvent ?window.attachEvent('onload', $MPC_load) : window.addEventListener('load', $MPC_load, false)) : null;})();
</script>
	
<? include ("footer.php") ;?>


