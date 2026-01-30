<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";
// header("Content-Type: text/plain; charset=ISO-8859-1");

$articulo=$_GET['articulo'];
$talle=$_GET['talle'];
$color=$_GET['color'];

$articulo.=$color.$talle;
if($talle<>'')
	$articulo=$talle;

$sql="eco_articulos_consul ";
$sql.="'".$articulo."',@usar_like_espacios='N'";
$sql.=",@usuario='".$_SESSION['usuario']."'";
//echo $sql;
$result=sqlsrv_query($conn,$sql);

$hay_resultado = sqlsrv_has_rows( $result );
if ($hay_resultado === true){

	$row=sqlsrv_fetch_array($result);

	$precio=$row['mone'].' '.cdouble($row['precio_vta']);
	$precio_sin_oferta=$row['mone'].' '.cdouble($row['precio_sin_oferta']);
	echo 'ok^'.$row['cod_articulo'].'^'.$row['cod_barras'].'^'.$precio.'^'.$row['stock'].'^'.
				$row['desc_adicional'].'^'.$row['obser_web'].'^'.$row['obser_2'].'^'.$row['descrip_arti'].'^'.
				$precio_sin_oferta.'^'.$row['descrip_oferta'];
}else{
	echo 'NO^';
}
