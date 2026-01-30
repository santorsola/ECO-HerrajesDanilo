<?php
  include "../funciones/conexion.php";
  include "../funciones/funciones_generales.php";

  $archivo_actual = basename($_SERVER['PHP_SELF']);

  if ($archivo_actual != "signin.php"){
    if (comprobar_sesson()==false){
      logout();
      header('Location: signin.php?error=2');
      exit();
    }
  }


  $sql="select razon_social from empresa";
  $result = sqlsrv_query($conn,$sql);
  $row=sqlsrv_fetch_array($result);


?>

<!DOCTYPE html>
<!-- saved from url=(0040)http://getbootstrap.com/examples/signin/ -->
<html lang="es"><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta charset="iso-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Pedidos Web - Rp Sistemas">
    <meta name="author" content="Rp Sistemas">
    <link rel="icon" href="favicon.ico">
    <title>Panel Administrador - <?=$row['razon_social']?></title>



    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->

    <script src="bootstrap/js/jquery-1.10.2.min.js"></script>
    <script src="bootstrap/js/ie10-viewport-bug-workaround.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/js/bootswatch.js"></script>

    <script src="../funciones/funciones_java.js"></script>

    <link href="bootstrap/css/modificador.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

    <link href="bootstrap/css/general.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="bootstrap/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="bootstrap/js/html5shiv.min.js"></script>
      <script src="bootstrap/js/respond.min.js"></script>
    <![endif]-->


 
<?include "../funciones/grilla_data_table.php"; 
?>

  </head>

  <body>



<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
<?if ($archivo_actual != "signin.php") {?>
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Desplegar Navegación</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#">Panel Administrador - <?=$row['razon_social']?></a>
  </div>

<?}
else {
?>
  <div class="navbar-header">
    <a class="navbar-brand" href="#">Panel Administrador - <?=$row['razon_social']?></a>
  </div>
<?}?>



<?if ($archivo_actual != "signin.php") {?> 
  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav">
       
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Operaciones <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="sliders.php">Configuración de Sliders</a></li>
          <li><a href="zonas_entregas.php">Configuración de Zonas de Entrega</a></li>
          <!-- <li><a href="tags.php">Configuración de Tags</a></li> -->
        </ul>
      </li>
    </ul>


    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown navbar-right">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><? echo $_SESSION['nombre_usuario'].' ('.$_SESSION['usuario'].')'?> <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="logout.php">Salir</a></li>
        </ul>
      </li>
    </ul>

  </div><!-- /.navbar-collapse -->
<?}?>
</nav>

