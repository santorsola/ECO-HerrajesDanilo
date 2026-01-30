<?

define('CLAVE_ENCRIP', 'HOMERO*2015'); 
define('SEPARADOR', '||'); 
define('SISTEMA', 'BULONERA'); 
 
function encriptar($cadena)
{/*
$key=CLAVE_ENCRIP;
$algorithm = MCRYPT_BLOWFISH;
$mode = MCRYPT_MODE_ECB;
$iv = mcrypt_create_iv(mcrypt_get_iv_size($algorithm, $mode),
                       MCRYPT_DEV_URANDOM);

$encrypted_data = mcrypt_encrypt($algorithm, $key, $cadena, $mode, $iv);
$plain_text = base64_encode($encrypted_data);

return $plain_text;
*/


global $conn;
	
	$sql="webrp_encriptar '".$cadena."'";
	$result = sqlsrv_query($conn,$sql);
	$row=sqlsrv_fetch_array($result);
	$plain_text=$row['encriptado'];

return $plain_text;
}



function desencriptar($encriptado)
{/*
$key=CLAVE_ENCRIP;
$algorithm = MCRYPT_BLOWFISH;
$mode = MCRYPT_MODE_ECB;
$iv = mcrypt_create_iv(mcrypt_get_iv_size($algorithm, $mode),
                       MCRYPT_DEV_URANDOM);

$encrypted_data = base64_decode($encriptado);
$decoded = mcrypt_decrypt($algorithm, $key, $encrypted_data, $mode, $iv);

//El parametro del trim "\x00..\x1F" lo que hace es limpia todos los caracteres ascii de control del 0 al 31 inclusive
$decoded = trim($decoded, "\x00..\x1F");
$decoded =preg_replace('/[\x00-\x1F\x7F]/', '', $decoded);
return $decoded;
*/



	global $conn;
	
	$sql="webrp_desencriptar '".$encriptado."'";
	$result = sqlsrv_query($conn,$sql);	
	$row=sqlsrv_fetch_array($result);
	$decoded=$row['desencriptado'];


//El parametro del trim "\x00..\x1F" lo que hace es limpia todos los caracteres ascii de control del 0 al 31 inclusive
$decoded = trim($decoded, "\x00..\x1F");
$decoded =preg_replace('/[\x00-\x1F\x7F]/', '', $decoded);
return $decoded;
}
 
function mostrar_error_sql($errors){

$mje=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
$mje=str_replace('[Microsoft][ODBC Driver 11 for SQL Server][SQL Server]', '', $errors[0][ 'message']);
$mje=str_replace('[Microsoft][SQL Server Native Client 11.0][SQL Server]', '', $errors[0][ 'message']);
$mje=str_replace('[Microsoft][ODBC Driver 11 for SQL Server][SQL Server]', '', $errors[0][ 'message']);



//$mje=encodeToIso(utf8_encode($mje));

$mje=str_replace('n*', 'ñ', $mje);
$mje=str_replace('N*', 'Ñ', $mje);
$mje=str_replace('a*', 'á', $mje);
$mje=str_replace('e*', 'é', $mje);
$mje=str_replace('i*', 'í', $mje);
$mje=str_replace('o*', 'ó', $mje);
$mje=str_replace('u*', 'ú', $mje);
$mje=str_replace('A*', 'Á', $mje);
$mje=str_replace('E*', 'É', $mje);
$mje=str_replace('I*', 'Í', $mje);
$mje=str_replace('O*', 'Ó', $mje);
$mje=str_replace('U*', 'Ú', $mje);



echo $mje;

}

function devolver_error_sql($errors){

$mje=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);

//$mje=encodeToIso(utf8_encode($mje));

$mje=str_replace('n*', 'ñ', $mje);
$mje=str_replace('N*', 'Ñ', $mje);
$mje=str_replace('a*', 'á', $mje);
$mje=str_replace('e*', 'é', $mje);
$mje=str_replace('i*', 'í', $mje);
$mje=str_replace('o*', 'ó', $mje);
$mje=str_replace('u*', 'ú', $mje);
$mje=str_replace('A*', 'Á', $mje);
$mje=str_replace('E*', 'É', $mje);
$mje=str_replace('I*', 'Í', $mje);
$mje=str_replace('O*', 'Ó', $mje);
$mje=str_replace('U*', 'Ú', $mje);



return $mje;

}



function proceso_subida_alta($secuen,$funcion,$parametros){
	global $conn;

	$sql="websrv_proceso_subida_alta ".$secuen.",'".$funcion."','".$parametros."'";

	$rs =  sqlsrv_query( $conn, $sql );

	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|MySQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			proceso_subida_error_actua($secuen,$error); //Error de la funcion
			echo $error;
			exit();
			}
	}	

	$row = sqlsrv_fetch_array($rs);

	//Si es PRO, salgo, si es PEN sigo con la ejecución.
	if ($row['estado']=='PRO'){
		echo "PRO|";
		exit();
		}
}


function proceso_subida_error_actua($secuen,$error){
global $conn;

$error=str_replace("'","''",$error);

$sql="update proceso_subida set mensaje_error='".$error."' where secuen=".$secuen;
$rs =  sqlsrv_query( $conn, $sql );

if(!$rs){
	if( ($errors = sqlsrv_errors() ) != null) {
		$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
		$error ="ERROR|MySQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
		proceso_subida_error_actua($secuen,$error); //Error de la funcion
		return $error;
		}
}

}



function proceso_bajada_alta($funcion,$parametros){
	global $conn;

	$sql="websrv_proceso_bajada_alta '".$funcion."','".$parametros."'";
	$rs =  sqlsrv_query( $conn, $sql );
	
	if(!$rs){
		if( ($errors = sqlsrv_errors() ) != null) {
			/*$errors[0][ 'message']=str_replace('[Microsoft][SQL Server Native Client 10.0][SQL Server]', '', $errors[0][ 'message']);
			$error ="ERROR|MySQL error ".$errors[0][ 'code'].": ".$errors[0][ 'message']."-Al ejecutar:".$sql; 
			*/
			return 1;
			}
	}

	return 0;
}


function secure_session_start(){
	//Se deberia llamar solo la 1ra vez
	session_start();

	$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
	$_SESSION['IPaddress'] = $_SERVER["REMOTE_ADDR"];
	$_SESSION['LastActivity'] = $_SERVER['REQUEST_TIME'];
	$_SESSION['registered'] = 1;
	$_SESSION['sistema'] = SISTEMA;
}


function comprobar_sesson(){
	// session_start(); //se puso en el header asi siempre se inicia
	//session_regenerate_id(true); no tiene sentido cambiar de id x cada carga
return true;
	if ($_SESSION['registered'] != 1){
		die( '1'.print_r( $_SESSION, true));
		return false;
	}

	if ($_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT']){
		die( '2'.print_r( $_SESSION, true));
		return false;
	}

	/*if ($_SESSION['IPaddress'] != $_SERVER['REMOTE_ADDR']){
		//die( '3'.print_r( $_SESSION, true));
		return false;
	}*/

	if ($_SESSION['sistema'] !=SISTEMA){
		die( '4'.print_r( $_SESSION, true));
		return false;
	}

	// if ($_SESSION['usuario'] ==''){
	// 	die( print_r( $_SESSION, true));
	// 	return false;
	// }

	if ($_SERVER['REQUEST_TIME'] - $_SESSION['LastActivity'] < 3600){
		//$_SESSION['LastActivity'] = $_SERVER['REQUEST_TIME'];
		return true;	
	}
	else{
		die( '5'.print_r( $_SESSION, true));
		logout();
		return false; //time out
	}

}

function logout() {
/*
     echo "DEBUG SE CERRO LA SESION.<BR><BR><BR>";
     die( print_r( $_SESSION, true));*/

	session_start();
	session_unset();
	session_destroy();
	session_start();
	session_regenerate_id(true); //se regenera un nuevo id asi el anterior ya no es referenciado
}

function redireccionar_salida() {
	session_unset();
	session_destroy();
	echo '<meta http-equiv="Refresh" content="0;url=signin.php?error=2">';
	exit();
}

function encodeToIso($string) {
     return mb_convert_encoding($string, "ISO-8859-1", mb_detect_encoding($string, "UTF-8, ISO-8859-1, ISO-8859-15", true));
}

function limpiar_GET_POST()
{            
    foreach ($_POST as $campo => $valor )
    {
        $_POST[$campo]=encodeToIso(evitar_sql_injection($valor));
    }   
    foreach ($_GET as $campo => $valor )
    {
        $_GET[$campo]=encodeToIso(evitar_sql_injection($valor));
    }   
}  
 
function evitar_sql_injection($val)
{

/*Una configuracion del server php "get_magic_quotes_gpc" hace que get / post ya viaje escapado automaticamente '-->\' 
Si esta regla no esta activa lo hago con addslashes ... y luego hago el replace
 */




$val = str_ireplace("=","", $val);
$val = str_ireplace("!","", $val);
$val = str_ireplace("<>","", $val);
$val = str_ireplace("--","", $val);
$val = str_ireplace(" UNION ","", $val);
$val = str_ireplace(" OR ","", $val);
$val = str_ireplace(" AND ","", $val);
$val = str_ireplace("DELETE ","", $val);
$val = str_ireplace("SELECT ","", $val);
$val = str_ireplace("INSERT ","", $val);
$val = str_ireplace("DROP ","", $val);
$val = str_ireplace("TRUNCATE ","", $val);
$val = str_ireplace("CREATE ","", $val);
$val = str_ireplace("WHERE ","", $val);
$val = str_ireplace("LIKE","", $val);
$val = str_ireplace("^","", $val);



$val=str_ireplace("\'","",$val);
$val=str_ireplace("\"","",$val);
$val=str_ireplace("\\","",$val);
$val=str_ireplace("'","",$val);
$val=str_ireplace('"','',$val);

//El parametro del trim "\x00..\x1F" lo que hace es limpia todos los caracteres ascii de control del 0 al 31 inclusive
$val = trim($val, "\x00..\x1F");

return $val;
} 
 
limpiar_GET_POST(); //siempre llamar a esta funcion




function consultar_configuracion($nombre_config)
{
	global $conn;
	$sql="eco_config_general_consul '".$nombre_config."'";
	$result = sqlsrv_query($conn,$sql);
	$row=sqlsrv_fetch_array($result);
	return $row['valor_config'];
}


function cdouble( $val )
{
    return number_format($val,2,',','.');
}





function EnviarMail($mail_destino,$asunto,$cuerpo,&$error,$cc='',$ruta_adjunto='', $nombre_archivo=''){
	$remitente='Herrajes Danilo'; //Nombre a mostrar

	/*
	Ver: para reemplazar : if(EnviarMail($mail_destino,$asunto,$cuerpo,$error)==false){
	activar_usuario / enviar_consulta / guardar_cliente / guardar_entrega
	guardar_pago / olvido_pass
	*/

	//https://programacion.net/articulo/uso_de_la_clase_phpmailer_213
	//https://latincloud.com/argentina/ayuda/como-envio-correos-con-php-por-smtp-phpmailer/
	require_once("PHPMailer-5.2.25/PHPMailerAutoload.php");
	//require("funciones/PHPMailer-5.2.25/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->PluginDir = "PHPMailer-5.2.25/";

	//Luego tenemos que iniciar la validación por SMTP:
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = false; //nose pero no andaba y con esto funciono
	$mail->SMTPAutoTLS = false; //ojo probar en true o false factupymes en FALSE / cursos geben en True
	//$mail->SMTPDebug = 2; // para debug
	$mail->Host = "herrajesdanilo.com"; // A RELLENAR. Aquí pondremos el SMTP a utilizar. Por ej. mail.midominio.com
	$mail->Username = "no-reply@herrajesdanilo.com"; // A RELLENAR. Email de la cuenta de correo. ej.info@midominio.com La cuenta de correo debe ser creada previamente. 
	$mail->Password = "NoResponder_2024"; // A RELLENAR. Aqui pondremos la contraseña de la cuenta de correo
	$mail->Port = 25; // Puerto de conexión al servidor de envio. 
	$mail->From = "no-reply@herrajesdanilo.com"; // A RELLENARDesde donde enviamos (Para mostrar). Puede ser el mismo que el email creado previamente.
	$mail->FromName = $remitente; //A RELLENAR Nombre a mostrar del remitente. 
	//$mail->AddAddress($mail_destino); // Esta es la dirección a donde enviamos 
	if($cc!='')
		$mail->AddBCC($cc); // Copia oculta
	//$mail->AddCC("cuenta@dominio.com"); // Copia

	$mail_destino=str_replace(";", ",", $mail_destino);
	$direcciones=explode(',', $mail_destino);
	for($i=0;$i<=count($direcciones);$i++){
		if($direcciones[$i]!='')
			$mail->AddAddress($direcciones[$i]); // Esta es la dirección a donde enviamos 
	}


	$mail->IsHTML(true); // El correo se envía como HTML 
	$mail->Subject = $asunto; // Este es el titulo del email. 
/*
	$mail->Host = "mail.factupymes.com.ar"; // A RELLENAR. Aquí pondremos el SMTP a utilizar. Por ej. mail.midominio.com
	$mail->Username = "test@factupymes.com.ar"; // A RELLENAR. Email de la cuenta de correo. ej.info@midominio.com La cuenta de correo debe ser creada previamente. 
	$mail->Password = "Rop1234"; // A RELLENAR. Aqui pondremos la contraseña de la cuenta de correo
	$mail->Port = 25; // Puerto de conexión al servidor de envio. 
	$mail->From = "test@factupymes.com.ar"; // A RELLENARDesde donde enviamos (Para mostrar). Puede ser el mismo que el email creado previamente.
*/

	$mail->Body = $cuerpo; // Mensaje a enviar. 

	if ($ruta_adjunto!="") {
		$mail->AddAttachment($ruta_adjunto, $nombre_archivo);
	}


	$exito = $mail->Send(); // Envía el correo.
	$error= $mail->ErrorInfo;
	/*
	if($exito){ echo 'El correo fue enviado correctamente.'; }
	else{ echo 'Hubo un problema. Contacta a un administrador.'; } 

	echo "<br/>".$mail->ErrorInfo;

	*/
/*
	global $conn;

	if(!$exito){
	    $sql="insert into cursos_auditoria_mails(tipo,num,asunto,mail_destino,cuerpo,headers,codigo,fecha)";
	    $sql.=" select '".$tipo."',".cdouble($num).",".cdoubl($secuen).",'".$asunto."','".$mail_destino."','".$cuerpo."','".$mail->ErrorInfo."','NO ENVIADO',getdate()";

	    $rs=sqlsrv_query($conn,$sql);
	}
	else {
	    $sql="insert into cursos_auditoria_mails(tipo,num,asunto,mail_destino,cuerpo,headers,codigo,fecha)";
	    $sql.=" select '".$tipo."',".cdouble($num).",".cdoubl($secuen).",'".$asunto."','".$mail_destino."','".$cuerpo."','','OK',getdate()";
	    $rs=sqlsrv_query($conn,$sql);    
	}
*/

	return $exito;

}
?>