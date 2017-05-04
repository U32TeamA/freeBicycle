<?php
namespace Home\Controller;

use Think\Controller;
use Think\Model;
class XujieController extends Controller{
    private $UserModel;
    public function __construct(){
        $this->UserModel = new Model('tb_admin');
    }
    public function login($ad_account,$ad_password){
    //         $userName = $_POST["userName"];
    //         $userPass = $_POST["userPass"];
            //查询数据
            echo $ad_account;
            $users=$this->UserModel->where("ad_account=%d","$ad_account")->find();
            $host = $_SERVER["HTTP_HOST"];

//             header("location:http://localhost:8080/freeBicycle/welcome.html");
            if (count($users) > 0){
                

                if ($ad_password == $users["ad_password"]){
                    $_SESSION["loginUser"]=$users;
                    //查询管理员拥有的菜单
                    $menus = $this->UserModel->table("tb_admin ad,tb_menus m,tb_jurisdiction j")
                    ->field("m.*")
                    ->where("ad.ad_id=j.ad_id and j.me_id=m.me_id and j.ad_id=".$users["ad_id"])
                    ->select();
                    $_SESSION["menus"]=$menus;
                    //跳转到欢迎界面
                    //$this->assign("BASEPATH",BASEPATH);
                    //$this->display("ZJ/welcome");
                    //redirect("http://".$host."/tp/welcome.php");
                   header("location:http://localhost:8080/freeBicycle/welcome.html");
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