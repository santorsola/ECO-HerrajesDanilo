<?
include "header.php";
$mensaje = $_GET["mje"];
?>

<link href="bootstrap/css/general.css" rel="stylesheet">

<link href="bootstrap/css/datepicker/bootstrap-datepicker3.css" rel="stylesheet">
<script src="bootstrap/js/datepicker/bootstrap-datepicker.min.js"></script>
<script src="bootstrap/js/datepicker/bootstrap-datepicker.es.min.js"></script>

<script src="bootstrap/js/selectpicker/bootstrap-select.min.js"></script>
<link href="bootstrap/css/selectpicker/bootstrap-select.min.css" rel="stylesheet">

<script src="bootstrap/js/modal/bootstrap-dialog.js"></script>
<link href="bootstrap/css/modal/bootstrap-dialog.css" rel="stylesheet">

<!--http://ashleydw.github.io/lightbox/-->
<script src="bootstrap/js/lightbox/ekko-lightbox.js"></script>
<link href="bootstrap/css/lightbox/ekko-lightbox.css" rel="stylesheet">


<script>
var tabla;

 $(document).ready(function() {
		
		tabla=$('#tbl').DataTable( {
				  "columnDefs": [
					{ "width": "10%", "targets": 0},
                    { "width": "15%", "targets": 2},
                    { "width": "15%", "targets": 3}
				  ],				  
				  dom:'<"arriba_izq"l><"clear">rt<"clear">',
				   responsive: false,
				  "paging":   false
				} );

        SumarUnidades();

        $('#cuadro_error').css('display', 'none');

        <?if($mensaje==""){?>
            $('#cuadro_ok').css('display', 'none');
        <?}else{?>
            $('#cuadro_ok').css('display', 'block');
        <?}?>



        $("#guardar").submit(function()
        {

            BootstrapDialog.confirm({
                title: 'Control Stock',
                message: '¿Está seguro de guardar el movimiento?',
                type: BootstrapDialog.TYPE_PRIMARY, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
                closable: true, // <-- Default value is false
                draggable: true, // <-- Default value is false
                btnCancelLabel: 'No', // <-- Default value is 'Cancel',
                btnOKLabel: 'Si', // <-- Default value is 'OK',
                callback: function(result) {
                    if(result){
                         $.post("guardar_stock.php", $("#guardar").serialize() ,function(data)
                        {

                            comprobar_sesion_cerrada(data);

                            var resultado,tipo,num,mje;
                            resultado=data.split('^');

                            if(resultado[0]=='ok')
                            {
                                tipo=resultado[1];
                                num=resultado[2];
                                mje=resultado[3];

                                $("#mje_info_ok").fadeTo(200,0.1,function()
                                { //$('#cuadro_ok').css('display', 'block');
                                  //$('#cuadro_error').css('display', 'none');
                                  //$(this).html('Se grabo correctamente el comprobante: '+mje).fadeTo(500,1);
                                  document.location='stock.php?mje=Se grabo correctamente el comprobante: '+mje;
                                });
                            }
                            else
                            {
                                $("#mje_info").fadeTo(200,0.1,function()
                                { $('#cuadro_error').css('display', 'block');
                                  $(this).html(data).fadeTo(500,1);
                                });     
                            }
                                
                        });
                    }
                }
            });

            return false; 
        });

} );


$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
   event.preventDefault();
   $(this).ekkoLightbox();
}); 


function SumarUnidades() {
var unidades=0;


	tabla.column( 3 )
    .data()
    .each( function ( value ) {

            var datahtml ="<div>"+value+"</div>";
            var id_row;
            var cantidad;
            id_row="#"+$(datahtml).find(":input").attr("id");
            cantidad=parseFloat($(id_row).val());

            if($.isNumeric(cantidad)){
                cantidad=parseFloat(cantidad);
            }else{
                cantidad=0;
            }

            unidades=unidades+cantidad;
			
    } );


$("#unidades").html(unidades);

}


</script>

<script language=javascript type=text/javascript>
function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 13) && (node.type=="number" || node.type=="text")) {return false;}
}
document.onkeypress = stopRKey; 

</script>


<div class="container"> 
<div class="contenedor"> 

<h2>Control Stock</h2>

<form method="POST" id="guardar" action="guardar_pedido.php">

<br>
<h4>Total de Unidades en Stock: <span id="stock"></span></h4>
<h4>Total de Unidades Vendidas: <span id="unidades"></span></h4>

<div class="col-lg-12 text-right" style="padding:0px">
    <button type="submit" id="btn_guardar" class="btn btn-primary btn-sm ">Guardar</button>
</div>

<div class="row" id="cuadro_error">
    <div class="col-lg-12 form-group">
        <br>
        <div  class="alert alert-danger">
            <div id="mje_info"></div>
        </div>
    </div>
</div>

<div class="row" id="cuadro_ok">
    <div class="col-lg-12 form-group">
        <br>
        <div class="alert alert-success">
            <div id="mje_info_ok"><?=$mensaje?></div>
        </div>
    </div>
</div>

<table id="tbl" class="display" width="100%" cellspacing="0">
<thead>
<tr class="info">
<th>Código</th>
<th>Descripción</th>
<th>Stock</th>
<th>Cant. Vendida</th>
</tr>
</thead> 
<tbody>
    
<?

$sql="natuvida_stock_consul '".$_SESSION['codigo'] ."'";

$result = sqlsrv_query($conn,$sql);
$i=1;
while ( $row = sqlsrv_fetch_array($result)){
    echo "<tr>";
    $total_stock=$row['total'];
?>
    <td><?=$row['cod_articulo']?>
        <input type="hidden" id="row-<?=$i?>-codigo" name="row-<?=$i?>-codigo" value="<?=$row['cod_articulo']?>">
    </td>
    <td><?=$row['descrip_arti']?></td>
    <td><?=$row['cant_stock']?></td>
    <td>
        <input type="number"  min="0" id="row-<?=$i?>-cantidad" style="max-width:60px" class="cantidad" name="row-<?=$i?>-cantidad" value="0" onInput="SumarUnidades()">
    </td>
<?
$i++;

}?>

</tbody>
</table>
</form>



<script type="text/javascript">
    // For demo to fit into DataTables site builder...
    $('#tbl')
        .removeClass( 'display' )
        .addClass('table table-striped table-hover dt-responsive');


    $("#stock").html(<?=$total_stock?>);
</script>

<?
include "footer.php";
?>