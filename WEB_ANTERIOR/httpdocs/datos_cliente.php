<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
header("Content-Type: text/plain; charset=ISO-8859-1");
if (comprobar_sesson()==false){
    logout();
    header('Location: index.php?mje_tipo=3');
    exit(); 
}

?>
<div class="contenedor">
<script type="text/javascript">
$(document).ready(function() {
    $( "#btn-cerrar-datos").click(function() {
          $.fancybox.close();
    });

    $("select").change(function() {
          if ($(this).val()=="")
            $(this).css('color','grey');
          else
            $(this).css('color','black');
    });


    $( "#btn-guardar-datos").click(function() {
        $.post("guardar_cliente.php?tipo=M", $("#guardar_cliente").serialize() ,function(data){
            var resultado;
            resultado=data.split('^');

            if(resultado[0]=='OK'){
                $(".mje-result").fadeTo(200,0.1,function(){
                    $("#nom_clien", window.parent.document).html($("#razon").val());

                    if(resultado[1]=='M'){
                        var mje='Los datos se han guardado correctamente.';
                    }
                    if(resultado[1]=='MM'){
                        var mje='Los datos se han guardado correctamente.<br>Debido al cambio de mail debe activar su usuario desde el mail que le hemos enviado. ';
                    }
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
<form id="guardar_cliente">
        <?
        $sql="eco_clientes_consul ";
        $sql.="@usuario_web='".$_SESSION['usuario']."'";

        $result = sqlsrv_query($conn,$sql);
        $row_cliente=sqlsrv_fetch_array($result);
        ?>

        <h1>Mis Datos</h1>
        <label for="razon">Nombre y Apellido</label>
        <input type="text" class="input-rojo" name="razon" id="razon" value="<?=$row_cliente['razon']?>" maxlength="60">
        <label for="telefono">Teléfono</label>
        <input type="tel" class="input-rojo" name="telefono" value="<?=$row_cliente['telefono']?>" maxlength="35">
        <label for="iva">Iva</label>
        <select class="select-rojo" name="iva">
            <option value="">Categoría Iva:</option>
            <?$sql="eco_cate_iva_consul";
            $result = sqlsrv_query($conn,$sql);
            while($row=sqlsrv_fetch_array($result)){
                if($row['codigo']==$row_cliente['iva'])
                    echo '<option value="'.$row['codigo'].'" selected >'.$row['descrip'].'</option>';   
                else
                    echo '<option value="'.$row['codigo'].'" >'.$row['descrip'].'</option>';   
            }?>
        </select>
<!--         <label for="agru1">Tipo Cliente</label>
        <select class="select-rojo">
            <option value="<?=$row_cliente['agru_1']?>" selected><?=$row_cliente['descrip_agru1']?></option>
        </select>
        <label for="agru2">Profesión</label>
        <select class="select-rojo" name="agru2">
            <option value="">Seleccione su profesión:</option>
            <?$sql="eco_agrup_clientes_consul 2";
            $result = sqlsrv_query($conn,$sql);
            while($row=sqlsrv_fetch_array($result)){
                if($row['CODI_AGRU']==$row_cliente['agru_2'])
                    echo '<option value="'.$row['CODI_AGRU'].'" selected >'.$row['DESCRIP_AGRU'].'</option>';   
                else
                    echo '<option value="'.$row['CODI_AGRU'].'" >'.$row['DESCRIP_AGRU'].'</option>';    
            }?>
        </select> -->
        <label for="cuit">DNI/CUIT</label>
        <input type="tel" class="input-rojo" name="cuit" value="<?=$row_cliente['cuit']?>" maxlength="14">
        <label for="domicilio">Dirección</label>
        <input type="text" class="input-rojo" name="domicilio" value="<?=$row_cliente['domicilio']?>" maxlength="40">
        <label for="localidad">Localidad</label>
        <input type="text" class="input-rojo" name="localidad" value="<?=$row_cliente['localidad']?>" maxlength="30">
        <label for="cp">Cod. Postal</label>
        <input type="text" class="input-rojo" name="cp" value="<?=$row_cliente['cp']?>" maxlength="15">
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
        <label for="mail">Mail</label>
        <input type="email" class="input-rojo" name="mail" value="<?=$row_cliente['mail']?>" maxlength="150">

        <div class="mje-result"></div>

        <div style="margin-top: 25px;">
            <input type="button" class="btn-rojo" value="Guardar" id="btn-guardar-datos" style="width: 100px;">
            <input type="button" class="btn-rojo" value="Cerrar" id="btn-cerrar-datos" style="width: 100px;">
        </div>
        
</form>
    </article>
</div>