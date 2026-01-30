<? 

include "funciones/funciones_generales.php";

$mail_destino='msantorsola@gmail.com';
$asunto='con 465 ssl';
$cuerpo='hola prueba desde web.';
$error='xxx';
EnviarMail($mail_destino,$asunto,$cuerpo,$error,$cc,$ruta_adjunto, $nombre_archivo);
echo $error.'>>><<<<';
?>