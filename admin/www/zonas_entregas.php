<?
include "header.php";


ini_set('max_execution_time', 300);

$nombre=$_GET['nombre'];
$id_zona=$_GET['id_zona'];
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
var table; $(document).ready(function() {
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

        $('#cuadro_error').css('display', 'none');
        $('#cuadro_ok').css('display', 'none');

 
        var table = $('#tbl').DataTable( {
                  "columnDefs": [
                    { "width": "10%","type": "date-uk", "targets": 0}, //nombre zona
                    { "width": "10%", "targets": 1}, //codigo articulo
                    { "width": "10%", "targets": 2}, //bonificado desde
                    { "width": "10%", "targets": 3}, //codigo articulo
                    { "width": "5%", "targets": 4}, //orden
                    { "width": "25%", "targets": 5}, //obs 1
                    { "width": "25%", "targets": 6}, //obs 2
                    { "width": "5%", "targets": 7} //opciones
                  ]} );
       
  } );


  function modalZona(id_zona,nuevo) {
    if(id_zona==null)
        titulo="Nueva zona de entrega";
      else titulo = "Edicion de zona de entrega";
    //http://nakupanda.github.io/bootstrap3-dialog/
    BootstrapDialog.show({
        message: $('<div id="Modal"></div>').load('zonas_entregas_modal.php?id_zona='+id_zona+'&nuevo='+nuevo, function(data) {
                    comprobar_sesion_cerrada(data);
                    }),
        title: titulo,
        size: 'size-wide',
        closable: 'true'
    });
}

function bajaZona(id_zona){
    BootstrapDialog.show({
            title: 'Eliminar Zona de Entrega',
            message: '&iquest;Esta seguro de eliminar la zona de entrega seleccionada?',
            buttons: [{
                label: 'Si',
                cssClass: 'btn-primary',
                autospin: true,
                action: function(dialogRef){
                    dialogRef.enableButtons(false);
                    dialogRef.setClosable(false);
                    dialogRef.getModalBody().html('Eliminando...');
                    setTimeout(function(){
                        dialogRef.close();
                    }, 2000);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "eliminar_zona_entrega.php",
                        data: {id_zona:id_zona},		 
                        success: function(data){
                            if( !data.success ){
                                //Como el JSON trae un mensaje, lo puedes imprimir
                                $("#modal_info").fadeTo(200,0.1,function(){
                                    $('#modal_error').css('display', 'block');
                                    $(this).html(data.message).fadeTo(500,1);
                                });						
                            } else{
                                $("#btn_buscar").trigger("click");
                                }
                            }   
                    });
                }
            }, {
                label: 'No',
                action: function(dialogRef){
                    dialogRef.close();
                }
            }]
        });
}
</script>


<div class="container"> 
<div class="contenedor"> 


<h2>Zonas de entrega</h2>


<form class="form-horizontal">
<div class="well bs-component">
<div class="col-lg-12">
<div class="col-lg-10">

<div class="row">
<fieldset>
<div class="form-group">
    <label class="col-lg-1">Nombre</label>
    <div class="col-lg-8 text-right">
        <div class="input">
          <input type="text" id="nombre" name="nombre"  class="form-control input-sm" placeholder="Buscar Zona..." value=""> 
        </div><!-- /input-group -->
    </div>
</div>
</fieldset>
</div>

</div><!-- fin 10 -->

<div class="col-lg-2">
    <div class="row">
        <fieldset>
            <div class="form-group">
                <button type="submit" id="btn_buscar" class="btn btn-primary btn-sm col-lg-8 col-lg-offset-3">Buscar</button>
            </div>
        </fieldset>

    </div>

    <div class="row">
        <fieldset>
            <div class="form-group">
                <button onclick="modalZona(null,1)" type="button" class="btn btn-primary btn-sm col-lg-8 col-lg-offset-3" id="nuevo">Nuevo</button>
            </div>
        </fieldset>
    </div>
</div>
<div class="row" id="cuadro_error">
            <div class="col-lg-8 form-group">
                <div  class="alert alert-danger">
                    <div id="mje_info"></div>
                </div>
            </div>
        </div>

        <div class="row" id="cuadro_ok">
            <div class="col-lg-8 form-group">
                <div class="alert alert-success">
                    <div id="mje_info_ok"></div>
                </div>
            </div>
        </div>


</div><!-- fin 12 -->

<div class="clear"></div>
</div>
</form>


<table id="tbl" class="display" width="100%" cellspacing="0">
<thead>
    <tr class="info">
        <th>Zona</th>
        <th>Cod. Articulo</th>
        <th>Bonificado desde</th> 
        <th>Precio envio</th>
        <th>Orden</th>
        <th>Obser. 1</th>
        <th>Obser. 2</th> 
        <th>Editar</th> 
    </tr>
</thead>
 
<tbody>     
    <?
    $sql="eco_zonas_abm_consul ";
    $sql.=$nombre!=''? "'".$nombre."'," : "null,";
    $sql.=$id_zona!=''? $id_zona : "null";
    $sql.=",0"; // PARA CONSULTAS DE REGISTROS EXISTENTES
   
    $result = sqlsrv_query($conn,$sql);

    while ( $row = sqlsrv_fetch_array($result)){ 
    ?>
        <tr>
            <td><?=$row['nombre']?></td>    
            <td><?=$row['cod_articulo_envio']?></td>
            <td><?=(int)$row['bonificado_desde']?></td>
            <td><?=(int)$row['precio_envio']?></td>
            <td><?=$row['orden']?></td>
            <td><?=$row['tiempo']?></td>
            <td><?=$row['obser2']?></td>
            <td>
            <a onclick="modalZona(<?=$row['id_zona']?>,0)" data-toggle="tooltip" data-placement="bottom" title="Editar zona">
    					<span class="glyphicon glyphicon-pencil" style="color:#FB0417;"></span>								
                    </a>
                    &nbsp; &nbsp; &nbsp;
            <a onclick="bajaZona(<?=$row['id_zona']?>)" data-toggle="tooltip" data-placement="bottom" title="Borrar zona">
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