<?



function consultar_cant_carrito()
{
	global $conn;
	$sql="eco_carrito_canti_consul '".session_id()."','".$_SESSION['usuario']."'";
	$result = sqlsrv_query($conn,$sql);
	$row=sqlsrv_fetch_array($result);
	echo '('.$row['cantidad'].')';
}

function devolver_cant_y_total_carrito(&$cant,&$total)
{
	global $conn;
	$sql="eco_carrito_canti_consul '".session_id()."','".$_SESSION['usuario']."'";
	$result = sqlsrv_query($conn,$sql);
	$row=sqlsrv_fetch_array($result);
	$cant=$row['cantidad'];
	$total=$row['mone'].$row['total'];
}



?>