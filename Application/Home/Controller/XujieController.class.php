<?php
namespace Home\Controller;

use Think\Controller;
use Think\Model;
class XujieController extends Controller{
    private $UserModel;
    public function __construct(){
        parent::__construct();
        $this->UserModel = new Model('tb_admin');
    }
    /**
     * 管理员登录
     * @param int $ad_account
     * @param string $ad_password
     */
    public function login($ad_account,$ad_password){
            //查询数据
            $users=$this->UserModel->where("ad_account=%d",$ad_account)->select();
            $host = $_SERVER["HTTP_HOST"];
            //print_r($users);
//             header("location:http://localhost:8080/freeBicycle/welcome.html");
            if (count($users) > 0){
                $u = $users[0];
                if ($ad_password == $u["ad_password"]){
                    $_SESSION["loginUser"]=$u;
                    //查询管理员拥有的菜单
                    $menus = $this->UserModel->table("tb_admin ad,tb_menus m,tb_jurisdiction j")
                    ->field("m.*")
                    ->where("ad.ad_id=j.ad_id and j.me_id=m.me_id and j.ad_id=".$u["ad_id"])
                    ->select();
                    $_SESSION["menus"]=$menus;
                    //print_r($menus);
                    //跳转到欢迎界面
                    //$this->assign("BASEPATH",BASEPATH);
                    $this->display("ZJ/welcome");
                    //redirect("http://".$host."/tp/welcome.php");
                    //header("location:http://localhost:8080/freeBicycle/welcome.html");
                }else{
                    //密码错误
                   // $_SESSION["loginError"] = "密码错误";
                    //redirect("http://".$host."/freeBicycle/login.php");
    //                 header("location:http://".$host."/tp/login.php");
                }
            }else{
                 //用户名错误
                // $_SESSION["loginError"] = "用户名不存在";
                 //redirect("http://".$host."/freeBicycle/login.php");
    //              header("location:http://".$host."/tp/login.php");
             }
    }
}

?>