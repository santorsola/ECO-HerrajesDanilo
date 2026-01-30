<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
header("Content-Type: text/html; charset=ISO-8859-1");
?>
<div class="contenedor">

<script type="text/javascript">
$(document).ready(function() {
    $( "#btn-cancelar-registro").click(function() {
          $.fancybox.close();
    });
/*
    $("select").change(function() {
          if ($(this).val()=="")
            $(this).css('color','grey');
          else
            $(this).css('color','black');
    });*/


    $( "#btn-confirmar-registro").click(function() {
        $.post("guardar_cliente.php?tipo=R", $("#guardar_cliente").serialize() ,function(data){
            var resultado;
            resultado=data.split('^');

            if(resultado[0]=='OK'){
                $(".mje-result").fadeTo(200,0.1,function(){
                    if(resultado[1]=='R'){
                        var mje='Los datos se han guardado correctamente.<br>Su usuario ya esta Activado, puede ingresar al sistema.';
                    }
                    if(resultado[1]=='E'){
                        var mje='Los datos se han guardado correctamente.<br>Aguarde nuestro mail de confirmación de activación de usuario para poder utilizar el sitio.';
                    }
                    $(this).html(mje).fadeTo(500,1);
                    $( "#btn-confirmar-registro").attr("disabled","disabled");
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
<form id="guardar_cliente">
        <h1>Registrarse</h1>
        <input type="text" class="input-rojo" placeholder="Nombre y Apellido" name="razon" maxlength="60">
        <input type="tel" class="input-rojo" placeholder="Teléfono" name="telefono" maxlength="35">
        <select class="select-rojo" name="iva">
            <option value="">Seleccione su categoria de IVA:</option>
            <?$sql="eco_cate_iva_consul";
            $result = sqlsrv_query($conn,$sql);
            while($row=sqlsrv_fetch_array($result)){
                echo '<option value="'.$row['codigo'].'" >'.$row['descrip'].'</option>';   
            }?>
        </select>
<!--         <select class="select-rojo" name="agru1">
            <option value="">Seleccione el tipo de cliente:</option>
            <?$sql="eco_agrup_clientes_consul 1";
            $result = sqlsrv_query($conn,$sql);
            while($row=sqlsrv_fetch_array($result)){
                echo '<option value="'.$row['CODI_AGRU'].'" >'.$row['DESCRIP_AGRU'].'</option>';   
            }?>
        </select> 
        <select class="select-rojo" name="agru2">
            <option value="">Seleccione su profesión:</option>
            <?$sql="eco_agrup_clientes_consul 2";
            $result = sqlsrv_query($conn,$sql);
            while($row=sqlsrv_fetch_array($result)){
                echo '<option value="'.$row['CODI_AGRU'].'" >'.$row['DESCRIP_AGRU'].'</option>';   
            }?>
        </select>-->
        <input type="tel" class="input-rojo" placeholder="DNI/CUIT" name="cuit" maxlength="14">
        <input type="text" class="input-rojo" placeholder="Dirección" name="domicilio" maxlength="40">
        <input type="text" class="input-rojo" placeholder="Localidad" name="localidad" maxlength="30">
        <input type="text" class="input-rojo" placeholder="Cod. Postal" name="cp" maxlength="15">
        <select class="select-rojo" name="provincia">
            <option value="">Seleccione la provincia:</option>
            <?$sql="eco_provincias_consul";
            $result = sqlsrv_query($conn,$sql);
            while($row=sqlsrv_fetch_array($result)){
                echo '<option value="'.$row['codi'].'" >'.$row['nombre'].'</option>';   
            }?>
        </select>
        <input type="email" class="input-rojo" placeholder="Ingrese su mail" name="mail" maxlength="150">
        <!-- <input type="text" class="input-rojo" placeholder="Ingrese su usuario" name="usuario"> -->
        <input type="password" class="input-rojo" placeholder="Ingrese una contraseña" name="pass" maxlength="30">
        <input type="password" class="input-rojo" placeholder="Repita la contraseña" name="repetida" maxlength="30">
        
        <div class="mje-result"></div>

        <div style="margin-top: 25px;">
            <input type="button" class="btn-rojo" value="Confirmar" id="btn-confirmar-registro" style="width: 45%; max-width: 100px;">
            <input type="button" class="btn-rojo" value="Cerrar" id="btn-cancelar-registro" style="width: 45%; max-width: 100px;">
        </div>
        
</form>
    </article>
</div>