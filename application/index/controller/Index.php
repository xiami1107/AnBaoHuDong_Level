<?php
namespace app\index\Controller;
use \think\Db;
use \think\Controller;
use \think\view;
//use \app\index\model\student;


class Index extends Controller
{
//调用方法localhost/tp_5/public/index.php/index/index/index/
	public function index()
    {
		$level=Db::table('ENTER_RESULTS')->where('RES_YEAR','2018')->count();
		
		$level_A=Db::table('ENTER_RESULTS')->where('RES_YEAR','2018')->whereLike('RES_RANK','%甲%')->count();
		
		$level_B=Db::table('ENTER_RESULTS')->where('RES_YEAR','2018')->whereLike('RES_RANK','%乙%')->count();
		
		$level_C=Db::table('ENTER_RESULTS')->where('RES_YEAR','2018')->whereLike('RES_RANK','%丙%')->count();
		
		$level_D=Db::table('ENTER_RESULTS')->where('RES_YEAR','2018')->whereLike('RES_RANK','%丁%')->count();
		
		$level_NULL=Db::table('ENTER_RESULTS')->where('RES_YEAR','2018')->where('RES_RANK',"")->count();
		
		//print($level);
		
		$percentage_A=$level_A/$level;		//甲类企业的占比数量
		$percentage_A=(round($percentage_A,2))*100;
		
		$percentage_B=$level_B/$level;		//乙类企业的占比数量
		$percentage_B=(round($percentage_B,2))*100;
		
		$percentage_C=$level_C/$level;		//丙类企业的占比数量
		$percentage_C=(round($percentage_C,2))*100;
		
		$percentage_D=$level_D/$level;		//丁类企业的占比数量
		$percentage_D=(round($percentage_D,2))*100;
		
		$percentage_NULL=$level_NULL/$level;		//无评级类企业的占比数量
		$percentage_NULL=(round($percentage_NULL,2))*100;
		
		//print($percentage_A.",");
		//print($percentage_B.",");
		//print($percentage_C.",");
		//print($percentage_D.",");
		//print($percentage_NULL.",");
		
		$level_BN[]="版纳";
		$level_BN[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','版纳')->whereLike('RES_RANK','%甲%')->count();
		$level_BN[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','版纳')->whereLike('RES_RANK','%乙%')->count();
		$level_BN[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','版纳')->whereLike('RES_RANK','%丙%')->count();
		$level_BN[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','版纳')->whereLike('RES_RANK','%丁%')->count();
		$level_BN[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','版纳')->where('RES_RANK',"")->count();
		
		$level_BS[]="保山";
		$level_BS[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','保山')->whereLike('RES_RANK','%甲%')->count();
		$level_BS[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','保山')->whereLike('RES_RANK','%乙%')->count();
		$level_BS[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','保山')->whereLike('RES_RANK','%丙%')->count();
		$level_BS[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','保山')->whereLike('RES_RANK','%丁%')->count();
		$level_BS[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','保山')->where('RES_RANK',"")->count();
		
		$level_CX[]="楚雄";
		$level_CX[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','楚雄')->whereLike('RES_RANK','%甲%')->count();
		$level_CX[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','楚雄')->whereLike('RES_RANK','%乙%')->count();
		$level_CX[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','楚雄')->whereLike('RES_RANK','%丙%')->count();
		$level_CX[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','楚雄')->whereLike('RES_RANK','%丁%')->count();
		$level_CX[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','楚雄')->where('RES_RANK',"")->count();
		
		$level_DL[]="大理";
		$level_DL[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','大理')->whereLike('RES_RANK','%甲%')->count();
		$level_DL[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','大理')->whereLike('RES_RANK','%乙%')->count();
		$level_DL[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','大理')->whereLike('RES_RANK','%丙%')->count();
		$level_DL[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','大理')->whereLike('RES_RANK','%丁%')->count();
		$level_DL[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','大理')->where('RES_RANK',"")->count();
		
		$level_DH[]="德宏";
		$level_DH[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','德宏')->whereLike('RES_RANK','%甲%')->count();
		$level_DH[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','德宏')->whereLike('RES_RANK','%乙%')->count();
		$level_DH[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','德宏')->whereLike('RES_RANK','%丙%')->count();
		$level_DH[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','德宏')->whereLike('RES_RANK','%丁%')->count();
		$level_DH[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','德宏')->where('RES_RANK',"")->count();
		
		$level_DQ[]="迪庆";
		$level_DQ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','迪庆')->whereLike('RES_RANK','%甲%')->count();
		$level_DQ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','迪庆')->whereLike('RES_RANK','%乙%')->count();
		$level_DQ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','迪庆')->whereLike('RES_RANK','%丙%')->count();
		$level_DQ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','迪庆')->whereLike('RES_RANK','%丁%')->count();
		$level_DQ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','迪庆')->where('RES_RANK',"")->count();
		
		$level_HH[]="红河";
		$level_HH[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','红河')->whereLike('RES_RANK','%甲%')->count();
		$level_HH[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','红河')->whereLike('RES_RANK','%乙%')->count();
		$level_HH[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','红河')->whereLike('RES_RANK','%丙%')->count();
		$level_HH[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','红河')->whereLike('RES_RANK','%丁%')->count();
		$level_HH[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','红河')->where('RES_RANK',"")->count();
		
		$level_KM[]="昆明";
		$level_KM[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','昆明')->whereLike('RES_RANK','%甲%')->count();
		$level_KM[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','昆明')->whereLike('RES_RANK','%乙%')->count();
		$level_KM[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','昆明')->whereLike('RES_RANK','%丙%')->count();
		$level_KM[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','昆明')->whereLike('RES_RANK','%丁%')->count();
		$level_KM[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','昆明')->where('RES_RANK',"")->count();
		
		$level_LJ[]="丽江";
		$level_LJ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','丽江')->whereLike('RES_RANK','%甲%')->count();
		$level_LJ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','丽江')->whereLike('RES_RANK','%乙%')->count();
		$level_LJ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','丽江')->whereLike('RES_RANK','%丙%')->count();
		$level_LJ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','丽江')->whereLike('RES_RANK','%丁%')->count();
		$level_LJ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','丽江')->where('RES_RANK',"")->count();
		
		$level_NJ[]="怒江";
		$level_NJ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','怒江')->whereLike('RES_RANK','%甲%')->count();
		$level_NJ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','怒江')->whereLike('RES_RANK','%乙%')->count();
		$level_NJ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','怒江')->whereLike('RES_RANK','%丙%')->count();
		$level_NJ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','怒江')->whereLike('RES_RANK','%丁%')->count();
		$level_NJ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','怒江')->where('RES_RANK',"")->count();
		
		$level_PE[]="普洱";
		$level_PE[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','普洱')->whereLike('RES_RANK','%甲%')->count();
		$level_PE[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','普洱')->whereLike('RES_RANK','%乙%')->count();
		$level_PE[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','普洱')->whereLike('RES_RANK','%丙%')->count();
		$level_PE[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','普洱')->whereLike('RES_RANK','%丁%')->count();
		$level_PE[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','普洱')->where('RES_RANK',"")->count();
		
		$level_QJ[]="曲靖";
		$level_QJ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','曲靖')->whereLike('RES_RANK','%甲%')->count();
		$level_QJ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','曲靖')->whereLike('RES_RANK','%乙%')->count();
		$level_QJ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','曲靖')->whereLike('RES_RANK','%丙%')->count();
		$level_QJ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','曲靖')->whereLike('RES_RANK','%丁%')->count();
		$level_QJ[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','曲靖')->where('RES_RANK',"")->count();
		
		$level_WS[]="文山";
		$level_WS[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','文山')->whereLike('RES_RANK','%甲%')->count();
		$level_WS[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','文山')->whereLike('RES_RANK','%乙%')->count();
		$level_WS[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','文山')->whereLike('RES_RANK','%丙%')->count();
		$level_WS[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','文山')->whereLike('RES_RANK','%丁%')->count();
		$level_WS[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','文山')->where('RES_RANK',"")->count();
		
		$level_YX[]="玉溪";
		$level_YX[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','玉溪')->whereLike('RES_RANK','%甲%')->count();
		$level_YX[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','玉溪')->whereLike('RES_RANK','%乙%')->count();
		$level_YX[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','玉溪')->whereLike('RES_RANK','%丙%')->count();
		$level_YX[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','玉溪')->whereLike('RES_RANK','%丁%')->count();
		$level_YX[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','玉溪')->where('RES_RANK',"")->count();
		
		$level_ZT[]="昭通";
		$level_ZT[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','昭通')->whereLike('RES_RANK','%甲%')->count();
		$level_ZT[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','昭通')->whereLike('RES_RANK','%乙%')->count();
		$level_ZT[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','昭通')->whereLike('RES_RANK','%丙%')->count();
		$level_ZT[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','昭通')->whereLike('RES_RANK','%丁%')->count();
		$level_ZT[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','昭通')->where('RES_RANK',"")->count();
		
		$this->assign('level_A',$level_A);
		$this->assign('level_B',$level_B);
		$this->assign('level_C',$level_C);
		$this->assign('level_D',$level_D);
		$this->assign('level_NULL',$level_NULL);
		
		$this->assign('percentage_A',$percentage_A);
		$this->assign('percentage_B',$percentage_B);
		$this->assign('percentage_C',$percentage_C);
		$this->assign('percentage_D',$percentage_D);
		$this->assign('percentage_NULL',$percentage_NULL);
		
		$this->assign('level_BN',$level_BN);	//版纳
		$this->assign('level_BS',$level_BS);	//保山
		$this->assign('level_CX',$level_CX);	//楚雄
		$this->assign('level_DL',$level_DL);	//大理
		$this->assign('level_DH',$level_DH);	//德宏
		$this->assign('level_DQ',$level_DQ);	//迪庆
		$this->assign('level_HH',$level_HH);	//红河
		$this->assign('level_KM',$level_KM);	//昆明
		$this->assign('level_LJ',$level_LJ);	//丽江
		$this->assign('level_NJ',$level_NJ);	//怒江
		$this->assign('level_PE',$level_PE);	//普洱
		$this->assign('level_QJ',$level_QJ);	//曲靖
		$this->assign('level_WS',$level_WS);	//文山
		$this->assign('level_YX',$level_YX);	//玉溪
		$this->assign('level_ZT',$level_ZT);	//昭通		
		
		return $this->fetch('index');
	}
	
	
	public function jcxxcx()
    {
		//$this = new View();
		$this->assign([
				'enter_name'=>'',
				'enter_add'=>''
				]);
		//$this->assign('123','123');
		return $this->fetch('jcxxcx');
	}
	
//查询企业是否存在，并跳转到企业基础信息新增或修改界面	
	public function jcxxlr($enter_name='',$enter_id='')
    {
		//$enter_name = $_POST['enter_name'];
		//$enter_id = $_POST['enter_id'];
		
		//print_r($enter);
		//return $this->fetch('jcxxlr');
		if(empty($enter_name)){
			return $this->fetch('jcxxlr');
		} 
	 	else {
			$enter_name=$_POST['enter_name'];
			$info=Db::table('ENTER_BASIC_INFO')->where('ENTER_NAME',$enter_name)->find();
			//如果企业不存在跳转到新增界面
			if(!$info){                            
					$this->assign(['enter_name'=>$enter_name]);
					return $this->fetch('jcxxlr_xz');
					}
			//如果企业存在跳转到企业修改界面	
			else 	{
					$enter_city=$info['ENTER_CITY'];
					$enter_county=$info['ENTER_COUNTY'];
					$enter_name=$info['ENTER_NAME'];
		//$enter_id=$info['ENTER_ID']==""?$enter_id="无机构代码":$enter_id=$info['ENTER_ID'];
					$enter_id=$info['ENTER_ID'];
					$enter_add=$info['ENTER_ADD'];
					$enter_capital=$info['ENTER_CAPITAL'];
					$enter_xingzhi=$info['ENTER_XINGZHI'];
					$enter_leixing=$info['ENTER_LEIXING'];
					$enter_zhuangtai=$info['ENTER_ZHUANGTAI'];
					$enter_pr=$info['ENTER_PR'];
					$enter_pr_manager=$info['ENTER_PR_MANAGER'];
					$enter_pr_grade=$info['ENTER_PR_GRADE'];
					$enter_pr_high=$info['ENTER_PR_HIGH'];
					$id=$info['ID'];
					$this->assign([
						'id'=>$id,
						'enter_city'=>$enter_city,
						'enter_county'=>$enter_county,
						'enter_name'=>$enter_name,
						'enter_id'=>$enter_id,
						'enter_add'=>$enter_add,
						'enter_capital'=>$enter_capital,
						'enter_xingzhi'=>$enter_xingzhi,
						'enter_leixing'=>$enter_leixing,
						'enter_zhuangtai'=>$enter_zhuangtai,
						'enter_pr'=>$enter_pr,
						'enter_pr_manager'=>$enter_pr_manager,
						'enter_pr_grade'=>$enter_pr_grade,
						'enter_pr_high'=>$enter_pr_high
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
	

				
	

//调用方法localhost/tp_5/public/index.php/index/index/instr/name/lisi/age/3	
	
	public function instr()
	{
	//$DB = new Db;
	//$data = Db::table('stu')->select();
	//$data1 = ['name' => 'zhangsan', 'age' => '20'];
	$account    = $this->request->post('account');
    $password   = $this->request->post('password');
	$res=db::table('ENTER_INFO')->where('ID',$account)->find();
		$name=$res['ENTER_NAME'];
		$this->assign('name',$name);
		return $this->fetch('index-demo');
	
	//$data = ['name'=>$account,'age'=>$password];
	
	//Db::table('ENTER_INFO')->insert($data);
	//print_r($data);
    //print_r($data[0]);
	}

//调用方法localhost/tp_5/public/index.php/index/index/hello/name/100
	public function hello()
	{
		//$this->assign('enter_name',$name);
		//return $this->fetch();
		//return 'hello'.$name;
		//print_r($enter);
		//$this->assign('name', $name);
        //return $this->fetch();
		}

	
	public function enter()
	{
		return student::get(1);
		}

//查询企业基本信息表		
	public function seletc($enter_name="",$enter_id="")
	//public function seletc()
	{
		//$this->assign('name',$name);
		if($enter_name=="" or $enter_id="")
		{
			return $this->fetch('jcxxcx');
		}	
		
		
		$info=Db::table('ENTER_BASIC_INFO')->where('ENTER_NAME',$enter_name)->find();
		$enter_city=$info['ENTER_CITY'];
		$enter_county=$info['ENTER_COUNTY'];
		$enter_name=$info['ENTER_NAME'];
		//$enter_id=$info['ENTER_ID']==""?$enter_id="无机构代码":$enter_id=$info['ENTER_ID'];
		$enter_id=$info['ENTER_ID'];
		$enter_add=$info['ENTER_ADD'];
		$enter_capital=$info['ENTER_CAPITAL'];
		$enter_xingzhi=$info['ENTER_XINGZHI'];
		$enter_leixing=$info['ENTER_LEIXING'];
		$enter_pr=$info['ENTER_PR'];
		$enter_pr_manager=$info['ENTER_PR_MANAGER'];
		$enter_pr_grade=$info['ENTER_PR_GRADE'];
		$enter_pr_high=$info['ENTER_PR_HIGH'];
		$this->assign([
			'enter_city'=>$enter_city,
			'enter_county'=>$enter_county,
			'enter_name'=>$enter_name,
			'enter_id'=>$enter_id,
			'enter_add'=>$enter_add,
			'enter_capital'=>$enter_capital,
			'enter_xingzhi'=>$enter_xingzhi,
			'enter_leixing'=>$enter_leixing,
			'enter_pr'=>$enter_pr,
			'enter_pr_manager'=>$enter_pr_manager,
			'enter_pr_grade'=>$enter_pr_grade,
			'enter_pr_high'=>$enter_pr_high
		]);
		
		$year='2019';
		$info=Db::table('ENTER_BAOFEI')
				->where('ENTER_NAME','like','%'.$enter_name.'%')
				->where('ENTER_BF_YEAR',$year)
				->find();
		$enter_bf_baofei=$info['ENTER_BF_BAOFEI'];
		$this->assign('enter_bf_baofei',$enter_bf_baofei);
		return $this->fetch('jcxxcx_sel');
	}
	/*------获取企业当年保费金额---------*/	
	public function bfgm($enter_name)   
	{
		$res=Db::table('ENTER_BAOFEI')->where('ENTER_NAME',$enter_name)->where('BF_YEAR','2018')->find();
		
		
		return $bf_baofei=$res['BF_BAOFEI'];
		//return $this->assign('bf_baofei',$bf_baofei);
		//return $this->assign('bf_baofei',$bf_baofei);
		}
		
		
	public function exportExcel($expTitle,$expCellName,$expTableData)
	{
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = $_SESSION['account'].date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        vendor("PHPExcel.PHPExcel");
       
        $objPHPExcel = new PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
       // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));  
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]); 
        } 
          // Miscellaneous glyphs, UTF-8   
        for($i=0;$i<$dataNum;$i++){
          for($j=0;$j<$cellNum;$j++){
            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
          }             
        }  
        
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); 
        exit;   
    }
 /**
     *
     * 导出Excel
     */
    function expUser(){//导出Excel
        $xlsName  = "User";
        $xlsCell  = array(
        array('id','账号序列'),
        array('truename','名字'),
        array('sex','性别'),
        array('res_id','院系'),
        array('sp_id','专业'),
        array('class','班级'),
        array('year','毕业时间'),
        array('city','所在地'),
        array('company','单位'),
        array('zhicheng','职称'),
        array('zhiwu','职务'),
        array('jibie','级别'),
        array('tel','电话'),
        array('qq','qq'),
        array('email','邮箱'),
        array('honor','荣誉'),
        array('remark','备注')    
        );
        $xlsModel = M('Member');
    
        $xlsData  = $xlsModel->Field('id,truename,sex,res_id,sp_id,class,year,city,company,zhicheng,zhiwu,jibie,tel,qq,email,honor,remark')->select();
        foreach ($xlsData as $k => $v)
        {
            $xlsData[$k]['sex']=$v['sex']==1?'男':'女';
        }
        $this->exportExcel($xlsName,$xlsCell,$xlsData);
         
    }


/*------数据导出---------*/
	public function d(){
	$csv=new \think\csv\Csv();  //调用数据生成的类文件
    //$list=Db::table('BASE_XUBAOSHIXIAO')->select();//查询数据，可以进行处理
    $list=Db::view('BASE_XUBAOSHIXIAO','ID,ENTER_NAME')
	->view('ENTER_BASIC_INFO','ENTER_ID,ENTER_ADD','ENTER_BASIC_INFO.ID=BASE_XUBAOSHIXIAO.ID')
    //->where()
    ->select();
	$csv_title=array('用户ID','用户名','绑定邮箱','绑定手机','注册时间','注册IP');
    $csv->put_csv($list,$csv_title);
		}
		/*----------/企业评级家数汇总和占比------------*/
	public function pjjghz()
	{

		//$level_YX[]="玉溪";
		//$level_YX[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','玉溪')->whereLike('RES_RANK','%甲%')->count()
											//	->where('ENTER_CITY','玉溪')->whereLike('RES_RANK','%乙%')->count();
		$map1 = [
        ['ENTER_CITY','=','玉溪'],
        ['RES_RANK','like','%甲%'],
    	];
    
		$map2 = [
        ['ENTER_CITY','=','玉溪'],
        ['RES_RANK','like','%乙%'],
    	];
		
		$level_YX=Db::table('ENTER_RESULTS')
    	->whereOr([ $map1, $map2 ])
    	->count();
		//$level_YX[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','玉溪')->whereLike('RES_RANK','%乙%')->count();
		//$level_YX[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','玉溪')->whereLike('RES_RANK','%丙%')->count();
		//$level_YX[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','玉溪')->whereLike('RES_RANK','%丁%')->count();
		//$level_YX[]=Db::table('ENTER_RESULTS')->where('ENTER_CITY','玉溪')->where('RES_RANK',"")->count();
		//print "甲级：".$level."<br />";
		
		
		
		//$E=Db::table('ENTER_RESULTS')->whereLike('RES_RANK','%乙%')->count();
		//echo "$E\n";
		print_r($level_YX);
		//echo($level_YX[1]);
		
	}
	
	/*----------/企业工商信息获取接口------------*/
	public function idata()
    {
        $method = "GET";
        //$url = "http://api01.idataapi.cn:8000/org/idataapi?apikey=aVYdEVB6L9qXeW2WVRpEpDkFFrUeErKENId3kc2wMaPih1z5OetzuzsNQvdqjTJZ&kw=玉溪大红山矿业有限公司&creditCode=91530427757184315E";
        //$url = "http://api01.idataapi.cn:8000/org/idataapi?apikey=aVYdEVB6L9qXeW2WVRpEpDkFFrUeErKENId3kc2wMaPih1z5OetzuzsNQvdqjTJZ&creditCode=91530427757184315E";
        $url = "http://api01.idataapi.cn:8000/org/idataapi?sortMode=1&detail=true&name=云南几维进出口贸易有限公司&apikey=aVYdEVB6L9qXeW2WVRpEpDkFFrUeErKENId3kc2wMaPih1z5OetzuzsNQvdqjTJZ";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_ENCODING, "gzip");
        $json = curl_exec($curl);
        $json = json_decode($json, true);
        $retcode=$json['retcode'];
        print_r($retcode);
        if ($retcode==000000) {   //状态代码000000:成功调用并返回数据
        //print_r($json);
            echo("<br />");
            echo("-----------------------------------------------");
            echo("<br />");

            print_r($json1 = ($json['data'][0]));
            echo("<br />");

            echo("<br />");
            echo("-----------------------------------------------");
            echo("<br />");

            $city = $json1['city']<>"西双版纳傣族自治州" ? $json1['city'] : "版纳";
            $enter_city =mb_substr($city,0,2);       //市
            $enter_county=$json1['district'];          //区
            $enter_name=$json1['screenName'];            //公司名称
            $enter_capital=$json1['licenseCapital'];       //工商注册资本
            $enter_zhuangtai=$json1['businessStatus'];     //经营状态
            $enter_add=$json1['address'];           //街道地址
            $enter_bid=$json1['licenseNo'];           //工商注册号，执照号码
            $enter_id=$json1['creditCode'];            //统一社会信用代码
            $enter_leixing=$json1['comType'];           // 公司类型
            $enter_legalperson=$json1['legalRepresentative'];           //法定代表人
            $enter_phone=$json1['telephones'][0];             //电话

            print_r("市:" . $enter_city. "<br />"); //市
            print_r("区:" . $enter_county . "<br />"); //区
            print_r("公司名称:" . $enter_name . "<br />");  //公司名称
            print_r("工商注册资本:" . $enter_capital . "<br />"); //工商注册资本
            print_r("经营状态:" . $enter_zhuangtai . "<br />"); //经营状态
            print_r("街道地址:" . $enter_add . "<br/>");   //街道地址
            print_r("工商注册号:" . $enter_bid . "<br/>");   //工商注册号，执照号码
            print_r("统一社会信用代码:" . $enter_id . "<br/>");   //统一社会信用代码
            print_r("公司类型:" . $enter_leixing . "<br/>");   //公司类型
            print_r("法定代表人:" . $enter_legalperson . "<br />"); //法定代表人
            print_r("电话:" . $enter_phone . "<br />"); //电话

            echo("<br />");
            echo("-----------------------------------------------");
            echo("<br />");

            echo("<br />");
            echo("-----------------------------------------------");
            echo("<br />");

        }
        if($retcode==100002){   //状态代码000000:目标参数搜索没结果
            echo("没有数据");
        }

    }
	public function test()
	{
	$str[] = "Array ( [hasNext] => [data] => Array ( [0] => Array ( [licenseCapital] => 105500万人民币 [orgCode] => 757184315 [geoPoint] => Array ( [lon] => 101.58264251679 [lat] => 24.053134572251 ) [businessStatus] => 存续 [verifiedDate] => 2016-05-18 [url] => https://www.tianyancha.com/company/221615895 [legalRepresentative] => 邢志华 [branches] => Array ( [0] => Array ( [name] => 玉溪大红山矿业有限公司管道运输分公司 [id] => 295384810 ) [1] => Array ( [name] => 玉溪大红山矿业有限公司新平红山红物流分公司 [id] => 295384860 ) ) [createDate] => 1568372957 [telephones] => Array ( [0] => 0877-7394697 [1] => 0877-7394716 ) [industries] => Array ( [0] => 黑色金属矿采选业 ) [changeEvents] => Array ( [0] => Array ( [date] => 2019-06-10 [after] => 吕昌健 *** 备案手机：*** （网上办理） [item] => 联络员备案 [before] => 钱晓曼 *** 备案手机：*** ) [1] => Array ( [date] => 2018-09-04 [after] => 李俊 李树雄 宋钊刚 董瑞章 包继锋 邢志华 余正方 [item] => 高级管理人员备案（董事、监事、经理等） [before] => 邢志华 李树雄 宋钊刚 董瑞章 包继锋 李俊 蔺朝辉 ) [2] => Array ( [date] => 2018-09-04 [after] => 包继锋 [item] => 高级管理人员备案（董事、监事、经理等） ) [3] => Array ( [date] => 2017-05-23 [after] => 2017-02-28新章程 [item] => 章程备案 [before] => 无 ) [4] => Array ( [date] => 2016-11-21 [after] => 张润红 张春华 雷勇 [item] => 高级管理人员备案（董事、监事、经理等） [before] => 杜陆军 黄乃星 陈绍平 彭伟 代苏丽 ) [5] => Array ( [date] => 2016-11-21 [item] => 高级管理人员备案（董事、监事、经理等） [before] => 李金恩 ) [6] => Array ( [date] => 2016-11-21 [after] => 董瑞章 邢志华 包继锋 宋钊刚 李树雄 李俊 蔺朝辉 [item] => 高级管理人员备案（董事、监事、经理等） [before] => 蔺朝辉 紫立新 邢志华 丁红力 卢明 陈昆宁 ) [7] => Array ( [date] => 2016-11-21 [item] => 章程修正案备案 [before] => 无 ) [8] => Array ( [date] => 2016-11-21 [item] => 经理备案 [before] => 李金恩 ) [9] => Array ( [date] => 2016-11-21 [after] => 张润红 张春华 雷勇 [item] => 监事备案 [before] => 杜陆军 黄乃星 陈绍平 彭伟 代苏丽 ) [10] => Array ( [date] => 2016-11-21 [after] => 董瑞章 邢志华 包继锋 宋钊刚 李树雄 李俊 蔺朝辉 [item] => 董事备案 [before] => 蔺朝辉 紫立新 邢志华 丁红力 卢明 陈昆宁 ) [11] => Array ( [date] => 2016-07-12 [after] => 钱晓曼 *** 备案手机：*** （网上办理） [item] => 联络员备案 [before] => 徐绍娟 *** 备案手机：*** ) [12] => Array ( [date] => 2016-05-18 [after] => 邢志华 [item] => 法定代表人变更 [before] => 徐士申 ) [13] => Array ( [date] => 2016-05-18 [after] => 陈昆宁 丁红力 蔺朝辉 邢志华 紫立新 卢明 [item] => 高级管理人员备案（董事、监事、经理等） [before] => 丁红力 蔺朝辉 卢明 徐士申 紫立新 陈昆宁 ) [14] => Array ( [date] => 2016-05-18 [after] => 陈昆宁 丁红力 蔺朝辉 邢志华 紫立新 卢明 [item] => 董事备案 [before] => 丁红力 蔺朝辉 卢明 徐士申 紫立新 陈昆宁 ) [15] => Array ( [date] => 2016-01-18 [after] => 徐绍娟 *** 备案手机：*** [item] => 联络员备案 [before] => 雷寿姣 *** 备案手机：*** ) [16] => Array ( [date] => 2016-01-18 [after] => 陈昆宁 丁红力 蔺朝辉 徐士申 紫立新 卢明 [item] => 高级管理人员备案（董事、监事、经理等） [before] => 徐士申 卢明 罗明发 紫立新 陈昆宁 蔺朝辉 ) [17] => Array ( [date] => 2016-01-18 [after] => 陈昆宁 丁红力 蔺朝辉 徐士申 紫立新 卢明 [item] => 董事备案 [before] => 徐士申 卢明 罗明发 紫立新 陈昆宁 蔺朝辉 ) [18] => Array ( [date] => 2016-01-18 [after] => 105500.0000万人民币 [item] => 注册资本(金)变更 [before] => 55500万人民币 ) [19] => Array ( [date] => 2016-01-18 [after] => 李俊 [item] => 财务负责人 ) [20] => Array ( [date] => 2016-01-18 [after] => 云南省玉溪市新平彝族傣族自治县戛洒镇小红山 [item] => 住所变更 [before] => 云南省玉溪市新平县老厂乡小红山 ) [21] => Array ( [date] => 2015-07-02 [after] => 铁矿开采、矿产品、黑色金属矿、有色金属矿加工、销售;冶金高新技术开发、技术服务;矿浆管道输送；直接还原铁、还原铁粉、化工铁粉，天然微合金铁粉的研发、生产、销售；仓储配送、货物运输、物流信息；机械设备及配件、汽车及零配件、建材、农副产品销售；造林苗、城镇绿化苗、经济林苗、花卉批发、零售。（依法须经批准的项目，经相关部门批准后方可开展经营活动） [item] => 经营范围变更 [before] => 铁矿开采、矿产品、黑色金属矿、有色金属矿加工、销售;冶金高新技术开发、技术服务;矿浆管道输送；直接还原铁、还原铁粉、化工铁粉，天然微合金铁粉的研发、生产、销售。 ) [22] => Array ( [date] => 2014-05-19 [after] => 姓名：徐士申性别：男 住所：云南省安宁市连然镇金屯路金屯小区19幢2302单元号居民身份证 ：*** 产生方式：委派聘任单位：玉溪大红山矿业有限公司董事会 [item] => 法定代表人变更 [before] => 姓名：徐炜性别：男 住所：云南省安宁市连然镇建设西路黄金海岸小区6幢2单元501室居民身份证 ：*** 产生方式：委派聘任单位：玉溪大红山矿业有限公司董事会 ) [23] => Array ( [date] => 2014-05-19 [after] => 云南省玉溪市新平县老厂乡小红山电话：********邮编：653405 [item] => 住所(营业场所、地址)变更 [before] => 玉溪市新平县老厂乡小红山电话：********邮编：653405 ) [24] => Array ( [date] => 2014-05-19 [after] => 姓名：徐士申性别：男 住所：**********居民身份证 ：******产生方式：委派聘任单位：玉溪大红山矿业有限公司董事会 [item] => 法定代表人(负责人、董事长、首席代表)变更 [before] => 姓名：徐炜性别：男 住所：**********居民身份证 ：******产生方式：委派聘任单位：玉溪大红山矿业有限公司董事会 ) ) [address] => 云南省玉溪市新平彝族傣族自治县戛洒镇小红山 [businessDuration] => 2004-01-06至2064-01-05 [aicBureau] => 新平彝族傣族自治县市场监督管理局 [state] => 云南省 [aliases] => Array ( [0] => 大红山 ) [insuredCount] => 896 [screenNameEng] => Yuxi Dahongshan Mining Co.,Ltd. [id] => 221615895 [emails] => Array ( [0] => 1499427651@qq.com [1] => yxdhsky@ynkg.com [2] => 916180370@qq.com ) [rating] => 76 [avatarUrl] => https://img5.tianyancha.com/logo/lll/073bfe7fc385713b46eb0629e1338d8b.png@!f_200x200 [tags] => [parentOrgScreenName] => 昆明钢铁集团有限责任公司 [screenName] => 玉溪大红山矿业有限公司 [parentOrgId] => 213522043 [billingPhones] => Array ( [0] => 0877-7394697 ) [city] => 玉溪市 [creditCode] => 91530427757184315E [startupDate] => 2004-01-06 [updateDate] => 1568370688 [district] => 新平彝族傣族自治县 [businessRange] => 铁矿开采、矿产品、黑色金属矿、有色金属矿加工、销售;冶金高新技术开发、技术服务;矿浆管道输送；直接还原铁、还原铁粉、化工铁粉，天然微合金铁粉的研发、生产、销售；仓储配送、货物运输、物流信息；机械设备及配件、汽车及零配件、建材、农副产品销售；造林苗、城镇绿化苗、经济林苗、花卉批发、零售。（依法须经批准的项目，经相关部门批准后方可开展经营活动） [staffScale] => 500-999人 [shareholders] => Array ( [0] => Array ( [percent] => 1 [subCapital] => 105500 [name] => 昆明钢铁集团有限责任公司 [id] => 213522043 ) ) [staffs] => Array ( [0] => Array ( [name] => 雷勇 [position] => 监事 [id] => 2263405349 ) [1] => Array ( [name] => 李俊 [position] => 董事 [id] => 1979475272 ) [2] => Array ( [name] => 张春华 [position] => 监事 [id] => 1927058522 ) [3] => Array ( [name] => 张润红 [position] => 监事 [id] => 1928956752 ) [4] => Array ( [name] => 余正方 [position] => 董事 [id] => 1785612674 ) [5] => Array ( [name] => 邢志华 [position] => 董事长 [id] => 2205712290 ) [6] => Array ( [name] => 李树雄 [position] => 董事 [id] => 1986512167 ) [7] => Array ( [name] => 宋钊刚 [position] => 董事 [id] => 1892009805 ) [8] => Array ( [name] => 包继锋 [position] => 董事兼总经理 [id] => 1820675364 ) [9] => Array ( [name] => 董瑞章 [position] => 董事 [id] => 2147957393 ) ) [billingAddress] => 云南省玉溪市新平彝族傣族自治县戛洒镇小红山 [dataType] => org [comType] => 有限责任公司 [licenseNo] => 530427000001952 [comLevel] => 非自然人投资或控股的法人独资 ) ) [total] => 1 [dataType] => org [appCode] => idataapi [pageToken] => [retcode] => 000000 )
";
	print_r($str);
	echo("<br />");
	echo("-----------------------------------------------");
	echo("<br />");
	echo $str['data'];
	}
}








