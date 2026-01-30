<?
include "funciones/conexion.php";
include "funciones/funciones_generales.php";

//En los archivo que baja a excel hay que expander la memoria que usa, ya que si tiene muchos registros desborda memoria
ini_set('memory_limit', '256M');

if (comprobar_sesson()==false){
  logout();
  header('Location: index.php?mje_tipo=3');
  exit();
}


$agru_1=$_GET['agru_1'];
$agru_2=$_GET['agru_2'];
$agru_3=$_GET['agru_3'];

$agru_1=$agru_1!='undefined'? $agru_1 : "";
$agru_2=$agru_2!='undefined'? $agru_2 : "";
$agru_3=$agru_3!='undefined'? $agru_3 : "";
//$fecha_desde=str_replace('-', '', $_GET['fecha_desde']);
//$fecha_hasta=str_replace('-', '', $_GET['fecha_hasta']);

$descrip_agru1=consultar_configuracion('AGRU1_DESCRIP');
$descrip_agru2=consultar_configuracion('AGRU2_DESCRIP');
$descrip_agru3=consultar_configuracion('AGRU3_DESCRIP'); 


/** Se agrega la libreria PHPExcel */
require_once 'funciones/PHPExcel/PHPExcel.php';
/*
http://www.ingenieroweb.com.co/exportar-datos-desde-mysql-excel-con-php
http://comunidad.fware.pro/dev/php/como-crear-verdaderos-archivos-de-excel-usando-phpexcel/
http://www.codedrinks.com/crear-un-reporte-en-excel-con-php-y-mysql/
*/


// Se crea el objeto PHPExcel
$objPHPExcel = new PHPExcel();

// Se asignan las propiedades del libro
$objPHPExcel->getProperties()->setCreator("Rp Sistemas") //Autor
                     ->setLastModifiedBy("Rp Sistemas") //Ultimo usuario que lo modificó
                     ->setTitle("Reporte Excel")
                     ->setSubject("Reporte Excel")
                     ->setDescription("Reporte web")
                     ->setKeywords("Reporte web")
                     ->setCategory("Reporte excel");

// Se asigna el nombre a la hoja
$objPHPExcel->getActiveSheet()->setTitle('Lista_de_precios');

// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
$objPHPExcel->setActiveSheetIndex(0);
// Inmovilizar paneles 
//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
//$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

$tituloReporte = "Lista de precios";
$titulosColumnas = array('Codigo', 'Descripcion', 'Moneda   ','Precio (IVA incl.)','Oferta','Fin Oferta','Precio de lista',$descrip_agru1,$descrip_agru2,$descrip_agru3);



$gdImage = imagecreatefrompng('img/logo.png');
// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setImageResource($gdImage);
$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
$objDrawing->setHeight(50);
$objDrawing->setCoordinates('A2');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');



//Unifica celda para el titulo
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:F1');
                
// Se agregan los titulos del reporte
$objPHPExcel->setActiveSheetIndex(0)
            //->setCellValue('A1',$tituloReporte) // Titulo del reporte

            ->setCellValue('A5',  $titulosColumnas[0])
            ->setCellValue('B5',  $titulosColumnas[1])
            ->setCellValue('C5',  $titulosColumnas[2])
            ->setCellValue('D5',  $titulosColumnas[3])
            ->setCellValue('E5',  $titulosColumnas[4])
            ->setCellValue('F5',  $titulosColumnas[5])
            ->setCellValue('G5',  $titulosColumnas[6])
            ->setCellValue('H5',  $titulosColumnas[7])
            ->setCellValue('I5',  $titulosColumnas[8])
            ->setCellValue('J5',  $titulosColumnas[9]);



$sql="select convert(numeric(12,2),mone_coti)mone_coti from monedas where codi_afip='DOL' ";

$result = sqlsrv_query($conn,$sql);
$row = sqlsrv_fetch_array($result);
//$coti='TC= '.$row['mone_coti'];

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('E4',  utf8_encode($coti));


$sql="eco_articulos_consul ";
$sql.=$agru_1!=''? "@agru_1='".$agru_1."'," : "@agru_1=null,";
$sql.=$agru_2!=''? "@agru_2='".$agru_2."'," : "@agru_2=null,";
$sql.=$agru_3!=''? "@agru_3='".$agru_3."'," : "@agru_3=null,";
$sql.="@usuario='".$_SESSION['usuario']."',";
$sql.=$fecha_desde!=''? "@fecha_desde='".$fecha_desde."'," : "@fecha_desde=null,";
$sql.=$fecha_hasta!=''? "@fecha_hasta='".$fecha_hasta."'" : "@fecha_hasta=null";

$result = sqlsrv_query($conn,$sql);
$i = 6; //fila inicio
while ( $row = sqlsrv_fetch_array($result)){
    
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i,  utf8_encode($row['cod_articulo']))
            ->setCellValue('B'.$i,  utf8_encode($row['descrip_arti']))
            ->setCellValue('C'.$i,  utf8_encode($row['mone']))
            ->setCellValue('D'.$i,  utf8_encode($row['precio_vta']))
            ->setCellValue('E'.$i,  utf8_encode($row['descrip_oferta']))
            ->setCellValue('F'.$i,  utf8_encode($row['fin_oferta']))
            ->setCellValue('G'.$i,  utf8_encode($row['precio_sin_oferta']))
            ->setCellValue('H'.$i,  utf8_encode($row['descrip_agru1']))
            ->setCellValue('I'.$i,  utf8_encode($row['descrip_agru2']))
            ->setCellValue('J'.$i,  utf8_encode($row['descrip_agru3']));
            $i++;

//$objSheet->setCellValue('A1', '=Hyperlink("https://www.someurl.com/","Mi web")');

}



$estiloTituloReporte = array(
    'font' => array(
        'name'      => 'Verdana',
        'bold'      => true,
        'italic'    => false,
        'strike'    => false,
        'size' =>16
    ),
    'alignment' =>  array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'rotation'   => 0,
            'wrap'       => TRUE
    )
);


$estiloTituloColumnas = array(
    'font' => array(
        'name'      => 'Arial',
        'bold'      => true,
        'size'      => 11,
        'color' => array('rgb' => 'ffffff')
    ),
    'fill' => array(
        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '538dd5')
    ),
    'alignment' =>  array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => TRUE
    ));


/*
$estiloInformacion = new PHPExcel_Style();
$estiloInformacion->applyFromArray(
array(
    'font' => array(
        'name'      => 'Arial',
        'bold'      => fasle,
        'size'      => 10
    ),
    'alignment' =>  array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => TRUE
    ))
));*/



$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($estiloTituloReporte);
$objPHPExcel->getActiveSheet()->getStyle('A5:K5')->applyFromArray($estiloTituloColumnas);       
//$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:AR".($i-1));




//Se autosizean las columnas Desde 1er col a ultima
for($i = 'A'; $i <= 'Z'; $i++){
    $objPHPExcel->setActiveSheetIndex(0)            
        ->getColumnDimension($i)->setAutoSize(TRUE);
}


// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Lista_de_Precios.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;






/* para poner estilo
$estiloTituloReporte = array(
    'font' => array(
        'name'      => 'Verdana',
        'bold'      => true,
        'italic'    => false,
        'strike'    => false,
        'size' =>16,
            'color'     => array(
                'rgb' => 'FFFFFF'
            )
    ),
    'fill' => array(
        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('argb' => 'FF220835')
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE                    
        )
    ), 
    'alignment' =>  array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'rotation'   => 0,
            'wrap'          => TRUE
    )
);

$estiloTituloColumnas = array(
    'font' => array(
        'name'      => 'Arial',
        'bold'      => true,                          
        'color'     => array(
            'rgb' => 'FFFFFF'
        )
    ),
    'fill'  => array(
        'type'      => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
        'rotation'   => 90,
        'startcolor' => array(
            'rgb' => 'c47cf2'
        ),
        'endcolor'   => array(
            'argb' => 'FF431a5d'
        )
    ),
    'borders' => array(
        'top'     => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            'color' => array(
                'rgb' => '143860'
            )
        ),
        'bottom'     => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            'color' => array(
                'rgb' => '143860'
            )
        )
    ),
    'alignment' =>  array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'          => TRUE
    ));
    
$estiloInformacion = new PHPExcel_Style();
$estiloInformacion->applyFromArray(
    array(
        'font' => array(
        'name'      => 'Arial',               
        'color'     => array(
            'rgb' => '000000'
        )
    ),
    'fill'  => array(
        'type'      => PHPExcel_Style_Fill::FILL_SOLID,
        'color'     => array('argb' => 'FFd9b7f4')
    ),
    'borders' => array(
        'left'     => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN ,
            'color' => array(
                'rgb' => '3a2a47'
            )
        )             
    )
));
 
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($estiloTituloReporte);
$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->applyFromArray($estiloTituloColumnas);       
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:D".($i-1));*/
        

        

?>