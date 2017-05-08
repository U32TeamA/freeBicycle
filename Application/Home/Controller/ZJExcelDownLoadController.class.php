<?php
namespace Home\Controller;

use Think\Controller;
use Think\Model;
class ZJExcelDownLoadController extends Controller
{
    private $user ;
    public function __construct(){
        $this->user = new Model();
    }
    public function excelDownLoad(){
        $detil = dirname(__DIR__);
        require_once "Public/PHPExcel.php";
        require_once 'Public/PHPExcel/Writer/Excel2007.php';
        $table = $_REQUEST["table"];
        $where = $_REQUEST["where"];
        $field = $_REQUEST["field"];
        //echo __DIR__;
        $dbutil = new Model();
        $data = $dbutil->table("$table")->where("$where")->field("$field")->select();
        $phpExcel = new \PHPExcel();//创建PHPExcel对象
        $tableHeader = $_REQUEST['tableHeader'];//设置表头
        $AZ = array();//设置
        for($i=0 ; $i<count($tableHeader) ; $i++){
            $j = 65+$i;
            $AZ[$i]=chr($j);
        }
        $sheet = $phpExcel->getSheet(0);//获取第一个工作簿 索引为0
        // $AZ = getAZ(count($tableHeader));//获取列数，并转换成ABC..形式
        $i=0;
        
        foreach ($tableHeader as $t){
            $A = $AZ[$i]."1";
            $sheet->setCellValue($A, $t);     //填充表头
            $i++;
            //设置表头的对齐方式为居中对齐
            $sheet->getStyle($A)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //设置表头的字体大小和加粗
            $sheet->getStyle($A)->getFont()->setSize(12)->setBold(true);
        }
        $i = 0;
        foreach ($data as $rows){
            $j = 0;
            foreach ($rows as $r){
                $A = $AZ[$j].($i+2);
                $sheet->setCellValue($A , $r);
                $sheet->getStyle($A)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $j++;
            }
            $i++;
        }
        $load = "Public/tmpFiles/new.xls";
        $objWriter = new \PHPExcel_Writer_Excel2007($phpExcel);//创建输出流
        $objWriter->save($load);//保存临时文件
        echo $load;
    }
    /**
     * 下载EXCEL文件
     */
    public function down(){
        $laod = $_REQUEST['load'];
        $name = $_REQUEST['name'];
        //文件下载
        header("Content-type:application/vnd.ms-excel");
        header('Content-Disposition: attachment;filename='.$name);
        header("Content-Length:".filesize($laod));
        readfile($laod);
        //下载完毕后删除临时文件
        if(file_exists($laod)){
            unlink($laod);
        }
    }
}

?>