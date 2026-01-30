<? 
include ("header.php");

//Este parametro viene desde mis pedidos, para hacer el pago desde ahi y no muestra los pasos
$pasos=$_GET['pasos'];
$estado=$_GET['estado'];
$num=(!is_numeric($_GET['num'])) ? 0 : $_GET['num'];
$num_pago=(!is_numeric($_GET['num_pago'])) ? 0 : $_GET['num_pago'];
$tipo=consultar_configuracion('TIPO_PEDIDO');
$mostrar_entrega_y_pago=consultar_configuracion('MOSTRAR_ENTREGA_Y_PAGO');

if ($estado=='ok'){ //es xq vino de mp
    $sql="eco_pedi_cabe_pago_actua ";
    $sql.="'".$_SESSION['codigo']."',"; 
    $sql.=$num.",'tc'";
    $result=sqlsrv_query($conn,$sql);
}


//verifico que el pedido sea del cliente logueado
$sql="eco_pedi_cabe_consul ";
$sql.="'".$_SESSION['codigo']."',".$num;    
$result = sqlsrv_query($conn,$sql);
if (!sqlsrv_has_rows($result))
    $estado='incorrecto';
?>
    

<script>
$(document).ready(function(){
    
    $( "#btn-continuar").click(function() {
        document.location="index.php";
    });
}); //document.ready


</script>


    <main class="main-carrito">

        <?
        if ($pasos!="N" && $mostrar_entrega_y_pago=='S'){
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
            <p class="info-pasos">
                <?
                switch ($estado) {
                    case 'ok':?>
                        Su pago fue procesado correctamente. <br>
                        Puede encontar mas información de su pago en la sección <b><a href="mis_pedidos.php">Mis Pedidos</a></b>.<br>
                        Gracias por elegirnos.
                        <?break;
                    case 'error': //se proceso pero no se generó el anticipo?>
                        Ocurrio un error.<br>
                        El pago se realizo, pero no pudimos registrarlo en nuestro sistema.
                        Comuniquese con nosotros indicando su Nro de pedido y Nro de pago.<br><br>
                        <?
                        $sql="eco_pagos_mp_consul ";
                        $sql.="'".$tipo."',".$num.",".$num_pago;  
                        $result = sqlsrv_query($conn,$sql);   
                        $row = sqlsrv_fetch_array($result);
                        $collection_id =$row['mp_collection_id'];
                        ?>
                        <b>Nro pedido:</b> <?=$num?> <br>
                        <b>Nro pago:</b> <?=$collection_id?>

                        Disculpe las molestas.
                        <?break;
                    case 'pend':?>
                        Su pago se encuentra pendiente de acreditación.
                        <?break;
                    case 'fallo':?>
                        Su pago no pudo ser procesado.
                        <?break;
                    case 'incorrecto':?>
                        El pedido no pudo ser encontrado.
                        <?break;
                    case 'ok_sin_pasos': // modo sin lugar de entrega ni pago
                        //Verifico que el pedido exista y sea del cliente logueado
                        $sql="eco_pedi_cabe_consul ";
                        $sql.="'".$_SESSION['codigo']."',".$num; 
                        $result = sqlsrv_query($conn,$sql); 
                        $row = sqlsrv_fetch_array($result);?>

                        Su pedido ya ha sido registrado correctamente.<br>
                        <b>Nro de pedido asignado: <?=$num;?><br></b>
                        Recibirá un mail con la información del pedido.<br>
                        <b>El total de su pedido es: <?
                            echo $row['total'];
                            if($row['hay_descuentos']=='S'){
                                echo ' (se aplicaron descuentos)';
                            }?>
                        </b><br><br>
                        Un vendedor se contactará a la brevedad.
                        <?break;
                    case '':
                        echo "Gracias por elegirnos.";
                        break;
                }
                ?>
                <br>
            </p>

            <div class="pago-botones">
                <input type="button" class="btn-rojo" id="btn-continuar" value="Seguir comprando" style="width: 150px;">
            </div>
        </section>
    </main>
<? include ("footer.php") ;?>





