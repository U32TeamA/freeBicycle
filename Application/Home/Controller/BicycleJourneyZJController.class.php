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
    /**
     * 同步+Bootstrap加载用户充值记录信息
     * @param int $pageNo
     * @param int $pageSize
     */
    public function loadUserRecharge($pageNo=1,$pageSize=10){
        //查询总条数
        $total = $this->adminZJmodel->table("tb_recharge")->count();
        //查询当前页展示的数据
        $rows = $this->adminZJmodel->table("tb_recharge rec,tb_user u")
        ->field("rec.rec_id,u.u_account,rec.rec_money,rec.rec_time,rec.rec_balance")
        ->page($pageNo,$pageSize)->where("rec.u_id=u.u_id")->order("rec.rec_balance desc")->select();
        //数组
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize);
        //发送
        $this->assign("page",$page);
        $this->display("ZJ/loadUserRecharge");
    }
    /**
     * 同步请求--根据用户帐号和充值编号查询用户充值信息并分页展示
     * @param int $pageNo
     * @param int $pageSize
     * @param string $user
     * @param int $recid
     */
    public function SearchUserRecharge($pageNo=1,$pageSize=10,$user=null,$recid=null){
        $query = "1=1 ";//字符串作为查询
        if($user != "" && $user !=null){
            $query .= "and u_account like '%$user%'";
        }
        if($recid != "" && $recid != null){
            $query .= "and rec_id like '%$recid%'";
        }
        //查询总数量
        $total = $this->adminZJmodel->table("tb_recharge")->count();
        //查询当前页展示的数据
        $rows = $this->adminZJmodel->table("tb_recharge rec")->join("tb_user u on u.u_id=rec.u_id")
        ->field("rec.rec_id,u.u_account,rec.rec_money,rec.rec_time,rec.rec_balance")
        ->page($pageNo,$pageSize)->where($query)->order("rec.rec_balance desc")->select();
        //数组
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize,"user"=>$user,"recid"=>$recid);
        //发送
        $this->assign("page",$page);
        $this->display("ZJ/loadUserRecharge");
    }
    /**
     * 同步+Bootstrap加载用户消费记录信息
     * @param int $pageNo
     * @param int $pageSize
     */
    public function loadUserConsume($pageNo=1,$pageSize=10){
        //查询总条数
        $total = $this->adminZJmodel->table("userConsume")->count();
        //查询当前页展示的数据
        $rows = $this->adminZJmodel->table("userConsume uc,tb_user u")
        ->field("u.u_account,uc.consumeMoney,uc.consumeTime,uc.totalMoney")
        ->page($pageNo,$pageSize)->where("uc.u_id=u.u_id")->order("uc.totalMoney desc")->select();
        //数组
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize);
        //发送
        $this->assign("page",$page);
        $this->display("ZJ/loadUserConsumeList");
    }
    /**
     * 同步请求--根据用户帐号查询用户消费信息并分页展示
     * @param int $pageNo
     * @param int $pageSize
     * @param string $user
     * @param int $recid
     */
    public function SearchUserConsume($pageNo=1,$pageSize=10,$user=null,$recid=null){
        $query = array();//数组作为查询条件
        if($user != "" && $user !=null){
            $query["u_account"] = array("LIKE","%$user%");
        }
        //查询总数量
        $total = $this->adminZJmodel->table("userConsume")->count();
        //查询当前页展示的数据
        $rows = $this->adminZJmodel->table("userConsume uc")->join("tb_user u on u.u_id=uc.u_id")
        ->field("u.u_account,uc.consumeMoney,uc.consumeTime,uc.totalMoney")
        ->page($pageNo,$pageSize)->where($query)->order("uc.totalMoney desc")->select();
        //数组
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize,"user"=>$user);
        //发送
        $this->assign("page",$page);
        $this->display("ZJ/loadUserConsumeList");
    }
    /**
     * 同步加载奖品列表
     * @param int $pageNo
     * @param int $pageSize
     */
    public function loadPrizeList($pageNo=1,$pageSize=10){
        //查询总数量
        $total = $this->adminZJmodel->table("tb_prize")->count();
        //当前页展示的数据
        $rows = $this->adminZJmodel->table("tb_prize pr")
        ->field("pr.pr_id,pr.pr_name,pr.pr_picture,pr.pr_integral,pr.pr_cost")
        ->page($pageNo,$pageSize)->select();
        //数组
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize);
        $this->assign("page",$page);
        $this->display("ZJ/loadPrizeList");
    }
    
}

?>