<?
if ($no_mostrar_categorias)
    return;
$descrip_agru1=consultar_configuracion('AGRU1_DESCRIP'); 
$descrip_agru2=consultar_configuracion('AGRU2_DESCRIP');
$descrip_agru3=consultar_configuracion('AGRU3_DESCRIP'); 
$descrip_agru1='MARCA'; 
$descrip_agru2='CATEGORIA'; 
$descrip_agru3=''; 

if($modo_grilla=='S')
    $index_url="index_grilla.php";
else
    $index_url="index.php";


if($agru_1!=''){
    $sql="eco_agrupaciones_consul '".$agru_1."',1";
    $sql.=",@usuario='".$_SESSION['usuario']."'";
    $result = sqlsrv_query($conn,$sql);
    $row = sqlsrv_fetch_array($result);
    $titulo_busqueda.=$descrip_agru1.' > '.$row['DESCRIP_AGRU'];
}
if($agru_2!=''){
    $sql="eco_agrupaciones_consul '".$agru_2."',2";
    $sql.=",@usuario='".$_SESSION['usuario']."'";
    $result = sqlsrv_query($conn,$sql);
    $row = sqlsrv_fetch_array($result);
    if ($titulo_busqueda!="") $titulo_busqueda=$titulo_busqueda.' | ';
    $titulo_busqueda.=$descrip_agru2.' > '.$row['DESCRIP_AGRU'];
}
if($agru_3!=''){
    $sql="eco_agrupaciones_consul '".$agru_3."',3";
    $sql.=",@usuario='".$_SESSION['usuario']."'";
    $result = sqlsrv_query($conn,$sql);
    $row = sqlsrv_fetch_array($result);
    if ($titulo_busqueda!="") $titulo_busqueda=$titulo_busqueda.' | ';
    $titulo_busqueda.=$descrip_agru3.' > '.$row['DESCRIP_AGRU'];
}

?>

<script> 
$(document).ready(function(){

    if($(window).width()>=670){
        <?if($articulo==""){?>
            <?if($agru_1==''){?>
                $(".agru1").css('display','none');//para ya abiertas: css('display','flex');
            <?}?>
            <?if($agru_2==''){?>
                $(".agru2").css('display','none');//para ya abiertas: css('display','flex');
            <?}?>
            <?if($agru_3==''){?>
                $(".agru3").css('display','none');//para ya abiertas: css('display','flex');
            <?}?>
        <?}?>
    }else{
        <?if($articulo==""){?>
                $(".agru1").css('display','none');//para que en mobile esten siempre cerradas  
                $(".agru2").css('display','none');//y haya menos scroll 
                $(".agru3").css('display','none');// 
        <?}?>
    }


    $( ".categorias a").click(function() {
        var id;
        var num_agru;

        id=$(this).attr('id');
        $( "."+id ).animate({
            height: 'toggle'
        });
    });

}); //document.ready

</script>


        <nav class="categorias">
            <!--  <div class="buscador2">
                <i class="material-icons lupa2" id="btn-buscar">search</i>
                <input type="text" id="busqueda" placeholder="Buscar por código o descripción" class="input-rojo">
            </div>-->
            <ul>
<!--                 <li>
                    <a href="<?=$index_url?>?articulo=">Productos<i class="material-icons icono">add</i></a>
                </li> -->

                <?if($descrip_agru1!=''){?>
	                <li>
	                    <a href="javascript:;" id="ag1"><?=$descrip_agru1?><i class="material-icons icono">add</i></a>
	                </li>
	                <div class="agru1 ag1">
	                    <? 
	                    $sql="eco_agrupaciones_consul null,1";
                        $sql.=",@articulo=".($articulo==""?"null":"'%".$articulo."%'");
                        $sql.=",@usuario='".$_SESSION['usuario']."'";
  
	                    $result = sqlsrv_query($conn,$sql);

	                    while ( $row = sqlsrv_fetch_array($result)){
                            if($row['CODI_AGRU']==$agru_1){
                                $class='class="activo"';
                                //$link=$index_url."?articulo=".$articulo."&agru_1=&agru_2=".$agru_2."&agru_3=".$agru_3;
                                $link=$index_url."?articulo=".$articulo."&agru_1=&agru_2=&agru_3=";
                                $descrip=$row['DESCRIP_AGRU'].' [X]';
                            }else{
                                $class='class="ag-item"';
                                //$link=$index_url."?articulo=".$articulo."&agru_1=".$row['CODI_AGRU']."&agru_2=".$agru_2."&agru_3=".$agru_3;
                                $link=$index_url."?articulo=".$articulo."&agru_1=".$row['CODI_AGRU']."&agru_2=&agru_3=";
                                $descrip=$row['DESCRIP_AGRU'];
                            }
                            $link.="&cant_x_pagina=".$cant_x_pagina."&modo_grilla=".$modo_grilla;
                            ?>
	                       <a <?=$class?> href="<?=$link?>"><i class="material-icons icono2">chevron_right</i><?=$descrip?></a>
	                    <?}?>
	                </div>
                <?}?>

                <?if($descrip_agru2!=''){?>
                    <li>
                        <a href="javascript:;" id="ag2"><?=$descrip_agru2?><i class="material-icons icono">add</i></a>

                    </li>
                    <div class="agru2 ag2">
                        <?
                        $sql="eco_agrupaciones_consul null,2";
                        $sql.=",@articulo=".($articulo==""?"null":"'%".$articulo."%'");
						$sql.=",@agru_padre=".($agru_1==""?"null":"'".$agru_1."'");
                        $sql.=",@usuario='".$_SESSION['usuario']."'";

                        $result = sqlsrv_query($conn,$sql);

                        while ( $row = sqlsrv_fetch_array($result)){
                            if($row['CODI_AGRU']==$agru_2){
                                $class='class="activo"';
                                //$link=$index_url."?articulo=".$articulo."&agru_1=".$agru_1."&agru_2=&agru_3=".$agru_3;
                                $link=$index_url."?articulo=".$articulo."&agru_1=".$agru_1."&agru_2=&agru_3=";
                                $descrip=$row['DESCRIP_AGRU'].' [X]';
                            }else{
                                $class='';
                                //$link=$index_url."?articulo=".$articulo."&agru_1=".$agru_1."&agru_2=".$row['CODI_AGRU']."&agru_3=".$agru_3;
                                $link=$index_url."?articulo=".$articulo."&agru_1=".$agru_1."&agru_2=".$row['CODI_AGRU']."&agru_3=";
                                $descrip=$row['DESCRIP_AGRU'];
                            }
                            $link.="&cant_x_pagina=".$cant_x_pagina."&modo_grilla=".$modo_grilla;
                            ?>
                           <a <?=$class?> href="<?=$link?>"><i class="material-icons icono2">chevron_right</i><?=$descrip?></a>
                        <?}?>
                    </div>
                <?}?>

                <?if($descrip_agru3!=''){?>
                    <li>
                        <a href="javascript:;" id="ag3"><?=$descrip_agru3?><i class="material-icons icono">add</i></a>
                    </li>
                    <div class="agru3 ag3">
                        <?
                        $sql="eco_agrupaciones_consul null,3";
                        $sql.=",@articulo=".($articulo==""?"null":"'%".$articulo."%'");
						$sql.=",@agru_padre=".($agru_1==""?"null":"'".$agru_1."'");
						$sql.=",@agru_padre_2=".($agru_2==""?"null":"'".$agru_2."'");
                        $sql.=",@usuario='".$_SESSION['usuario']."'";

                        $result = sqlsrv_query($conn,$sql);

                        while ( $row = sqlsrv_fetch_array($result)){
                            if($row['CODI_AGRU']==$agru_3){
                                $class='class="activo"';
                                $link=$index_url."?articulo=".$articulo."&agru_1=".$agru_1."&agru_2=".$agru_2."&agru_3=";
                                $descrip=$row['DESCRIP_AGRU'].' [X]';
                            }else{
                                $class='';
                                $link=$index_url."?articulo=".$articulo."&agru_1=".$agru_1."&agru_2=".$agru_2."&agru_3=".$row['CODI_AGRU'];
                                $descrip=$row['DESCRIP_AGRU'];
                            }
                            $link.="&cant_x_pagina=".$cant_x_pagina."&modo_grilla=".$modo_grilla;
                            ?>
                           <a <?=$class?> href="<?=$link?>"><i class="material-icons icono2">chevron_right</i><?=$descrip?></a>
                        <?}?>
                    </div>
                <?}?>
            </ul>

            <div class="nav-marcas">
  
            </div>
        </nav>