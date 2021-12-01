<?php
namespace app\index\Controller;
use \think\Db;
use \think\Controller;
use \think\view;

class Yhgl	extends Controller
{
//调用方法http://127.0.0.1/tp_5/public/index.php/index/yhgl/jcxxcx

/*----------进入企业基础信息查询页面------------*/
	public function jcxxcx()
    {
	
		return $this->fetch('jcxxcx');
	}
	

/*-----------查询获取企业列表------------------*/
	public function seletc($enter_name="",$enter_id="")
	{

		if(!empty($enter_name)){			//判断如果企业名称不为空
			$enter_name=("%".$enter_name."%");
			if(!empty($enter_id)){              //企业名称不为空，企业代码不为空，企业名称加代码查询数据库
				$list=Db::table('ENTER_BASIC_INFO')
					->where('ENTER_NAME','like',$enter_name)
					->where('ENTER_ID',$enter_id)
                    ->select();	
			}
			else{								//企业名称不为空，企业机构代为为空，企业名称查询数据库
				$list=Db::table('ENTER_BASIC_INFO')
					->where('ENTER_NAME','like',$enter_name)
                    ->select();
			}
		}
		else{
			if(!empty($enter_id)){				//企业名称为空，企业机构代码不为空，企业代码查询数据库
				$list=Db::table('ENTER_BASIC_INFO')
					->where('ENTER_ID',$enter_id)
                    ->select();
			}
			else{								//企业名称和代码为空，弹框提示请输入名称或机构编码
				echo "<script>alert('您输入企业名称或机构编码！')</script>";
				return $this->fetch('jcxxcx');
			}
		}

		if(!empty($list)){				//查询结果不为空，获取企业列表
			$this -> assign('list',$list);
			#print_r($list);
			return $this->fetch('jcxxcx_list');
		}
		else{						//查询结果为空，弹框提示
			echo "<script>alert('您输入的企业未找到，请核实或重新输入！')</script>";
			return $this->fetch('jcxxcx');
		}
		
	}


/*-----------获取企业基本信息和历史保费------------------*/
    public function jcxxcx_info($enter_name="",$enter_id="")
    {
        if($enter_name=="" or $enter_id=""){
            return $this->fetch('jcxxcx');
        }

        else{

            $info = Db::table('ENTER_BASIC_INFO')->where('ENTER_NAME', $enter_name)->find();
                $enter_city=$info['ENTER_CITY'];
                $enter_county=$info['ENTER_COUNTY'];
                $enter_name=$info['ENTER_NAME'];
                $enter_id=$info['ENTER_ID'];
                $enter_bid=$info['ENTER_BID'];
                $enter_add=$info['ENTER_ADD'];
                $enter_capital=$info['ENTER_CAPITAL'];
                $enter_xingzhi=$info['ENTER_XINGZHI'];
                $enter_leixing=$info['ENTER_LEIXING'];
                $enter_zhuangtai=$info['ENTER_ZHUANGTAI'];
                $enter_legalperson=$info['ENTER_LEGALPERSON'];
                $enter_phone=$info['ENTER_PHONE'];

            $this->assign([
                'enter_city' => $enter_city,
                'enter_county' => $enter_county,
                'enter_name' => $enter_name,
                'enter_id' => $enter_id,
                'enter_bid' => $enter_bid,
                'enter_add' => $enter_add,
                'enter_capital' => $enter_capital,
                'enter_xingzhi' => $enter_xingzhi,
                'enter_leixing' => $enter_leixing,
                'enter_zhuangtai' => $enter_zhuangtai,
                'enter_legalperson' => $enter_legalperson,
                'enter_phone' => $enter_phone
            ]);
            #$list = Db::table('BASE_POLICY')->where('ENTER_NAME',$enter_name)->select();
            $list=Db::table('BASE_POLICY')
                    ->field('ENTER_NAME','POLICY_ID,POLICY_BEGIN_DATE,POLICY_END_DATE,avg(PREMIUM) as PREMIUM,avg(POLICY_PR) as POLICY_PR,INSURANCE_TYPE')
                    ->where('ENTER_NAME',$enter_name)
                    #->where('POLICY_PAY_DATE','LIKE','%'.$year.'%')
                    #->where('PREMIUM','>','0')
                    ->group('POLICY_ID,INSURANCE_TYPE')
                    ->order('POLICY_BEGIN_DATE')
                    ->select();

            #$this->assign('enter_name',$ENTER_NAME);

        }
        $this->assign('list',$list);
        return $this->fetch('jcxxcx_info');
    }


/*-----------获取企业基本信息表------------------*/
    public function jcxxcx_res($enter_name="",$enter_id="")
    {
        if($enter_name=="" or $enter_id=""){
            return $this->fetch('jcxxcx');
        }

        else{

            $info = Db::table('ENTER_RES_RECORD')->where('ENTER_NAME', $enter_name)->find();
                $enter_city=$info['ENTER_CITY'];
                $enter_county=$info['ENTER_COUNTY'];
                $enter_name=$info['ENTER_NAME'];

            $this->assign([
                'enter_city' => $enter_city,
                'enter_county' => $enter_county,
                'enter_name' => $enter_name,

            ]);
            $list=Db::table('ENTER_RES_RECORD')
                    #->field('ENTER_NAME','POLICY_ID,POLICY_BEGIN_DATE,POLICY_END_DATE,avg(PREMIUM) as PREMIUM,avg(POLICY_PR) as POLICY_PR,INSURANCE_TYPE')
                    ->where('ENTER_NAME',$enter_name)
                    #->where('POLICY_PAY_DATE','LIKE','%'.$year.'%')
                    #->where('PREMIUM','>','0')
                    #->group('POLICY_ID,INSURANCE_TYPE')
                    ->order('RES_YEAR,W_TIME')
                    ->select();

            #$this->assign('enter_name',$ENTER_NAME);

        }
        $this->assign('list',$list);
        return $this->fetch('jcxxcx_res');
    }

/*-------功能：输入企业名称并跳转到企业基础信息新增或修改界面------*/	
	public function jcxxlr($enter_name='',$enter_id='')
    {
		if(empty($enter_name)){
		    /* echo "<script>alert('您输入的企业名称或代码！')</script>"; */
			return $this->fetch('jcxxlr');
		} 
	 	else {
			$enter_name=$_POST['enter_name'];
			$info=Db::table('ENTER_BASIC_INFO')->where('ENTER_NAME',$enter_name)->find();
			if(empty($info)){               //如果企业不存在跳转到新增界面
					/*echo "<script>alert('')</script>";*/
					$this->assign(['enter_name'=>$enter_name]);
					return $this->fetch('jcxxlr_xz');
					}
			//如果企业存在跳转到企业修改界面	
			else 	{
			        $id=$info['ID'];
					$enter_city=$info['ENTER_CITY'];
					$enter_county=$info['ENTER_COUNTY'];
					$enter_name=$info['ENTER_NAME'];
					$enter_id=$info['ENTER_ID'];
					$enter_bid=$info['ENTER_BID'];
					$enter_add=$info['ENTER_ADD'];
					$enter_capital=$info['ENTER_CAPITAL'];
					$enter_xingzhi=$info['ENTER_XINGZHI'];
					$enter_leixing=$info['ENTER_LEIXING'];
					$enter_zhuangtai=$info['ENTER_ZHUANGTAI'];
					$enter_legalperson=$info['ENTER_LEGALPERSON'];
					$enter_phone=$info['ENTER_PHONE'];

					$this->assign([
						'id'=>$id,
						'enter_city'=>$enter_city,
						'enter_county'=>$enter_county,
						'enter_name'=>$enter_name,
						'enter_id'=>$enter_id,
						'enter_bid'=>$enter_bid,
						'enter_add'=>$enter_add,
						'enter_capital'=>$enter_capital,
						'enter_xingzhi'=>$enter_xingzhi,
						'enter_leixing'=>$enter_leixing,
						'enter_zhuangtai'=>$enter_zhuangtai,
                        'enter_legalperson'=>$enter_legalperson,
                        'enter_phone'=>$enter_phone
					]);
					return $this->fetch('jcxxlr_xg');
					}
				}
		
		//$this = new View();
		//$this->assign([
		//'enter_name'=>'',
		//'enter_add'=>''
		//]);
		//$this->assign('123','123');
		return $this->fetch('jcxxlr'); 
	}
	

/*----------从企业数据导出跳转到企业基础信息修改----------------*/
/*-------功能：跳转到企业基础信息修改界面------*/	
	public function jcxxlr_xg($enter_name='',$enter_id='')
    {
		if(empty($enter_name)){
			return $this->fetch('jcxxlr');
		} 
	 	else {
			$info=Db::table('ENTER_BASIC_INFO')->where('ENTER_NAME',$enter_name)->find();
			//如果企业不存在跳转到新增界面
			if(empty($info)){
					/*echo "<script>alert('')</script>";*/                          
					$this->assign(['enter_name'=>$enter_name]);
					return $this->fetch('jcxxlr_xz');
					}
			//如果企业存在跳转到企业修改界面	
			else 	{
			        $id=$info['ID'];
					$enter_city=$info['ENTER_CITY'];
					$enter_county=$info['ENTER_COUNTY'];
					$enter_name=$info['ENTER_NAME'];
					$enter_id=$info['ENTER_ID'];
					$enter_bid=$info['ENTER_BID'];
					$enter_add=$info['ENTER_ADD'];
					$enter_capital=$info['ENTER_CAPITAL'];
					$enter_xingzhi=$info['ENTER_XINGZHI'];
					$enter_leixing=$info['ENTER_LEIXING'];
					$enter_zhuangtai=$info['ENTER_ZHUANGTAI'];
					$enter_legalperson=$info['ENTER_LEGALPERSON'];
					$enter_phone=$info['ENTER_PHONE'];
					$this->assign([
						'id'=>$id,
						'enter_city'=>$enter_city,
						'enter_county'=>$enter_county,
						'enter_name'=>$enter_name,
						'enter_id'=>$enter_id,
						'enter_bid'=>$enter_bid,
						'enter_add'=>$enter_add,
						'enter_capital'=>$enter_capital,
						'enter_xingzhi'=>$enter_xingzhi,
						'enter_leixing'=>$enter_leixing,
						'enter_zhuangtai'=>$enter_zhuangtai,
                        'enter_legalperson'=>$enter_legalperson,
                        'enter_phone'=>$enter_phone
					]);
					return $this->fetch('jcxxlr_xg');
					}
				}
		return $this->fetch('jcxxlr'); 
	}	
	
	
/*---------------修改企业基本信息------------------------*/
	public function jcxxlr_update()
	{
		$enter = $_POST;
		$id=$enter['id'];
		if(empty($enter['enter_name'])){
		    echo "<script>alert('企业名称不能为空')</script>";                              //
			return $this->fetch('jcxxlr');
						}
		else{
			$sql=Db::table('ENTER_BASIC_INFO')                     /* 更新企业基本信息表中的企业信息 */
    			->where('ID',$id)
    			->update([
					'ENTER_CITY' =>$enter['enter_city'],
					'ENTER_COUNTY' =>$enter['enter_county'],
					'ENTER_NAME' =>$enter['enter_name'],
					'ENTER_ID'  => $enter['enter_id'],
					'ENTER_BID' => $enter['enter_bid'],
					'ENTER_ADD' => $enter['enter_add'],
					'ENTER_CAPITAL' => $enter['enter_capital'],
					'ENTER_XINGZHI' =>$enter['enter_xingzhi'],
					'ENTER_LEIXING' =>$enter['enter_leixing'],
					'ENTER_ZHUANGTAI' =>$enter['enter_zhuangtai'],
					'ENTER_LEGALPERSON' =>$enter['enter_legalperson'],
                    'ENTER_PHONE' =>$enter['enter_phone'],
    					]);
			//echo $enter_name;
			if($sql=='1'){			
			   	echo "<script>alert('信息修改成功')</script>";  
				return $this->fetch('jcxxlr');      //修改成功返回录入查询页
						}
			else{ 
				echo "<script>alert('".$id."')</script>";
				return $this->fetch('jcxxlr');	 
				}	
			//$enter_name=$enter['enter_name']
			//echo $enter['enter_name'];
			//echo $enter['entetr_zhuangtai'];
			}
	}


/*---------------新增企业基本信息------------------------*/
	public function jcxxlr_instr()
	{
		$enter = $_POST;

	   $data1=[
			'ENTER_CITY' =>$enter['enter_city'],
			'ENTER_COUNTY' =>$enter['enter_county'],
			'ENTER_XINGZHI' =>$enter['enter_xingzhi'], 
			'ENTER_LEIXING' =>$enter['enter_leixing'],
			'ENTER_NAME' =>$enter['enter_name'],
			'ENTER_ZHUANGTAI' =>$enter['enter_zhuangtai'],
			'ENTER_ADD' => $enter['enter_add'],
  			'ENTER_ID' =>$enter['enter_id'],
  			'ENTER_BID' =>$enter['enter_bid'],
            'ENTER_CAPITAL' => $enter['enter_capital'],
            'ENTER_LEGALPERSON' => $enter['enter_legalperson'],
            'ENTER_PHONE' => $enter['enter_phone']];
		$sql1=Db::table('ENTER_BASIC_INFO')->insert($data1);
		
/* 		$data2=[
			'ENTER_NAME' =>$enter['enter_name'],
			'ENTER_ID' =>$enter['enter_id'],
			'LINK_JBNAME' =>$enter['link_jbname'],
			'LINK_JBSEX' =>$enter['line_jbsex'],
			'LINK_JBJOB' =>$enter['link_jbjob'], 
			'LINK_JBMPHONE' =>$enter['link_jbmphone']];
			
		$sql2=Db::table('ENTER_LINK')->insert($data2); */
		if($sql1=="1"){
				echo "<script>alert('企业信息录入成功')</script>";  
				return $this->fetch('jcxxlr');      //修改成功返回录入查询页

			}	
		else{
			echo "<script>alert('企业信息没有录入成功，请核对录入信息正确！')</script>"; 
			return $this->fetch('jcxxlr');
			}
		
	}
	
		
	






	

	
	/*----------企业基础数据导出查询页面------------*/
	public function yhsjdc($enter_city="",$enter_county="",$enter_leixing="",$enter_id="",$enter_name="")
    {
		$this -> assign('enter_city',$enter_city);
		$this -> assign('enter_county',$enter_county);
		$this -> assign('enter_leixing',$enter_leixing);
		$this -> assign('enter_id',$enter_id);
		$this -> assign('enter_name',$enter_name);
		
		$enter_city==""?"":$map['ENTER_CITY'] = $enter_city;
		$enter_county==""?"":$map['ENTER_COUNTY'] = $enter_county;
		$enter_leixing==""?"":$map['ENTER_LEIXING'] = $enter_leixing;
		$enter_id==""?"":$map['ENTER_ID'] = $enter_id;
		$enter_name==""?"":$map['ENTER_NAME']  = $enter_name;
		if(empty($map))        //如果输入的查询条件判定为无，输出全部数据作为查询结果
			{
			$list='';
			$this -> assign('list',$list);
	    	return $this->fetch('yhsjdc');
			}
		else{
    		$list = Db::table('ENTER_BASIC_INFO')
						->where($map)
						->select();
						//->paginate($info); 
					if(empty($list))     //如果数据库查询结果为空，提示用户并显示所有数据为查询结果
						{
							//$info=Db::table('ENTER_BASIC_INFO')->count();
    						//$list = Db::table('ENTER_BASIC_INFO')->paginate($info);    
							//$this -> assign('list',$list);
							$this -> assign('list',$list);
							$this -> assign('enter_city',$enter_city);
							$this -> assign('enter_county',$enter_county);
							$this -> assign('enter_leixing',$enter_leixing);
							$this -> assign('enter_id',$enter_id);
							$this -> assign('enter_name',$enter_name);
							#print_r($map);
							echo "<script>alert('没有符合条件的单位信息')</script>";
	    					return $this->fetch('yhsjdc');
						}
					else{            //如果查询到结果，在列表显示，并保留筛选条件
					
					$this -> assign('list',$list);
					$this -> assign('enter_city',$enter_city);
					$this -> assign('enter_county',$enter_county);
					$this -> assign('enter_leixing',$enter_leixing);
					$this -> assign('enter_id',$enter_id);
					$this -> assign('enter_name',$enter_name);
					
	   				return $this->fetch('yhsjdc');
						}
			}
	
	}
	/*----------/企业基础数据导出查询页面------------*/


	/*----------/企业基础数据导出------------*/
	
	
	
	public function jcsjdc()
	{			
		$enter = $_POST;		
		$csv=new \think\csv\Csv();  //调用数据生成的类文件


		$enter['enter_city']==""?"":$map['ENTER_CITY'] = $enter['enter_city'];
		$enter['enter_county']==""?"":$map['ENTER_COUNTY'] = $enter['enter_county'];
		$enter['enter_leixing']==""?"":$map['ENTER_LEIXING'] = $enter['enter_leixing'];
		$enter['enter_id']==""?"":$map['ENTER_ID'] = $enter['enter_id'];
		$enter['enter_name']==""?"":$map['ENTER_NAME'] = $enter['enter_name'];
		if(empty($map)){        //如果输入的查询条件判定为无，输出全部数据作为查询结果
				$list=Db::table('ENTER_BASIC_INFO')
							->select();//查询数据，可以进行处理
				$csv_title=array('编号','机构','县区','单位名称','信用代码','工商注册号','单位地址','注册资金','单位性质','单位类型','单位状态','企业法人','联系电话');
    			$csv->put_csv($list,$csv_title);
						}	
					
		else{  
    			$list = Db::table('ENTER_BASIC_INFO')
						->where($map)
						->select(); 
					if(empty($list))     //如果数据库查询结果为空，提示用户并显示所有数据为查询结果
						{
							echo "<script>alert('没有符合条件的单位信息')</script>";
								$this -> assign('enter_city',"");
								$this -> assign('enter_county',"");
								$this -> assign('enter_leixing',"");
								$this -> assign('enter_id',"");
								$this -> assign('enter_name',"");
								$this -> assign('list',"");
							return $this->fetch('yhsjdc');
						}
					else{            //如果查询到结果，在列表显示，并保留筛选条件
					
							$csv_title=array('编号','机构','县区','单位名称','机构编码','单位地址','注册资本','单位性质','单位类型','经营状况','单位人数','管理人员','普通员工','高危人员');
    						$csv->put_csv($list,$csv_title);
						}	
			}
	}





	
	public function test($enter_name='',$enter_id='')
	{	
		if($enter_name==""){
			if($enter_id==""){
				echo "<script>alert('请输入企业名称')</script>";
				return $this->fetch('jcxxcx');
			}	
		}
		echo "$enter_name\n";
		echo "$enter_id\n";
		
		$info=Db::table('ENTER_BASIC_INFO')
                    //->where('ENTER_NAME',123)
                    ->find();
					
		print_r($info);
		$info1=Db::table('ENTER_BASIC_INFO')
                    //->where('ENTER_NAME',123)
                    ->select();
		echo "/n";
		echo "===================";
		//print_r($info1);
		}	
		
		

	
}







