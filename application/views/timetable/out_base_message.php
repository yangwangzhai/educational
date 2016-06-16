<?php
/** Error reporting */
error_reporting(E_ALL);



/** PHPExcel_Writer_Excel2003用于创建xls文件 */
include_once 'PHPExcel/Writer/Excel5.php';
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// 设置属性
$objPHPExcel->getProperties()->setCreator("课时表");
$objPHPExcel->getProperties()->setLastModifiedBy("课时表");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

/*转换编码格式
function convertUTF8($str)
{
    if(empty($str)) return '';
    return  iconv("UTF-8","gb2312",$str);
}*/

// 往单元格里添加数据
$objPHPExcel->setActiveSheetIndex(0);

$num=count($list);
//设置行高度
for($i=1;$i<=$num+2;$i++){
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(25);
}
//设置每个H、I单元格水平右对齐，
/*$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/

/*for($i=3;$i<=$num+2;$i++){
    $objPHPExcel->getActiveSheet()->getStyle('D'.($i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('E'.($i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
}*/

//设置列宽度
/*$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(130);*/



$replace=array("grade"=>"A","classname"=>"B","0"=>"C","1"=>"D","2"=>"E","3"=>"F","4"=>"G",
    "5"=>"H","6"=>"I","7"=>"J","8"=>"K","9"=>"L","10"=>"M","11"=>"N",
    "12"=>"O","13"=>"P","14"=>"Q","15"=>"R","16"=>"S","17"=>"T","18"=>"U","19"=>"V","20"=>"W","21"=>"X","22"=>"Y","23"=>"Z",);

foreach($list as $key=>$value):
    foreach($value as $k=>$val){
        $objPHPExcel->getActiveSheet()->getStyle("$replace[$k]".($key+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("$replace[$k]".($key+1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->SetCellValue("$replace[$k]".($key+1),$val);
    }
endforeach;

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('yyy');

// Save Excel 2007 file
//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
$objWriter->save(str_replace('.php', '.xls', __FILE__));
header("Pragma: public");
header("Expires: 0");
header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
header("Content-Type:application/force-download");
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");

header("Content-Type:application/octet-stream");
header("Content-Type:application/download");
header("Content-Disposition:attachment;filename=课时表.xls");
header("Content-Transfer-Encoding:binary");

$objWriter->save("php://output");


