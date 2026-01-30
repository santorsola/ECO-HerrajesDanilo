<? 
include ("header.php");
$tipo_mje=$_GET['tipo_mje'];
?>  

<script>
$(document).ready(function(){
    
    $( "#btn-continuar").click(function() {
        document.location="index.php";
    });
}); //document.ready


</script>


    <main class="main-carrito">
        <section class="contenido-carrito2">
            <p class="info-pasos">
                <?
                switch ($tipo_mje) {
                    case '1':?>
                        El usuario fue activado correctamente, ya le enviamos un mail dando aviso.<br>
                        <?break;
                    case '2':?>
                        poner mensaje
                        <?break;
                    case '3':?>
                        poner mensaje
                        <?break;
                    case '4':?>
                        poner mensaje
                        <?break;
                    case '':?>
                        Gracias por elegirnos
                        <?break;
                }
                ?>
                <br>
            </p>

            <div class="pago-botones">
                <input type="button" class="btn-rojo" id="btn-continuar" value="Continuar" style="width: 150px;">
            </div>
        </section>
    </main>
<? include ("footer.php") ;?>





