<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
$descrip_agru1=consultar_configuracion('AGRU1_DESCRIP');
$descrip_agru2=consultar_configuracion('AGRU2_DESCRIP');
$descrip_agru3=consultar_configuracion('AGRU3_DESCRIP'); 
?>

<script type="text/javascript">
$(document).ready(function() {
    $( "#btn-cancelar").click(function() {
          $.fancybox.close();
    });

    // http://api.jqueryui.com/datepicker/
    $( ".calendario" ).datepicker({
      dateFormat: "yy-mm-dd",
      dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ],
      dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
      dayNamesShort: [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ],
      monthNames: [ "Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre" ],
      monthNamesShort: [ "Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic" ]
    });

    $('#btn-descargar').click(function() {
        document.location="expor_xls_lista_precio.php?agru_1="+$("#cboAgru1").val()+
                        "&agru_2="+$("#cboAgru2").val()+"&agru_3="+$("#cboAgru3").val()+
                        "&fecha_desde="+$("#fecha_desde").val()+"&fecha_hasta="+$("#fecha_hasta").val();
    });


       //-----Para agrupaciones relacionadas----

        //paso las var de php al js
        var cboAgru1='';
        var cboAgru2='';
        var cboAgru3='';
        var usa_agru_rela='N'; //LOC TANYX


        if (usa_agru_rela=='S'){
            if (cboAgru1!='') {
                $('#cboAgru2').prop('disabled',false);
            }
            else {
                $('#cboAgru2').prop('disabled',true);
            }

            if (cboAgru2!='') {
                $('#cboAgru3').prop('disabled',false);
            }
            else {
                $('#cboAgru3').prop('disabled',true);
            }
        }


        $("#cboAgru1").change(function(){
            if (usa_agru_rela=='N')
                return;

            $('#cboAgru2').find('option').remove();
            
            if($("#cboAgru1").val()!=''){
                $.get("agrupaciones.php?num_agru=2&codi_agru="+$("#cboAgru1").val(), function( data ) {
                    $("#cboAgru2").html( data );
                    $('#cboAgru2').selectpicker('refresh');
                });
                $('#cboAgru2').prop('disabled',false);
            }else{
                $('#cboAgru2').append('<option value="" selected>Todos</option>');
                $('#cboAgru2').prop('disabled',true);
            }

    
            $('#cboAgru3').find('option').remove();
            $('#cboAgru3').append('<option value="" selected>Todos</option>');
            $('#cboAgru3').prop('disabled',true);
        });

        $("#cboAgru2").change(function(){
            if (usa_agru_rela=='N')
                return;

            $('#cboAgru3').find('option').remove();

            if($("#cboAgru2").val()!=''){
                $.get("agrupaciones.php?num_agru=3&codi_agru="+$("#cboAgru1").val()+"&codi_agru2="+$("#cboAgru2").val(), function( data ) {
                    $("#cboAgru3").html( data );
                });
                $('#cboAgru3').prop('disabled',false);
            }else{
                $('#cboAgru3').append('<option value="" selected>Todos</option>');
                $('#cboAgru3').prop('disabled',true);
            }

        });

        //-----FIN: Para agrupaciones relacionadas----

});
</script>

<div class="contenedor">
    <article class="form-registro">
        <form id="consulta">
             <h1>Descargar lista de precios</h1>
<!--            <label>Fec. Modificación desde</label>
            <input readonly type="text" class="input-rojo calendario" id="fecha_desde" tabindex="1" >
            <label>Fec. Modificación hasta</label>
            <input readonly type="text" class="input-rojo calendario" id="fecha_hasta" tabindex="1" > -->


            <label><?=$descrip_agru1?></label>
            <select id="cboAgru1" name="agru_1" class="select-rojo">
                <option value="">Todas</option>
                <?
                $sql="eco_agrupaciones_consul null,1";
                $result = sqlsrv_query($conn,$sql);
                while ($row = sqlsrv_fetch_array($result)) {?>
                    <option value="<?=$row['CODI_AGRU']?>"><?=$row['DESCRIP_AGRU']?></option>
                <?}?>
            </select>

            <label><?=$descrip_agru2?></label>
            <select id="cboAgru2" name="agru_2" class="select-rojo">
                <option value="">Todas</option>
                <?
                $sql="eco_agrupaciones_consul null,2";
                $sql.=",@usuario='".$_SESSION['usuario']."'";
                $result = sqlsrv_query($conn,$sql);
                while ($row = sqlsrv_fetch_array($result)) {?>
                    <option value="<?=$row['CODI_AGRU']?>"><?=$row['DESCRIP_AGRU']?></option>
                <?}?>
            </select>

            <div style="margin-top: 25px;">
                <input type="button" class="btn-rojo" value="Descargar" id="btn-descargar" style="width: 100px;">
                <input type="button" class="btn-rojo" value="Cancelar" id="btn-cancelar" style="width: 100px;">
            </div>
            <div class="mje-result"></div>
        </form>
    </article>
</div>