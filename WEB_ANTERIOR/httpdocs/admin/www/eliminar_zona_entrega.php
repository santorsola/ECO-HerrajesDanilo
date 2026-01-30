<?php
include "../funciones/conexion.php";
include "../funciones/funciones_manejo_errores.php";

$sql="eco_zonas_abm_baja ".$_POST['id_zona'];


$result =  sqlsrv_query( $conn, $sql );
if(!$result){
    $json['success'] = false;
    if( ($errors = sqlsrv_errors() ) != null) {
            $json['message']=devolver_error_sql($errors);
        }

    goto FIN;
    
}else{
    $json['success'] = true;
    $json['message'] = 'Zona de entrega eliminada';
}


FIN:

header('Content-Type: application/json');
echo json_encode( $json );
?>