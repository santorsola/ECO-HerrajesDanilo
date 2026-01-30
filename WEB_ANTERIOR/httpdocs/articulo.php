<? include ("header.php");
$cod_articulo=rawurldecode($_GET['cod_articulo']);


$mostrar_precios=true;

if(consultar_configuracion('SOLO_REGISTRADOS_VEN_PRECIOS')=='S'){
    if ($_SESSION['nombre_usuario']=='')
        $mostrar_precios=false;
    else
        $mostrar_precios=true;
}

?>


    <!-- swipe http://idangero.us/swiper -->
    <script src="js/swiper/dist/js/swiper.min.js"></script>
    <link rel="stylesheet" href="js/swiper/dist/css/swiper.css">


<script> 
$(document).ready(function(){

	//Esta linea hace andar al swiper cuando le haces click desde pc, xq solo andaba x celular
	$('.swiper-slide a').click(function() { window.location.href = $(this).attr("href"); });
	
    $("#color").change(function() {
        var idx;

        idx=$("#color option:selected").index();

        if (idx==0){
            $("#codi_arti").html('');
            $("#cod_barras").html('');
            return;
        }

        swiper.slideTo(idx);
        consultar_talle_color();
    });

    $("#talle").change(function() {
        var idx;

        idx=$("#talle option:selected").index();

        if (idx==0){
            $("#codi_arti").html('');
            $("#cod_barras").html('');
            return;
        }

        consultar_talle_color();
    });


    $( "#cantidad").change(function() {
        var patron = /^\d*$/;                  //Expresión regular para aceptar solo números enteros
        if (!patron.test($(this).val())) {   //Este método regresa tru si la cadena coincide con el patrón definido en la expresión regular
            $(this).val(0);
        }
        if ($(this).val()>1000){
            $(this).val(0);
        }
    });


    $( "#subir").click(function() {
        iCant=parseInt($( "#cantidad").val());
        $( "#cantidad").val(iCant+1);
    });

    $( "#bajar").click(function() {
        iCant=parseInt($( "#cantidad").val());
        if (iCant-1==0)
            return;
        $( "#cantidad").val(iCant-1);
    });

}); //document.ready
</script>



    <main>

        <?
        $sql="eco_articulos_consul ";
        $sql.="'".$cod_articulo."'";
        $sql.=",@usuario='".$_SESSION['usuario']."'";

        $result = sqlsrv_query($conn,$sql);
        $row = sqlsrv_fetch_array($result);

        $usa_color=$row['usa_color'];
        $usa_talle=$row['usa_talle'];
        $cod_articulo_base=$row['cod_articulo_base'];
        $agru_1=$row['agru_1'];
        $agru_2=$row['agru_2'];
        $agru_3=$row['agru_3'];


        //Pongo el lateral con los desplegables y marcas
        include "categorias.php";


        $sql="eco_articulos_consul ";
        $sql.="'".$cod_articulo."'";
        $sql.=",@usuario='".$_SESSION['usuario']."'";

        $result = sqlsrv_query($conn,$sql);
        $row = sqlsrv_fetch_array($result);
        ?>


<script>
<?/*esta luego de la consulta ya se usa las variables del php*/?>
function agregar_carrito(){
<?if($mostrar_precios){?>

    if($("#cantidad").val()=="0")
        return;

    codi_arti=$("#agregar").attr("data-codi_arti"); 
console.log(codi_arti); 

    <?if($usa_color=="S"){?>
        var idx;
        idx=$("#color option:selected").index();

        if (idx==0){
            $("#mje_error").html("Debe seleccionar un color para continuar");
            return;
        }
    <?}?>

    <?if($usa_talle=="S"){?>
        var idx;
        idx=$("#talle option:selected").index();

        if (idx==0){
            $("#mje_error").html("Debe seleccionar un talle para continuar");
            return;
        }
    <?}?>

    if (codi_arti=='')
        return;

    $.get( "agregar_carrito.php",{ articulo: codi_arti,cantidad: $("#cantidad").val() }, function( data ) {
        $( ".cant_carrito" ).html( data );
    });
<?}?>
}


function consultar_talle_color(){

    var codi_arti_base='<?=$cod_articulo_base?>';
    var codi_color;
    var codi_talle;
    var mensaje_error;

    $("#mje_error").html('');
    $("#agregar").attr('data-codi_arti','');


    <?if($usa_talle=="S"){?>
        codi_talle=$("#talle option:selected").val();
        mensaje_error="El talle seleccionado no esta disponible.";
    <?}?>

    <?if($usa_color=="S"){?>
        codi_color=$("#color option:selected").val();
        mensaje_error="El color seleccionado no esta disponible.";
    <?}?>


    <?if($usa_color=="S" && $usa_talle=="S"){?>
        codi_color=$("#color option:selected").val();
        mensaje_error="La combinacion de color y talle seleccionada no esta disponible.";
    <?}?>

    $.get( "consultar_talle_color.php",{ articulo: codi_arti_base,color:codi_color,talle:codi_talle }, function( data ) {
        resultado=data.split('^');

        if(resultado[0]=='ok'){
            $( "#codi_arti" ).html("Código: "+resultado[1]);
            $("#agregar").attr('data-codi_arti',resultado[1]);

            if (resultado[2]==""){
                $( "#cod_barras" ).html("");
            }else{
                $( "#cod_barras" ).html("Cód. Barras: "+resultado[2]);
            }
            $( "#valor_precio" ).html(resultado[3]);

            <?if (consultar_configuracion('MOSTRAR_STOCK')=="S"){?>
                if (resultado[4]>0){
                    $( "#stock" ).html("<span class='con_stock'>Con stock</span>");
                }else{
                    $( "#stock" ).html("<span class='sin_stock'>Sin stock</span>");
                }
           <?}?>

            var info="";

            if (resultado[5]!=""){
                info=info+"<h2>Marca</h2><br><p>"+resultado[5]+"</p>";
            }
            if (resultado[6]!=""){
                info=info+"<h2>Observaciones</h2><br><p>"+resultado[6]+"</p>";
            }
            if (resultado[7]!=""){
                info=info+"<h2>Más Información</h2><br><p>"+resultado[7]+"</p>";
            }

            $( ".articulo-info-adic" ).html(info);
        }else{
            $("#mje_error").html(mensaje_error);
        }


    });

}

</script>

<style>
    .swiper-container {
        width: 100%;
        height: 300px;
    }
    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #FFF;
        /* Center slide text vertically */
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .swiper-slide .pie{
        width: 100%;
        position: absolute;
        align-self: flex-end;
        bottom: 15px;
        text-align: left;
        padding-left: 50px;
    }
</style>

        <section class="main-articulo">
            <div class="destacado-titulo"><?=utf8_decode($row['descrip_arti'])?></div>

            <article class="articulo-cabecera">
                <figure class="articulo-slider" id="slider1">
                    <div class="swiper-container">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Slides -->
                            <?
                            $hay_fotos_adicionales=false;

                            if ($usa_color=='N'){
                                ?>
                                <div class="swiper-slide"><img src="<?=$row['web_link']?>"></div> <!-- img principal -->
                                <?
                                $sql="eco_articulos_imagenes_consul ";
                                $sql.="'".$cod_articulo."'";
                                //echo $sql;
                            }else{
                                $sql="eco_articulos_colores_imagenes_consul ";
                                $sql.="'".$cod_articulo_base."'";
                            }

                            $result_img = sqlsrv_query($conn,$sql);

                            while ($row_img = sqlsrv_fetch_array($result_img)){
                                $hay_fotos_adicionales=true;
                            ?>
                                <div class="swiper-slide">
                                    <div>
                                        <img src="<?=$row_img['imagen']?>">
                                    </div>
                                    <div class="pie">
                                        <h3 class="precio"><?=$row_img['descrip_color']?></h3>
                                    </div>
                                </div>
                            <?}?>
                        </div>

                        <?if($hay_fotos_adicionales){?>
                            <!-- If we need pagination -->
                            <div class="swiper-pagination"></div>
                            
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        <?}?>
                    </div>
                </figure>
                <div class="articulo-cont-info">
                    <div class="articulo-info" style="align-items:center;">
                    <?if($mostrar_precios){?>
                        <?if($row['descrip_oferta']<>''){?>
                            <div class="oferta">
                               <h3 id="descrip_oferta"> <?=$row['descrip_oferta']?></h3>
                            </div>
                            <div class="precio_viejo">
                                <h3 id="precio_sin_oferta"><?echo $row['mone'].' '.cdouble($row['precio_sin_oferta'])?></h3>
                            </div>
                        <?}?>
                    
                        <div class="precio">
                            <h3 id="valor_precio"><?echo $row['mone'].' '.cdouble($row['precio_vta'])?></h3>
                        </div>

                        <h3 class="talle_color">Cantidad</h3>
                        <!-- <input type="number" class="input-rojo input-canti" id="cantidad" value="1"> -->
                        <div>
                            <input type="button" class="btn-rojo" id="bajar" value="-" style="width: 30px;height: 32px;">
                            <input type="number" class="input-rojo input-canti" id="cantidad" value="1">
                            <input type="button" class="btn-rojo" id="subir" value="+" style="width: 30px;height: 32px;">
                        </div>
    
                        <?if($usa_color=="S"){?>
                            <h3 class="talle_color">Colores</h3>
                            <select class="select-rojo cbo_talle_color" name="color" id="color">
                                <option value="">Seleccione un Color</option>
                                <?
                                $sql="eco_articulos_colores_imagenes_consul ";
                                $sql.="'".$cod_articulo_base."'";
                                $result_color = sqlsrv_query($conn,$sql);
                                while($row_color=sqlsrv_fetch_array($result_color)){
                                    echo '<option value="'.$row_color['codi_color'].'">'.$row_color['descrip_color'].'</option>';
                                }?>
                            </select>
                        <?}?>

                        <?if($usa_talle=="S"){?>
                            <h3 class="talle_color">Tipo</h3>
                            <select class="select-rojo cbo_talle_color" name="talle" id="talle">
                                <option value="">Seleccionar</option>
                                <?
                                //$sql="eco_articulos_talles_consul ";
                                $sql="eco_articulos_presentaciones_consul ";

                                $sql.="'".$cod_articulo_base."'";
                                $result_color = sqlsrv_query($conn,$sql);
                                while($row_color=sqlsrv_fetch_array($result_color)){
                                    echo '<option value="'.$row_color['cod_articulo'].'">'.$row_color['variante'].'</option>';
                                }?>
                            </select>
                        <?}?>

                        <div class="contenedor-boton-agregar">
                            <a class="boton-agregar-articulo" href="javascript:;" id="agregar" data-codi_arti="<?=$row['cod_articulo']?>" onclick="agregar_carrito();">
                                <i class="material-icons icono_art2" title="">add_shopping_cart</i>Agregar al carrrito
                            </a>
                        </div>

                        <div class="sin_stock" id="mje_error"></div>

                    <?}
                    else{?>
                        <div class="precio">
                            <span class="sin_stock">Solo usuarios registrados pueden ver precios.</span>
                        </div>
                    <?}?>                            

                    </div>
                    <div class="articulo-info">
                        <?
                        if (consultar_configuracion('MOSTRAR_STOCK')=="S"){
                            if ($row['stock']>0){
                                echo "<div id='stock'><span class='con_stock'>Con stock</span></div>";
                            }else{
                                echo "<div id='stock'><span class='sin_stock'>Sin stock</span></div>";
                            }
                        }?>
                        <h4 id="codi_arti">Código: <?=$row['cod_articulo']?></h4>
                        <?/*if ($row['cod_barras']!=''){?>
                            <h4 id="cod_barras">Cód. Barras: <?=$row['cod_barras']?></h4>
                        <?}*/?>
                    </div>
                </div>
            </article>

            <p class="info-pasos"><br></p>

            <?include("leyendas.php");?>

            <article class="articulo-info-adic">
                <?if ($row['desc_adicional']<>''){?>
                    <h2>Características</h2><br>
                    <p><?=$row['desc_adicional']?></p>
                <?}?>
                <?if ($row['obser_web']<>''){?>
                    <h2>Descripción</h2><br>
                    <p><?=$row['obser_web']?></p>
                <?}?>
                <?if ($row['obser_2']<>''){?>
                    <h2>Más Información</h2><br>
                    <p><?=$row['obser_2']?></p>
                <?}?>
                <?if ($row['doc_path']<>''){?>
                    <h2>Descargar ficha técnica</h2><br>
                    <p><a href="<?=$row['doc_path']?>" target="_blank"><img src="img/pdf.png"  style="height: 50px;"></a></p>
                <?}?>
            </article> 

            <?
            /*
            $sql="eco_articulos_consul @agru_1=".($row['agru_1']==""?"null":"'".$row['agru_1']."'");
            $sql.=",@pagina=1,@cant_x_pagina=20,@cod_arti_exclu='".$row['cod_articulo']."'";
            $sql.=",@usuario='".$_SESSION['usuario']."'";*/

            $sql="eco_articulos_sugeridos_consul '".$row['cod_articulo']."'";
            $result = sqlsrv_query($conn,$sql);
            
            $hay_resultado = sqlsrv_has_rows( $result );
            if ($hay_resultado === true){
            ?>
            <p class="info-pasos"><br></p>
            <h2>Otros árticulos que te pueden interesar</h2>

            <figure class="articulo-slider" id="slider2">
                <div class="swiper-container">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        <?
                        $cant_relacionados=0;
                        while ($row_img = sqlsrv_fetch_array($result)){
                            $cant_relacionados++;
                        ?>
                            <div class="swiper-slide">
                                <a href="articulo.php?cod_articulo=<?=$row_img['cod_articulo']?>">
                                    <img src="<?=$row_img['web_link']?>">
                                    <h5><?=$row_img['descrip_arti']?></h5>
                                </a>
                                
                            </div>
                        <?}?>

                    </div>
                    
                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </figure>
            <?}//fin otros de la misma categoria?>
        </section>
    </main>



<script>

	//esta linea tiene que estar en el document.ready
	//$('.swiper-slide a').click(function() { window.location.href = $(this).attr("href"); });

    var swiper = new Swiper('#slider1 .swiper-container', {
        <?if($hay_fotos_adicionales){?>
            pagination: '.swiper-pagination',
            paginationClickable: true,
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            loop: true
        <?}?>
    });

    var swiper2 = new Swiper('#slider2 .swiper-container', {
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        loop: <?=$cant_relacionados>1?'true':'false';?>,
        slidesPerView: 'auto',
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: 3500,
        autoplayDisableOnInteraction: false
    });
</script>

<script> 
var titulo='<?=$row["descrip_arti"]?>';
$("#titulo_busqueda").html(titulo);
</script>

<? include ("footer.php") ;?>