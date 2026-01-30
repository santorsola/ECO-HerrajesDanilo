<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
header("Content-Type: text/plain; charset=ISO-8859-1");
?>
<div class="contenedor">
<script type="text/javascript">
$(document).ready(function() {
    $( "#btn-cancelar-clave").click(function() {
          $.fancybox.close();
    });

    $("select").change(function() {
          if ($(this).val()=="")
            $(this).css('color','grey');
          else
            $(this).css('color','black');
    });


    $( "#btn-confirmar-clave").click(function() {
        $.post("guardar_clave.php", $("#guardar_clave").serialize() ,function(data){
            if(data=='OK'){
                $(".mje-result").fadeTo(200,0.1,function(){
                    var mje='La contraseña se cambio correctamente.';
                    $(this).html(mje).fadeTo(500,1);
                });
            }else{
                $(".mje-result").fadeTo(200,0.1,function(){
                    $(this).html(data).fadeTo(500,1);
                });
            }
        });
    });
});
</script>


    <article class="form-registro">
<form id="guardar_clave">
        <h1>Cambiar Contraseña</h1>
        <input type="password" class="input-rojo" placeholder="Ingrese su contraseña" name="actual" maxlength="30">
        <input type="password" class="input-rojo" placeholder="Ingrese la nueva contraseña" name="nueva" maxlength="30">
        <input type="password" class="input-rojo" placeholder="Repita la contraseña" name="repetida" maxlength="30">
        <div style="margin-top: 25px;">
            <input type="button" class="btn-rojo" value="Confirmar" id="btn-confirmar-clave" style="width: 100px;">
            <input type="button" class="btn-rojo" value="Cerrar" id="btn-cancelar-clave" style="width: 100px;">
        </div>
        <div class="mje-result"></div>
</form>
    </article>
</div>