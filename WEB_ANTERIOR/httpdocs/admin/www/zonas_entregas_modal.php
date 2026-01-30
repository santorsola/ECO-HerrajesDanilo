<?
include "../funciones/conexion.php";
include "../funciones/funciones_generales.php";
 
if (comprobar_sesson()==false){
  logout();
  header('Location: signin.php?error=2');
  exit(); 
}    

$id_zona=$_GET['id_zona'];
$nuevo=$_GET['nuevo'];
?>

<link href="bootstrap/css/datepicker/bootstrap-datepicker3.css" rel="stylesheet">
<script src="bootstrap/js/datepicker/bootstrap-datepicker.min.js"></script>
<script src="bootstrap/js/datepicker/bootstrap-datepicker.es.min.js"></script>

<script src="bootstrap/js/selectpicker/bootstrap-select.min.js"></script>
<link href="bootstrap/css/selectpicker/bootstrap-select.min.css" rel="stylesheet">

<script>
    $(document).ready(function()
    { 
       $('[data-toggle="tooltip"]').tooltip();
        // http://bootstrap-datepicker.readthedocs.org/en/latest/
        $('.input-daterange').datepicker({
            clearBtn: true,
            language: "es",
            orientation: "top left",
            multidate: false,
            todayHighlight: true
        });
        $('.selectpicker').selectpicker({
              style: 'btn-default btn-sm' 
          });

        $('#error_modal').css('display', 'none');
    }); 
 
 



    $("#modal_guardar").submit(function(){

        /*http://stackoverflow.com/questions/10899384/uploading-both-data-and-files-in-one-form-using-ajax*/
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "guardar_zona_entrega.php",
            type: 'POST',
            data: formData,
            async: true,

            beforeSend: function () {
                $('#loading').html('<img style="margin-left:10px;" src="img/ajax-loader.gif" />');
            },
            success: function (data) {
                if(data==1){
                 
                    $('#error_modal').css('display', 'none');

                    var submitBtn = document.getElementById('btn_buscar');
                    if(submitBtn){
                        submitBtn.click();
                    }

                    BootstrapDialog.closeAll();
                }
                else{
                    $("#mje_info_modal").fadeTo(200,0.1,function(){
                        $('#error_modal').css('display', 'block');
                        $(this).html(data).fadeTo(500,1);
                    });     
                }
                
                $('#loading').html("");
            }, 
            cache: false,
            contentType: false,
            processData: false
        });
 

        return false;
    });


    function cerrar(){
      BootstrapDialog.closeAll();
    };
	
</script>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<div class="well bs-component">
    <div class="container">
        <form id="modal_guardar" name="modal_guardar" enctype="multipart/form-data" method="POST" action="#">
		<?

    $sql="eco_zonas_abm_consul null,";
    $sql.=$id_zona!=''? $id_zona."," : "null,";
    $sql.=$nuevo!=''? $nuevo : "null";

    $result = sqlsrv_query($conn,$sql);
    $row = sqlsrv_fetch_array($result)
      
     ?>
       <input type="hidden" name="id_zona" id="id_zona" value="<?=$row['id_zona']?>">
       
		<div class="col-lg-10 form-group">
                <div class="row">
                    <div class="col-lg-10">
                        <label class="col-lg-2">Nombre zona</label>
                        <div class="col-lg-8">
                            <input id="nombre" name="nombre" type="text" maxlength="100" class="form-control input-sm" value="<?=$row['nombre']?>"/>
                        </div>
                    </div>
                </div>    
        </div>

		<div class="col-lg-10 form-group">
                <div class="row">
                    <div class="col-lg-10">
                        <label class="col-lg-2">C&oacute;d. Articulo</label>
                        <div class="col-lg-3">
                            <input id="cod_articulo_envio" name="cod_articulo_envio" type="text" maxlength="30"  class="form-control input-sm" value="<?=$row['cod_articulo_envio']?>"/>
                        </div>
                    </div>
                </div>    
        </div>

		<div class="col-lg-10 form-group">
                <div class="row">
                    <div class="col-lg-10">
                        <label class="col-lg-2">Precio envio</label>
                        <div class="col-lg-3">
                        <input id="precio_envio" name="precio_envio" type="number" maxlength="9"  class="form-control input-sm" value="<?=(int)$row['precio_envio']?>"/>
                        </div>
                    </div>
                </div>    
        </div>

        <div class="col-lg-10 form-group">
                <div class="row">
                    <div class="col-lg-10">
                        <label class="col-lg-2">Bonificaci&oacute;n</label>
                        <div class="col-lg-3">
                        <input id="bonificado_desde" name="bonificado_desde" type="number" maxlength="9" class="form-control input-sm" value="<?=(int)$row['bonificado_desde']?>"/>
                        </div>
                    </div>
                </div>    
        </div>

        <div class="col-lg-10 form-group">
                <div class="row">
                    <div class="col-lg-10">
                        <label class="col-lg-2">Orden</label>
                        <div class="col-lg-2">
                        <input id="orden" name="orden" type="number" maxlength="4"  class="form-control input-sm" value="<?=$row['orden']?>"/>
                        </div>
                    </div>
                </div>    
        </div>

        <div class="col-lg-10 form-group">
                <div class="row">
                    <div class="col-lg-10">
                        <label class="col-lg-2">Observaci&oacute;n 1</label>
                        <div class="col-lg-8">
                        <textarea id="tiempo" name="tiempo" type="text" maxlength="255" rows="4" class="form-control input-sm"><?=$row['tiempo']?></textarea>

                        </div>
                    </div>
                </div>    
        </div>

        <div class="col-lg-10 form-group">
                <div class="row">
                    <div class="col-lg-10">
                        <label class="col-lg-2">Observaci&oacute;n 2</label>
                        <div class="col-lg-8">
                        <textarea id="obser2" name="obser2" type="text" maxlength="2000" rows="4" class="form-control input-sm"><?=$row['obser2']?></textarea>
                        </div>
                    </div>
                </div>    
        </div>

	<div class="row">
                <div class="col-lg-3 col-lg-offset-6 form-group">
                    <div id="loading"></div>
                    <div class="col-lg-1 col-lg-offset-1">
                        <button id="modal_btn_guardar" type="submit" class="btn btn-primary btn-sm ">Guardar</button>
                    </div>
                    <div class="col-lg-1  col-lg-offset-2">
                        <button type="button" onclick="cerrar()" class="btn btn-primary btn-sm ">Cerrar</button>
                    </div>
                </div>
            </div>
            <div class="row" id="error_modal">
                <div class="col-lg-8 form-group">
                    <div  class="alert alert-danger">
                        <div id="mje_info_modal"></div>
                    </div>
                </div>
            </div>
	
        </form>
    </div>
</div>
