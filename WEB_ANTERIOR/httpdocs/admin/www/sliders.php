<?

include "header.php";


?>



<link href="bootstrap/css/general.css" rel="stylesheet">

<script src="https://cdn.datatables.net/plug-ins/1.10.13/sorting/date-eu.js"></script>

<link href="bootstrap/css/datepicker/bootstrap-datepicker3.css" rel="stylesheet">
<script src="bootstrap/js/datepicker/bootstrap-datepicker.min.js"></script>
<script src="bootstrap/js/datepicker/bootstrap-datepicker.es.min.js"></script>

<script src="bootstrap/js/selectpicker/bootstrap-select.min.js"></script>
<link href="bootstrap/css/selectpicker/bootstrap-select.min.css" rel="stylesheet">


<script src="bootstrap/js/modal/bootstrap-dialog.js"></script>
<link href="bootstrap/css/modal/bootstrap-dialog.css" rel="stylesheet">

<script>
var table;
 $(document).ready(function() {

    // http://bootstrap-datepicker.readthedocs.org/en/latest/
    
    $('[data-toggle="tooltip"]').tooltip();


    $('.selectpicker').selectpicker({
          style: 'btn-default btn-sm'
      });




    table=$('#tbl').DataTable(
            {
              "columnDefs": [
                { "width": "1%", "targets": 0},
                { "width": "60%", "targets": 1},
                { "width": "1%", "targets": 2},
                { "width": "1%", "targets": 3},
                { "width": "1%", "targets": 4}
              ],
            dom:'<"arriba_der"f><"arriba_izq"l><"clear">rt<"abajo_izq"i><"clear">',
            "paging":   false,
            "info":   false,
            "ordering": false
            } );


    $('#cuadro_error').css('display', 'none');
    $('#cuadro_ok').css('display', 'none');

    $("#frmguardar").submit(function()
    {


    /*http://stackoverflow.com/questions/10899384/uploading-both-data-and-files-in-one-form-using-ajax*/
    var formData = new FormData($(this)[0]);

    $.ajax({
        url: "guardar_slider.php",
        type: 'POST',
        data: formData,
        async: true,

        beforeSend: function () {
            $('#loading').html('<img style="margin-left:10px;" src="img/ajax-loader.gif" />');
        },
        success: function (data) {

            comprobar_sesion_cerrada(data);

            var resultado;
            resultado=data.split('^');

            if(resultado[0]=='ok'){
                $('#cuadro_error').css('display', 'none');

                $("#mje_info_ok").fadeTo(200,0.1,function(){
                    $('#cuadro_ok').css('display', 'block');
                    $(this).html('El archivo se grabo correctamente.').fadeTo(500,1).delay(2000).fadeTo(500,1,function(){
                        $('#cuadro_ok').css('display', 'none');
                    });
                });

                document.location='sliders.php';
            }
            else{
                $('#cuadro_ok').css('display', 'none');
                $("#mje_info").fadeTo(200,0.1,function(){
                    $('#cuadro_error').css('display', 'block');
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

    $('#archivo').change(function(){
         $('#nombre_archivo').val($(this).val().replace("C:\\fakepath\\", ""));
    });

    $('#buscar_archivo').click(function(){
         $('#archivo').click();
    });

});


function CambiarOrden(obj,secuen,accion) {
        $.get( "cambiar_orden_slider.php",{ secuen: secuen, accion: accion }, function( data ) {
            document.location='sliders.php';
        });
}

function BorrarArchivo(obj,secuen) {
    BootstrapDialog.confirm({
        title: 'Administración',
        message: '¿Esta seguro de eliminar el archivo?',
        type: BootstrapDialog.TYPE_PRIMARY, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
        closable: true, // <-- Default value is false
        draggable: true, // <-- Default value is false
        btnCancelLabel: 'No', // <-- Default value is 'Cancel',
        btnOKLabel: 'Si', // <-- Default value is 'OK',
        callback: function(result) {
            if(result) {
               $.post("eliminar_slider.php", {secuen: secuen} ,function(data) {
                    comprobar_sesion_cerrada(data);
                    if(data=='ok'){
                        document.location='sliders.php';
                    }else{
                        $('#modal_ok').css('display', 'none');
                        $("#mje_info").fadeTo(200,0.1,function(){
                            $('#modal_error').css('display', 'block');
                            $(this).html(data).fadeTo(500,1);
                        });  
                    }
                });
            }  
        }
    });
}



</script>


<div class="container"> 
<div class="contenedor"> 


<h2>Configuración de Sliders</h2>

<div class="row">
<div class="col-lg-12">
<div class="well bs-component">




<form class="form-horizontal" id="frmguardar" enctype="multipart/form-data" method="POST" action="#">
<input name="id" type="hidden" value="<?=$row['id']?>" />
<fieldset> 


<div class="form-group">
    <div class="row">
        <div class="col-sm-12">
            <label class="col-lg-2">Archivo</label>
            <div class="col-lg-7">
                <div class="input-group">
                  <input readonly type="text" id="nombre_archivo" name="nombre_archivo"  class="form-control input-sm" placeholder="Buscar archivo...">
                  <span class="input-group-btn">
                    <button class="btn btn-primary btn-sm" type="button" id="buscar_archivo">
                        <span class="glyphicon glyphicon-folder-open"></span>
                    </button>
                  </span>
                </div><!-- /input-group -->
            </div>
            <input name="archivo" id="archivo" type="file" class="file" style="visibility:hidden; height: 0px;"  accept=".doc,.docx,.xls,.xlsx,.pdf,.png,.gif,.jpg,.jpeg"/>
        </div>
    </div>
</div> 

<div class="form-group">
    <div class="row">
        <div class="col-sm-12">
            <label class="col-lg-2">Link</label>
            <div class="col-lg-7">
                 <input type="text" id="link" name="link"  class="form-control input-sm" >
            </div>
        </div>
    </div>
</div> 

<div class="form-group">
    <div class="row">
        <div class="col-sm-12">

            <label class="col-lg-2">Orden</label>

            <div class="col-lg-2">
                <select id="selectSeccion" name="orden" class="selectpicker float-left ancho-auto">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select> 
            </div>
            <label class="col-lg-7">Se recomienda un ancho de 1920px y un alto entre 300 px y 500 px</label>
        </div>
    </div>
</div>  

<div class="form-group">
    <div class="row" id="cuadro_error" style="margin-left: 15px;">
        <div class="col-xs-12 form-group">
            <div  class="alert alert-danger">
                <div id="mje_info"></div>
            </div>
        </div>
    </div>

    <div class="row" id="cuadro_ok" style="margin-left: 15px;">
        <div class="col-xs-12 form-group">
            <div class="alert alert-success">
                <div id="mje_info_ok"></div>
            </div>
        </div>
    </div>

</div> 

    <button id="modal_btn_guardar" type="submit" class="btn btn-primary btn-sm col-xs-4 col-sm-3 col-md-2 col-lg-2">Guardar</button>
    <div id="loading"></div>

</div>
</fieldset>
</form>


</div>
</div>
</div>


<div class="clear"></div>


<table id="tbl" class="display" width="100%" cellspacing="0">

<thead>

<tr class="info">
<th>Orden</th>
<th>Imagen</th>
<th class="no-sort"></th>
<th class="no-sort"></th>
<th class="no-sort"></th>
</tr>

</thead>


<tbody>
  

<?

$sql="eco_sliders_consul";

$result = sqlsrv_query($conn,$sql);
$i=1;
while ( $row = sqlsrv_fetch_array($result)){
?>

    <tr>
    <td><h4 style="text-align:center">    <?=$row['orden']?></h4>    </td>
    <td>
    <h5>Link configurado: <a href="<?=$row['link']?>"><?=$row['link']?></a></h5>
    <h5><?=$row['archivo']?></h5><img src="../../<?=$row['archivo']?>" style="width: 800px;">

    </td>
    
    <!-- <td><a href="javascript:;" title="Mostrar mas detalles" onclick="mostrar_detalle('xxx');"><span class="glyphicon glyphicon-search"></span></a></td> -->
    <td>
        <a href="javascript:;" 
        data-toggle="tooltip" data-placement="bottom" title="Subir Orden" onClick="CambiarOrden(this,'<?=$row['secuen']?>','SUBIR')">
        <span class="glyphicon glyphicon-arrow-up"></span>
        </a>
    </td>
    <td>
        <a href="javascript:;"
        data-toggle="tooltip" data-placement="bottom" title="Bajar Orden" onClick="CambiarOrden(this,'<?=$row['secuen']?>','BAJAR')">
        <span class="glyphicon glyphicon-arrow-down"></span>
        </a>
    </td>
    <td>
        <a href="javascript:;" data-toggle="tooltip" data-placement="bottom" title="Eliminar" onClick="BorrarArchivo(this,'<?=$row['secuen']?>')">
        <span class="glyphicon glyphicon-remove"></span>
        </a>
    </td>
    </tr>
<?}?>

</tbody>
</table>         

 

<script type="text/javascript">
    // For demo to fit into DataTables site builder...
    $('#tbl')
        .removeClass( 'display' )
        .addClass('table table-striped table-hover');
</script>

</div>
</div>

<?
include "footer.php";
?>   