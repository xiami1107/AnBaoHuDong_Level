<?php
namespace app\index\controller;
use \think\Db;
use \think\controller;
use \think\View;

class Admin extends Controller{
  public function lst(){
/* 分页开始  */
    $list = Db::table('BASE_XUBAOSHIXIAO')->paginate(10);
    $this -> assign('list',$list);
/* 结束 */
    return $this->fetch();
  }
  public function add(){
    //判断页面是否提交
    if(request()->isPost()){
      //打印接收到的参数
      //dump(input('post.'));
      $data = [  //接受传递的参数
        'username' => input('username'),
        'password' => md5(input('password')),
      ];
/*验证开始*/
      $validate = \think\Loader::validate('Admin');
            /* scene('add') 在add页面添加验证应用  */
      if(!$validate -> scene('add')-> check($data)){
        /* 验证失败打印 */
        $this -> error($validate->getError());
        die;
      }
/*结束*/
    /* Db('表名') 数据库助手函数*/
      if(Db('ENTER_BASCI_INFO') -> insert($data)){    //添加数据
        return $this->success('添加成功','lst'); //成功后跳转 lst 界面
      }else{
        return $this->error('添加管理员失败');
      }
      return;
    }
    return $this->fetch('add');
  }
}