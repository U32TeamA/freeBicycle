<?php
namespace Home\Controller;

use Think\Controller;

class WYXContorller extends Controller
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
    public function showUserList($pageNo = 1, $pageSize = 10, $account = "", $uname = "", $phone = "")
    {
        // 查询条件
        $con['u_account'] = array(
            'LIKE',
            "%$account%"
        );
        $con['u_name'] = array(
            'LIKE',
            "%$uname%"
        );
        $con['u_phone'] = array(
            'LIKE',
            "%$phone%"
        );
        // 总条数
        $total = M()->count();
        // 查询数据
        $rows = M("tb_user u")->page($pageNo, $pageSize)
            ->join("tb_account a on acc.u_id=u.u_id")
            ->join("tb_terrace t on t.ter_id=u.ter_id")
            ->where($con)
            ->field("u.u_id as uid, u.u_account as account, u.u_name as uname, u.u_phone as phone, u.u_gender as gender, t.ter_name as tname, a.acc_freeze as freeze")
            ->select();
        // 封装数组
        $page = array(
            "total" => $total,
            "rows" => $rows,
            "pageNo" => $pageNo,
            "pageSize" => $pageSize
        );
        // 发送数据打开页面
        $this->assign("page", $page);
        $this->display(UserListView);
    }
}

?>