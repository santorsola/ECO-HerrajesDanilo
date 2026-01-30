<? 

include ("header.php");
?>
    

<script>
$(document).ready(function(){
    
    $( "#btn-volver").click(function() {
        document.location="micarrito.php";
    });

    $( "input[name=tipo_entrega]").change(function() {
        motrar_entregas();
    });

    //  Descomentar para activar
    // $( "#cdd").change(function() {

    //     $.get( "validar_cdd.php",{ cdd: $(this).val()}, function( data ) {
    //         var resultado;
    //         resultado=data.split('^');
    //         $(".mje-cdd").css("color","#000");

    //         if(resultado[0]=='OK')
    //         {
    //             $(".mje-cdd").fadeTo(200,0.1,function(){
    //                 $(".mje-cdd").css("color","#379837");
    //                 $(this).html("Se aplicará un "+resultado[1]+"% de descuento en compras de "+resultado[2]).fadeTo(500,1);
    //             });
    //         }else{
    //                 $(".mje-cdd").fadeTo(200,0.1,function(){
    //                 $(".mje-cdd").css("color","#AA1721");
    //                 $(this).html(data).fadeTo(500,1);
    //             });
    //         }
    //     });
    // });

    $( "#btn-confirmar").click(function() {
        $.post("guardar_entrega.php", $("#guardar_entrega").serialize() ,function(data){

            var resultado;
            var js_tipo;
            var js_num;
            resultado=data.split('^');

            if(resultado[0]=='OK')
            {
                js_tipo=resultado[1];
                js_num=resultado[2];
                document.location="micarrito3.php?num="+js_num;
            }else{
                $(".mje-result").fadeTo(200,0.1,function(){
                    $(this).html(data).fadeTo(500,1);
                });
            }
        });
    });


    motrar_entregas();
}); //document.ready

function motrar_entregas(){
    if ($( "input[name=tipo_entrega]:checked" ).val()=='sucur'){
        $(".entrega-sucur").css('display','block');
        $(".entrega-envio").css('display','none');
        $(".mje-result").html('');
    }else{
        $(".entrega-sucur").css('display','none');
        $(".entrega-envio").css('display','block');
        $(".mje-result").html('');
    }
}

</script>


    <main class="main-carrito">
        <div class="pasos">
            <section class="pasos-compra" style="border-top-left-radius: 3px;border-bottom-left-radius: 3px;">
                <h2>Artículos</h2>
                <figure class="titulo-carrito">
                    <i class="material-icons" style="font-size: 30px;">chevron_right</i>
                </figure>
            </section>
            <section class="pasos-compra paso-activo">
                <h2>Datos de entrega</h2>
                <figure class="titulo-carrito">
                    <i class="material-icons" style="font-size: 30px;">chevron_right</i>
                </figure>
            </section>
            <section class="pasos-compra" style="border-top-right-radius: 3px;border-bottom-right-radius: 3px;">
                <h2>Confirmá tu compra</h2>
                <figure class="titulo-carrito">
                    <i class="material-icons" style="font-size: 30px;">chevron_right</i>
                </figure>
            </section>
        </div>

        <section class="contenido-carrito2">
            <?devolver_cant_y_total_carrito($cant,$total);?>
            <?
            if ($cant>=1){
            ?> 
            <p class="info-pasos">
                Ud. esta a punto de confirmar una compra por un total de <b><?=$total;?> (con 
                <?if($cant>1)
                    echo $cant.' items'; 
                else 
                    echo '1 item';?>).</b><br>
                Luego de la confirmación recibirá un mail con la información del pedido.
            </p>
            <form id="guardar_entrega" class="entrega-cuerpo">
                <div class="entrega-tipo">
                    <h2>Forma de entrega</h2>
                    <input type="radio" name="tipo_entrega" value="sucur" checked> Retiro en sucursal<br>
                    <input type="radio" name="tipo_entrega" value="envio"> Expreso / Transporte<br>
                    <br>
                    Observaciones para la entrega<br><textarea class="input-rojo" name="obser" rows="5" maxlength="200"></textarea>

<!-- descomentar para activar <br><br><br>
                    <h2>Código de Descuento</h2>
                        Ingresa tu código de descuento <input type="text" class="input-rojo" name="cdd" id="cdd" style="width: 180px;font-size: 15px;">
                        <div class="mje-cdd" style="margin-top: 10px;font-size: 13px;font-weight: bold;"></div>
 -->
                </div>

                <div class="entrega-datos">
                    <div class="entrega-sucur">
                        <h2>Sucursal</h2>
                        <select name="sucur" class="select-rojo">
                            <option value="">Seleccione una sucursal</option>
                            <?
                            $sql="eco_sucursales_consul";
                            $result = sqlsrv_query($conn,$sql);
                            while ($row_sucur = sqlsrv_fetch_array($result)) {?>
                                <option value="<?=$row_sucur['codi_sucur']?>"><?=$row_sucur['descrip_sucur']?></option>
                            <?}?>
                        </select>
                    </div>
                    <div class="entrega-envio">
                        <h2>Datos de entrega</h2>
                        <?
                        $sql="eco_clientes_consul @usuario_web='".$_SESSION['usuario']."'";
                        $result = sqlsrv_query($conn,$sql);
                        $row_cliente = sqlsrv_fetch_array($result)
                        ?>

                        <label for="domicilio">Dirección</label>
                        <input type="text" class="input-rojo" name="domicilio" value="<?=$row_cliente['domicilio']?>">
                        <label for="localidad">Localidad</label>
                        <input type="text" class="input-rojo" name="localidad" value="<?=$row_cliente['localidad']?>">
                        <label for="cp">Cod. Postal</label>
                        <input type="text" class="input-rojo" name="cp" value="<?=$row_cliente['cp']?>">
                        <label for="provincia">Provincia</label>
                        <select class="select-rojo" name="provincia">
                            <option value=""> </option>
                            <?$sql="eco_provincias_consul";
                            $result = sqlsrv_query($conn,$sql);
                            while($row=sqlsrv_fetch_array($result)){
                                if($row['codi']==$row_cliente['codi_provin'])
                                    echo '<option value="'.$row['codi'].'" selected >'.$row['nombre'].'</option>';
                                else
                                    echo '<option value="'.$row['codi'].'" >'.$row['nombre'].'</option>';
                            }?>
                        </select>
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="input-rojo" name="telefono" value="<?=$row_cliente['telefono']?>">
                    </div>
                    <div class="mje-result"></div>
                </form>
            </div>
            <div class="entrega-botones">
                <input type="button" class="btn-rojo" id="btn-volver" value="Volver" style="width: 100px;">
                <input type="button" class="btn-rojo" id="btn-confirmar" value="Confirmar datos" style="width: 150px;">
            </div>
            <?} //fin ($cant>=1)
            else{?>
                <h2 style="color:#BF272D;">No hay items en el carrito</h2>
    
            <?}?>
        </section>
    </main>
<? include ("footer.php") ;?>





