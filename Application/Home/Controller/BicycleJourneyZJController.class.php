<?php
namespace Home\Controller;

use Think\Controller;
use Think\Model;
class BicycleJourneyZJController extends Controller{
    private $adminZJmodel;
    
    public function __construct(){
        parent::__construct();
        $this->adminZJmodel = new Model("tb_bicycle");
    }
    
    /**
     * 同步+Bootstrap加载单车行程信息
     * @param int $pageNo
     * @param int $pageSize
     */
    public function loadBicycleJourney($pageNo=1,$pageSize=10){
        //总条数
        $total = $this->adminZJmodel->count();
        //数据
        $rows = $this->adminZJmodel->table("tb_bicycle b")
        ->field("b.bi_no,b.bi_model, b.bi_journey,b.bi_putTime")
        ->page($pageNo,$pageSize)->select();
        //数组
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize);
        //发送
        $this->assign("page",$page);
        $this->display("ZJ/loadBicycleJourney");
    }
}

?>