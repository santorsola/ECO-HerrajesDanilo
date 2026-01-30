<?

define('CLAVE_ENCRIP', 'HOMERO*2015'); 
define('SEPARADOR', '||'); 
define('SISTEMA', 'PRUSSIA'); 
 
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
	session_start();
	session_regenerate_id(true);

	if ($_SESSION['registered'] != 1)
		return false;

	if ($_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT'])
		return false;
	/*
	if ($_SESSION['IPaddress'] != $_SERVER['REMOTE_ADDR'])
		return false;*/

	if ($_SESSION['sistema'] !=SISTEMA)
		return false;

	if ($_SESSION['usuario'] =='')
		return false;

	if ($_SERVER['REQUEST_TIME'] - $_SESSION['LastActivity'] < 3600){
		$_SESSION['LastActivity'] = $_SERVER['REQUEST_TIME'];
		return true;	
	}
	else
		return false; //time out

}

function logout() {
	session_start();
	session_regenerate_id(true);
	session_unset();
	session_destroy();
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



//$val = str_ireplace("=","", $val);
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




function consultar_configuracion($valor_config)
{
	global $conn;
	$sql="pediweb_config_general_consul '".$valor_config."'";
	$result = sqlsrv_query($conn,$sql);
	$row=sqlsrv_fetch_array($result);
	return $row['valor_config'];
}



?>