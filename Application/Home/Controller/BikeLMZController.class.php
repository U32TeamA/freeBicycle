<?php
namespace Home\Controller;


use Think\Controller;
use Think\Model;
class BikeLMZController extends Controller
{
    private $userModel;//创建Model对象
    
    public function __construct(){
        $this->userModel = new Model();
    }
    
    public function unusual_bicycleView($pageNo = 1 ,$pageNum=10){
        
        $rows = $this->userModel->table("tb_bicycle bi,tb_bicycle_state bs")->where("bi.bs_id=bs.bs_id and bs.bs_name='异常'")
            ->field("bi.bi_id,bi.bi_journey,bi.bi_no,bi.bi_model,bi.bi_puttime,bs.bs_name")->select();
        //总页数
        $totalPage = count($rows)%$pageNum==0?count($rows)/$pageNum:intval(count($rows)/$pageNum)+1;
        //分页数据
        $rows = $this->userModel->table("tb_bicycle bi,tb_bicycle_state bs")->where("bi.bs_id=bs.bs_id and bs.bs_name='异常'")
            ->page($pageNo,$pageNum)->field("bi.bi_id,bi.bi_journey,bi.bi_no,bi.bi_model,bi.bi_puttime,bs.bs_name")->select();
        $_SESSION['totalPage']=$totalPage;
        $_SESSION['rows']=$rows;
        //重定向
       header("Location:http://localhost:8080/freeBicycle/Application/Home/View/LMZ/unusual_bicycleView.php");
    }
}

?>