<?php
namespace Home\Controller;

use Think\Controller;

class WYXController extends Controller
{

    private $WYXModel;

    public function __construct()
    {
        parent::__construct();
        $this->WYXModel = M("tb_user");
    }

    /**
     * 用户信息一览
     *
     * @param number $pageNo            
     * @param number $pageSize            
     */
    public function showUserList($pageNo = 1, $pageSize = 10,$search="")
    {
        // 模糊查询条件 
        $con['u_account|u_name|u_phone|ter_name'] = array('LIKE',"%$search%");
        // 总条数
        $total = M()->table("tb_user u")
            ->join("tb_account a on a.u_id=u.u_id")
            ->join("tb_terrace t on t.ter_id=u.ter_id")
            ->where($con)
            ->field("u.u_id as uid, u.u_account as account, u.u_name as uname, u.u_phone as phone, u.u_gender as gender, t.ter_name as tname, a.acc_freeze as freeze")
            ->count();
        // 分页查询数据
        $rows = M()->table("tb_user u")
            ->page($pageNo, $pageSize)
            ->join("tb_account a on a.u_id=u.u_id")
            ->join("tb_terrace t on t.ter_id=u.ter_id")
            ->where($con)
            ->field("u.u_id as uid, u.u_account as account, u.u_name as uname, u.u_phone as phone, u.u_gender as gender, t.ter_name as tname, a.acc_freeze as freeze")
            ->select();
        // 总页数
        $totalPage = ($total%$pageSize)==0?($total/$pageSize):(intval($total/$pageSize)+1);
        // 封装数组
        $page = array(
            "total" => $total,
            "totalPage" =>$totalPage,
            "rows" => $rows,
            "pageNo" => $pageNo,
            "pageSize" => $pageSize,
            "search" =>$search
        );
        // 发送数据打开页面
        $_SESSION["userlist"] = $page;
        $this->assign("page", $page);
        $this->display(UserListView);
    }
}

?>