<?

include "funciones/conexion.php";
include "funciones/funciones_generales.php";


header("Content-Type: text/plain; charset=ISO-8859-1");

$num_agru=$_GET['num_agru'];
$codi_agru=$_GET['codi_agru'];
$codi_agru2=$_GET['codi_agru2'];

$sql="eco_agrupaciones_consul null,";
$sql.=($num_agru == '' ? "null" : $num_agru);
$sql.=",@agru_padre=".($codi_agru == '' ? "null" : "'".$codi_agru."'");
$sql.=",@agru_padre_2=".($codi_agru2 == '' ? "null" : "'".$codi_agru2."'");
$sql.=",@usuario='".$_SESSION['usuario']."'";
 
$result = sqlsrv_query($conn,$sql);
echo $sql;
echo '<option value="" selected>Todos</option>';
while($row=sqlsrv_fetch_array($result)){
	echo '<option value="'.$row['CODI_AGRU'].'" >'.$row['DESCRIP_AGRU'].'</option>';   
}
?>