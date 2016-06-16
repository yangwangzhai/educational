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
$objPHPExcel->getProperties()->setCreator("课程总表");
$objPHPExcel->getProperties()->setLastModifiedBy("课程总表");
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
$pp=count($sections);
$table_num=count($list);//总的班级数
$letter=array( 1=>'B',2=>'C',3=>'D',4=>'E',5=>'F',6=>'G',7=>'H',8=>'I',9=>'J',10=>'K',11=>'L',12=>'M',13=>'N',
                14=>'O',15=>'P',16=>'Q',17=>'R',18=>'S',19=>'T',20=>'U',21=>'V',22=>'W',23=>'X',24=>'Y',25=>'Z',
                26=>'AA',27=>'AB',28=>'AC',29=>'AD',30=>'AE',31=>'AF',32=>'AG',33=>'AH',34=>'AI',35=>'AJ',36=>'AK',
                37=>'AL',38=>'AM',39=>'AN',40=>'AO',41=>'AP'
            );

$letter2=array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E',6=>'F',7=>'G',8=>'H',9=>'I',10=>'J',11=>'K',12=>'L',13=>'M',14=>'N',
    15=>'O',16=>'P',17=>'Q',18=>'R',19=>'S',20=>'T',21=>'U',22=>'V',23=>'W',24=>'X',25=>'Y',26=>'Z',
    27=>'AA',28=>'AB',29=>'AC',30=>'AD',31=>'AE',32=>'AF',33=>'AG',34=>'AH',35=>'AI',36=>'AJ',37=>'AK',38=>'AL',39=>'AM',
    40=>'AN',41=>'AO'
);
//设置行高度 $table_num+2 头占了两行所以加2
for($i=1;$i<=$table_num+2;$i++){
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);
}
//设置每个单元格水平，垂直居中

for($i=1;$i<=$table_num+2;$i++){
    $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
    $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    for($j=1;$j<=$pp*5;$j++){
        $objPHPExcel->getActiveSheet()->getStyle($letter[$j].$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
        $objPHPExcel->getActiveSheet()->getStyle($letter[$j].$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    }
}

//设置列宽度
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
foreach($letter as $key=>$value){
    $objPHPExcel->getActiveSheet()->getColumnDimension($value)->setWidth(10);
}

//设置单元格边框
for($i=0;$i<$table_num+2;$i++){
    for($k=1;$k<=$pp*5+1;$k++){
        $objPHPExcel->getActiveSheet()->getStyle($letter2[$k].($i+1))->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle($letter2[$k].($i+1))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle($letter2[$k].($i+1))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    }
}


    /*//设置字体样式
    $objPHPExcel->getActiveSheet()->getStyle('A'.($k*10+1))->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A'.($k*10+1))->getFont()->setSize(16);
    $objPHPExcel->getActiveSheet()->getStyle('A'.($k*10+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/

    foreach($weeks as $key=>$value){
        $objPHPExcel->getActiveSheet()->mergeCells($letter[$pp*($key-1)+1]."1:".$letter[$pp*$key]."1");    //合并单元格
        $objPHPExcel->getActiveSheet()->SetCellValue($letter[$pp*($key-1)+1].'1',"$value");
    }

    foreach($weeks as $week_key=>$week):
        foreach($sections as $section_key=>$sction):
            $objPHPExcel->getActiveSheet()->SetCellValue($letter[$section_key+($week_key-1)*$pp].'2',$section_key);
        endforeach;
    endforeach;

    foreach($list as $k=>$class):
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.($k+3),$class['grade'].$class['classname']);
        foreach($weeks as $week_key=>$week):
            foreach($sections as $section_key=>$sction):
                $str1=$class['table'][$week_key][$section_key]['title'];
                $str2=$class['table'][$week_key][$section_key]['teacher_truename'];
/*                $objPHPExcel->getActiveSheet()->SetCellValue($letter[$section_key+($week_key-1)*$pp].(3+$k),"$str1\r\n$str2");*///课程表含有老师名字
                $objPHPExcel->getActiveSheet()->SetCellValue($letter[$section_key+($week_key-1)*$pp].(3+$k),"$str1");//课程表不含老师名字
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
header("Content-Disposition:attachment;filename=课程总表.xls");
header("Content-Transfer-Encoding:binary");

$objWriter->save("php://output");


