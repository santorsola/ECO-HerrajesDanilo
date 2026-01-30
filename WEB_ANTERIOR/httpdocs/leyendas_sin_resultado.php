<? 
if($articulo!='')
	$leyenda='"'.$articulo.'" o';


$leyenda='<p style="font-size: 13px;font-weight: bold;">
				Lo sentimos, NO OBTUVIMOS RESULTADOS para '.$leyenda.' los filtros aplicados.<br><br>

				¡Por favor intentalo nuevamente!<br><br>

				Consejos para la búsqueda<br><br>

				- Revisá tu ortografía por si tuviste algun error.<br>
				- Prueba con otra palabra similar.<br>
				- Intentá de nuevo, buscando únicamente una palabra.<br>
				- Prueba aplicando menos filtros a tu búsqueda.<br>
				- Prueba buscando términos más genéricos luego podrás filtrar los resultados.<br>
				- Si necesitas ayuda pudedes contactarnos haciendo <a href="javascript:;" class="consultas color_base">click aquí</a>.<br>
        </p>';

echo $leyenda;
?>


