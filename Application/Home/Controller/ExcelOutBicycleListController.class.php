<?php
namespace Home\Controller;
require_once "Public/PHPExcel.php";
require_once 'Public/PHPExcel/Writer/Excel2007.php';
use Think\Controller;
use Think\Model;
class ExcelOutBicycleListController extends Controller{
    private $outPutModel;
    public function __construct(){
        $this->outPutModel = new Model();
    }
    public function ExcelOutBicycleList(){
        $rows = $this->outPutModel->table("tb_bicycle b")->join("tb_bicycle_state bs on b.bs_id=bs.bs_id","LEFT")->join("tb_rent r on b.re_id=r.re_id","LEFT")
        ->join("tb_user u on r.u_id=u.u_id","LEFT")
        ->field("b.bi_id as id,b.bi_no as no,b.bi_model as model,u.u_account as account,b.bi_useState as state,b.bi_putTime as time,b.bi_NumOfUse as num,
            b.bi_journey as journey,bs.bs_name as name,r.re_begin as begin,r.re_end as end,b.bi_scrap as scrap")
                ->select();
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
                foreach ($rows as $rows){
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