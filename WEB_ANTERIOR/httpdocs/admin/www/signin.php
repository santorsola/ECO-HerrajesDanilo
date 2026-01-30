<?
include "header.php";
?>






    <script src="bootstrap/js/modal/bootstrap-dialog.js"></script>
    <link href="bootstrap/css/modal/bootstrap-dialog.css" rel="stylesheet">

    <link href="bootstrap/css/signin.css" rel="stylesheet">

    <div class="container">

    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-3 text-right">
            <img src="img/logo.png" style="margin-top:150px;width: 300px;" alt="">
        </div>
        <div class="col-lg-5">
            <form class="form-signin" action="login.php" method="POST">

            <h2 class="form-signin-heading">Iniciar Sesión</h2>
            <label for="usuario" class="sr-only">Usuario</label>
            <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuario" required autofocus>
            <label for="pass" class="sr-only">Password</label>
            <input type="password" id="pass" name="pass" class="form-control" placeholder="Contraseña" required>

            <?
            if($_GET['error']==1) {
            ?>
                    <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">×</a>
                    <strong>Erorr al ingresar</strong> Verifique los datos...
                    </div>
            <?}?>

            <?
            if($_GET['error']==2) {
            ?>
                    <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">×</a>
                    <strong>Su sesión ha caducado</strong> Por favor ingrese nuevamente y complete su operación.
                    </div>
            <?}?>

            <?
            if($_GET['error']==3) {
            ?>
                    <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">×</a>
                    <strong>Usuario no válido del sistema</strong>
                    </div>
            <?}?>



            <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>

            </form>
        </div>
        <div class="col-lg-2"></div>
    </div>
    </div> <!-- /container -->

<?
include "footer.php";
?>