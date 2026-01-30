<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
$form=$_GET['form'];
$mje_tipo=$_GET['mje_tipo'];

$ocultar_registrar=consultar_configuracion('OCULTAR_REGISTRAR');
header("Content-Type: text/plain; charset=ISO-8859-1");
?>

<script type="text/javascript">
$(document).ready(function() {
    $("#btn-registro").fancybox({
        'transitionIn'  :   'elastic',
        'transitionOut' :   'fade',
        'speedIn'       :   600, 
        'speedOut'      :   200, 
        'overlayShow'   :   false,
        'titlePosition' :   'inside',
        'href'          :   'registarse.php',
        'type'          :   'ajax',
        'wrapCSS'       :   'mifancy',
        'autoSize'      :   true,
        'autoDimensions':   true


    });

    $('#olvido_pass').click(function() {
        if($("#usuario").val()==''){
            $( ".mje-result" ).html('Debe completar el usuario.');
        }else{
            document.location='olvido_pass.php?usuario='+$('#usuario').val();      
        }
    });

    $( "#btn-ingresar").click(function() {
        $.post( "login.php",{ usuario: $("#usuario").val(), pass: $("#pass").val() }, function( data ) {
          //$( ".result" ).html( data );

            if(data=='OK'){

                <?
                switch ($form) {
                    case 'home':
                        if($mje_tipo=='1')
                            echo 'document.location="index.php";';
                        else
                            echo 'document.location="'.$_SESSION['archivo_actual'].$_SESSION['filtros'].'";';
                        
                        break;
                    case 'carrito':?>
                        window.parent.document.location="micarrito.php";<?
                        break;
                    default:?>
                        document.location="index.php";<?
                        break;
                }
                ?>
                return;
            }
            $( ".mje-result" ).html(data);
        });
    });
    // pasar datos a la pantalla trasera ambas son correctas
    // $( "#btn-registro").click(function() {
    //     //$(".buscador").val("hola");
    //     //$(".buscador", window.parent.document).val("juancito");
    // });
});
</script>
   
    <div id="recarga">
    <div class="contenedor">
        <article class="form-registro">
            <h1>Ingresar</h1>
            <input type="email" class="input-rojo" placeholder="Ingrese su mail" name="usuario" id="usuario" tabindex="1" maxlength="150">
            <input type="password" class="input-rojo" placeholder="Ingrese una contraseña" name="pass" id="pass" tabindex="2" maxlength="30">
            
            <?if ($ocultar_registrar=="N"){?>
                <a href="javascript:;" class="olvido" id="olvido_pass">Olvido su contraseña</a>
            <?}?>

            <div style="margin-top: 25px;">
                <input type="button" class="btn-rojo" value="Ingresar" id="btn-ingresar" style="width: 45%; max-width: 100px;">
                <?if ($ocultar_registrar=="N"){?>
                    <input type="button" class="btn-rojo" value="Registarse" id="btn-registro" style="width: 49%; max-width: 100px;">
                <?}?>
            </div>
            <div class="mje-result">
                <?
                switch ($mje_tipo) {
                    case '1':
                        echo "El usuario ya se encuentra activo, puede iniciar sesión.";
                        break;
                    case '2':
                        echo "Error al activar el usuario.";
                        break;
                    case '3':
                        echo "Su sesión ha caducado.";
                        break;
                    case '4':
                        echo "Usuario no válido del sistema.";
                        break;
                    case '5':
                        echo "Le hemos enviado un mail con su contraseña.";
                        break;
                }
                ?>
            </div>
        </article>
    </div>
    </div>