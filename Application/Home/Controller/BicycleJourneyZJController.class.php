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
     */
    public function SearchUserConsume($pageNo=1,$pageSize=10,$user=null){
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
    /**
     * 根据奖品名搜索奖品并分页展示
     * @param number $pageNo
     * @param number $pageSize
     * @param string $searchName
     */
    public function searchPrizeList($pageNo=1,$pageSize=10,$searchName=null){
        //数组作为查询条件
        $query = array();
        //判断输入的名称是否为空进行模糊查询
        if($searchName != null && $searchName != ""){
            $query["pr_name"] = array("LIKE","%$searchName%");
        }
        //查询总的数量
        $total = $this->adminZJmodel->table("tb_prize")->count();
        //查询当前页展示的数据
        $rows = $this->adminZJmodel->table("tb_prize pr")->where($query)
        ->field("pr.pr_id,pr.pr_name,pr.pr_picture,pr.pr_integral,pr.pr_cost")
        ->page($pageNo,$pageSize)->select();
        //数组
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize,"searchName"=>$searchName);
        $this->assign("page",$page);
        $this->display("ZJ/loadPrizeList");
    }
    /**
     * 新增奖品
     * @param string $prizeName
     * @param string $picture
     * @param int $integral
     * @param int $cost
     */
    public function addPrizeInfo($prizeName,$picture,$integral,$cost){
        //奖品表中插入数据
        $data = array("pr_name"=>$prizeName,"pr_picture"=>$picture,"pr_integral"=>$integral,"pr_cost"=>$cost);
        $this->adminZJmodel->table("tb_prize")->field("pr_name,pr_picture,pr_integral,pr_cost")->add($data);
        //返回列表
        $this->loadPrizeList();
    }
    /**
     * 同步加载并返回中奖信息列表
     * @param number $pageNo
     * @param number $pageSize
     */
    public function loadWinnersList($pageNo=1,$pageSize=10){
        //查询总数量
        $total = $this->adminZJmodel->table("tb_win")->count();
        //查询当前页展示的数据
        $rows = $this->adminZJmodel->table("tb_win w")->join("tb_user u on u.u_id=w.u_id")->join("tb_prize pr on pr.pr_id=w.pr_id")
        ->field("w.wi_id,u.u_account,pr.pr_name,w.wi_time")->select();
        $page = array("pageNo"=>$pageNo,"pageSize"=>$pageSize,"total"=>$total,"rows"=>$rows);
        //返回列表页面
        $this->assign("page",$page);
        $this->display("ZJ/loadWinnersList");
    }
    /**
     * 按用户帐号，奖品名称搜索奖品列表并分页
     * @param number $pageNo
     * @param number $pageSize
     * @param string $searchUser
     * @param string $searchName
     */
    public function searchWinnersList($pageNo=1,$pageSize=10,$searchUser=null,$searchName=null){
        //字符串作为查询条件
        $query = "1=1 ";
        if($searchUser != "" && $searchUser != null){
            $query .= "and u_account like '%$searchUser%'";
        }
        if($searchName != "" && $searchName != null){
            $query .= "and pr_name like '%$searchName%'";
        }
        //查询总数据
        $total = $this->adminZJmodel->table("tb_win")->count();
        //查询当前页展示的数据
        $rows = $this->adminZJmodel->table("tb_win w")->join("tb_user u on u.u_id=w.u_id")->join("tb_prize pr on pr.pr_id=w.pr_id")
        ->where($query)->field("w.wi_id,u.u_account,pr.pr_name,w.wi_time")->page($pageNo,$pageSize)->select();
        $page = array("pageNo"=>$pageNo,"pageSize"=>$pageSize,"total"=>$total,"rows"=>$rows,"searchUser"=>$searchUser,"searchName"=>$searchName);
        //返回列表页面
        $this->assign("page",$page);
        $this->display("ZJ/loadWinnersList");
    }
    /**
     * 同步加载并返回用户押金信息列表
     * @param number $pageNo
     * @param number $pageSize
     */
    public function loadPledgeList($pageNo=1,$pageSize=10){
        //查询总数量
        $total = $this->adminZJmodel->table("tb_pledge")->count();
        //查询当前页展示的数据
        $rows = $this->adminZJmodel->table("tb_pledge pl,tb_user u")
        ->field("pl.pl_id,pl.pl_no,u.u_account,pl.pl_money,pl.pl_time")
        ->page($pageNo,$pageSize)->where("pl.u_id=u.u_id")->select();
        $page = array("pageNo"=>$pageNo,"pageSize"=>$pageSize,"total"=>$total,"rows"=>$rows);
        //返回列表页面
        $this->assign("page",$page);
        $this->display("ZJ/loadPledgeList");
    }
    /**
     * 搜索用户押金信息并返回列表
     * @param number $pageNo
     * @param number $pageSize
     * @param string $searchUser
     * @param string $searchNo
     */
    public function searchPledgeList($pageNo=1,$pageSize=10,$searchUser=null,$searchNo=null){
        //字符串作为查询条件
        $query = "1=1 ";
        if($searchUser != "" && $searchUser != null){
            $query .= "and u_account like '%$searchUser%'";
        }
        if($searchNo != "" && $searchNo != null){
            $query .= "and pl_no like '%$searchNo%'";
        }
        //查询总数据
        $total = $this->adminZJmodel->table("tb_pledge")->count();
        //查询当前页展示的数据
        $rows = $this->adminZJmodel->table("tb_pledge pl")->join("tb_user u on u.u_id=pl.u_id")
        ->where($query)->field("pl.pl_id,pl.pl_no,u.u_account,pl.pl_money,pl.pl_time")->page($pageNo,$pageSize)->select();
        $page = array("pageNo"=>$pageNo,"pageSize"=>$pageSize,"total"=>$total,"rows"=>$rows,"searchUser"=>$searchUser,"searchNo"=>$searchNo);
        //返回列表页面
        $this->assign("page",$page);
        $this->display("ZJ/loadPledgeList");
    }
    /**
     * 通过id查询用户押金信息
     * @param int $pl_id
     */
    public function loadPledgeById($pl_id){
        $user = $this->adminZJmodel->table("tb_pledge pl,tb_user u")->field("pl.pl_no,u.u_account,pl.pl_money")
        ->where("pl.u_id=u.u_id and pl_id=%d",$pl_id)->select();
        $this->ajaxReturn($user[0]);
    }
    /**
     * 通过id数组查询用户押金信息
     */
    public function loadPledgeByIds(){    
        $getid = $_REQUEST['pl_ids'];
        //print_r($getid);
        $map['pl.pl_id'] = array ('in',$getid);       
        $user = $this->adminZJmodel->table("tb_pledge pl")->join("tb_user u on u.u_id=pl.u_id")->field("u.u_account")
        ->where($map)->select();
        $this->ajaxReturn($user);
    }
    /**
     * 修改押金返还信息
     */
    public function editPledgeBack($pl_no,$pl_money,$pl_back){
        $data = array(
          "pl_money"=>99-$pl_money,
          "pl_back"=>$pl_back
        );
        //通过编号修改押金信息表的押金退还情况
        $this->adminZJmodel->table("tb_pledge")->field("pl_money,pl_back")->where("pl_no='%s'",$pl_no)->save($data);
        $this->loadPledgeList();
    }
    /**
     * 搜索用户押金退还记录信息并返回列表
     * @param number $pageNo
     * @param number $pageSize
     * @param string $searchUser
     * @param string $searchNo
     */
    public function PledgeBackInfo($pageNo=1,$pageSize=10,$searchUser=null,$searchNo=null){
        //字符串作为查询条件
        $query = "pl.pl_back=1 ";
        if($searchUser != "" && $searchUser != null){
            $query .= "and u_account like '%$searchUser%'";
        }
        if($searchNo != "" && $searchNo != null){
            $query .= "and pl_no like '%$searchNo%'";
        }
        //查询总数据
        $total = $this->adminZJmodel->table("tb_pledge")->where("pl_back=1")->count();
        //查询当前页展示的数据
        $rows = $this->adminZJmodel->table("tb_pledge pl")->join("tb_user u on u.u_id=pl.u_id")
        ->where($query)->field("pl.pl_no,u.u_account,pl.pl_money,pl.pl_back")->page($pageNo,$pageSize)->select();
        $page = array("pageNo"=>$pageNo,"pageSize"=>$pageSize,"total"=>$total,"rows"=>$rows,"searchUser"=>$searchUser,"searchNo"=>$searchNo);
        //返回列表页面
        $this->assign("page",$page);
        $this->display("ZJ/PledgeBackInfo");
    }
    /**
     * 查询平台表
     */
    public function loadBicycleTerrace(){
        $result = $this->adminZJmodel->table("tb_terrace")->select();
        $this->ajaxReturn($result);
    }
    /**
     * 同步加载并搜索平台信息列表并分页
     * @param number $pageNo
     * @param number $pageSize
     * @param string $tername
     * @param string $user
     */
    public function loadTerraceList($pageNo=1,$pageSize=10,$tername='',$user=null){
        //数组作为查询条件
        $query = array();
        if($tername != "选择单车平台" && $tername != null){
            $query["ter_name"] = array("LIKE","%$tername%");
        }
        if($user != "" && $user != null){
            $query["ter_person"] = array("LIKE","%$user%");
        }
        //查询总数量
        $total = $this->adminZJmodel->table("tb_terrace")->where($query)->count();
        //查询当前页展示的数据
        $rows = $this->adminZJmodel->table("tb_terrace")->field("ter_id,ter_name,ter_address,ter_person,ter_phone")
        ->where($query)->page($pageNo,$pageSize)->select();
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize,"tername"=>$tername,"user"=>$user);
        //返回数据列表
        $this->assign("page",$page);
        $this->display("ZJ/loadTerraceList");
    }
    /**
     * 新增平台
     */
    public function addTerrace($ter_name,$ter_address,$ter_person,$ter_phone){
        $rows = array("ter_name"=>$ter_name,"ter_address"=>$ter_address,"ter_person"=>$ter_person,"ter_phone"=>$ter_phone);
        $this->adminZJmodel->table("tb_terrace")->field("ter_name,ter_address,ter_person,ter_phone")->add($rows);
        $this->loadTerraceList();
    }
    /**
     * 同步加载并搜索用户租赁记录信息
     * @param number $pageNo
     * @param number $pageSize
     * @param string $tername
     * @param string $user
     */
    public function loadRentRecord($pageNo=1,$pageSize=10,$tername=null,$user=null){
        //数组作为查询条件
        $query = array();
        if($tername != "选择单车平台" && $tername != null){
            $query["ter_name"] = array("LIKE","%$tername%");
        }
        if($user != "" && $user != null){
            $query["u_account"] = array("LIKE","%$user%");
        }
        //查询总数据
        $total = $this->adminZJmodel->table("tb_rent")->where($query)->count();
        //当前页展示的数据
        $rows = $this->adminZJmodel->table("tb_rent re")->join("tb_user u on u.u_id=re.u_id")->join("tb_terrace ter on ter.ter_id=re.ter_id")
        ->field("u.u_account,ter.ter_name,re.re_begin,re.re_end,re.re_money")->where($query)->page($pageNo,$pageSize)->select();
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize,"tername"=>$tername,"user"=>$user);
        //返回页面
        $this->assign("page",$page);
        $this->display("ZJ/loadRentRecord");
    }
    /**
     * 同步加载并分页搜索返回单车消失信息列表
     * @param number $pageNo
     * @param number $pageSize
     * @param string $searchNo
     * @param string $searchModel
     */
    public function bicycleDisappearList($pageNo=1,$pageSize=10,$searchNo=null,$searchModel=null){
        //字符串作为查询条件
        $query = "bc.bs_id=5 ";
        if($searchNo != "" && $searchNo != null){
            $query .= "and bc.bi_no like '%$searchNo%'";
        }
        if($searchModel != "" && $searchModel != null){
            $query .= "and bc.bi_model like '%$searchModel%'";
        }
        //查询bs_id=5的单车表数量
        $total = $this->adminZJmodel->table("tb_bicycle bc")->where($query)->count();
        //查询当前页展示数据
        $rows = $this->adminZJmodel->table("tb_bicycle bc")->join("tb_bicycle_state bcs on bcs.bs_id=bc.bs_id")
        ->join("tb_terrace ter on ter.ter_id=bc.ter_id")->field("bc.bi_no,bc.bi_model,bcs.bs_name,ter.ter_name,bc.bi_putTime")
        ->where($query)->page($pageNo,$pageSize)->select();
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize,"searchNo"=>$searchNo,"searchModel"=>$searchModel);
        //返回列表
        $this->assign("page",$page);
        $this->display("ZJ/bicycleDisappearList");
    }
    /**
     * 异步请求通过单车编号查询消失单车详情
     * @param string $bi_no
     */
    public function loadBicycleDisappear($bi_no){
        //print_r($bi_no);
        //查询某行数据单车详情
        $result = $this->adminZJmodel->table("tb_bicycle bc")->join("tb_bicycle_state bcs on bcs.bs_id=bc.bs_id")
        ->join("tb_terrace ter on ter.ter_id=bc.ter_id")->where("bi_no = '%s'",$bi_no)
        ->field("bc.bi_no,bc.bi_model,bc.bi_journey,bcs.bs_name,ter.ter_name,bc.bi_putTime,bc.bi_NumOfUse")
        ->select();
        //print_r($result);
        $this->ajaxReturn($result);
    }
    /**
     * 通过单车编号修改消失单车信息
     * @param string $bi_no
     */
    public function deleteDisappearBicycle($bi_no){
        //把bs_id=5 修改为 6
        $data = array("bs_id"=>6);
        $result = $this->adminZJmodel->table("tb_bicycle")->where("bi_no='%s'",$bi_no)->save($data);
        //$this->ajaxReturn($result);
        $this->bicycleDisappearList();
    }
    /**
     * 同步加载并分页返回低频单车列表
     * @param number $pageNo
     * @param number $pageSize
     * @param string $searchNo
     * @param string $searchModel
     */
    public function loadLowsBicycle($pageNo=1,$pageSize=10,$searchNo=null,$searchModel=null){
        //字符串作为查询条件
        $query = "bc.bs_id=1 ";
        if($searchNo != "" && $searchNo != null){
            $query .= "and bc.bi_no like '%$searchNo%'";
        }
        if($searchModel != "" && $searchModel != null){
            $query .= "and bc.bi_model like '%$searchModel%'";
        }
        //查询bs_id=1的单车表数量
        $total = $this->adminZJmodel->table("tb_bicycle bc")->where($query)->count();
        //查询当前页展示数据
        $rows = $this->adminZJmodel->table("tb_bicycle bc")->join("tb_bicycle_state bcs on bcs.bs_id=bc.bs_id")
        ->join("tb_terrace ter on ter.ter_id=bc.ter_id")->field("bc.bi_no,bc.bi_model,bcs.bs_name,ter.ter_name,bc.bi_putTime")
        ->where($query)->page($pageNo,$pageSize)->select();
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize,"searchNo"=>$searchNo,"searchModel"=>$searchModel);
        //返回列表
        $this->assign("page",$page);
        $this->display("ZJ/loadLowsBicycle");
    }
    
    
    
    
}

?>