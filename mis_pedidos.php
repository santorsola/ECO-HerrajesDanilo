<? 
include ("header.php");
$mostrar_entrega_y_pago=consultar_configuracion('MOSTRAR_ENTREGA_Y_PAGO');
?>
    

<script>
$(document).ready(function(){

    $( "tr[id*='row-']" ).click(function() {
        document.location="ver_pedido.php?num="+$(this).children("td.col2").html();
    });

}); //document.ready



</script>


    <main class="main-carrito">

        <div class="contenido-pedidos">

            <?
            $sql="eco_pedi_cabe_consul ";
            $sql.="'".$_SESSION['codigo']."'";

            $result = sqlsrv_query($conn,$sql);

            if (sqlsrv_has_rows($result)){
            ?>
            <div class="destacado-titulo-seccion" style="margin-bottom: 20px">
                <h2 style="font-size: 0.25em">Mis Pedidos registrados</h2>
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="text-align:center;">Fecha</th>
                        <th style="text-align:center;">Nº Pedido</th> 
                        <th style="text-align:right;">Total</th>

                        <?if ($mostrar_entrega_y_pago=="S"){?>
                            <th style="text-align:left;">Datos Entrega</th>
                            <th style="text-align:left;">Datos Pago</th>
                        <?}?>
                    </tr>
                </thead>
                <tbody>
                <?
                $sql="eco_pedi_cabe_consul ";
                $sql.="'".$_SESSION['codigo']."'";

                $result = sqlsrv_query($conn,$sql);

                while ( $row = sqlsrv_fetch_array($result)){
                ?>
                    <tr id="row-<?=$row['num']?>">
                        <td class="col1"><?=$row['fecha']?></td>
                        <td class="col2"><?=$row['num']?></td>
                        <td class="col3"><?=$row['total']?></td>
                        <?if ($mostrar_entrega_y_pago=="S"){?>
                            <td class="col4"><?=$row['datos_entrega']?></td>
                            <td class="col5"><?=$row['datos_pago']?></td>
                        <?}?>
                    </tr>

                <?} //fin while?>
                </tbody>
            </table>
            
            <?}else{?>
                <h2 class="color_base" style="font-size: 0.2em">No hay pedidos registrados</h2>
    
            <?    } //fin if?>
        </div>
    </main>

<? include ("footer.php") ;?>