<? 
include ("header.php");
?>
    

<script>
$(document).ready(function(){


}); //document.ready



</script>


    <main class="main-carrito">

        <div class="contenido-pedidos">

            <?
            $sql="factu_compo_saldo_clien_lista_2  @formato='N',@estado='P',@exclu_reci='S',@exclu_remi='S',";
            $sql.="@cliente='".$_SESSION['codigo']."'";
            
            $result = sqlsrv_query($conn,$sql);

            if (sqlsrv_has_rows($result)){
            ?>
            <div class="destacado-titulo-seccion" style="margin-bottom: 20px">
                <h2 style="font-size: 0.25em">Composición de Saldos</h2>
            </div>
            <?
            $sql2="eco_saldos_clientes_consul ";
            $sql2.="'".$_SESSION['codigo']."'";

            $result2 = sqlsrv_query($conn,$sql2);
            $row2 = sqlsrv_fetch_array($result2);
            ?>
            <div style="font-size: 0.18em;width:100%;font-weight: bold;font-style: italic;text-align:right">
               Total Saldo del cliente: <?=$row2['saldo']?>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th style="text-align:left;">Comprobante</th>
                        <th style="text-align:center;">Nro</th>
                        <th style="text-align:center;">Fecha</th>
                        <th style="text-align:right;">Total</th>
                        <th style="text-align:right;">Saldo</th>
                        <th style="text-align:center;">Vencimiento</th> 
                        <th style="text-align:left;">Observaciones</th> 
                    </tr>
                </thead>
                <tbody>
                <?
                $sql="factu_compo_saldo_clien_lista_2  @formato='N',@estado='P',@exclu_reci='S',@exclu_remi='S',";
                $sql.="@cliente='".$_SESSION['codigo']."'";

                $result = sqlsrv_query($conn,$sql);

                while ( $row = sqlsrv_fetch_array($result)){
                ?>
                    <tr id="row-<?=$row['num']?>">
                        <td class="col1"><?=$row['compro_descrip']?></td>
                        <td class="col2"><?=$row['num']?></td>
                        <td class="col1"><?=date_format($row['fecha'],'d/m/Y')?></td>
                        <td class="col3"><?=round($row['total'],2)?></td>
                        <td class="col3"><?=round($row['saldo'],2)?></td>
                        <td class="col1"><?if($row['fecha_venci']<>'') echo date_format($row['fecha_venci'],'d/m/Y')?></td>
                        <td class="col5"><?=$row['obser_cabe']?></td>
                    </tr>

                <?} //fin while?>
                </tbody>
            </table>
            
            <?}else{?>
                <h2 class="color_base" style="font-size: 0.2em">No hay comprobantes pendientes</h2>
    
            <?    } //fin if?>
        </div>
    </main>

<? include ("footer.php") ;?>