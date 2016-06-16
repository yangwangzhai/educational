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
$objPHPExcel->getProperties()->setCreator("质量分析表");
$objPHPExcel->getProperties()->setLastModifiedBy("质量分析表");
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

$table_num=count($each_class_excellent);//总的科目数
$pp=count($classname_unique)+3;
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
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);

//设置单元格边框
for($i=1;$i<$table_num*$pp+2;$i++){
        for($k=1;$k<=6;$k++){
            $objPHPExcel->getActiveSheet()->getStyle($letter2[$k].$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle($letter2[$k].$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle($letter2[$k].$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        }

}

foreach($each_class_excellent as $k=>$class):
    //设置字体样式
    $objPHPExcel->getActiveSheet()->getStyle('A'.($k*$pp+1))->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A'.($k*$pp+1))->getFont()->setSize(16);
    $objPHPExcel->getActiveSheet()->getStyle('A'.($k*$pp+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('B'.($k*$pp+1))->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('B'.($k*$pp+1))->getFont()->setSize(16);
    $objPHPExcel->getActiveSheet()->getStyle('B'.($k*$pp+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->getActiveSheet()->mergeCells('B'.($k*$pp+1).':F'.($k*$pp+1));    //合并单元格：
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.($k*$pp+1), $subject_unique[$k]);
    $objPHPExcel->getActiveSheet()->mergeCells('A'.($k*$pp+1).':A'.($k*$pp+2));    //合并单元格：
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.($k*$pp+1), '班别');
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.($k*$pp+2), '0.9人数');
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.($k*$pp+2), '0.8人数');
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.($k*$pp+2),'及格人数');
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.($k*$pp+2),'任课老师');
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.($k*$pp+2),'');
    foreach($class as $class_key=>$class_value):
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.($k*$pp+3+$class_key),$class_value['classname']);
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.($k*$pp+3+$class_key),$class_value['excellent_rate1_num']);
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.($k*$pp+3+$class_key),$class_value['excellent_rate2_num']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.($k*$pp+3+$class_key),$class_value['pass_num']);
        /*$objPHPExcel->getActiveSheet()->SetCellValue('E'.($k*$pp+3+$class_key),$class_value['avg_score']);*/
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.($k*$pp+3+$class_key),'');
    endforeach;
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.($k*$pp+$pp),'年级');
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.($k*$pp+$pp),$grade_excellent[$k]['excellent_rate1_num_grade']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.($k*$pp+$pp),$grade_excellent[$k]['excellent_rate2_num_grade']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.($k*$pp+$pp),$grade_excellent[$k]['pass_num_grade']);
    /*$objPHPExcel->getActiveSheet()->SetCellValue('E'.($k*$pp+$pp),$grade_excellent[$k]['avg_score_grade']);*/
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.($k*$pp+$pp),'');
endforeach;

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle("$test_name".'各优秀率人数 ');

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
header("Content-Disposition:attachment;filename=".$test_name."各优秀率人数.xls");
header("Content-Transfer-Encoding:binary");

$objWriter->save("php://output");


