function comprobar_sesion_cerrada(str){

	if(str.indexOf("<title>")>0)
		document.location='signin.php?error=2'; 

}