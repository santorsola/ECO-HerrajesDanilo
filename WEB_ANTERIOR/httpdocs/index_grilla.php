<? 
$body='home';
$agru_1=$_GET['agru_1'];
$agru_2=$_GET['agru_2'];
$agru_3=$_GET['agru_3'];
$cant_x_pagina=$_GET['cant_x_pagina'];
$modo_grilla='S';
$solo_stock=$_GET['solo_stock'];
$solo_ofertas=$_GET['solo_ofertas']; 


if ($cant_x_pagina=='' || $cant_x_pagina=='12' || $cant_x_pagina=='24' || $cant_x_pagina=='48' || $cant_x_pagina=='86')
    $cant_x_pagina='25';


include ("header.php");

$articulo=$_GET['articulo'];
$p=$_GET['p'];
$mostrar_destacados=$_GET['destaca']=='1'?true:false;

$mostrar_precios=true;

if(consultar_configuracion('SOLO_REGISTRADOS_VEN_PRECIOS')=='S'){
    if ($_SESSION['nombre_usuario']=='')
        $mostrar_precios=false;
    else
        $mostrar_precios=true;
}


if($_GET['p']=='')
    $p=1;

$titulo_busqueda='';


if($agru_1=='' && $agru_2=='' && $agru_3=='' && isset($_GET['articulo'])){
    $titulo_busqueda='Resultado de la búsqueda';
}

if($agru_1=='' && $agru_2=='' && $agru_3=='' && isset($_GET['articulo']) && $articulo==''){
    $titulo_busqueda='Todos los productos';
}

if($mostrar_destacados || ($agru_1=='' && $agru_2==''  && $agru_3=='' && !isset($_GET['articulo']))){
    $sql="eco_hay_destacados_consul ";
    $result = sqlsrv_query($conn,$sql);
    $row = sqlsrv_fetch_array($result);
    if($row['hay_destacados']=='N'){
        $titulo_busqueda='Todos los productos';
        $mostrar_destacados=false; 
    }else{
        $titulo_busqueda='Productos Destacados';
        $mostrar_destacados=true; 
    }
}

$_SESSION['filtros']="?agru_1=".$agru_1.
"&agru_2=".$agru_2.
"&agru_3=".$agru_3.
"&articulo=".$articulo.
"&destaca=".$mostrar_destacados.
"&modo_grilla=".$modo_grilla.
"&solo_stock=".$solo_stock.
"&solo_ofertas=".$solo_ofertas.
"&cant_x_pagina=".$cant_x_pagina;
?>
 
<script>
var mone;
$(document).ready(function(){

    $( ".iconos" ).tooltip();

    <? //completo el buscador con lo que se busco
    if($articulo!='')
        echo '$( "#busqueda" ).val("'.$articulo.'");';
    ?>
    


    $(".ver_img").fancybox({
        'transitionIn'  :   'elastic',
        'transitionOut' :   'fade',
        'speedIn'       :   600, 
        'speedOut'      :   200, 
        'overlayShow'   :   false,
        'titlePosition' :   'inside',
        wrapCSS         :   'mifancy',
        autoSize        :   true

    });

    $( ".col4 input").change(function() {
        var patron = /^\d*$/;                  //Expresión regular para aceptar solo números enteros
        if (!patron.test($(this).val())) {   //Este método regresa tru si la cadena coincide con el patrón definido en la expresión regular
            $(this).val(0);
        }
        if ($(this).val()>1000){
            $(this).val(0);
        }
    });


    $(".btn-agregar").click(function(){
        $( ".canti").each(function() {
            canti="";
            codi_arti="";
            canti=$(this).val();
            codi_arti=$(this).data("articulo");
            secuen=$(this).data("secuen");

            if(canti=="")
                canti=0;

            if($.isNumeric(canti) && codi_arti!="" && canti>0){
                agregar_carrito(codi_arti,secuen);
                $(this).val(0);
            }

        });


    });

    /*$( ".canti").change(function() {
        var codi_arti;
        var cantidad;

        codi_arti=$(this).data("articulo");
        cantidad=$(this).val();

        $.get( "actualizar_item_carrito.php",{ articulo: codi_arti, canti: cantidad }, function( data ) {
            calcular_total();
        });
    });*/



}); //document.ready


function agregar_carrito(codi_arti,secuen){
<?if($mostrar_precios){?>
    if($("#cantidad-"+secuen).val()=="0")
        return;

    if($("#cantidad-"+secuen).val()=="")
        $("#cantidad-"+secuen).val('1');

    $.get( "agregar_carrito.php",{ articulo: codi_arti,cantidad: $("#cantidad-"+secuen).val() }, function( data ) {
        $( ".cant_carrito" ).html( data );
        $( "#row-"+secuen+" i" ).css("background","#127924");
    });
<?}?>
}


</script>


    <main class="main-grilla">
        <?
        //Pongo el lateral con los desplegables y marcas
        //$titulo_busqueda esta dentro de este php
        include "categorias.php";

        $colspan=$mostrar_precios?5:4;

        ?>
        <div class="resultado-grilla">

            
            <div class="destacado-titulo"><?=$titulo_busqueda?></div>
            <?if(!$mostrar_precios){?>
                <span class="sin_stock" style="width: 100%;margin-bottom: 15px;">Solo usuarios registrados pueden ver precios.</span>
            <?}?>  
            <div class="menu-grilla">
                <div class="cant_x_pagina">Mostrar:&nbsp
                    <? $link="index_grilla.php?articulo=".$articulo."&agru_1=".$agru_1."&agru_2=".$agru_2."&agru_3=".$agru_3."&modo_grilla=S"?>
                    <a <?if($cant_x_pagina=='25') echo 'class="activo"';?> href="<?=$link?>&cant_x_pagina=25">25</a> | 
                    <a <?if($cant_x_pagina=='50') echo 'class="activo"';?> href="<?=$link?>&cant_x_pagina=50">50</a> | 
                    <a <?if($cant_x_pagina=='100') echo 'class="activo"';?> href="<?=$link?>&cant_x_pagina=100">100</a> | 
                    <a <?if($cant_x_pagina=='200') echo 'class="activo"';?> href="<?=$link?>&cant_x_pagina=200">200</a> | 
                <a title="Vista por fotos" href="index.php<?=$_SESSION['filtros'];?>"> <i class="material-icons">view_comfy</i></a>
                <a title="Vista por lista"  href="index_grilla.php<?=$_SESSION['filtros'];?>"> <i class="material-icons">format_list_bulleted</i></a>
                </div>

                <div style="font-size: 10px;">
                    <input type="button" class="btn-rojo btn-agregar" value="Agregar todo al carrito" style="width: 150px;">
                </div>
            </div>

            <?
            $sql="eco_articulos_consul ";
            $sql.=$articulo!=''? "'%".$articulo."%'," : "null,";
            $sql.=$agru_1!=''? "'".$agru_1."'," : "null,";
            $sql.=$agru_2!=''? "'".$agru_2."'," : "null,";
            $sql.=$agru_3!=''? "'".$agru_3."'," : "null,";
            $sql.=$mostrar_destacados ? "'S'," : "null,";
            $sql.="@pagina=".$p.",";
            $sql.="@cant_x_pagina=".$cant_x_pagina;
            $sql.=",@usuario='".$_SESSION['usuario']."'";
            $sql.=",@solo_ofertas='".$solo_ofertas."'";
            $sql.=",@solo_stock='".$solo_stock."'";
        
//echo $sql;
            $result = sqlsrv_query($conn,$sql);

            if (sqlsrv_has_rows($result)){
            ?>                
            <table>
                <thead>
                    <tr>
                        <th colspan="2">Producto</th>
                        <th >Código</th>                        
                        <?if($mostrar_precios){?>
                            <th style="text-align:right;">Precio</th>
                            <th colspan="2" style="text-align:left;">Cantidad</th> 
                        <?}?>
                    </tr>
                </thead>
                <tbody>
<!--                     <tr class="espaciado">
                        <td colspan="<?=$colspan?>"></td>
                    </tr> -->
                <?

                $result = sqlsrv_query($conn,$sql);

                while ( $row = sqlsrv_fetch_array($result)){
                    $cant++;
                    $cant_paginas=$row['cant_paginas'];
                ?>


                    <tr id="row-<?=$row['secuen']?>">
                        <td class="col2">
                            <a class="ver_img mouseover-thumbnail-holder" href="<?=$row['web_link']?>">
                                <img src="<?=$row['web_link']?>" class="img-art-grilla">
                                <?if(strstr($row['web_link'], 'sin_foto.jpg')!="sin_foto.jpg"){?>
                                    <img class="large-thumbnail-style" src="<?=$row['web_link']?>" class="img-art-grilla">
                                <?}?>
                            </a>
                        </td>
                        <td class="col3">
                            <div>
                                <h3><a href="articulo.php?cod_articulo=<?=rawurlencode($row['cod_articulo'])?>"><?=$row['descrip_arti']?></a></h3>
                                <?if($mostrar_precios){?>
                                <p class="descrip-adicional"><?=str_replace('<br>', ' - ', $row['descrip_bultos'])?><br><?=$row['desc_adicional']?></p> 
                                <?}?>
                            </div>
                        </td>
                        <td class="col3">
                            <div>
                                <h3><a href="articulo.php?cod_articulo=<?=rawurlencode($row['cod_articulo'])?>"><?=$row['cod_articulo']?></a></h3>
                            </div>
                        </td>
                        <?if($mostrar_precios){?>
                            <td class="col5 carrito-precio"><?echo $row['mone'].' '.cdouble($row['precio_vta'])?></td>
                        
                            <td class="col4">
                                <input type="number" id="cantidad-<?=$row['secuen']?>" class="input-rojo canti" data-articulo="<?=$row['cod_articulo']?>" data-secuen="<?=$row['secuen']?>" value="<?=$row['canti']?>">
                            </td>
                            <td class="col6">
                                <a href="javascript:;" onclick="agregar_carrito('<?=$row['cod_articulo']?>','<?=$row['secuen']?>');">
                                    <i class="material-icons icono-grilla" title="Agregar al carrrito">add_shopping_cart</i>
                                </a>
                            </td>
                        <?}?> 
                    </tr>

                <?} //fin while?>

                </tbody>
            </table>
            
            <div style="width:100%;text-align: right;font-size: 10px;margin-top: 20px;">
                <input type="button" class="btn-rojo btn-agregar" value="Agregar todo al carrito" style="width: 150px;">
            </div>

            <?}//fin if

            if ($cant>0)
                include("leyendas.php");
            else{
                include("leyendas_sin_resultado.php");
            }
            ?>
        </div>
    </main>

    <section class="paginacion">
            <?
            if ($cant_paginas>1){
                //Config cuantos se muestran para atras/adelante de la pag actual
                $cuantos_atras=2;
                $cuantos_adelante=2;

                if($p-$cuantos_atras>1)
                    $mostrar_pag_min=$p-$cuantos_atras;
                else
                    $mostrar_pag_min=1;

                if($p+$cuantos_adelante>$cant_paginas)
                    $mostrar_pag_max=$cant_paginas;
                else
                    $mostrar_pag_max=$p+$cuantos_adelante;

                if ($p>1){?>
                    <a href="<?=$_SESSION['filtros'].'&p='.($p-1)?>"><span><i class="material-icons icono">chevron_left</i></span></a>
                <?}

                for($i=$mostrar_pag_min;$i<=$mostrar_pag_max;$i++){?>
                    <a href="<?=$_SESSION['filtros'].'&p='.$i?>">
                        <span <?if($i==$p) echo ' class="activo"';?>><?=$i?></span>
                    </a>
                <?}

                if ($p<$cant_paginas){?>
                    <a href="<?=$_SESSION['filtros'].'&p='.($p+1)?>"><span><i class="material-icons icono">chevron_right</i></span></a>
                <?}
            } //if ($cant_paginas>1)?>        
    </section>
<? include ("footer.php") ;?>