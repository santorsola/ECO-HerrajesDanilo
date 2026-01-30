<?php
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
include "funciones/funciones_carrito.php";

$archivo_actual = strtolower(basename($_SERVER['PHP_SELF']));
$vista_grilla_default=consultar_configuracion('VISTA_GRILLA_DEFAULT');
$ocultar_registrar=consultar_configuracion('OCULTAR_REGISTRAR');
$mostrar_saldo_cliente=consultar_configuracion('MOSTRAR_SALDO_CLIENTE');

if(count($_GET)==0 && $archivo_actual=="index.php" && $vista_grilla_default=='S')
    header('Location: index_grilla.php');


if($modo_grilla=='S')
    $index_url="index_grilla.php";
else
    $index_url="index.php";


switch ($archivo_actual) {
    case 'micarrito2.php': 
    case 'micarrito3.php': 
    case 'mis_pedidos.php':
    case 'compo_saldos.php':
        //entra para 2 o 3
        if (comprobar_sesson()==false){
            logout();
            header('Location: index.php?mje_tipo=3');
            exit();
        }
        break;
    default:
        if ($_SESSION['nombre_usuario']<>''){
                if (comprobar_sesson()==false){
                    logout();
                    header('Location: index.php?mje_tipo=3');
                    exit();
                }
        }               
    
    break;
}


$sql="select razon_social from empresa";
$result = sqlsrv_query($conn,$sql);
$row=sqlsrv_fetch_array($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?=$row['razon_social']?></title> 
    <meta charset="ISO-8859-1" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico"/>
    <meta http-equiv="Content-Language" content="es"/>

    <script src="admin/www/bootstrap/js/bootstrap.min.js"></script>
    <link href="admin/www/bootstrap/css/bootstrap.css" rel="stylesheet">


    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="style_grilla.css">
    <link rel="stylesheet" type="text/css" href="marquee.css">
    <link rel="stylesheet" type="text/css" href="style_tanyx.css">
    <link rel="stylesheet" type="text/css" href="style_mobile.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>

    <!-- Jquery UI  LOC FENIX 
    Tema actual:http://jqueryui.com/themeroller/#!zThemeParams=5d00000100d805000000000000003d8888d844329a8dfe02723de3e5700bbb34ecf36cdef1e1654faa0015427bdb9eb45ebe89aaede0ec5f0d92417fcc6551ce804ff46bf543167700d2cf4e583f2515147aacb86ffa11c0e588dae72a13c98dc37478199f7eea536e99702ea71406d59d8f5b8b635ab08c8738e4fb8e66d9cae65aedf495dd6c449095b82c412ee02d38b3d0cdae45b0a6d001af1cccd8aaf39539e0de4317535143f4b2e9c3c8996edafeedd8ce9e3f2b414aa899a72c730482b6643db9bdae754cde51cdbe5c1276bf3d2451b78b4b518015fd973ebdb1feff8b4d6ee3db07f4bd3f23684f3cf0cfb5b5deec66be9cbbd00fc2348bf8a7394f4d6b1824baa9048594d255e090e0a4700c54cee1046d75ea8afdc84245556c9ae01bed59c1800dc56d327be7531d9c8d90539b57c8bcbaffcf79cf32a729b398d196baa0cbc9c0e544d5c2663255ca4ee184042d77cfea3b3c0e397bd0d209eeb21326360f275a160c38ce19ba5a2f014f7e4fec070dfea1b931d2fc3c566d7fd284e5ff1568fbdbdc9fc20200a13d04da894a65e15751a094dd324761b9b483bb8ae3829321677333dd7fd4082dcbe30f4a798d380b6a9f9ac75e6c2f4a53074bda9beb96ed6979c3a421ffd4ed13b0
    -->
    <!-- <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
    <script src="js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
    <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> -->
    <link rel="stylesheet" href="js/jquery-ui-1.11.4.custom/jquery-ui.css">


    <!-- Add fancyBox main JS and CSS files -->
    <script type="text/javascript" src="js/fancyBox/jquery.fancybox.js?v=2.1.5"></script>
    <link rel="stylesheet" type="text/css" href="js/fancyBox/jquery.fancybox.css?v=2.1.5" media="screen" />
    <link rel="stylesheet" type="text/css" href="js/fancyBox/mi_estilo_fancybox.css" media="screen" />




    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />


</head> 
<body>     

<script type="text/javascript">
$(document).ready(function() {
    $("#registarse").fancybox({
        'transitionIn'  :   'elastic',
        'transitionOut' :   'fade',
        'speedIn'       :   600, 
        'speedOut'      :   200, 
        'overlayShow'   :   false,
        'titlePosition' :   'inside',
        'href'          :   'registarse.php',
        'type'          :   'ajax',
        wrapCSS         :   'mifancy',
        autoSize        :   true,
        'autoDimensions':   true

    });

    $("#cambiar_clave").fancybox({
        'transitionIn'  :   'elastic',
        'transitionOut' :   'fade',
        'speedIn'       :   600, 
        'speedOut'      :   200, 
        'overlayShow'   :   false,
        'titlePosition' :   'inside',
        'href'          :   'cambiar_clave.php',
        'type'          :   'ajax',
        wrapCSS         :   'mifancy',
        autoSize        :   true

    });

    $("#mis_datos").fancybox({
        'transitionIn'  :   'elastic',
        'transitionOut' :   'fade',
        'speedIn'       :   600, 
        'speedOut'      :   200, 
        'overlayShow'   :   false,
        'titlePosition' :   'inside',
        'href'          :   'datos_cliente.php',
        'type'          :   'ajax',
        wrapCSS         :   'mifancy',
        autoSize        :   true

    });

    $("#login").fancybox({
        'transitionIn'  :   'elastic',
        'transitionOut' :   'fade',
        'speedIn'       :   600, 
        'speedOut'      :   200, 
        'overlayShow'   :   false,
        'titlePosition' :   'inside',
        'href'          :   'signin.php?form=home',
        'type'          :   'ajax',
        wrapCSS         :   'mifancy',
        autoSize        :   true

    });

    $(".consultas").fancybox({
        'transitionIn'  :   'elastic',
        'transitionOut' :   'fade',
        'speedIn'       :   600, 
        'speedOut'      :   200, 
        'overlayShow'   :   false,
        'titlePosition' :   'inside',
        'href'          :   'consultas.php',
        'type'          :   'ajax',
        wrapCSS         :   'mifancy',
        autoSize        :   true

    });

    $(".lista_precios").fancybox({
        'transitionIn'  :   'elastic',
        'transitionOut' :   'fade',
        'speedIn'       :   600, 
        'speedOut'      :   200, 
        'overlayShow'   :   false,
        'titlePosition' :   'inside',
        'href'          :   'lista_precios.php',
        'type'          :   'ajax',
        wrapCSS         :   'mifancy',
        autoSize        :   true

    });

    $('#btn-buscar').click(function() {
      //document.location="<?=$index_url?>?agru_1=<?=$agru_1?>&agru_2=<?=$agru_2?>&agru_3=<?=$agru_3?>&articulo="+$("#busqueda").val();      
      document.location="<?=$index_url?>?articulo="+$("#busqueda").val();      
    });

    $('#mis_pedidos').click(function() {
      document.location="mis_pedidos.php";      
    });

    $('#compo_saldos').click(function() {
      document.location="compo_saldos.php";      
    });


    /*$('#ver_menu').hover(function() {
      $('.menu_cliente').animate({
            height: 'auto'
        });    
    });
    
    $(".menu_cliente").css('display','none');*/

    $("#busqueda").keypress(function(e) {
       if(e.which == 13) {
          $('#btn-buscar').click();
       }
    });


    $("#menu-mobile").click(function(){
        $("#botonera-texto-mobile").toggleClass("open", function() {
            $("body").toggleClass("limitar-body");

            if ($("#desplegable-cliente").hasClass("menu_cliente"))
                $("#desplegable-cliente").removeClass("menu_cliente").addClass("menu-cliente-mobile");
            else
                $("#desplegable-cliente").removeClass("menu-cliente-mobile").addClass("menu_cliente");
                
        });
    });
    $("#close-menu-mobile").click(function(){
        $("#botonera-texto-mobile").toggleClass("open", function() {
            $("body").toggleClass("limitar-body");

            if ($("#desplegable-cliente").hasClass("menu_cliente"))
                $("#desplegable-cliente").removeClass("menu_cliente").addClass("menu-cliente-mobile");
            else
                $("#desplegable-cliente").removeClass("menu-cliente-mobile").addClass("menu_cliente");
                
        });
    });



    $(window).resize(function() {
        if($(window).width()>=670){
            if ($("#desplegable-cliente").hasClass("menu-cliente-mobile"))
                $("#desplegable-cliente").removeClass("menu-cliente-mobile").addClass("menu_cliente");
        }else{
            if ($("#desplegable-cliente").hasClass("menu_cliente"))
                $("#desplegable-cliente").removeClass("menu_cliente").addClass("menu-cliente-mobile");
        }
    });

});



</script>



    <header>

        <nav id="botonera-login-mobile">
            <div id="menu-mobile"><i class="material-icons">menu</i></div>
        </nav>

        <nav id="botonera-texto-mobile">
            <div id="close-menu-mobile"><i class="material-icons">close</i></div>
            <ul class="seccion-login">

                

                <?if ($_SESSION['nombre_usuario']==''){?>

                    <li><a href="javascript:;" id="login"><i class="material-icons">input</i><span>Ingresar</span></a></li>
                    <?if ($ocultar_registrar=="N"){?>
                            <li><a href="javascript:;" id="registarse"><i class="material-icons">assignment_turned_in</i><span>Registrarme</span></a></li>
                    <?}?>
                <?} else {
                        if (comprobar_sesson()==false){
                            logout();
                            header('Location: index.php?mje_tipo=3');
                            exit(); 
                        }
                ?>
                <li>  
                    <li id="ver_menu" class="nombre_usuario">
                        <span><div class="menu_cliente" id="desplegable-cliente">
                            <a href="javascript:;" id="mis_pedidos">Mis Pedidos</a>
                            <a href="javascript:;" id="mis_datos">Mis Datos</a>
                            <?if ($ocultar_registrar=="N"){?>
                                <a href="javascript:;" id="cambiar_clave">Cambiar Clave</a>
                            <?}?>                            
                            <?if ($mostrar_saldo_cliente=="S"){?>
                                <a href="javascript:;" id="compo_saldos">Comp. de saldos</a>
                            <?}?>                            
                            <a href="logout.php" >Salir</a><!-- title="<?=session_id();?>" -->
                        </div>
                        </span>
                        <a href="javascript:;"><i class="material-icons">input</i><span id="nom_clien"><?=$_SESSION['nombre_usuario'];?></span></a>
                    </li>
                </li>
                <?}?>

                <li><a href="area_clientes.php"><i class="material-icons">person</i><span>Area Clientes</span></a></li>
                <li><a href="javascript:;" class="consultas"><i class="material-icons">mail_outline</i><span>Consultas Comerciales</span></a></li>



            </ul>

            <ul class="seccion-menus">
                <li><a href="<?=$link.'39'?>"><img src="img/videoicon.png"> <span>Video Vigilancia</span></a></li>
                <li><a href="<?=$link.'54'?>"><img src="img/controlicon.png"> <span>Control de Accesos</span></a></li>
                <li><a href="<?=$link.'10'?>"><img src="img/wifiicon.png"> <span>Conectividad</span></a></li>
                <li><a href="<?=$link.'4'?>"><img src="img/storageicon.png"> <span>NAS Storage</span></a></li>
                <li><a href="<?=$link.'1'?>"><img src="img/accesicon.png"> <span>Accesorios</span></a></li>
                <li><a href="<?=$link.'3'?>"><img src="img/porteria.png"> <span>Portería</span></a></li>
            </ul>
        </nav>

        <nav id="botonera-login" class="contenedor-interno"> 
            <figure id="logo">
                <a href="<?=$index_url?>" class="logo"><img src="img/logo.png"></a>
                <span id="logo-texto">Sentite bien asesorado</span>
            </figure>

            <ul>
                <a href="area_clientes.php" class="area-clientes">
                    <button type="button" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-user"></span> Área Clientes
                    </button>
                </a>
                <li><a href="javascript:;" class="consultas">Consultas Comerciales</a></li>
                <li class="pipe">|</li>
                <?if ($_SESSION['nombre_usuario']==''){?>

                    <li><a href="javascript:;" id="login">Ingresar</a></li>
                    <?if ($ocultar_registrar=="N"){?>
                            <li class="pipe">|</li>
                            <li><a href="javascript:;" id="registarse">Registrarme</a></li>
                    <?}?>
                <?} else {
                        if (comprobar_sesson()==false){
                            logout();
                            header('Location: index.php?mje_tipo=3');
                            exit(); 
                        }
                ?>
                <li>
                    <li id="ver_menu" class="nombre_usuario">
                        <span><div class="menu_cliente" id="desplegable-cliente">
                            <a href="javascript:;" id="mis_pedidos">Mis Pedidos</a>
                            <a href="javascript:;" id="mis_datos">Mis Datos</a>
                            <?if ($ocultar_registrar=="N"){?>
                                <a href="javascript:;" id="cambiar_clave">Cambiar Clave</a>
                            <?}?>                            
                            <?if ($mostrar_saldo_cliente=="S"){?>
                                <a href="javascript:;" id="compo_saldos">Comp. de saldos</a>
                            <?}?>                            
                            <a href="logout.php" >Salir</a><!-- title="<?=session_id();?>" -->
                        </div>
                        </span>
                        <span id="nom_clien"><?=$_SESSION['nombre_usuario'];?></span>
                    </li>
                </li>
                <?}?>
            </ul>

            <ul class="ul-carrito"> 
                <li>
                    <a href="micarrito.php">
                        <i class="material-icons icono_barra">shopping_cart</i>
                    </a>

                    <a href="micarrito.php" style="text-align: center;"><span id="cant_carrito"><?consultar_cant_carrito();?></span></a>                
                </li>
            </ul> 
        </nav>

<!--         <figure id="logo" class="contenedor-interno">
            <a href="<?=$index_url?>" class="logo"><img src="img/logo.png"></a>
            <span id="logo-texto">Sentite bien asesorado</span>
        </figure> -->
        <?
        $link=$index_url."?agru_1=";
        ?>
        <div id="menu">
            <div class="contenedor-interno flex-menu">
                <nav id="botonera-texto"> 

                    <ul>
                        <li><a href="<?=$link.'39'?>"><img src="img/videoicon.png"> Video Vigilancia</a></li>
                        <li><a href="<?=$link.'54'?>"><img src="img/controlicon.png"> Control de Accesos</a></li>
                        <li><a href="<?=$link.'10'?>"><img src="img/wifiicon.png"> Conectividad</a></li>
                        <li><a href="<?=$link.'4'?>"><img src="img/storageicon.png"> NAS Storage</a></li>
                        <li><a href="<?=$link.'1'?>"><img src="img/accesicon.png"> Accesorios</a></li>
                        <li><a href="<?=$link.'3'?>"><img src="img/porteria.png"> Portería</a></li>
                    </ul>


                    <? 
                    if(isset($_GET['activo']))
                        $body=$_GET['activo'];
                    $class='class="activo"';?>
                </nav>
            </div>
        </div>
    </header>


<?if(strtolower($archivo_actual)=='index.php' || strtolower($archivo_actual)=='index2.php'){
    if($agru_1=='' && $agru_2=='' && $agru_3=='' && !isset($_GET['articulo'])){
        $no_mostrar_categorias=true;?>

        <style>
            .swiper-container {
                width: 100%;    
                /*padding-bottom: 20px;*/
            }
            .swiper-container img{
                max-width: 1920px;
                /* max-height: 300px; */
            }
            .swiper-slide {
                /* Center slide text vertically */
                display: flex;
                justify-content: center;
                align-items: center;
            }
        </style>


        <!-- swipe http://idangero.us/swiper -->
        <script src="js/swiper/dist/js/swiper.min.js"></script>
        <link rel="stylesheet" href="js/swiper/dist/css/swiper.css">

        <div class="banner" id="slider_banner">
            <div class="marquee-contenedor">
                <div class="swiper-container">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        <?
                        $sql="eco_sliders_consul";
                        $result = sqlsrv_query($conn,$sql);
                        while ( $row = sqlsrv_fetch_array($result)){?>
                            <div class="swiper-slide"><img src="<?=$row['archivo']?>" width="100%"></div>
                        <?}?>
                    </div>
                    <!-- If we need pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>

        <script>

            //esta linea tiene que estar en el document.ready
            //$('.swiper-slide a').click(function() { window.location.href = $(this).attr("href"); });

            var slider_banner = new Swiper('#slider_banner .swiper-container', {
                loop: 'true',
                slidesPerView: '1', // original auto
                spaceBetween: 0, //original 30 es un margin entre sliders
                centeredSlides: true,
                autoplay: 3500,
                autoplayDisableOnInteraction: false,
                paginationClickable: true
            });
        </script>

        <div id="menu-buscador">
            <nav id="botonera-iconos">
                <div class="buscador">
                    <i class="material-icons lupa" id="btn-buscar">search</i>
                    <input type="text" id="busqueda" placeholder="Buscar por modelo, código o descripción" class="input-rojo">
                </div>
            </nav> 
        </div> 

        <div id="logos">
            <h1>Productos Destacados</h1>
        </div> 


    <?}
}?>

<div class="contenedor">