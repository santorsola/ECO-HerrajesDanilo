<? 
include ("header.php");

$mostrar_entrega_y_pago=consultar_configuracion('MOSTRAR_ENTREGA_Y_PAGO');
$mostrar_saldo_cliente=consultar_configuracion('MOSTRAR_SALDO_CLIENTE');
$validar_stock=consultar_configuracion('VALIDAR_STOCK');

?>
    

<script> 
var mone;
$(document).ready(function(){

    $(".ico_borrar").tooltip();

    $( "#btn-continuar").click(function() {
        document.location="index.php";
        });

    $( "#btn-limpiar-carrito").click(function() {
        $.get( "limpiar_carrito.php", function( data ) {
            document.location="micarrito.php";
        });
    });


    $( "#dialog" ).dialog({
      autoOpen: false,
      modal: true,
      buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
          document.location="micarrito.php";
        }
      }
    });

    $( "#dialog_stock" ).dialog({
      autoOpen: false,
      modal: true
    });


    $( "#btn-guardar-carrito").click(function() {
        $.get( "guardar_carrito.php", function( data ) {
            $( "#dialog" ).dialog( "open" );            
        });
    });

    $( "#btn-confirmar-carrito").click(function() {
        var logueado=<?echo ($_SESSION['usuario']=='' ? 'false' : 'true');?>;
        var resultado;
        var bSeguir='S';
        var jsValidarStock='<?=$validar_stock?>';
        var jsMostrarEntregaPago='<?=$mostrar_entrega_y_pago?>';
        console.log('<?=$_SERVER['REMOTE_ADDR']?>');
        if(logueado){
            console.log('1');
            if(jsMostrarEntregaPago=='S'){
                console.log('2');
                if(jsValidarStock=='S'){
                    console.log('3');
                    $.get( "validar_stock.php", function( data ) {
                        resultado=data.split('^');
                        if(resultado[0]!='OK'){
                            $( "#dialog_stock" ).html(data);
                            $( "#dialog_stock" ).dialog( "open" ); 
                            if($(window).width()>=670){
                                $( "#dialog_stock" ).dialog( "option", "width", 800 );
                            }
                            console.log('4');
                        }else{
                            console.log('5');
                            document.location="micarrito2.php";
                        }
                    });
                }else{
                    console.log('6');
                    document.location="micarrito2.php";
                }
            }else{
                $.post("guardar_entrega.php", $("#guardar_entrega").serialize() ,function(data){
                    var js_tipo;
                    var js_num;
                    resultado=data.split('^');

                    if(resultado[0]=='OK')
                    {
                        js_tipo=resultado[1];
                        js_num=resultado[2];
                        document.location="micarrito4.php?estado=ok_sin_pasos&num="+js_num;
                    }else{
                        $(".mje-result").fadeTo(200,0.1,function(){
                            $(this).html(data).fadeTo(500,1);
                        });
                    }
                });
            }            
        }else{
            $.fancybox.open({
                'transitionIn'  :   'elastic',
                'transitionOut' :   'fade',
                'speedIn'       :   600, 
                'speedOut'      :   200, 
                'overlayShow'   :   false,
                'titlePosition' :   'inside',
                'href'          :   'signin.php?form=carrito',
                'type'          :   'ajax',
                wrapCSS         :   'mifancy',
                autoSize        :   true
            });
        }
    });




    $( ".col4 input").change(function() {
        var patron = /^\d*$/;                  //Expresión regular para aceptar solo números enteros
        if (!patron.test($(this).val())) {   //Este método regresa tru si la cadena coincide con el patrón definido en la expresión regular
            $(this).val(0);
        }
        if ($(this).val()>1000){
            $(this).val(0);
        }
        calcular_total();
    });

    $( ".canti").change(function() {
        var codi_arti;
        var cantidad;

        codi_arti=$(this).data("articulo");
        cantidad=$(this).val();

        $.get( "actualizar_item_carrito.php",{ articulo: codi_arti, canti: cantidad }, function( data ) {
            calcular_total();
        });
    });



}); //document.ready


function eliminar_item(codi_arti,secuen){
    $.get( "eliminar_item_carrito.php",{ articulo: codi_arti }, function( data ) {
        $( ".cant_carrito" ).html( data );
        $( "#row-"+secuen ).remove();
        calcular_total();
    });
}



function calcular_total(){
        var canti=0;
        var totalcanti=0;
        var precio=0;
        var subtotal=0;
        var total=0;

        $( "tr[id*='row-']" ).each(function() {
            canti=$(this).children("td.col4").children("input").val();

            if($.isNumeric(canti)){
                canti=parseFloat(canti);
            }else{
                canti=0;
            }

            precio=$(this).children("td.col5").html();

            precio=precio.replace(mone,'');

            if($.isNumeric(precio)){
                precio=parseFloat(precio);
            }else{
                precio=0;
            }

            subtotal=canti*precio;
            total=total+subtotal;
            totalcanti=totalcanti+canti;

            $(this).children("td.col6").html(mone+subtotal.toFixed(2));
        });

        $( ".cant_carrito" ).html( '('+totalcanti+')' );
        $( "#total" ).html( mone+total.toFixed(2) );
}

</script>


    <main class="main-carrito">

        <?if ($mostrar_entrega_y_pago=="S"){?>
            <div class="pasos">
                <section class="pasos-compra paso-activo" style="border-top-left-radius: 3px;border-bottom-left-radius: 3px;">
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
                <section class="pasos-compra" style="border-top-right-radius: 3px;border-bottom-right-radius: 3px;">
                    <h2>Confirmá tu compra</h2>
                    <figure class="titulo-carrito">
                        <i class="material-icons" style="font-size: 30px;">chevron_right</i>
                    </figure>
                </section>
            </div>
        <?}else{?>
            <div class="destacado-titulo">Mi Carrito</div>
        <?}?>


        <div class="contenido-carrito">

<?/*
            <div style="font-size: 0.25em;width:100%;font-weight: bold;text-align:left;color:#da3b3b">
               Estaremos de cerrados por vacaciones del 31/12/22 al 16/01/23.
            </div>activar el boton*/?>

            <?if ($mostrar_saldo_cliente=="S" && $_SESSION['codigo']!=''){

                $sql="eco_saldos_clientes_consul ";
                $sql.="'".$_SESSION['codigo']."'";

                $result = sqlsrv_query($conn,$sql);
                $row = sqlsrv_fetch_array($result);
                ?>
                <div style="font-size: 0.18em;width:100%;font-weight: bold;font-style: italic;text-align:right">
                   <a href="compo_saldos.php">Saldo del cliente: <?=$row['saldo']?></a>
                </div>
            <?}?>
            <?
            $sql="eco_carrito_items_consul ";
            $sql.="'".session_id()."'";

            $result = sqlsrv_query($conn,$sql);

            if (sqlsrv_has_rows($result)){
            ?>                
            <table>
                <thead>
                    <tr>
                        <th colspan="3">Producto</th>
                        <th >Código</th>
                        <th style="text-align:center;">Cantidad</th> 
                        <th style="text-align:right;">Precio</th>
                        <th style="text-align:right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="espaciado">
                        <td colspan="7"></td>
                    </tr>
                <?
                $sql="eco_carrito_items_consul ";
                $sql.="'".session_id()."'";

                $result = sqlsrv_query($conn,$sql);

                while ( $row = sqlsrv_fetch_array($result)){
                    $total=$row['total'];
                    $mone=$row['mone'];
                ?>

                    <tr id="row-<?=$row['secuen']?>">
                        <td class="col1">
                            <a href="#" style="display:flex" onclick="eliminar_item('<?=$row['cod_articulo']?>','<?=$row['secuen']?>');">
                                <i class="material-icons ico_borrar" title="Eliminar">delete_forever</i>
                            </a>
                        </td>
                        <td class="col2">
                            <img src="<?=$row['web_link']?>" class="img-art">
                        <td class="col3">
                            <div>                                
                                <h3><?=$row['descrip_arti']?></h3>
                                <p class="descrip-adicional"><?=$row['desc_adicional']?></p>
                            </div>
                        </td>
                        </td>
                        <td class="col3" style="line-height: 0.7em;"> 
                            <div>                                
                                <h3><?=$row['cod_articulo']?></h3>
                            </div>
                        </td>
                        <td class="col4">
                            <input type="number" class="input-rojo canti" data-articulo="<?=$row['cod_articulo']?>" value="<?=$row['canti']?>">
                        </td>
                        <td class="col5 carrito-precio"><?=$row['mone'].$row['precio']?></td>
                        <td class="col6 carrito-precio"><?=$row['mone'].$row['subtotal']?></td>
                    </tr>

                <?} //fin while?>

                    <tr class="espaciado">
                        <td colspan="6"></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5"></td>
                        <td class="col5">
                            Total
                        </td>
                        <td class="col6 carrito-precio" id="total"><?=$mone.$total?></td>
                    </tr>
                </tfoot>
            </table>

            <?if ($mostrar_entrega_y_pago=="N"){?>
                <form id="guardar_entrega">
                    <div style="font-size: 0.18em; width:100%; margin-top:20px">
                        Observaciones del Pedido<br><textarea style="width:75%;" class="input-rojo" name="obser" rows="5" maxlength="200"></textarea>
                        <div class="mje-result"></div>
                    </div>
                </form>
            <?}?>

            <div id="dialog" title="Carrito guardado">
              <p>El contenido del carrito se ha guardado correctamente. <br></p>
                <?if ($mostrar_entrega_y_pago=="N"){?>
                    <p style="font-size: 0.8em; margin-top:15px;"><i><b>Atención:</b> Las observaciones del pedido <b>NO</b> quedaran guardadas, se deben volver a ingresar al momento de la confirmación del carrito</i></p>
                <?}?>
            </div>
            
            <?include("leyendas.php");?> 

            <div id="dialog_stock" title="Faltante de Stock" style="font-size: 1em; margin-top:15px;">
            </div>
                 <?/**/?>
            <input type="button" class="btn-rojo" id="btn-continuar" value="Seguir comprando" style="width: 150px;">
            <input type="button" class="btn-rojo" id="btn-limpiar-carrito" value="Limpiar" style="width: 100px;">
            <input type="button" class="btn-rojo" id="btn-guardar-carrito" value="Guardar Carrito" style="width: 150px;">
            <input type="button" class="btn-rojo" id="btn-confirmar-carrito" value="Confirmar Carrito" style="width: 150px;">

            <?}else{?>
                <h2 class="color_base" style="font-size: 0.2em">No hay items en el carrito</h2>
    
            <?} //fin if?>
        </div>
    </main>
<script type="text/javascript">
    mone='<?=$mone?>';
</script>



<? include ("footer.php") ;?>