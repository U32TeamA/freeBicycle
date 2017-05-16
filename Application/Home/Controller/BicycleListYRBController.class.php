<?php
namespace Home\Controller;

use Think\Controller;
use Think\Upload;
class BicycleListYRBController extends Controller{
    private $BicycleListYRBModel;
    public function __construct(){
        parent::__construct();
        $this->BicycleListYRBModel = M("tb_bicycle");
    }
    /**
     * 查询单车信息
     * @param number $pageNo
     * @param number $pageSize
     */
    public function BicycleList($pageNo=1,$pageSize=10){
        //总条数
        $total = $this->BicycleListYRBModel->count();
        //数据
//         $rows = $this->BicycleListYRBModel->table("tb_bicycle b,tb_bicycle_state bs,tb_rent r,tb_user u")
//         ->where("b.bs_id=bs.bs_id and b.re_id=r.re_id and r.u_id=u.u_id")
//         ->field("b.bi_id as id,b.bi_no as no,b.bi_model as model,b.bi_putTime as time,b.bi_NumOfUse as num,
//             b.bi_journey as journey,bs.bs_name as name,r.re_begin as begin,r.re_end as end,u.u_account as account,b.bi_useState as state")->page($pageNo,$pageSize)->select();
        $rows = $this->BicycleListYRBModel->table("tb_bicycle b")->join("tb_bicycle_state bs on b.bs_id=bs.bs_id","LEFT")->join("tb_rent r on b.re_id=r.re_id","LEFT")
        ->join("tb_user u on r.u_id=u.u_id","LEFT")
        ->field("b.bi_id as id,b.bi_no as no,b.bi_model as model,b.bi_putTime as time,b.bi_NumOfUse as num,
            b.bi_journey as journey,bs.bs_name as name,r.re_begin as begin,r.re_end as end,u.u_account as account,b.bi_useState as state,b.bi_scrap as scrap")
        ->page($pageNo,$pageSize)->select();
        //数组
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize);
        //发送
        $this->assign("page",$page);
        $this->display(bicycleList);
    }
    /**
     * 添加，修改单车信息
     * @param unknown $ctr
     * @param unknown $no   单车编号
     * @param unknown $model    单车型号
     * @param unknown $puttime  投放时间
     * @param unknown $name 状态名
     */
    public function BicycleListEdit($ctr,$no,$model,$puttime,$name){
        if($ctr>0){
            $data = array(
                'bi_no'=>$no,
                'bi_model'=>$model,
                'bi_putTime'=>$puttime,
                'bs_id'=>$name
            );
            $this->BicycleListYRBModel->field("bi_no,bi_model,bi_putTime,bi_id")->add($data);
            $this->BicycleList();
        }else {
            $data=array(
                'bi_no'=>$no,
                'bs_id'=>$name
            );
            $this->BicycleListYRBModel->field("bs_id")->where("bi_no=%d",$data['bi_no'])->save($data);
            $this->BicycleList();
        }
    }
    /**
     * 根据编号查询单车，用于回填
     * @param unknown $no
     */
    public function BicycleSearch($no){
        $rows = $this->BicycleListYRBModel->where("bi_no = '$no'")->select();
        $this->ajaxReturn($rows);
    }
    /**
     * 根据编号删除单车，报废
     * @param unknown $no
     */
    public function BicycleListHide($no){
        $data = array('bi_scrap'=>'1');
        $rows = $this->BicycleListYRBModel->where("bi_no = '$no'")->save($data);
        $this->BicycleList();
    }
    /**
     * 组合查询单车
     */
    public function BicycleListSearch($suser='',$sno='',$smodel='',$sstate='',$pageNo=1,$pageSize=10){
        //查询数组
        $query = array();
        if ($suser != '' && $suser != null){
            $query['u_account']=array("LIKE","%$suser%");
        }
        if ($sno != '' && $sno != null){
            $query['bi_no']=array("LIKE","%$sno%");
        }
        if ($smodel != '' && $smodel != null){
            $query['bi_model']=array("LIKE","%$smodel%");
        }
        if ($sstate != '' && $sstate != null){
            $query['bs_name']=array("LIKE","%$sstate%");
        }
        $total = $this->BicycleListYRBModel->table("tb_bicycle b")->join("tb_bicycle_state bs on b.bs_id=bs.bs_id","LEFT")->join("tb_rent r on b.re_id=r.re_id","LEFT")
        ->join("tb_user u on r.u_id=u.u_id","LEFT")
        ->field("b.bi_id as id,b.bi_no as no,b.bi_model as model,b.bi_putTime as time,b.bi_NumOfUse as num,
            b.bi_journey as journey,bs.bs_name as name,r.re_begin as begin,r.re_end as end,u.u_account as account,b.bi_useState as state,b.bi_scrap as scrap")
        ->where($query)->count();
        $rows = $this->BicycleListYRBModel->table("tb_bicycle b")->join("tb_bicycle_state bs on b.bs_id=bs.bs_id","LEFT")->join("tb_rent r on b.re_id=r.re_id","LEFT")
        ->join("tb_user u on r.u_id=u.u_id","LEFT")
        ->field("b.bi_id as id,b.bi_no as no,b.bi_model as model,b.bi_putTime as time,b.bi_NumOfUse as num,
            b.bi_journey as journey,bs.bs_name as name,r.re_begin as begin,r.re_end as end,u.u_account as account,b.bi_useState as state,b.bi_scrap as scrap")
        ->page($pageNo,$pageSize)->where($query)->select();
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize,"suser"=>$suser,"sno"=>$sno,"smodel"=>$smodel,"sstate"=>$sstate);
        //
        $this->assign("page",$page);
        $this->display("bicycleList");
    }
    /**
     * 活动一览，查询所有活动
     */
    public function activity($sname='',$surl='',$stime='',$stername='',$pageNo=1,$pageSize=10){
        //查询数组
        $query = array();
        if ($sname != '' && $sname != null){
            $query['ac_name']=array("LIKE","%$sname%");
        }
        if ($surl != '' && $surl != null){
            $query['ac_url']=array("LIKE","%$surl%");
        }
        if ($stime != '' && $stime != null){
            $query['ac_time']=array("LIKE","%$stime%");
        }
        if ($stername != '0' && $stername != null){
            $query['ter_name']=array("LIKE","%$stername%");
        }
        $total = $this->BicycleListYRBModel->table("tb_activity ac")->join("tb_terrace te on te.ter_id=ac.ter_id","LEFT")->where($query)->count();
        $rows = $this->BicycleListYRBModel->table("tb_activity ac")->where($query)->join("tb_terrace te on te.ter_id=ac.ter_id","LEFT")->page($pageNo,$pageSize)
        ->field("ac.*,te.ter_name as tname")->select();
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize,"sname"=>$sname,"surl"=>$surl,"stime"=>$stime,"stername"=>$stername);
        $this->assign("page",$page);
        $this->display(activity);
    }
    /**
     * 平台列表查询
     */
    public function activityTerrace(){
        $rows = $this->BicycleListYRBModel->table("tb_terrace")->select();
        $this->ajaxReturn($rows);
    }
    /**
     * 根据id查询活动，用于回填
     * @param unknown $acid
     */
    public function activitySearch($acid){
        $rows = $this->BicycleListYRBModel->table("tb_activity")->where("ac_id = '$acid'")->select();
        $this->ajaxReturn($rows);
    }
    /**
     * 增加或修改活动列表
     * @param unknown $ctr
     * @param unknown $ac_id
     * @param unknown $acname
     * @param unknown $acurl
     * @param unknown $issuetime
     * @param unknown $tername
     */
    public function activityListEdit($ctr,$ac_id,$acname,$acurl,$issuetime,$tername){
        if($ctr>0){
            $data = array(
                'ac_name'=>$acname,
                'ac_url'=>$acurl,
                'ac_time'=>$issuetime,
                'ter_id'=>$tername
            );
            //print_r($data);
            $this->BicycleListYRBModel->table("tb_activity")->field("ac_name,ac_url,ac_time,ter_id")->add($data);

            $this->activity();
        }else {
            $data = array(
                "ac_name"=>$acname,
                "ac_url"=>$acurl,
                "ac_time"=>$issuetime,
                "ter_id"=>$tername
            );
            $this->BicycleListYRBModel->table("tb_activity")->field("ac_name,ac_url,ac_time,ter_id")->where("ac_id = '$ac_id'")->save($data);
            //print $ac_id;
            $this->activity();
        }
        //保存图片
        $config = array(
            "maxSize"=>0,
            "rootPath"=>"./Public/",
            "savePath"=>"",
            "autoSub"=>true,
            "subName"=>"upload",
            "saveName"=>round(1,10000)."".time(),
            "exts"=>array("jpg","png","gif")//"jpg,png,gif"
        );
        $up = new Upload($config);
        $info = $up->uploadOne($_FILES['picture']);
        if (!$info){
            echo $up->getError();
        }else {
            //print_r($info);
        }
    }
    /**
     * 删除活动
     * @param unknown $acid
     */
    public function activityListHide($acid){
        $rows = $this->BicycleListYRBModel->table("tb_activity")->where("ac_id = '$acid'")->delete();
        $this->activity();
    }
    /**
     * 公告一览，查询所有活动
     */
    public function announcement($sname='',$surl='',$stime='',$stername='',$pageNo=1,$pageSize=10){
        //查询数组
        $query = array();
        if ($sname != '' && $sname != null){
            $query['an_name']=array("LIKE","%$sname%");
        }
        if ($surl != '' && $surl != null){
            $query['an_url']=array("LIKE","%$surl%");
        }
        if ($stime != '' && $stime != null){
            $query['an_time']=array("LIKE","%$stime%");
        }
        if ($stername != '0' && $stername != null){
            $query['ter_name']=array("LIKE","%$stername%");
        }
        $total = $this->BicycleListYRBModel->table("tb_announcement an")->join("tb_terrace te on te.ter_id=an.ter_id","LEFT")->where($query)->count();
        $rows = $this->BicycleListYRBModel->table("tb_announcement an")->where($query)->join("tb_terrace te on te.ter_id=an.ter_id","LEFT")->page($pageNo,$pageSize)
        ->field("an.*,te.ter_name as tname")->select();
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize,"sname"=>$sname,"surl"=>$surl,"stime"=>$stime,"stername"=>$stername);
        $this->assign("page",$page);
        $this->display(announcement);
    }
    /**
     * 根据id查询公告，用于回填
     * @param unknown $acid
     */
    public function announcementSearch($anid){
        $rows = $this->BicycleListYRBModel->table("tb_announcement")->where("an_id = '$anid'")->select();
        $this->ajaxReturn($rows);
    }
    /**
     * 删除公告
     * @param unknown $acid
     */
    public function announcementHide($anid){
        $rows = $this->BicycleListYRBModel->table("tb_announcement")->where("an_id = '$anid'")->delete();
        $this->announcement();
    }
    /**
     * 增加或修改活动列表
     * @param unknown $ctr
     * @param unknown $ac_id
     * @param unknown $acname
     * @param unknown $acurl
     * @param unknown $issuetime
     * @param unknown $tername
     */
    public function announcementListEdit($ctr,$ac_id,$acname,$acurl,$issuetime,$tername){
        if($ctr>0){
            $data = array(
                'an_name'=>$acname,
                'an_url'=>$acurl,
                'an_time'=>$issuetime,
                'ter_id'=>$tername
            );
            //print_r($data);
            $this->BicycleListYRBModel->table("tb_announcement")->field("an_name,an_url,an_time,ter_id")->add($data);
    
            $this->announcement();
        }else {
            $data = array(
                "an_name"=>$acname,
                "an_url"=>$acurl,
                "an_time"=>$issuetime,
                "ter_id"=>$tername
            );
            $this->BicycleListYRBModel->table("tb_announcement")->field("ac_name,an_url,an_time,ter_id")->where("an_id = '$ac_id'")->save($data);
            //print $ac_id;
            $this->announcement();
        }
    }
    /**
     * 优惠券一览，查询所有优惠券
     */
    public function coupon($sname='',$spri='',$stime='',$stername='',$pageNo=1,$pageSize=10){
        //查询数组
        $query = array();
        if ($sname != '' && $sname != null){
            $query['cou_name']=array("LIKE","%$sname%");
        }
        if ($spri != '' && $spri != null){
            $query['cou_price']=array("LIKE","%$spri%");
        }
        if ($stime != '' && $stime != null){
            $query['cou_end']=array("LIKE","%$stime%");
        }
        if ($stername != '0' && $stername != null){
            $query['ter_name']=array("LIKE","%$stername%");
        }
        $total = $this->BicycleListYRBModel->table("tb_coupon cou")->join("tb_terrace te on te.ter_id=cou.ter_id","LEFT")->where($query)->count();
        $rows = $this->BicycleListYRBModel->table("tb_coupon cou")->where($query)->join("tb_terrace te on te.ter_id=cou.ter_id","LEFT")->page($pageNo,$pageSize)
        ->field("cou.*,te.ter_name as tname")->select();
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize,"sname"=>$sname,"spri"=>$spri,"stime"=>$stime,"stername"=>$stername);
        $this->assign("page",$page);
        $this->display(coupon);
    }
    /**
     * 根据id查询优惠券，用于回填
     * @param unknown $couid
     */
    public function couponSearch($couid){
        $rows = $this->BicycleListYRBModel->table("tb_coupon")->where("cou_id = '$couid'")->select();
        $this->ajaxReturn($rows);
    }
    /**
     * 删除公告
     * @param unknown $couid
     */
    public function conponHide($couid){
        $rows = $this->BicycleListYRBModel->table("tb_coupon")->where("cou_id = '$couid'")->delete();
        $this->coupon();
    }
    /**
     * 增加，修改优惠券信息
     * @param unknown $ctr
     * @param unknown $ac_id
     * @param unknown $acname
     * @param unknown $acurl
     * @param unknown $issuetime
     * @param unknown $tername
     */
    public function couponListEdit($ctr,$cou_id,$couname,$coupri,$couend,$tername){
        if($ctr>0){
            $data = array(
                'cou_name'=>$couname,
                'cou_price'=>$coupri,
                'cou_end'=>$couend,
                'ter_id'=>$tername
            );
            //print_r($data);
            $this->BicycleListYRBModel->table("tb_coupon")->field("cou_name,cou_price,cou_end,ter_id")->add($data);
    
            $this->coupon();
        }else {
            $data = array(
                "cou_name"=>$couname,
                "cou_pri"=>$coupri,
                "cou_end"=>$couend,
                "ter_id"=>$tername
            );
            $this->BicycleListYRBModel->table("tb_coupon")->field("cou_name,cou_price,cou_end,ter_id")->where("cou_id = '$cou_id'")->save($data);
            //print $ac_id;
            $this->coupon();
        }
    }
    /**
     * 加载所有的故事列表
     * @param number $pageNo
     * @param number $pageSize
     */
    public function story($sname='',$surl='',$stime='',$stername='',$pageNo=1,$pageSize=10){
        $query = array();
        if ($sname != "" && $sname != null){
            $query['st_name'] = array("LIKE","%$sname%");
        }
        if ($surl != "" && $surl != null){
            $query['st_url'] = array("LIKE","%$surl%");
        }
        if ($stime != "" && $stime != null){
            $query['st_time'] = array("LIKE","%$stime%");
        }
        if ($stername != '0' && $stername != null){
            $query['ter_name'] = array("LIKE","%$stername%");
        }
        $total = $this->BicycleListYRBModel->table("tb_story st")->join("tb_terrace ter on st.ter_id=ter.ter_id","LEFT")->where($query)->count();
        $rows = $this->BicycleListYRBModel->table("tb_story st")->join("tb_terrace ter on st.ter_id=ter.ter_id","LEFT")->field("st.*,ter.ter_name")->page($pageNo,$pageSize)->where($query)->select();
        $page = array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize,"sname"=>$sname,"surl"=>$surl,"stime"=>$stime);
        $this->assign("page",$page);
        $this->display(story);
    }
    /**
     * 根据id查询单行数据
     * @param string $stid
     */
    public function storySearch($stid){
        $rows = $this->BicycleListYRBModel->table("tb_story")->where("st_id = '$stid'")->select();
        $this->ajaxReturn($rows);
    }
    /**
     * 根据ctr，增加或修改故事
     * @param unknown $ctr
     * @param unknown $st_id
     * @param unknown $stname
     * @param unknown $sturl
     * @param unknown $sttime
     * @param unknown $tername
     */
    public function storyListEdit($ctr,$st_id,$stname,$sturl,$sttime,$tername){
        $data = array(
            "st_name"=>$stname,
            "st_url"=>$sturl,
            "st_time"=>$sttime,
            "ter_id"=>$tername
        );
        if ($ctr == 1){
            //增加
            $this->BicycleListYRBModel->table("tb_story")->field("st_name,st_url,st_time,ter_id")->add($data);
            $this->story();
        }else {
            $this->BicycleListYRBModel->table("tb_story")->field("st_name,st_url,st_time,ter_id")->where("st_id = '$st_id'")->save($data);
            $this->story();
        }
    }
    /**
     * 根据id删除某列故事
     * @param unknown $stid
     */
    public function storyDelete($stid){
        $this->BicycleListYRBModel->table("tb_story")->where("st_id = '$stid'")->delete();
        $this->story();
    }
    /**根据当前id查询管理员信息
     * @param unknown $ad_id
     */
    public function myAccount(){
        $myacc = $_REQUEST['myacc'];
        $rows = $this->BicycleListYRBModel->table("tb_admin")->where("ad_account = '$myacc'")->select();
        $this->assign("rows",$rows);
        $this->display(myAccount);
    }
    public function passwordEdit($account,$password){
        $data = array(
            "ad_password"=>$password
        );
        $this->BicycleListYRBModel->table("tb_admin")->where("ad_account = '$account'")->field("ad_password")->save($data);
        $rows = $this->BicycleListYRBModel->table("tb_admin")->where("ad_account = '$account'")->select();
        $this->assign("rows",$rows);
        $this->display(myAccount);
    }
}

?>