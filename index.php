<?
$body='home';
$agru_1=$_GET['agru_1'];
$agru_2=$_GET['agru_2'];
$agru_3=$_GET['agru_3'];
$cant_x_pagina=$_GET['cant_x_pagina'];
$modo_grilla='N';
$solo_stock=$_GET['solo_stock'];
$solo_ofertas=$_GET['solo_ofertas']; 


if ($cant_x_pagina=='' || $cant_x_pagina=='25' || $cant_x_pagina=='50' || $cant_x_pagina=='100' || $cant_x_pagina=='200')
    $cant_x_pagina='12';


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

if($mostrar_destacados || ($agru_1=='' && $agru_2=='' && $agru_3=='' && !isset($_GET['articulo']))){
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
"&cant_x_pagina=".$cant_x_pagina.
"&solo_stock=".$solo_stock.
"&solo_ofertas=".$solo_ofertas;
?>


<script> 
$(document).ready(function(){

    $( ".iconos" ).tooltip();

    <? //completo el buscador con lo que se busco
    if($articulo!='')
        echo '$( "#busqueda" ).val("'.$articulo.'");';
    ?>


    $('#btn-solo-stock').click(function() {
        var Valor;
        if( $('#btn-solo-stock').prop('checked') )
            Valor='S';
        else
            Valor='N';
        document.location="<?=$index_url?>?agru_1=<?=$agru_1?>&agru_2=<?=$agru_2?>&agru_3=<?=$agru_3?>"+
                        "&articulo=<?=$articulo?>&destaca=<?=$destaca?>&modo_grilla=<?=$modo_grilla?>"+
                        "&solo_ofertas=<?=$solo_ofertas?>&solo_stock="+Valor;      
    });

    $('#btn-solo-ofertas').click(function() {
        var Valor;
        if( $('#btn-solo-ofertas').prop('checked') )
            Valor='S';
        else
            Valor='N';
        document.location="<?=$index_url?>?agru_1=<?=$agru_1?>&agru_2=<?=$agru_2?>&agru_3=<?=$agru_3?>"+
                        "&articulo=<?=$articulo?>&destaca=<?=$destaca?>&modo_grilla=<?=$modo_grilla?>"+
                        "&solo_ofertas=<?=$solo_stock?>&solo_ofertas="+Valor;    
    });


    $( ".iconos img"  ).hover(
        function() {
            foto=$( this ).attr("src");
            foto=foto.replace(".png","_over.png");
            $( this ).attr("src",foto);
        }, function() {
            foto=$( this ).attr("src");
            foto=foto.replace("_over.png",".png");
            $( this ).attr("src",foto);
        });

    abrir_login_mje('<?=$_GET["mje_tipo"]?>');

}); //document.ready
/*
function ver_detalle(codi_arti){
    $.fancybox.open({
            'transitionIn'  :   'elastic',
            'transitionOut' :   'fade',
            'speedIn'       :   600, 
            'speedOut'      :   200, 
            'overlayShow'   :   false,
            'titlePosition' :   'inside',
            'href'          :   'detalle_articulo.php?cod_articulo='+codi_arti,
            'type'          :   'ajax',
            wrapCSS         :   'mifancy',
            centerOnScroll  :   true,
            autoDimensions  :   true

        });
}
*/
function agregar_carrito(codi_arti){

<?if($mostrar_precios){?>
    $.get( "agregar_carrito.php",{ articulo: codi_arti, cantidad: $("#"+codi_arti).val() }, function( data ) {
        $( ".cant_carrito" ).html( data );
    });
<?}?>


}

function abrir_login_mje(tipo){
    if(tipo=='')
        return;

    //tipo=1 --> validacion de usuario correcta
    //tipo=2 --> error de validacion de usuario
    //tipo=3 --> session caducada

    $.fancybox.open({
            'transitionIn'  :   'elastic',
            'transitionOut' :   'fade',
            'speedIn'       :   600, 
            'speedOut'      :   200, 
            'overlayShow'   :   false,
            'titlePosition' :   'inside',
            'href'          :   'signin.php?form=home&mje_tipo='+tipo,
            'type'          :   'ajax',
            wrapCSS         :   'mifancy',
            centerOnScroll  :   true,
            autoDimensions  :   true

        });
}



</script>
<?/*
            <div style="font-size: 30px;width:100%;font-weight: bold;text-align:center;color:#da3b3b">
               Estaremos de cerrados por vacaciones del 31/12/22 al 16/01/23
            </div>activar el boton*/?>

    <main>

        <?
        //Pongo el lateral con los desplegables y marcas
        //$titulo_busqueda esta dentro de este php
        include "categorias.php";
        ?>

        <section class="resultado">

            <div id="filtros_busqueda">
                <label class="contenedor_check">Solo Con Stock
                  <input type="checkbox" <?if($solo_stock=='S') echo 'checked="checked"'?> name="solo_stock" value="S" id="btn-solo-stock">
                  <span class="checkmark"></span>
                </label>

                <label class="contenedor_check">Solo Ofertas
                  <input type="checkbox" <?if($solo_ofertas=='S') echo 'checked="checked"'?> name="solo_ofertas" value="S"  id="btn-solo-ofertas">
                  <span class="checkmark"></span>
                </label>
            </div>

            <?if(!$mostrar_precios){?>
                <span class="sin_stock" style="width: 100%;margin-bottom: 15px;">Solo usuarios registrados pueden ver precios.</span>
            <?}?>    
             <div class="cant_x_pagina" style="width: 100%;">Mostrar:&nbsp
                <? $link="index.php?articulo=".$articulo."&agru_1=".$agru_1."&agru_2=".$agru_2."&agru_3=".$agru_3."&modo_grilla=N&tipo=".$tipo;?>
                <a <?if($cant_x_pagina=='12') echo 'class="activo"';?> href="<?=$link?>&cant_x_pagina=12">12</a> | 
                <a <?if($cant_x_pagina=='24') echo 'class="activo"';?> href="<?=$link?>&cant_x_pagina=24">24</a> | 
                <a <?if($cant_x_pagina=='48') echo 'class="activo"';?> href="<?=$link?>&cant_x_pagina=48">48</a> | 
                <a <?if($cant_x_pagina=='86') echo 'class="activo"';?> href="<?=$link?>&cant_x_pagina=86">86</a> | 
            <a title="Vista por fotos" href="index.php<?=$_SESSION['filtros'];?>"> <i class="material-icons">view_comfy</i></a>
            <a title="Vista por lista"  href="index_grilla.php<?=$_SESSION['filtros'];?>"> <i class="material-icons">format_list_bulleted</i></a>
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
            $sql.=",@solo_ofertas='".$solo_ofertas."'";
            $sql.=",@solo_stock='".$solo_stock."'";
            $sql.=",@usuario='".$_SESSION['usuario']."'";
                
            $result = sqlsrv_query($conn,$sql);

            while ( $row = sqlsrv_fetch_array($result)){
                $cant++;
                $cant_paginas=$row['cant_paginas'];

                $usa_color=$row['usa_color'];
                $usa_talle=$row['usa_talle'];
            ?>


            <article class="articulos">
            <?if($row['descrip_oferta']<>''){?>
            <div class="art-pie banda-oferta">
                <?=$row['descrip_oferta']?>
            </div>
            <?}?>
            <figure class="art-foto">
                <a href="articulo.php?cod_articulo=<?=rawurlencode($row['cod_articulo'])?>">
                    <img src="<?=$row['web_link']?>">
                </a>
            </figure>
            <h4>
                <a href="articulo.php?cod_articulo=<?=rawurlencode($row['cod_articulo'])?>">
                    <?echo utf8_decode($row['descrip_arti'])?>
                </a>
            </h4>
            <h5>Código: <?echo $row['cod_articulo']?></h5>
            <p><?echo $row['desc_adicional']?></p>
            
            <?if($mostrar_precios){?>
            <?if($row['descrip_oferta']<>''){?>
                <p style="font-weight: 500;font-size: 16px;color: #888;text-decoration: line-through;"><?echo $row['mone'].' '.cdouble($row['precio_sin_oferta'])?></p>
            <?}?>

                <p style="font-weight: bold;font-size: 18px;"><?echo $row['mone'].' '.cdouble($row['precio_vta'])?> <span style="font-weight: normal;font-size: 12px;"></span></p>
            <?}?>


<div class="pie-arti">


            <a class="btn-tanyx" href="articulo.php?cod_articulo=<?=rawurlencode($row['cod_articulo'])?>">
                <button type="button" class="btn btn-default">Ver Producto</button>
            </a>

            <?if($mostrar_precios){
                if($usa_color=='S' || $usa_talle=='S'){?>
                    <a href="articulo.php?cod_articulo=<?=$row['cod_articulo']?>">
                        <i class="material-icons icono_art" title="Indicar color o talle y agregar al carrrito">add_shopping_cart</i>
                    </a> 
                <?}else{?>  
                <div style="align-items: center; display: flex;">
                    <a href="javascript:;" onclick="agregar_carrito('<?=$row['cod_articulo']?>');">
                        <i class="material-icons icono_art" title="Agregar al carrrito">add_shopping_cart</i>
                    </a>
                    <input type="number" class="input-rojo canti" id="<?=$row['cod_articulo']?>" value="1">
                </div>
                <?}
            }?>
</div>
            </article>



<!--             <article class="articulos">
                <figure class="art-foto">
                    <a href="articulo.php?cod_articulo=<?=$row['cod_articulo']?>" class="ver_detalle">
                        <img src="<?=$row['web_link']?>">
                    </a>
                </figure>
                <div class="art-pie">
                    <div class="descripcion" >
                        <h2 style="font-size:14px"><?echo /*'Cod: '.$row['cod_articulo'].' - '.*/$row['descrip_arti']?></h2>
                        <p><?if(strlen($row['desc_adicional'])>90) echo substr($row['desc_adicional'],0,90).'...';?></p>
                    </div>
                </div>
                <div class="art-pie-footer">
                    <div class="iconos">
                        <a href="articulo.php?cod_articulo=<?=$row['cod_articulo']?>">
                            <i class="material-icons icono_art" title="Detalle">add_circle_outline</i>
                        </a>
                        <?if($mostrar_precios){
                            if($usa_color=='S' || $usa_talle=='S'){?>
                                <a href="articulo.php?cod_articulo=<?=$row['cod_articulo']?>">
                                    <i class="material-icons icono_art" title="Indicar color o talle y agregar al carrrito">add_shopping_cart</i>
                                </a> 
                            <?}else{?>  
                            <a href="javascript:;" onclick="agregar_carrito('<?=$row['cod_articulo']?>');">
                                <i class="material-icons icono_art" title="Agregar al carrrito">add_shopping_cart</i>
                            </a>
                            <input type="number" class="input-rojo canti" id="<?=$row['cod_articulo']?>" value="1">
                            <?}
                        }?>

                    </div>
                    <div class="precio">
                    <?if($mostrar_precios){?>
                        <h3 style="display: inline-block;"><?echo $row['mone'].' '.cdouble($row['precio_vta'])?></h3>
                    <?}?>  
                    </div>
                </div>
                
            </article> LOC TANYX Article original -->

            <?} //fin while
            
            $resto=3-($cant % 3);
            if($resto<3){
                for($i=1;$i<=$resto;$i++){?>
                    <article class="relleno"></article>
                <?}
            }

            if ($cant>0)
                include("leyendas.php");
            else{
                include("leyendas_sin_resultado.php");
            }?>

        </section>
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
<script> 
var titulo='<?=$titulo_busqueda?>';
$("#titulo_busqueda").html(titulo);
</script>



<? include ("footer.php") ;?>