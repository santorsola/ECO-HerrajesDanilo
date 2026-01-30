</div><!-- contenedor  -->

<script type="text/javascript">
$(document).ready(function() {
    $('#btn-enviar2').click(function() {
        $.post("enviar_consulta.php", $("#consulta2").serialize() ,function(data){
            if(data=='OK'){
                $(".mje-result2").fadeTo(200,0.1,function(){
                    var mje='Su consulta ha sido enviada.';
                    $(this).html(mje).fadeTo(500,1);
                    $('#consulta2').each (function(){
                        this.reset();
                    });
                });
            }else{
                $(".mje-result2").fadeTo(200,0.1,function(){
                    $(this).html(data).fadeTo(500,1);
                });
            }
        });
    });
});
</script>
<?$link=$index_url."?agru_3=";?>




<div class="pre-footer">
    <div class="col-sm-6">
        <form class="validate" action="" method="post" type="contact" id="consulta2">
            <div class="form-group">
                <h2 style="color: #fff;">Contactanos</h2>

                <input class="required" type="text" name="razon" placeholder="Nombre y Apellido*">
                <input type="text" name="empresa" placeholder="Empresa">
                <input class="required" type="text" name="telefono" placeholder="Teléfono">
                <input class="required" type="email" name="mail" placeholder="E-mail*">
                <textarea class="required" name="cuerpo" rows="10" cols="30"></textarea>
                <input type="hidden" name="formulario" value="home">
                
                <div class="mje-result2" style="font-size: 20px;color: #FFF;"></div>
                <button type="button" id="btn-enviar2" class="btn btn-default">Enviar</button>
            </div>
        </form>
    </div>
    <a name="ubicacion"></a>
    <div class="col-sm-6">
        <h2 style="color: #fff;">Vení a visitarnos</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2556.784609002631!2d-58.5878188!3d-34.751867499999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bcc5a60fc44b67%3A0xb12c9d8e65077223!2sDanilo%20Herrajes!5e1!3m2!1ses-419!2sar!4v1735827299545!5m2!1ses-419!2sar" width="100%" height="420" frameborder="0" style="border:0" allowfullscreen=""></iframe>
    </div>

</div>




<script>
 

    //LOC herraje
    var cant_marcas=1;
    if($(window).width()>=1100)
        cant_marcas=8;
    else{
        if($(window).width()>=670)
            cant_marcas=6;
        else
            cant_marcas=3;
    }

    var swipermarca = new Swiper('#slider_marcas .swiper-container', {
        slidesPerView: cant_marcas,
        spaceBetween: 10,
        centeredSlides: true,
        loop: true,
        autoplayDisableOnInteraction: false,
        autoplay: 500,
        paginationClickable: true,
        speed: 1000
    });

</script>


<div class="footer-widgets">
    <a name="telefono"></a>
    <div class="container" >
        <div class="col-sm-6">
            <img class="logo-principalx" style="margin: 10px 0;width: 260px;" src="img/logo.png">

        </div>
        <div class="col-sm-6 col-md-5 col-md-offset-1  col-lg-5 col-lg-offset-1">
            <p style="margin: 20px 0px 0px 0px; font-size:11px">
            </p>

            <p><i class="fa fa-map-marker" aria-hidden="true"></i>Beethoven 6152<br> Gregorio de Laferrere, Buenos Aires, Argentina</p>
            <p><i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:1144672188">(011) 4467 2188</a>  </p>
            <p><i class="fa fa-whatsapp" aria-hidden="true" style="font-size: 21px;"></i> <a href="https://wa.me/5491136751405">(Whatsapp) (+549) 11 3668 8052</a></p>
            <p><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:ventas@danilodistribuidora.com.ar">ventas@herrajesdanilo.com</a></p>
            <p><i class="fa fa-clock-o" aria-hidden="true"></i> Lunes a Viernes 08:00 a 13:00 y de 14:00 a 17:00<br> Sábados 08:00 a 13:00</p>
            


            <div style="font-size: 26px;" class="color_base">
                <a href="https://youtube.com/@Danilo.Distribuidora" target="_blank" style="margin-left:10px">
                    <img style="margin-right:2px;height: 35px;" src="img/yt.png">
                </a>                     
                <a href="https://instagram.com/danilo.distribuidora.ok/" target="_blank">
                    <img style="margin-right: 4px;height: 35px;" src="img/insta.png">
                </a>                   
                <a href="https://www.tiktok.com/@danilo.distribuidora.ok" target="_blank">
                    <img style="margin-right: 4px;height: 35px;" src="img/tiktok.png">
                </a>                    
                <a href="https://wa.me/5491136688052" target="_blank">
                    <img style="height: 35px;" src="img/whats.png">
                </a>
                <?/* <a href="https://qr.afip.gob.ar/?qr=jMNIqKO782qK7TCACv9ZoQ,," target="_F960AFIPInfo">
                    <img src="https://www.afip.gob.ar/images/f960/DATAWEB.jpg" style="width: 64px;float: right;" alt="" border="0">
                </a>*/?>
            </div>
            <!-- <a id="terminos-mob" href="terminos.php" target="_blank">Terminos y Condiciones</a> -->
            <p style="margin: 20px 0px 0px 0px; font-size:11px">
                <a href="https://www.rpsistemas.com.ar" target="_blank">Desarrollado por RP Sistemas</a>
            </p>
        </div>
<!--         <div class="col-sm-3 no-mobile"><h4>Compras Online</h4>
            <ul>
                <li><a href="#" target="_blank">Como Comprar</a></li> 
                <li><a href="terminos.php" target="_blank">Terminos y Condiciones</a></li>
            </ul>
        </div> -->
    </div>

</div>