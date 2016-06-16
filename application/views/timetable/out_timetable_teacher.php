<?php

/** Error reporting */
error_reporting(E_ALL);
/** PHPExcel */
include_once 'PHPExcel.php';

/** PHPExcel_Writer_Excel2003用于创建xls文件 */
include_once 'PHPExcel/Writer/Excel5.php';

//Create new PHPExcel object
$objPHPExcel = new PHPExcel();

//设置属性
$objPHPExcel->getProperties()->setCreator("教师表");
$objPHPExcel->getProperties()->setLastModifiedBy("教师表");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");


/*转换编码格式
function convertUTF8($str)
{
    if(empty($str)) return '';
    return  iconv("UTF-8","gb2312",$str);
}*/

//往单元格里添加数据
$objPHPExcel->setActiveSheetIndex(0);
$pp=count($sections)+3;
$table_num=count($list);//总的班级数
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
    6=>'F'
);
//设置行高度 $table_num*10 每个班级10行
for($i=1;$i<=$table_num*$pp;$i++){
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);
}
//设置每个单元格水平，垂直居中
for($i=1;$i<=$table_num*$pp;$i++){
    for($j=1;$j<=6;$j++){
        $objPHPExcel->getActiveSheet()->getStyle($letter2[$j].$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
        $objPHPExcel->getActiveSheet()->getStyle($letter2[$j].$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    }
}

//设置列宽度
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);

//设置单元格边框
for($i=0;$i<$table_num;$i++){
    for($j=2;$j<=$pp+1;$j++){
        for($k=1;$k<=6;$k++){
            if($j<$pp+1){
                $objPHPExcel->getActiveSheet()->getStyle($letter2[$k].($j+$i*$pp))->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle($letter2[$k].($j+$i*$pp))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle($letter2[$k].($j+$i*$pp))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            }else{
                $objPHPExcel->getActiveSheet()->getStyle($letter2[$k].($j+$i*$pp))->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            }

        }
    }
}

foreach($list as $k=>$class):
    //设置字体样式
    $objPHPExcel->getActiveSheet()->getStyle('A'.($k*$pp+2))->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A'.($k*$pp+2))->getFont()->setSize(16);
    $objPHPExcel->getActiveSheet()->getStyle('A'.($k*$pp+2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->getActiveSheet()->mergeCells('A'.($k*$pp+1).':F'.($k*$pp+1));    //合并单元格：
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.($k*$pp+1));
    $objPHPExcel->getActiveSheet()->mergeCells('A'.($k*$pp+2).':F'.($k*$pp+2));    //合并单元格：
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.($k*$pp+2), $class['teacher_truename']);
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.($k*$pp+3));
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.($k*$pp+3), '周一');
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.($k*$pp+3), '周二');
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.($k*$pp+3),'周三');
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.($k*$pp+3),'周四');
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.($k*$pp+3),'周五');
    foreach($sections as $section_key=>$sction):
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.($k*$pp+3+$section_key),$section_key);
        foreach($weeks as $week_key=>$week):
            $objPHPExcel->getActiveSheet()->SetCellValue($letter[$week_key].($k*$pp+3+$section_key),$class['table'][$section_key][$week_key]['title'].$class['table'][$section_key][$week_key]['grade'].$class['table'][$section_key][$week_key]['classname']);
        endforeach;
    endforeach;
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
header("Content-Disposition:attachment;filename=教师课表.xls");
header("Content-Transfer-Encoding:binary");

$objWriter->save("php://output");


