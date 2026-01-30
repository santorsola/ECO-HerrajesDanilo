<?

function EliminarClienteLugar($secuen,$num_cliente,$codi_lugar) {
	global $conn;
	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	return 'PRO|'; //LOC ECO

	
	global $conn;
	
	sqlsrv_begin_transaction( $conn );

	$sql="pediweb_clientes_lugares_baja "; 
	$sql.=($num_cliente=="" ? "0" : $num_cliente).",";
	$sql.=($codi_lugar=="" ? "0" : $codi_lugar);
	
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){ 
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}

function CargarClienteLugar($secuen,$num_cliente,$codi_lugar,$descrip) {
	global $conn;
	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	return 'PRO|'; //LOC ECO
	global $conn;
	
	sqlsrv_begin_transaction( $conn );

	$sql="pediweb_clientes_lugares_actua "; 
	$sql.=($num_cliente=="" ? "0" : $num_cliente).",";
	$sql.=($codi_lugar=="" ? "0" : $codi_lugar).",";
	$sql.=($descrip=="" ? "''" : "'".$descrip."'");
	
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){ 
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}

function CopiarClienteArticulo($secuen,$cliente_origen,$cliente_destino) {
	global $conn;
	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	return 'PRO|'; //LOC ECO
	global $conn;
	
	sqlsrv_begin_transaction( $conn );

	$sql="pediweb_clientes_arti_descuen_copiar "; 
	$sql.=($cliente_origen=="" ? "0" : $cliente_origen).",";
	$sql.=($cliente_destino=="" ? "0" : $cliente_destino);
	
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){ 
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}


function ActuaMasiClienteArticulo($secuen,$articulo,$signo,$porcen_ganan) {
	global $conn;
	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	return 'PRO|'; //LOC ECO
	global $conn;
	
	sqlsrv_begin_transaction( $conn );

	$sql="pediweb_clientes_arti_descuen_masi "; 
	$sql.="'".$articulo."',";
	$sql.=($signo=="" ? "0" : $signo).",";
	$sql.=($porcen_ganan=="" ? "0" : $porcen_ganan);
	
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){ 
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}

function CargarClienteArticulo($secuen,$num_cliente,$articulo,$dto_item) {
	global $conn;
	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	return 'PRO|'; //LOC ECO
	global $conn;
	
	sqlsrv_begin_transaction( $conn );

	$sql="pediweb_clientes_arti_descuen_actua "; 
	$sql.=$num_cliente.","; 
	$sql.="'".$articulo."',";
	$sql.=($dto_item=="" ? "0" : $dto_item);
	
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}

function EliminarClienteArticulo($secuen,$num_cliente,$articulo) {
	global $conn;
	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	return 'PRO|'; //LOC ECO
	global $conn;
	
	sqlsrv_begin_transaction( $conn );

	$sql="pediweb_clientes_arti_descuen_baja "; 
	$sql.=$num_cliente.","; 
	$sql.=($articulo=="" ? "null" : "'".$articulo."'");
	
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}


function CargarCliente($secuen,$num_cliente,$razon,$nom_fantasia,$domicilio,$telefono,
	$iva,$cuit,$mail,$codi_vende,$lista_codi,$condi_venta,$activo,$obser,
	$porcen_descuen,$agru_1,$lugar_entrega,
	$transportista,$localidad,$codi_provin,$descrip_provincia,$descrip_agru,$user_web,$pass_web) {

	global $conn;
	
	sqlsrv_begin_transaction( $conn );

	$sql="eco_ws_clientes_ws_actua "; //tb actua tb usuarios
	$sql.=$num_cliente.","; //factu
	$sql.="'".$user_web."',";
	$sql.="'".$razon."',";
	$sql.=($nom_fantasia=="" ? "null" : "'".$nom_fantasia."'").",";
	$sql.=($domicilio=="" ? "null" : "'".$domicilio."'").",";
	$sql.=($telefono=="" ? "null" : "'".$telefono."'").",";
	$sql.=($iva=="" ? "null" : "'".$iva."'").",";
	$sql.=($cuit=="" ? "null" : "'".$cuit."'").",";
	$sql.=($mail=="" ? "null" : "'".$mail."'").",";
	$sql.=($codi_vende=="" ? "null" : "'".$codi_vende."'").",";
	$sql.=($lista_codi=="" ? "null" : "'".$lista_codi."'").",";
	$sql.=($condi_venta=="" ? "null" : "'".$condi_venta."'").",";
	$sql.=($activo=="" ? "'N'" : "'".$activo."'").",";
	$sql.=($obser=="" ? "null" : "'".$obser."'").",";
	$sql.=($porcen_descuen=="" ? "0" : $porcen_descuen).",";
	$sql.=($agru_1=="" ? "null" : "'".$agru_1."'").",";
	$sql.=($lugar_entrega=="" ? "null" : "'".$lugar_entrega."'").",";
	$sql.=($transportista=="" ? "null" : "'".$transportista."'").",";
	$sql.=($localidad=="" ? "null" : "'".$localidad."'").",";
	$sql.=($codi_provin=="" ? "null" : "'".$codi_provin."'").",";
	$sql.=($user_web=="" ? "null" : "'".$user_web."'").",";
	$sql.=($pass_web=="" ? "null" : "'".$pass_web."'");
	
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	$row=sqlsrv_fetch_array($rs);
	$mandar_mail_aviso=$row['mandar_mail_aviso'];
	$mail=$row['mail'];
	//Abajo manda el mail



	$sql="eco_ws_agrup_clientes_actua ";
	$sql.="'".$agru_1."',";
	$sql.="'".$descrip_agru."'";
	
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );

	//Mismo mail que ActivarUsuario.php

	if ($mandar_mail_aviso!='S')
		return 'PRO|';

    $sql="select razon_social,path_logo,mail,mail_firma,path_empresa from empresa";
    $result=sqlsrv_query($conn,$sql);
    $row=sqlsrv_fetch_array($result);

    $empresa=$row['razon_social'];
    $path_logo=$row['path_logo'];
    $path_empresa=$row['path_empresa'];
    $mail_empresa=$row['mail'];
    $mail_firma=$row['mail_firma'];

    $mail_firma=str_replace('-BR-','<br>',$mail_firma);

    
    $asunto = "Usuario Activado";

    $cuerpo = '
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
    <font size=2 face=verdana>Estimado/a '.$razon.':</font>
    <p><font size=2 face=verdana>

    Su usuario ya se encuentra activo para poder utilizar nuestro sitio <a href="'.$path_empresa.'">'.$path_empresa.'</a>. <br><br>
    Sus datos son: <br>
	<b>Usuario</b>: '.$user_web.' <br>
	<b>Contraseña:</b> '.$pass_web.' <br>
    </p>
     
    '.$mail_firma.'
    <br>
    <br>
    <img src="'.$path_logo.'" />
    </body>
    </html>
    ';

    //para el envío en formato HTML
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=ISO-8859-1\r\n";

    //dirección del remitente
    $headers .= "From: ".$mail_empresa." <".$mail_empresa.">\r\n";
    //dirección CC
    // if(consultar_configuracion('MAIL_CC_EMPRESA')=='S'){
    //     $mails_cc=consultar_configuracion('MAILS_CC');
    //     $headers .= "Bcc: ".$mails_cc."\r\n";
    // }
    //Direccion de respuesta
    $headers .= "Reply-To: ".$mail_empresa."\r\n";


    $mail_destino=str_replace(";", ",", $mail);

    

    //guardo en auditoria

    if(mail($mail_destino,$asunto,$cuerpo,$headers)==false){
        $sql="insert into eco_auditoria_mails(tipo,num,asunto,mail_destino,cuerpo,headers,codigo,fecha) select null,null,";
        $sql.="'".$asunto."','".$mail_destino."','".$cuerpo."','".$headers."','NO ENVIADO',getdate()";
        $rs=sqlsrv_query($conn,$sql);
    }
    else {
        $sql="insert into eco_auditoria_mails(tipo,num,asunto,mail_destino,cuerpo,headers,codigo,fecha) select null,null,";
        $sql.="'".$asunto."','".$mail_destino."','".$cuerpo."','".$headers."','OK',getdate()";
        $rs=sqlsrv_query($conn,$sql);
    }





	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}

function EliminarCliente($secuen,$num_factu) {

	global $conn;
	
	sqlsrv_begin_transaction( $conn );

	$sql="eco_ws_clientes_baja ";
	$sql.=$num_factu;
	
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}



function ActualizarStock($secuen,$cod_articulo,$stock) {

	global $conn;
	
	sqlsrv_begin_transaction( $conn );


	$sql="eco_ws_articulos_stock_actua ";
	$sql.="'".$cod_articulo."',";
	$sql.=($stock=="" ? "0" : $stock);
	
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}


function ActualizarSaldosCliente($secuen,$num_factu,$obser_saldo,$valores_sin_agreditar,$saldo_vencido) {
	global $conn;
	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	return 'PRO|'; //LOC ECO
	
	
	sqlsrv_begin_transaction( $conn );


	$sql="pediweb_clientes_saldos_actua ";
	$sql.=$num_factu.",";
	$sql.=($obser_saldo=="" ? "" : "'".$obser_saldo)."',";
	$sql.=($valores_sin_agreditar=="" ? "0" : $valores_sin_agreditar).",";
	$sql.=($saldo_vencido=="" ? "0" : $saldo_vencido);
	
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}


function ActulizarNroClienteFactu($secuen,$num_factu,$usuario) {

	global $conn;
	
	sqlsrv_begin_transaction( $conn );


	$sql="eco_ws_clientes_num_factu_actua ";
	$sql.=$num_factu.",";
	$sql.="'".$usuario."'";
	
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}


function CargarAgrupacion($secuen,$codi_agru,$num_agru,$descrip_agru,$agru_padre,$agru_padre_2) {

	global $conn;
	
	sqlsrv_begin_transaction( $conn );


	$sql="eco_ws_agrupaciones_actua ";
	$sql.="'".$codi_agru."',";
	$sql.="'".$num_agru."',";
	$sql.=($descrip_agru=="" ? "null" : "'".$descrip_agru."'").",";
	$sql.=($agru_padre=="" ? "null" : "'".$agru_padre."'").",";
	$sql.=($agru_padre_2=="" ? "null" : "'".$agru_padre_2."'");
	
	
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}

function EliminarAgrupacion($secuen,$codi_agru,$num_agru) {

	global $conn;
	
	sqlsrv_begin_transaction( $conn );


	$sql="eco_ws_agrupaciones_baja ";
	$sql.="'".$codi_agru."',";
	$sql.=$num_agru;
	
		
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}

function CargarArticulo($secuen,$cod_articulo,$descrip_arti,$desc_adicional,$cod_barras,$agru_1,$agru_2,$agru_3,$activo,$web_publi,$obser,
						$obser_2,$web_destacado,$codi_color,$codi_talle,$porcen_descuen_vta,$fecha_vigen_descuen_vta,$doc_path,$porcen_iva,$exento,
						$codigo_articulo_web,$descrip_arti_web,$obser_web,$codi_publicacion_web) {

	global $conn;
	
	sqlsrv_begin_transaction( $conn );


	$sql="eco_ws_articulos_actua ";
	$sql.="'".$cod_articulo."',";
	$sql.="'".$descrip_arti."',";
	$sql.=($desc_adicional=="" ? "null" : "'".$desc_adicional."'").",";
	$sql.=($cod_barras=="" ? "null" : "'".$cod_barras."'").",";
	$sql.=($agru_1=="" ? "null" : "'".$agru_1."'").",";
	$sql.=($agru_2=="" ? "null" : "'".$agru_2."'").",";
	$sql.=($agru_3=="" ? "null" : "'".$agru_3."'").",";
	$sql.=($activo=="" ? "null" : "'".$activo."'").",";
	$sql.=($web_publi=="" ? "null" : "'".$web_publi."'").",";
	$sql.=($obser=="" ? "null" : "'".$obser."'").",";

	$sql.=($obser_2=="" ? "null" : "'".$obser_2."'").",";
	$sql.=($web_destacado=="" ? "null" : "'".$web_destacado."'").",";
	$sql.=($codi_color=="" ? "null" : "'".$codi_color."'").",";
	$sql.=($codi_talle=="" ? "null" : "'".$codi_talle."'").",";
	$sql.=($porcen_descuen_vta=="" ? 0 : $porcen_descuen_vta).",";
	$sql.=($fecha_vigen_descuen_vta=="" ? "null" : "'".$fecha_vigen_descuen_vta."'").",";
	$sql.=($doc_path=="" ? "null" : "'".$doc_path."'").",";
	$sql.=($porcen_iva=="" ? 0 : $porcen_iva).",";
	$sql.=($exento=="" ? "null" : "'".$exento."'").",";
	$sql.=($codigo_articulo_web=="" ? "null" : "'".$codigo_articulo_web."'").",";
	$sql.=($descrip_arti_web=="" ? "null" : "'".$descrip_arti_web."'").",";
	$sql.=($obser_web=="" ? "null" : "'".$obser_web."'").",";
	$sql.=($codi_publicacion_web=="" ? "null" : "'".$codi_publicacion_web."'");
			
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}

function EliminarArticulo($secuen,$cod_articulo) {

	global $conn;
	
	sqlsrv_begin_transaction( $conn );


	$sql="eco_ws_articulos_baja ";
	$sql.="'".$cod_articulo."'";
	
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}

function CambiarCodigoArticulo($secuen,$cod_articulo_ori,$cod_articulo_nuevo) {

	global $conn;
	
	sqlsrv_begin_transaction( $conn );


	$sql="eco_ws_articulos_cambio_codigo ";
	$sql.="'".$cod_articulo_ori."',";
	$sql.="'".$cod_articulo_nuevo."'";
	
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}

function EliminarListaCabe($secuen,$lista_codi) {

	global $conn;
	
	sqlsrv_begin_transaction( $conn );


	$sql="eco_ws_listas_cabe_baja ";
	$sql.="'".$lista_codi."'";
	
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}

function CargarListaCabe($secuen,$lista_codi,$lista_descrip) {

	global $conn;
	
	sqlsrv_begin_transaction( $conn );


	$sql="eco_ws_listas_cabe_actua ";
	$sql.="'".$lista_codi."',";
	$sql.="'".$lista_descrip."'";	
		
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}

function CargarListaItems($secuen,$lista_codi,$articulo,$precio_vta,$moneda,$precio_vta_ofer,$fecha_hasta_ofer) {

	global $conn;
	
	sqlsrv_begin_transaction( $conn );


	$sql="eco_ws_listas_items_actua ";
	$sql.="'".$lista_codi."',";
	$sql.="'".$articulo."',";
	$sql.=$precio_vta.",";
	$sql.="'".$moneda."',";
	$sql.=($precio_vta_ofer=="" ? 0 : $precio_vta_ofer).",";
	$sql.=($fecha_hasta_ofer=="" ? "null" : "'".$fecha_hasta_ofer."'");


		
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}

function EliminarListaItems($secuen,$lista_codi,$articulo) {

	global $conn;
	
	sqlsrv_begin_transaction( $conn );


	$sql="eco_ws_listas_items_baja ";
	$sql.="'".$lista_codi."',";
	$sql.="'".$articulo."'";
	
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}

function CargarMoneda($secuen,$mone,$mone_coti) {

	global $conn;
	
	sqlsrv_begin_transaction( $conn );


	$sql="eco_ws_monedas_actua ";
	$sql.="'".$mone."',";
	$sql.=$mone_coti;
	
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}

function EliminarMoneda($secuen,$mone) {

	global $conn;
	
	sqlsrv_begin_transaction( $conn );


	$sql="eco_ws_monedas_baja ";
	$sql.="'".$mone."'";
	
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}

function CargarImagenArticulo($secuen,$cod_articulo,$web_publi,$web_imagen) {

	global $conn;
	
	sqlsrv_begin_transaction( $conn );


	$sql="eco_ws_articulos_imagenes_actua ";
	$sql.="'".$cod_articulo."',";
	$sql.=($web_publi=="" ? "null" : "'".$web_publi."'").",";
	$sql.=($web_imagen=="" ? "null" : "'".$web_imagen."'");
	
		
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}





//Standars

//USUARIOS
function CargarUsuario($secuen,$usuario,$pass,$nombre,$codigo,$cuit,$mail,$id_perfil) {

	global $conn;
	
	sqlsrv_begin_transaction( $conn );

	if($id_perfil=='VEN'){
		$sql="eco_ws_vendedores_actua ";
		$sql.="'".$codigo."',";
		$sql.="'".$nombre."',";
		$sql.=($mail=="" ? "null" : "'".$mail."'");
		
			
		$rs = sqlsrv_query($conn,$sql);

		if(!$rs){
			if( ($errors = sqlsrv_errors() ) != null) {
				sqlsrv_rollback( $conn );
				$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
				$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
				proceso_subida_error_actua($secuen,$error); //Error de la funcion
				return $error;
				}
		}
	}
	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //LOC ECO
	global $conn;
	
	sqlsrv_begin_transaction( $conn );


	$sql="pediweb_usuarios_actua ";
	$sql.="'".$usuario."',";
	$sql.="'".$pass."',";
	$sql.="'".$nombre."',";
	$sql.="'".$codigo."',";
	$sql.=($cuit=="" ? "null" : "'".$cuit."'").",";
	$sql.=($mail=="" ? "null" : "'".$mail."'").",";
	$sql.=($id_perfil=="" ? "null" : "'".$id_perfil."'");
		
	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}


	//Lo marco como procesado
	$rs = sqlsrv_query($conn, "update proceso_subida set estado='PRO' where secuen=".$secuen );
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	sqlsrv_commit( $conn );
	return 'PRO|'; //No sacar el | del final ya que es para el parsing del vb
	
}



//PROCESO BAJADA

function ConsultarCantPend() {

	global $conn;
	
	$sql="select count(1) cantidad from proceso_bajada where estado<>'PRO'";
	$result = sqlsrv_query($conn,$sql);
	$row=sqlsrv_fetch_array($result);
	return $row['cantidad'].'|';//No sacar el | del final ya que es para el parsing del vb
	}


function ConsultarPend() {

	global $conn;
	
	$sql="select * from proceso_bajada where estado<>'PRO' order by secuen asc";
	$result = sqlsrv_query($conn,$sql);
	$row=sqlsrv_fetch_array($result);

	$rta.=$row['secuen'].'|';
	$rta.=$row['funcion'].'|';
	$rta.=$row['parametros'].'|';//No sacar el | del final ya que es para el parsing del vb
	
	//parametros esta separado por ^
	$rta=encriptar($rta);
	return $rta;

	}


function GuardarEstado($secuen,$estado,$mensaje_error) {

	global $conn;
	
	$estado="'".$estado."'";
	$mensaje_error="'".$mensaje_error."'";

	$sql="update proceso_bajada 
		set 
		estado = ".$estado.",
		mensaje_error=".$mensaje_error."
		where secuen =".$secuen;

	$rs = sqlsrv_query($conn,$sql);

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			sqlsrv_rollback( $conn );
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|SQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			return $error;
			}
	}

	
	return 'ok|'; //No sacar el | del final ya que es para el parsing del vb
	
}


?>