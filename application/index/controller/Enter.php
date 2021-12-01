<?php
namespace app\index\Controller;
use \think\Db;
use \think\Controller;
use \think\view;

class enter	extends Controller
{
//调用方法http://127.0.0.1/tp_5/public/index.php/index/enter/index
	public function index()
	{
		$name='andykign';
		$this->assign('name',$name);
		return $this->fetch('index');
		}
		
//调用方法http://127.0.0.1/tp_5/public/index.php/index/enter/enter		
	public function enter()
    {
		//$users = new View();
		//return $users->fetch('enter');
	 //$res=Db('stu')->count();
	//$users = db::query('select * from RANK_BAOFEIGUIMO WHERE 6.60 BETWEEN BFGM_DOWN AND BFGM_UP');
	 $RANK_BAOFEIGUIMO = Db::table('RANK_BAOFEIGUIMO')->where('BFGM_SCORE',2)->select();
	 $RANK_CANBAORENSHU = Db::table('RANK_CANBAORENSHU')->where('CBRS_SCORE',6)->select();
	 $RANK_CANBAOXIANGYING = Db::table('RANK_CANBAOXIANGYING')->where('CBXY_SCORE',6)->select();
	 $ENTER_NAME='大红山';
	 $info=Db::table('ENTER_INFO')->where('ENTER_NAME','like','%'.$ENTER_NAME.'%')->find();
	 //$cou=Db::name('stu')->count();
	 //print($cou);
	 //$users=db('stu')->where('name','jinlei')->find();
	
	print_r($RANK_BAOFEIGUIMO);
	echo '<br>';
	print_r($RANK_CANBAORENSHU);
	echo '<br>';
	print_r($RANK_CANBAOXIANGYING);
	echo '<br>';
	print_r($info['ID']);
    
//调用方法localhost/tp_5/public/index.php/index/index/instr/name/lisi/age/3	
	}
	public function instr($name,$age)
	{
	//$DB = new Db;
	//$data = Db::table('stu')->select();
	//$data1 = ['name' => 'zhangsan', 'age' => '20'];
	$data = ['name'=>$name,'age'=>$age];
	Db::table('stu')->insert($data);
	//print_r($data);
    //print_r($data[0]);
	}

//调用方法localhost/tp_5/public/index.php/index/index/hello/name/100
	public function hello($name ='ENTER_NAME')
	{
		//$this->assign('name',$name);
		//return $this->fetch();
		//return 'hello'.$name;
		$this->assign('name', $name);
        return $this->fetch();
		}



}


class RANK	extends controller
{
//调用方法localhost/tp_5/public/index.php/index/index/index/
	public function enter()
    {
		//$users = new View();
		//return $users->fetch('enter');
	 //$res=Db('stu')->count();
	//$users = db::query('select * from RANK_BAOFEIGUIMO WHERE 6.60 BETWEEN BFGM_DOWN AND BFGM_UP');
	 $RANK_BAOFEIGUIMO = Db::table('RANK_BAOFEIGUIMO')->where('BFGM_SCORE',2)->select();
	 $RANK_CANBAORENSHU = Db::table('RANK_CANBAORENSHU')->where('CBRS_SCORE',6)->select();
	 $RANK_CANBAOXIANGYING = Db::table('RANK_CANBAOXIANGYING')->where('CBXY_SCORE',6)->select();
	 //$cou=Db::name('stu')->count();
	 //print($cou);
	 //$users=db('stu')->where('name','jinlei')->find();
	
	print_r($RANK_BAOFEIGUIMO);
	echo '<br>';
	print_r($RANK_CANBAORENSHU);
	echo '<br>';
	print_r($RANK_CANBAOXIANGYING);
    
//调用方法localhost/tp_5/public/index.php/index/index/instr/name/lisi/age/3	
	}
}






