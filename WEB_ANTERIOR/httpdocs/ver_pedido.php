<? 
$body='home';
include ("header.php");

$num=(!is_numeric($_GET['num'])) ? 0 : $_GET['num'];
$tipo=consultar_configuracion('TIPO_PEDIDO');
$mostrar_entrega_y_pago=consultar_configuracion('MOSTRAR_ENTREGA_Y_PAGO');
?>
    

<script>
var mone;
$(document).ready(function(){
    $( "#btn-volver").click(function() {
        document.location="mis_pedidos.php";
    });
    $( "#btn-pagar").click(function() {
        document.location="micarrito3.php?num=<?=$num?>&pasos=N";
    });
    $( "#btn-copiar").click(function() {
        document.location="copiar_items.php?num=<?=$num?>";
    });
}); //document.ready


</script>


    <main class="main-carrito">
        <div class="contenido-carrito">
            <?
            $sql="eco_pedi_cabe_consul ";
            $sql.="'".$_SESSION['codigo']."',".$num;    

            $result = sqlsrv_query($conn,$sql);
            $row = sqlsrv_fetch_array($result);

            if ($row['datos_pago']=="" or $row['datos_pago']=="PENDIENTE DE PAGO / SIN PAGOS REGISTRADOS"){
                $mostrar_boton_pagar="S";
            }

            ?>
            <!-- <h2 style="color:#BF272D;">Pedido Nº <?=$num?></h2> -->
            <div class="destacado-titulo-seccion"  style="margin-top: -30px">
                <h2>Pedido Nº <?=$num?></h2>
            </div>

            <p style="margin-top: 10px; font-size: 0.18em;">
                <b>Fecha:</b> <?=$row['fecha']?><br><br>
                <?if ($mostrar_entrega_y_pago=="S"){?>
                    <b>Datos de entrega:</b><br><?=$row['datos_entrega']?><br><br>
                    <b>Datos de pago:</b><br><?
                if ($row['datos_pago']=="" or $row['datos_pago']=="PENDIENTE DE PAGO / SIN PAGOS REGISTRADOS"){
                        ?>
                        Sin datos<br><input type="button" class="btn-rojo" id="btn-pagar" value="Indicar forma de pago" style="width: 200px;font-size: 14px;">
                        <?
                    }else{
                        echo $row['datos_pago'];
                        $sql="eco_pagos_mp_consul ";
                        $sql.="'".$tipo."',".$num;    

                        $result = sqlsrv_query($conn,$sql);
                        $row = sqlsrv_fetch_array($result);
                        if ($row['mp_collection_id']<>''){
                        echo '<br>Nro. Refencia de Mercado Pago: '.$row['mp_collection_id'];
                        }

                    }?><br><br>
                <?}?>
                <b>Obser gral:</b><br><?=$row['obser_gral']?><br>
            </p>
            <div class="separador-1"></div>
            <?
            $sql="eco_pedi_items_consul ";
            $sql.="'".$_SESSION['codigo']."',".$num;

            $result = sqlsrv_query($conn,$sql);

            if (sqlsrv_has_rows($result)){
            ?>                
            <table>
                <thead>
                    <tr>
                        <th colspan="3">Producto</th>
                        <th style="text-align:center;">Cantidad</th> 
                        <th style="text-align:right;">Precio</th>
                        <th style="text-align:right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="espaciado">
                        <td colspan="6"></td>
                    </tr>
                <?
                $sql="eco_pedi_items_consul ";
                $sql.="'".$_SESSION['codigo']."',".$num;
                $result = sqlsrv_query($conn,$sql);

                while ( $row = sqlsrv_fetch_array($result)){
                    $total=(float)$row['total'];
                    $total_sin_dto=(float)$row['total_sin_dto'];
                    $mostrar_descuento=($row['hay_dto_item']=='S' || $row['hay_dto_cabe']=='S')?true:false;
                    $mone=$row['mone'];
                ?>

                    <tr id="row-<?=$row['secuen']?>">
                        <td colspan="2" class="col2">
                            <img src="<?=$row['web_link']?>" class="img-art">
                        </td>
                        <td class="col3">
                            <div>
                                <h3><?=$row['descrip_arti']?></h3>
                                <p class="descrip-adicional"><?=$row['desc_adicional']?></p>
                            </div>
                        </td>
                        <td class="col4 carrito-precio" style="text-align: center;"><?=$row['canti']?></td>
                        <td class="col5 carrito-precio"><?=$row['mone'].' '.cdouble($row['precio'])?></td>
                        <td class="col6 carrito-precio"><?=$row['mone'].' '.cdouble($row['subtotal'])?></td>
                    </tr>

                <?} //fin while?>

                    <tr class="espaciado">
                        <td colspan="6"></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="2" class="col5">
                            Total
                        </td>
                        <td class="col6 carrito-precio" id="total"><?=$mone.' '.cdouble($total_sin_dto)?></td>
                    </tr>
                    <?
                    if ($mostrar_descuento){?>

                        <tr class="espaciado">
                            <td colspan="6"></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2" class="col5">
                                Total c/Dto
                            </td>
                            <td class="col6 carrito-precio" id="total"><?=$mone.' '.cdouble($total)?></td>
                        </tr>

                    <?}?>
                </tfoot>
            </table>
            
            <input type="button" class="btn-rojo" id="btn-volver" value="Volver" style="width: 100px;">
            <input type="button" class="btn-rojo" id="btn-copiar" value="Agregar items al carrito" style="width: 170px;">
            
            <?}else{?>
                <h2 class="color_base">Nro de pedido incorrecto</h2>
    
            <?    } //fin if?>
        </div>
        <?include("leyendas.php");?>
    </main>
<script type="text/javascript">
    mone='<?=$mone?>';
</script>



<? include ("footer.php") ;?>