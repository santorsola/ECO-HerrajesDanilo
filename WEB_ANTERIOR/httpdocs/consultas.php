<?header("Content-Type: text/plain; charset=ISO-8859-1");?>
<script type="text/javascript">
$(document).ready(function() {
    $( "#btn-cancelar").click(function() {
          $.fancybox.close();
    });

    $('#btn-enviar').click(function() {
        $.post("enviar_consulta.php", $("#consulta").serialize() ,function(data){
            if(data=='OK'){
                $(".mje-result").fadeTo(200,0.1,function(){
                    var mje='Su consulta ha sido enviada.';
                    $(this).html(mje).fadeTo(500,1);
                    $('#consulta').each (function(){
                        this.reset();
                    });
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

<div class="contenedor">
    <article class="form-registro">
        <form id="consulta">
            <h4>Envianos tu consulta</h4>
            <input type="text" class="input-rojo" placeholder="Nombre y Apellido" name="razon" tabindex="1" maxlength="100">
            <input type="email" class="input-rojo" placeholder="Teléfono" name="telefono" tabindex="2" maxlength="100">
            <input type="email" class="input-rojo" placeholder="Ingrese su mail" name="mail" tabindex="3" maxlength="100">
            <input type="text" class="input-rojo" placeholder="Asunto" name="asunto" tabindex="4" maxlength="200">
            <textarea class="input-rojo" name="cuerpo" rows="6" tabindex="5" maxlength="10000"></textarea>
            <div style="margin-top: 25px;">
                <input type="button" class="btn-rojo" value="Enviar" id="btn-enviar" style="width: 100px;">
                <input type="button" class="btn-rojo" value="Cancelar" id="btn-cancelar" style="width: 100px;">
            </div>
            <div class="mje-result"></div>
        </form>
    </article>
</div>