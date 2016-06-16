<?php

/** Error reporting */
error_reporting(E_ALL);
/** PHPExcel */
//include_once 'PHPExcel.php';

/** PHPExcel_Writer_Excel2003用于创建xls文件 */
include_once 'PHPExcel/Writer/Excel5.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// 设置属性
$objPHPExcel->getProperties()->setCreator("年级排名表");
$objPHPExcel->getProperties()->setLastModifiedBy("年级排名表");
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

$table_num=count($list);//总的班级数
//总的列数
$pp=count($subject_unique)+5;
$letter=array(
    1=>'B',
    2=>'C',
    3=>'D',
    4=>'E',
    5=>'F'
);

$letter2=array(
    1=>'A',
    2=>'B',
    3=>'C',
    4=>'D',
    5=>'E',
    6=>'F',
    7=>'G',
    8=>'H',
    9=>'I',
    10=>'J',
    11=>'K',
    12=>'L',
    13=>'M',
    14=>'N',
    15=>'O',
    16=>'P',
    17=>'Q',
    18=>'R',
    19=>'S',
    20=>'T'
);
//设置行高度
for($i=1;$i<=$table_num+2;$i++){
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);
}
//设置每个单元格水平，垂直居中
for($i=1;$i<=$table_num+2;$i++){
    for($j=1;$j<=$pp;$j++){
        $objPHPExcel->getActiveSheet()->getStyle($letter2[$j].$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
        $objPHPExcel->getActiveSheet()->getStyle($letter2[$j].$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //设置边框
        $objPHPExcel->getActiveSheet()->getStyle($letter2[$j].$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle($letter2[$j].$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle($letter2[$j].$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle($letter2[$j].$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    }
}

//设置列宽度
for($i=1;$i<=$pp;$i++){
    $objPHPExcel->getActiveSheet()->getColumnDimension($letter2[$i])->setWidth(10);
}

$objPHPExcel->getActiveSheet()->mergeCells('A1:'.$letter2[$pp].'1');    //合并单元格：
$objPHPExcel->getActiveSheet()->SetCellValue('A1', $test_name);
//设置字体样式
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->SetCellValue('A2', '班别');
$objPHPExcel->getActiveSheet()->SetCellValue('B2', '姓名');
foreach($subject_unique as $subject_unique_key=>$subject_unique_value){
    $key=$subject_unique_key+1+2;
    $objPHPExcel->getActiveSheet()->SetCellValue("$letter2[$key]".'2',$subject_unique_value);
}
$kk=count($subject_unique)+3;
$objPHPExcel->getActiveSheet()->SetCellValue("$letter2[$kk]".'2', '总分');
$kk=count($subject_unique)+4;
$objPHPExcel->getActiveSheet()->SetCellValue("$letter2[$kk]".'2', '班次');
$kk=count($subject_unique)+5;
$objPHPExcel->getActiveSheet()->SetCellValue("$letter2[$kk]".'2', '年次');

foreach($list as $k=>$class):
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.($k+3),$class['classname']);
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.($k+3),$class['student']);
    $b=2;
    foreach($class['score'] as $class_key=>$class_value):
        $b++;
        $objPHPExcel->getActiveSheet()->SetCellValue($letter2[$b].($k+3),$class_value);
    endforeach;
    $kk=count($subject_unique)+3;
    $objPHPExcel->getActiveSheet()->SetCellValue("$letter2[$kk]".($k+3), $class['total_score']);
    $kk=count($subject_unique)+4;
    $objPHPExcel->getActiveSheet()->SetCellValue("$letter2[$kk]".($k+3), $class['class_rank']);
    $kk=count($subject_unique)+5;
    $objPHPExcel->getActiveSheet()->SetCellValue("$letter2[$kk]".($k+3), $class['grade_rank']);
endforeach;

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle("$test_name");

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
header("Content-Disposition:attachment;filename=".$test_name.".xls");
header("Content-Transfer-Encoding:binary");

$objWriter->save("php://output");


