<?

include "header.php";


$id=($_GET['id']==""?0:$_GET['id']);


$sql="eco_metatags_consul ".$id;
$result=sqlsrv_query($conn,$sql);
$row=sqlsrv_fetch_array($result);

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
                { "width": "10%", "targets": 0},
                { "width": "10%", "targets": 1},
                { "width": "10%", "targets": 2},
                { "width": "1%", "targets": 4},
                { "width": "1%", "targets": 5}
              ]
            } );




    $('#cuadro_error').css('display', 'none');
    $('#cuadro_ok').css('display', 'none');

    $("#frmguardar").submit(function()
    {
        $.post("guardar_tags.php", $("#frmguardar").serialize() ,function(data)
        {
        comprobar_sesion_cerrada(data);

        var resultado;
        resultado=data.split('^');


        if(resultado[0]=='ok')
        {
            $('#cuadro_error').css('display', 'none');
            $('#cuadro_advertencia').css('display', 'none');
            $("#mje_info_ok").fadeTo(200,0.1,function(){
                $('#cuadro_ok').css('display', 'block');
                $(this).html('El registro se guardo correctamente.').fadeTo(500,1).delay(800).fadeTo(500,1,function(){
                    $('#cuadro_ok').css('display', 'none');
                    document.location="tags.php";
                });
            });
        }

        if(resultado[0]!='ok')
        {
            $("#mje_info").fadeTo(200,0.1,function()
            { $('#cuadro_error').css('display', 'block');
              $(this).html(resultado[0]).fadeTo(500,1);
            });     
        }

                
        });
        return false; 
    });




  } );



function BorrarTag(obj,id) {
    BootstrapDialog.confirm({
        title: 'Panel',
        message: '¿Está seguro de eliminar el tag seleccionado?',
        type: BootstrapDialog.TYPE_PRIMARY, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
        closable: true, // <-- Default value is false
        draggable: true, // <-- Default value is false
        btnCancelLabel: 'No', // <-- Default value is 'Cancel',
        btnOKLabel: 'Si', // <-- Default value is 'OK',
        callback: function(result) {
            if(result) {
               $.post("eliminar_tag.php", {id: id} ,function(data) {
                    comprobar_sesion_cerrada(data);
                    if(data=='ok'){
                        fila=table.row( $(obj).parents('tr') ).index();
                        table.row(fila).remove().draw();
                    }else{
                        BootstrapDialog.alert({
                            title: 'Error al borrar el tag',
                            message: data,
                            type: BootstrapDialog.TYPE_DANGER, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
                            closable: true, // <-- Default value is false
                            draggable: true, // <-- Default value is false
                            buttonLabel: 'Aceptar'
                        });
                    }
                });
            }  
        }
    });
}


/*

function mostrar_detalle(codigo)
{
        //http://nakupanda.github.io/bootstrap3-dialog/
        BootstrapDialog.show({
            message: $('<div></div>').load('detalle_reparacion.php?recep_nume='+codigo),
            title: 'Mi reparación'
        });
}*/

 </script>


<div class="container"> 
<div class="contenedor"> 


<h2>Configuración de Tags</h2>

<div class="row">
<div class="col-lg-12">
<div class="well bs-component">




<form class="form-horizontal" id="frmguardar">
<input name="id" type="hidden" value="<?=$row['id']?>" />
<fieldset> 
<div class="form-group">
    <div class="row">
        <div class="col-sm-12">

            <label class="col-sm-1 col-xs-6">Seccion</label>

            <div class="col-sm-2 col-xs-6">
                <select id="selectSeccion" name="seccion" class="selectpicker float-left ancho-auto" data-live-search="true">
                    <option value="Todas" <?if ($row['seccion']=='Todas') echo 'selected'?> >Todas las Secciones</option>
                    <option value="Home" <?if ($row['seccion']=='Home') echo 'selected'?> >Home</option>
                    <option value="Area_Clientes" <?if ($row['seccion']=='Area_Clientes') echo 'selected'?> >Area Clientes</option>
                    <option value="Webinars" <?if ($row['seccion']=='Webinars') echo 'selected'?> >Webinars</option>
                </select>
            </div>
        </div>
    </div>
</div> 

<div class="form-group">
    <div class="row">
        <div class="col-sm-12">
            <label class="col-sm-1 col-xs-6">Tipo</label>

            <div class="col-sm-2 col-xs-6">
                <select id="selectTipo" name="tipo" class="selectpicker float-left ancho-auto" data-live-search="true">
                    <option value="name" <?if ($row['tipo']=='name') echo 'selected'?> >name</option>
                    <option value="property" <?if ($row['tipo']=='property') echo 'selected'?> >property</option>
                </select>
            </div>
            <label class="col-lg-1">Nombre</label>
            <div class="col-lg-5">
                <input name="nombre" type="text" class="form-control input-sm" value="<?=$row['nombre']?>" />
            </div>
        </div>
    </div>
</div> 

<div class="form-group">
    <div class="row">
        <div class="col-sm-12">
            <label class="col-lg-6">Content</label>
            <div class="col-lg-9">
                <textarea class="form-control" rows="6" id="content" name="content"><?=$row['content']?></textarea>
            </div>
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

    <button type="submit" class="btn btn-primary btn-sm col-xs-4 col-sm-3 col-md-2 col-lg-2">Guardar</button>

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
<th>Seccion</th>
<th>Tipo</th>
<th>Nombre</th>
<th>Content</th>
<th class="no-sort"></th>
<th class="no-sort"></th>
</tr>

</thead>


<tbody>
  

<?

$sql="eco_metatags_consul";

$result = sqlsrv_query($conn,$sql);
$i=1;
while ( $row = sqlsrv_fetch_array($result)){
?>

    <tr>
    <td><?=$row['seccion']?></td>
    <td><?=$row['tipo']?></td>
    <td><?=$row['nombre']?></td>
    <td><?=$row['content']?></td>
    
    <!-- <td><a href="javascript:;" title="Mostrar mas detalles" onclick="mostrar_detalle('xxx');"><span class="glyphicon glyphicon-search"></span></a></td> -->
    <td>
        <a href="tags.php?id=<?=$row['id']?>"  
        data-toggle="tooltip" data-placement="bottom" title="Editar Tag">
        <span class="glyphicon glyphicon-edit"></span>
        </a>
    </td>
    <td>
        <a href="javascript:;" onClick="BorrarTag(this,'<?=$row['id']?>')" 
        data-toggle="tooltip" data-placement="bottom" title="Borrar Tag">
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