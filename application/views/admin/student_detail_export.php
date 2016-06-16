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
$objPHPExcel->getProperties()->setCreator($title);
$objPHPExcel->getProperties()->setLastModifiedBy($title);
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
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(20);

//设置字体样式
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->mergeCells('A1:V1');    //合并单元格：
$objPHPExcel->getActiveSheet()->SetCellValue('A1', $title);


$objPHPExcel->getActiveSheet()->SetCellValue('A2','姓名');
$objPHPExcel->getActiveSheet()->SetCellValue('B2','班级名称');
$objPHPExcel->getActiveSheet()->SetCellValue('C2','学籍号');
$objPHPExcel->getActiveSheet()->SetCellValue('D2','性别');
$objPHPExcel->getActiveSheet()->SetCellValue('E2','出生日期');
$objPHPExcel->getActiveSheet()->SetCellValue('F2','身份证件类型');
$objPHPExcel->getActiveSheet()->SetCellValue('G2','身份证件号码');
$objPHPExcel->getActiveSheet()->SetCellValue('H2','民族');
$objPHPExcel->getActiveSheet()->SetCellValue('I2','出生地');
$objPHPExcel->getActiveSheet()->SetCellValue('J2','户口性质');
$objPHPExcel->getActiveSheet()->SetCellValue('K2','户口所在地');
$objPHPExcel->getActiveSheet()->SetCellValue('L2','现住址');
$objPHPExcel->getActiveSheet()->SetCellValue('M2','入园日期');
$objPHPExcel->getActiveSheet()->SetCellValue('N2','是否独生子女');
$objPHPExcel->getActiveSheet()->SetCellValue('O2','是否留守儿童');
$objPHPExcel->getActiveSheet()->SetCellValue('P2','是否进城务工人员随迁子女');
$objPHPExcel->getActiveSheet()->SetCellValue('Q2','是否残疾幼儿');
$objPHPExcel->getActiveSheet()->SetCellValue('R2','残疾幼儿类别');
$objPHPExcel->getActiveSheet()->SetCellValue('S2','是否寄宿生');
$objPHPExcel->getActiveSheet()->SetCellValue('T2','是否孤儿');
$objPHPExcel->getActiveSheet()->SetCellValue('U2','是否低保');
$objPHPExcel->getActiveSheet()->SetCellValue('V2','是否接受资助');

$arr=array(1=>'是',2=>'不是');
foreach($list as $key=>$value):
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.($key+3),$value['name']);
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.($key+3),$value['nickname']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.($key+3),$value['number']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.($key+3),config_item('gender')[$value['gender']]);
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.($key+3),$value['birthday']);
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.($key+3),config_item('idcardtype')[$value['idcardtype']]);
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.($key+3),$value['idcard']);
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.($key+3),$value['nation']);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.($key+3),$value['bir_address']);
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.($key+3),config_item('account')[$value['account']]);
    $objPHPExcel->getActiveSheet()->SetCellValue('K'.($key+3),$value['account_address']);
    $objPHPExcel->getActiveSheet()->SetCellValue('L'.($key+3),$value['address']);
    $objPHPExcel->getActiveSheet()->SetCellValue('M'.($key+3),$value['pubdate']);
    $objPHPExcel->getActiveSheet()->SetCellValue('N'.($key+3),$arr[$value['child']]);
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.($key+3),$arr[$value['stay']]);
    $objPHPExcel->getActiveSheet()->SetCellValue('P'.($key+3),$arr[$value['workers']]);
    $objPHPExcel->getActiveSheet()->SetCellValue('Q'.($key+3),$arr[$value['disabled']]);
    $objPHPExcel->getActiveSheet()->SetCellValue('R'.($key+3),config_item('disabled_type')[$value['disabled_type']]);
    $objPHPExcel->getActiveSheet()->SetCellValue('S'.($key+3),$arr[$value['boarding']]);
    $objPHPExcel->getActiveSheet()->SetCellValue('T'.($key+3),$arr[$value['orphans']]);
    $objPHPExcel->getActiveSheet()->SetCellValue('U'.($key+3),$arr[$value['allowances']]);
    $objPHPExcel->getActiveSheet()->SetCellValue('V'.($key+3),$arr[$value['support']]);
endforeach;

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle($title);

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
header("Content-Disposition:attachment;filename=$title.xls");
header("Content-Transfer-Encoding:binary");

$objWriter->save("php://output");


