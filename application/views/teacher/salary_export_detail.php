<?php
/** Error reporting */
error_reporting(E_ALL);
/** PHPExcel */
include_once 'PHPExcel.php';

/** PHPExcel_Writer_Excel2003用于创建xls文件 */
include_once 'PHPExcel/Writer/Excel5.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// 设置属性
$objPHPExcel->getProperties()->setCreator("工资表");
$objPHPExcel->getProperties()->setLastModifiedBy("工资表");
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
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(20);
}
//设置每个H、I单元格水平右对齐，
$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

for($i=3;$i<=$num+2;$i++){
    $objPHPExcel->getActiveSheet()->getStyle('H'.($i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('I'.($i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
}

//设置列宽度
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);

//设置字体样式
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->mergeCells('A1:N1');    //合并单元格：
$objPHPExcel->getActiveSheet()->SetCellValue('A1', $year.'年'.$month.'工资表');
$j=5;
foreach($list as $key=>$value):
$objPHPExcel->getActiveSheet()->SetCellValue('A'.($j-1),'姓名');
$objPHPExcel->getActiveSheet()->SetCellValue('B'.($j-1),'工资');
$objPHPExcel->getActiveSheet()->SetCellValue('C'.($j-1),'加班费');
$objPHPExcel->getActiveSheet()->SetCellValue('D'.($j-1),'奖金');
$objPHPExcel->getActiveSheet()->SetCellValue('E'.($j-1),'其他补贴');
$objPHPExcel->getActiveSheet()->SetCellValue('F'.($j-1),'高温津贴');
$objPHPExcel->getActiveSheet()->SetCellValue('G'.($j-1),'养老保险金');
$objPHPExcel->getActiveSheet()->SetCellValue('H'.($j-1),'医疗保险金');
$objPHPExcel->getActiveSheet()->SetCellValue('I'.($j-1),'失业保险金');
$objPHPExcel->getActiveSheet()->SetCellValue('J'.($j-1),'住房公积金');
$objPHPExcel->getActiveSheet()->SetCellValue('K'.($j-1),'无薪假期');
$objPHPExcel->getActiveSheet()->SetCellValue('L'.($j-1),'个人所得税');
$objPHPExcel->getActiveSheet()->SetCellValue('M'.($j-1),'其他调整');
$objPHPExcel->getActiveSheet()->SetCellValue('N'.($j-1),'实发薪金');

    $objPHPExcel->getActiveSheet()->mergeCells('A'.($j-2).':N'.($j-2));    //合并单元格：
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$j,$this->teacher['truename']);
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$j,$value['basic']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$j,$value['overtime']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$j,$value['bonus']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$j,$value['othersubsidy']);
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$j,$value['highsubsidy']);
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$j,$value['retire']);
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$j,$value['medical']);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$j,$value['unemployeed']);
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$j,$value['housing']);
    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$j,$value['nosalary']);
    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$j,$value['tax']);
    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$j,$value['adjust']);
    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$j,$value['total']);
$j+=3;
endforeach;

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle($year.'年'.$month.'工资表');

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
header("Content-Disposition:attachment;filename=".$this->teacher['truename']."工资明细表.xls");
header("Content-Transfer-Encoding:binary");

$objWriter->save("php://output");


