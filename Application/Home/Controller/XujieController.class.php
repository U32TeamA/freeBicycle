<?php
namespace Home\Controller;

use Think\Controller;
use Think\Model;
class XujieController extends Controller{
    private $UserModel;
    public function __construct(){
        $this->UserModel = new Model('tb_admin');
    }
    public function login($ID,$password){
           $result = $this->userModel->where("ID='%s'",$ID)->find();
            if (!$result){
                $this->assign("message","用户名不存在！");
                $this->display();
            }else {
            if ($result["password"]!=$password){
                $this->assign("message","密码错误！");
                $this->display();                              
            }
            
        }
    }
}

?>