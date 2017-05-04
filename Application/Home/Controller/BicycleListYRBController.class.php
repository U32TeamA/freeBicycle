<?php
namespace Home\Controller;

use Think\Controller;
class BicycleListYRBController extends Controller{
    private $BicycleListYRBModel;
    public function __construct(){
        parent::__construct();
        $this->BicycleListYRBModel = M(tb_bicycle);
    }
    /**
     * 查询单车信息
     */
    public function BicycListLoad($pageNo=1,$pageSize=10){
        //总条数
        $total = $this->BicycleListYRBModel->count();
        //数据
        $rows = $this->BicycleListYRBModel->table("tb_bicycle b,tb_bicycle_state bs,tb_rent r,tb_user u")
        ->where("b.bs_id=bs.bs_id and b.re_id=r.re_id and r.u_id=u.u_id")
        ->field("b.bi_joureny as joureny,bs.bs_name as name,r.re_begin as begin,r.re_end as end,u.u_account as account")->page($pageNo,$pageSize)->select();
        //数组
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize);
        //发送
        $this->assign("page",$page);
        $this->display();
    }
}

?>