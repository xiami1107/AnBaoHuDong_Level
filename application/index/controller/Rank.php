<?php
namespace app\index\Controller;
use \think\Db;
use \think\Controller;
use \think\view;

class rank	extends Controller
{
//调用方法http://127.0.0.1/tp_5/public/index.php/index/enter/index
	public function index()
	{
		
		return $this->fetch('index');
		}
		
		
/*调用方法http://127.0.0.1/tp_5/public/index.php/index/enter/index	*/
/*----功能:对企业进行评级计算----*/
	public function rank($enter_name="",$enter_id="",$year="")
	{
/* 			$enter_name=$_POST['vo.ENTER_CITY'];      //获取企业名称
			$enter_id=$_POST['vo.ENTER_ID'];
			$year=$_POST['vo.RES_YEAR']; */
			$info=Db::table('ENTER_BASIC_INFO')        //查询企业基础信息表是否存在企业信息
						->where('ENTER_NAME',$enter_name)						
						->find();

			$policy=Db::table('BASE_POLICY')            //查询企业保单信息表是否存在企业保单
						->where('ENTER_NAME',$enter_name)
						->select();
			
			//$info=Db::tabletest($enter_name)('ENTER_BASIC_INFO')->where('ENTER_NAME','like','%'.$enter_name.'%')->find();   //查询企业基础信息表是否存在企业信息
			//$enter_name=$info['ENTER_NAME'];            //获取企业名称
            //print_r($policy);
			if(empty($info)){			                //如果企业基础信息表不存在企业信息，跳转回首页
			        print_r($info);
					echo "<script>alert('您输入的企业不存在，请核实后再查询！')</script>" ;
					return $this->fetch('index');
					}

			else 	{
					//$year="2018";
					$res=Db::table('ENTER_RESULTS')             //查询企业评级信息表中是否存在评级记录
					        ->where('ENTER_NAME',$enter_name)
					        ->where('RES_YEAR',$year)
					        ->find();
					if(empty($res)){	                            //如果企业评级表中部不存在记录，对评级项进行计算赋值
							$this->assign('flag','rank_insert');   //判别提交按钮为新插入记录
							$this->assign('year',$year);
                            $this->assign('old_score',0);
							$this->assign('enter_city',$info['ENTER_CITY']);
							$this->assign('enter_county',$info['ENTER_COUNTY']);
							$this->assign('enter_id',$info['ENTER_ID']);
							$this->assign('enter_name',$info['ENTER_NAME']);
                            $this->assign('enter_zhuangtai',$res['ENTER_ZHUANGTAI']);
							$this->assign('enter_leixing',$info['ENTER_LEIXING']);	
						
                            $this->assign('res_bfgm_old','无历史记录');    //原保费规模
  						    $this->assign('res_bfgm',$bf=sprintf('%.2f',$this->bfgm($enter_name,$year)/0.45/10000));  //获取保费规模
                            $this->assign('rank_res_bfgm',$bfgm=$this->rank_res_bfgm($bf));  //获取保费评分                            
							
                            $this->assign('res_cbrs_old','无历史记录');   //原参保人数
							$this->assign('res_cbrs',$this->cbrs($enter_name,$year));   //获取参保人数
                            $this->assign('rank_res_cbrs',$cbrs=$this->rank_res_cbrs($this->cbrs($enter_name,$year)));  //获取参保人数评分
							
                            $this->assign('res_xbsx_old','无历史记录');  //原续保时效
							$this->assign('res_xbsx',$this->xbsx($enter_name,$year));                  //获取续保时效
						    $this->assign('rank_res_xbsx',$xbsx=$this->rank_res_xbsx($this->xbsx($enter_name,$year)));   //续保时效评分
                            
                            $this->assign('res_xbrs_old','无历史记录');   //原续保人数占比
							$this->assign('res_xbrs',$this->xbrs($enter_name,$year));		           //获取续保人数占比
                            $this->assign('rank_res_xbrs',$xbrs=$this->rank_res_xbrs($this->xbrs($enter_name,$year)));  //续保人数占比评分
                            
                            $this->assign('res_lxxb_old','无历史记录');    //原连续续保年数   
                            $this->assign('res_lxxb',$this->lxxb($enter_name,$year));                      //获取连续续保年数
                            $this->assign('rank_res_lxxb',$lxxb=$this->rank_res_lxxb($this->lxxb($enter_name,$year)));  //连续续保年数评分
							                        
                            $this->assign('res_jmpc_old','无历史记录');   //原见面频次数
                            $this->assign('res_jmpc',$this->jmpc());                //获取见面频次数
                            $this->assign('rank_res_jmpc',$jmpc=$this->rank_res_jmpc($this->jmpc()));     //见面频次数评分
                        
                            $this->assign('res_zwcd_old','无历史记录');  //原客户信息掌握度
                            $this->assign('res_zwcd',$this->zwcd());                    //获取客户信息掌握程度
                            $this->assign('rank_res_zwcd',$zwcd=$this->rank_res_zwcd($this->zwcd()));         //客户信息掌握度评分
                        
                            $this->assign('res_djxq_old','无历史记录');  //原洞见服务需求
                            $this->assign('res_djxq',$this->djxq());                //获取洞见服务需求
                            $this->assign('rank_res_djxq',$djxq=$this->rank_res_djxq($this->djxq()));     //洞见服务需求评分
                        
                            $this->assign('res_khzj_old','无历史记录');  //原客户转介绍数
                            $this->assign('res_khzj',$this->khzj());                //获取客户转介绍数
                            $this->assign('rank_res_khzj',$khzj=$this->rank_res_khzj($this->khzj()));     //客户转介绍数评分
                        
                            $this->assign('res_tbfa_old','无历史记录');  //原投保非安产品
                            $this->assign('res_tbfa',$this->tbfa());                //获取投保非安产品
                            $this->assign('rank_res_tbfa',$tbfa=$this->rank_res_tbfa($this->tbfa()));     //投保非安产品评分                       
                                                    
                            $this->assign('res_cbsx_old','无历史记录');  //原收集参保时效
                            $this->assign('res_cbsx',$this->cbsx($enter_name,$year));                //获取收集参保时效天数
                            $this->assign('rank_res_cbsx',$cbsx=$this->rank_res_cbsx($this->cbsx($enter_name,$year)));     //收集参保时效评分
                            
                            $this->assign('res_bqsx_old','无历史记录');  //原收集保全时效
                            $this->assign('res_bqsx',$this->bqsx($enter_name,$year));                //获取收集保全时效天数
                            $this->assign('rank_res_bqsx',$bqsx=$this->rank_res_bqsx($this->bqsx($enter_name,$year)));     //收集保全时效评分
                            
                            $this->assign('res_swlp_old','无历史记录');  //原收集死亡理赔资料时效
                            $this->assign('res_swlp',$this->sjlp($enter_name,$year,$type=3));                //获取收集死亡理赔资料天数
                            $this->assign('rank_res_swlp',$swlp=$this->rank_res_sjlp($this->sjlp($enter_name,$year,$type=3)));     //收集收集死亡理赔资料评分

                            $this->assign('res_sclp_old','无历史记录');  //原收集伤残理赔资料时效
                            $this->assign('res_sclp',$this->sjlp($enter_name,$year,$type=2));                //获取收集伤残理赔资料天数
                            $this->assign('rank_res_sclp',$sclp=$this->rank_res_sjlp($this->sjlp($enter_name,$year,$type=2)));     //收集伤残理赔资料评分

                            $this->assign('res_yllp_old','无历史记录');  //原收集医疗理赔资料时效
                            $this->assign('res_yllp',$this->sjlp($enter_name,$year,$type=3));                //获取收集医疗理赔资料天数
                            $this->assign('rank_res_yllp',$yllp=$this->rank_res_sjlp($this->sjlp($enter_name,$year,$type=3)));     //收集医疗理赔资料时效评分
                        
                            $this->assign('res_gahd_old','无历史记录');  //原关爱活动时效
                            $this->assign('res_gahd',$this->gahd($enter_name,$year));                //获取关爱活动时效天数
                            $this->assign('rank_res_gahd',$gahd=$this->rank_res_gahd($this->gahd($enter_name,$year)));     //关爱活动时效天数评分

                            $this->assign('res_lpxc_old','无历史记录');  //原重大理赔宣传时效
                            $this->assign('res_lpxc',$this->lpxc());              //获取重大理赔宣传时效天数
                            $this->assign('rank_res_lpxc',$lpxc=$this->rank_res_lpxc($this->lpxc()));     //重大理赔宣传时效天数评分
  
                            $this->assign('res_cbxy_old','无历史记录');  //原参保相应时效
                            $this->assign('res_cbxy',$this->cbxy());                //获取重参保相应时效天数
                            $this->assign('rank_res_cbxy',$cbxy=$this->rank_res_cbxy($this->cbxy()));     //参保相应时效天数评分

                            $rank_sum=($bfgm+$cbrs+$xbsx+$xbrs+$lxxb+$jmpc+$zwcd+$djxq+$khzj+$tbfa+$cbsx+$bqsx+$swlp+$sclp+$yllp+$gahd+$lpxc+$cbxy);
                            $this->assign('rank_sum',$rank_sum);
                            $this->assign('rank_leven',$this->rank_leven($rank_sum));
                            return $this->fetch('rank');  
							}
					else	{     //如果企业评级表中部存在记录，对评级项进行重新计算赋值
					       
							$this->assign('flag','rank_update');    //判别提交按钮为更新记录
                            $this->assign('year',$year);
                            $this->assign('old_score',$res['RES_SCORE']);
                        
							$this->assign('enter_city',$res['ENTER_CITY']);
							$this->assign('enter_county',$res['ENTER_COUNTY']);
							$this->assign('enter_id',$res['ENTER_ID']);
							$this->assign('enter_name',$res['ENTER_NAME']);
                            //$this->assign('enter_zhuangtai',$res['ENTER_ZHUANGTAI']);
							$this->assign('enter_leixing',$res['ENTER_LEIXING']);	
						
                            $this->assign('res_bfgm_old',$res['RES_BFGM']);    //原保费规模
  						    $this->assign('res_bfgm',$bf=sprintf('%.2f',$this->bfgm($enter_name,$year)/0.45/10000));  //获取保费规模
                            $this->assign('rank_res_bfgm',$bfgm=$this->rank_res_bfgm($bf));  //获取保费评分                            
							
                            $this->assign('res_cbrs_old',$res['RES_CBRS']);   //原参保人数
							$this->assign('res_cbrs',$this->cbrs($enter_name,$year));   //获取参保人数
                            $this->assign('rank_res_cbrs',$cbrs=$this->rank_res_cbrs($this->cbrs($enter_name,$year)));  //获取参保人数评分
							
                            $this->assign('res_xbsx_old',$res['RES_XBSX']);  //原续保时效
							$this->assign('res_xbsx',$this->xbsx($enter_name,$year));                  //获取续保时效
						    $this->assign('rank_res_xbsx',$xbsx=$this->rank_res_xbsx($this->xbsx($enter_name,$year)));   //续保时效评分
                            
                            $this->assign('res_xbrs_old',$res['RES_XBRS']);   //原续保人数占比
							$this->assign('res_xbrs',$this->xbrs($enter_name,$year));		           //获取续保人数占比
                            $this->assign('rank_res_xbrs',$xbrs=$this->rank_res_xbrs($this->xbrs($enter_name,$year)));  //续保人数占比评分
                            
                            $this->assign('res_lxxb_old',$res['RES_LXXB']);    //原连续续保年数   
                            $this->assign('res_lxxb',$this->lxxb($enter_name,$year));                      //获取连续续保年数
                            $this->assign('rank_res_lxxb',$lxxb=$this->rank_res_lxxb($this->lxxb($enter_name,$year)));  //连续续保年数评分
							                        
                            $this->assign('res_jmpc_old',$res['RES_JMPC']);   //原见面频次数
                            $this->assign('res_jmpc',$this->jmpc());                //获取见面频次数
                            $this->assign('rank_res_jmpc',$jmpc=$this->rank_res_jmpc($this->jmpc()));     //见面频次数评分
                        
                            $this->assign('res_zwcd_old',$res['RES_ZWCD']);  //原客户信息掌握度
                            $this->assign('res_zwcd',$this->zwcd());                    //获取客户信息掌握程度
                            $this->assign('rank_res_zwcd',$zwcd=$this->rank_res_zwcd($this->zwcd()));         //客户信息掌握度评分
                        
                            $this->assign('res_djxq_old',$res['RES_DJXQ']);  //原洞见服务需求
                            $this->assign('res_djxq',$this->djxq());                //获取洞见服务需求
                            $this->assign('rank_res_djxq',$djxq=$this->rank_res_djxq($this->djxq()));     //洞见服务需求评分
                        
                            $this->assign('res_khzj_old',$res['RES_KHZJ']);  //原客户转介绍数
                            $this->assign('res_khzj',$this->khzj());                //获取客户转介绍数
                            $this->assign('rank_res_khzj',$khzj=$this->rank_res_khzj($this->khzj()));     //客户转介绍数评分
                        
                            $this->assign('res_tbfa_old',$res['RES_TBFA']);  //原投保非安产品
                            $this->assign('res_tbfa',$this->tbfa());                //获取投保非安产品
                            $this->assign('rank_res_tbfa',$tbfa=$this->rank_res_tbfa($this->tbfa()));     //投保非安产品评分                       
                        
                            
                            $this->assign('res_cbsx_old',$res['RES_CBSX']);  //原收集参保时效
                            $this->assign('res_cbsx',$this->cbsx($enter_name,$year));                //获取收集参保时效天数
                            $this->assign('rank_res_cbsx',$cbsx=$this->rank_res_cbsx($this->cbsx($enter_name,$year)));     //收集参保时效评分
                            
                            $this->assign('res_bqsx_old',$res['RES_BQSX']);  //原收集保全时效
                            $this->assign('res_bqsx',$this->bqsx($enter_name,$year));                //获取收集保全时效天数
                            $this->assign('rank_res_bqsx',$bqsx=$this->rank_res_bqsx($this->bqsx($enter_name,$year)));     //收集保全时效评分
                            
                            $this->assign('res_swlp_old',$res['RES_SWLP']);  //原收集死亡理赔资料时效
                            $this->assign('res_swlp',$this->sjlp($enter_name,$year,$type=3));                //获取收集死亡理赔资料天数
                            $this->assign('rank_res_swlp',$swlp=$this->rank_res_sjlp($this->sjlp($enter_name,$year,$type=3)));     //收集收集死亡理赔资料评分

                            $this->assign('res_sclp_old',$res['RES_SCLP']);  //原收集伤残理赔资料时效
                            $this->assign('res_sclp',$this->sjlp($enter_name,$year,$type=2));                //获取收集伤残理赔资料天数
                            $this->assign('rank_res_sclp',$sclp=$this->rank_res_sjlp($this->sjlp($enter_name,$year,$type=2)));     //收集伤残理赔资料评分

                            $this->assign('res_yllp_old',$res['RES_YLLP']);  //原收集医疗理赔资料时效
                            $this->assign('res_yllp',$this->sjlp($enter_name,$year,$type=3));                //获取收集医疗理赔资料天数
                            $this->assign('rank_res_yllp',$yllp=$this->rank_res_sjlp($this->sjlp($enter_name,$year,$type=3)));     //收集医疗理赔资料时效评分
                        
                            $this->assign('res_gahd_old',$res['RES_GAHD']);  //原关爱活动时效
                            $this->assign('res_gahd',$this->gahd($enter_name,$year));                //获取关爱活动时效天数
                            $this->assign('rank_res_gahd',$gahd=$this->rank_res_gahd($this->gahd($enter_name,$year)));     //关爱活动时效天数评分

                            $this->assign('res_lpxc_old',$res['RES_LPXC']);  //原重大理赔宣传时效
                            $this->assign('res_lpxc',$this->lpxc());              //获取重大理赔宣传时效天数
                            $this->assign('rank_res_lpxc',$lpxc=$this->rank_res_lpxc($this->lpxc()));     //重大理赔宣传时效天数评分
  
                            $this->assign('res_cbxy_old',$res['RES_CBXY']);  //原参保相应时效
                            $this->assign('res_cbxy',$this->cbxy());                //获取重参保相应时效天数
                            $this->assign('rank_res_cbxy',$cbxy=$this->rank_res_cbxy($this->cbxy()));     //参保相应时效天数评分

                            $rank_sum=($bfgm+$cbrs+$xbsx+$xbrs+$lxxb+$jmpc+$zwcd+$djxq+$khzj+$tbfa+$cbsx+$bqsx+$swlp+$sclp+$yllp+$gahd+$lpxc+$cbxy);
                            $this->assign('rank_sum',$rank_sum);
                            $this->assign('rank_leven',$this->rank_leven($rank_sum));
                            return $this->fetch('rank');    
					}
			
			}
	}

/*---------评级结果写入数据库-----------------------*/
    public function rank_insert()
    {
        $rank = $_POST;
       //print_r($_POST);
        $data = ['ENTER_ID' => $rank['enter_id'],
                'ENTER_NAME' => $rank['enter_name'],
                'ENTER_CITY' => $rank['enter_city'],
                'ENTER_COUNTY' => $rank['enter_county'],
                'ENTER_LEIXING' => $rank['enter_leixing'],
                'RES_YEAR' => $rank['year'],
                //'RES_LEVEL' => 'A',
                 
                'RES_BFGM' => $rank['res_bfgm'],       //保费规模
                'RES_BFGM_SCORE' => $bfgm=$this->rank_res_bfgm($rank['res_bfgm']),
                
                'RES_CBRS' => $rank['res_cbrs'],          //参保人数
                'RES_CBRS_SCORE' => $cbrs=$this->rank_res_cbrs($rank['res_cbrs']), 
                
                'RES_XBSX' => $rank['res_xbsx'],                  //续保时效
                'RES_XBSX_SCORE' => $xbsx=$this->rank_res_xbsx($rank['res_xbsx']),
                
                'RES_XBRS' => $rank['res_xbrs'],                  //续保人数占比
                'RES_XBRS_SCORE' => $xbrs=$this->rank_res_xbrs($rank['res_xbrs']),
                
                'RES_LXXB' => $rank['res_lxxb'],                  //续保连续
                'RES_LXXB_SCORE' => $lxxb=$this->rank_res_lxxb($rank['res_lxxb']),
                
                'RES_JMPC' => $rank['res_jmpc'],              //见面次数
                'RES_JMPC_SCORE' => $jmpc=$this->rank_res_jmpc($rank['res_jmpc']),
                
                'RES_ZWCD' => $rank['res_zwcd'],                  //客户掌握度
                'RES_ZWCD_SCORE' => $zwcd=$this->rank_res_zwcd($rank['res_zwcd']),   
                
                'RES_DJXQ' => $rank['res_djxq'],                  //洞见需求
                'RES_DJXQ_SCORE' => $djxq=$this->rank_res_djxq($rank['res_djxq']),
                
                'RES_KHZJ' => $rank['res_khzj'],          //客户转介绍
                'RES_KHZJ_SCORE' => $khzj=$this->rank_res_khzj($rank['res_khzj']),
                
                'RES_TBFA' => $rank['res_tbfa'],              //投保非安产品
                'RES_TBFA_SCORE' => $tbfa=$this->rank_res_tbfa($rank['res_tbfa']),
                
                'RES_CBSX' => $rank['res_cbsx'],                  //收集参保时效
                'RES_CBSX_SCORE' => $cbsx=$this->rank_res_cbsx($rank['res_cbsx']),
                
                'RES_BQSX' => $rank['res_bqsx'],                 //收集保全时效
                'RES_BQSX_SCORE' => $bqsx=$this->rank_res_bqsx($rank['res_bqsx']),
                
                'RES_SWLP' => $rank['res_swlp'],          //收集死亡理赔时效
                'RES_SWLP_SCORE' => $swlp=$this->rank_res_sjlp($rank['res_swlp']),
                
                'RES_SCLP' => $rank['res_sclp'],          //收集伤残理赔时效
                'RES_SCLP_SCORE' => $sclp=$this->rank_res_sjlp($rank['res_sclp']),
                
                'RES_YLLP' => $rank['res_yllp'],              //收集医疗理赔时效
                'RES_YLLP_SCORE' => $yllp=$this->rank_res_sjlp($rank['res_yllp']),
                 
                'RES_GAHD' => $rank['res_gahd'],              //关爱活动
                'RES_GAHD_SCORE' => $gahd=$this->rank_res_gahd($rank['res_gahd']),
                
                'RES_LPXC' => $rank['res_lpxc'],              //重大理赔宣传
                'RES_LPXC_SCORE' => $lpxc=$this->rank_res_lpxc($rank['res_lpxc']), 
                 
                'RES_CBXY' => $rank['res_cbxy'],        //参保响应
                'RES_CBXY_SCORE' => $cbxy=$this->rank_res_cbxy($rank['res_cbxy']),
                                   
                'RES_SCORE' => $rank_sum=($bfgm+$cbrs+$xbsx+$xbrs+$lxxb+$jmpc+$zwcd+$djxq+$khzj+$tbfa+$cbsx+$bqsx+$swlp+$sclp+$yllp+$gahd+$lpxc+$cbxy),                 //评级总分
                'RES_RANK' => $this->rank_leven($rank_sum)];            //评级等级
            
        
        
        //print_r($data);
        $res=Db::table('ENTER_RESULTS')->insert($data);
        if($res=="1"){
                    Db::table('ENTER_RES_RECORD')->insert($data);
                    echo "<script>alert('录入成功')</script>";
                    return $this->fetch('index');
        }
        else{
                    echo "<script>alert('录入失败，请联系管理员')</script>";
                    return $this->fetch('index');
        }

        
    } 
    
    /*---------更新企业评级结果写入数据库-----------------------*/
    public function rank_update()
    {
        $rank = $_POST;
        $enter_name=$rank['enter_name'];
        $year=$rank['year'];
       //print_r($_POST);
        $data = ['ENTER_ID' => $rank['enter_id'],              
                'ENTER_CITY' => $rank['enter_city'],
                'ENTER_COUNTY' => $rank['enter_county'],
                'RES_YEAR' => $rank['year'],
                //'RES_LEVEL' => 'A',
                 
                'RES_BFGM' => $rank['res_bfgm'],       //保费规模
                'RES_BFGM_SCORE' => $bfgm=$this->rank_res_bfgm($rank['res_bfgm']),
                
                'RES_CBRS' => $rank['res_cbrs'],          //参保人数
                'RES_CBRS_SCORE' => $cbrs=$this->rank_res_cbrs($rank['res_cbrs']), 
                
                'RES_XBSX' => $rank['res_xbsx'],                  //续保时效
                'RES_XBSX_SCORE' => $xbsx=$this->rank_res_xbsx($rank['res_xbsx']),
                
                'RES_XBRS' => $rank['res_xbrs'],                  //续保人数占比
                'RES_XBRS_SCORE' => $xbrs=$this->rank_res_xbrs($rank['res_xbrs']),
                
                'RES_LXXB' => $rank['res_lxxb'],                  //续保连续
                'RES_LXXB_SCORE' => $lxxb=$this->rank_res_lxxb($rank['res_lxxb']),
                
                'RES_JMPC' => $rank['res_jmpc'],              //见面次数
                'RES_JMPC_SCORE' => $jmpc=$this->rank_res_jmpc($rank['res_jmpc']),
                
                'RES_ZWCD' => $rank['res_zwcd'],                  //客户掌握度
                'RES_ZWCD_SCORE' => $zwcd=$this->rank_res_zwcd($rank['res_zwcd']),   
                
                'RES_DJXQ' => $rank['res_djxq'],                  //洞见需求
                'RES_DJXQ_SCORE' => $djxq=$this->rank_res_djxq($rank['res_djxq']),
                
                'RES_KHZJ' => $rank['res_khzj'],          //客户转介绍
                'RES_KHZJ_SCORE' => $khzj=$this->rank_res_khzj($rank['res_khzj']),
                
                'RES_TBFA' => $rank['res_tbfa'],              //投保非安产品
                'RES_TBFA_SCORE' => $tbfa=$this->rank_res_tbfa($rank['res_tbfa']),
                
                'RES_CBSX' => $rank['res_cbsx'],                  //收集参保时效
                'RES_CBSX_SCORE' => $cbsx=$this->rank_res_cbsx($rank['res_cbsx']),
                
                'RES_BQSX' => $rank['res_bqsx'],                 //收集保全时效
                'RES_BQSX_SCORE' => $bqsx=$this->rank_res_bqsx($rank['res_bqsx']),
                
                'RES_SWLP' => $rank['res_swlp'],          //收集死亡理赔时效
                'RES_SWLP_SCORE' => $swlp=$this->rank_res_sjlp($rank['res_swlp']),
                
                'RES_SCLP' => $rank['res_sclp'],          //收集伤残理赔时效
                'RES_SCLP_SCORE' => $sclp=$this->rank_res_sjlp($rank['res_sclp']),
                
                'RES_YLLP' => $rank['res_yllp'],              //收集医疗理赔时效
                'RES_YLLP_SCORE' => $yllp=$this->rank_res_sjlp($rank['res_yllp']),
                 
                'RES_GAHD' => $rank['res_gahd'],              //关爱活动
                'RES_GAHD_SCORE' => $gahd=$this->rank_res_gahd($rank['res_gahd']),
                
                'RES_LPXC' => $rank['res_lpxc'],              //重大理赔宣传
                'RES_LPXC_SCORE' => $lpxc=$this->rank_res_lpxc($rank['res_lpxc']), 
                 
                'RES_CBXY' => $rank['res_cbxy'],        //参保响应
                'RES_CBXY_SCORE' => $cbxy=$this->rank_res_cbxy($rank['res_cbxy']),
                                   
                'RES_SCORE' => $rank_sum=($bfgm+$cbrs+$xbsx+$xbrs+$lxxb+$jmpc+$zwcd+$djxq+$khzj+$tbfa+$cbsx+$bqsx+$swlp+$sclp+$yllp+$gahd+$lpxc+$cbxy),                 //评级总分
                'RES_RANK' => $this->rank_leven($rank_sum)];                 //评级等级
             
        //print_r($data);
        $res=Db::table('ENTER_RESULTS')
            ->where('ENTER_NAME',$enter_name)
            ->where('RES_YEAR',$year)
            ->update($data);
        if($res=="1"){
        $data1 = ['ENTER_ID' => $rank['enter_id'],
                'ENTER_NAME' => $rank['enter_name'],
                'ENTER_CITY' => $rank['enter_city'],
                'ENTER_COUNTY' => $rank['enter_county'],
                'ENTER_LEIXING' => $rank['enter_leixing'],
                'RES_YEAR' => $rank['year'],
                //'RES_LEVEL' => 'A',
                 
                'RES_BFGM' => $rank['res_bfgm'],       //保费规模
                'RES_BFGM_SCORE' => $bfgm=$this->rank_res_bfgm($rank['res_bfgm']),
                
                'RES_CBRS' => $rank['res_cbrs'],          //参保人数
                'RES_CBRS_SCORE' => $cbrs=$this->rank_res_cbrs($rank['res_cbrs']), 
                
                'RES_XBSX' => $rank['res_xbsx'],                  //续保时效
                'RES_XBSX_SCORE' => $xbsx=$this->rank_res_xbsx($rank['res_xbsx']),
                
                'RES_XBRS' => $rank['res_xbrs'],                  //续保人数占比
                'RES_XBRS_SCORE' => $xbrs=$this->rank_res_xbrs($rank['res_xbrs']),
                
                'RES_LXXB' => $rank['res_lxxb'],                  //续保连续
                'RES_LXXB_SCORE' => $lxxb=$this->rank_res_lxxb($rank['res_lxxb']),
                
                'RES_JMPC' => $rank['res_jmpc'],              //见面次数
                'RES_JMPC_SCORE' => $jmpc=$this->rank_res_jmpc($rank['res_jmpc']),
                
                'RES_ZWCD' => $rank['res_zwcd'],                  //客户掌握度
                'RES_ZWCD_SCORE' => $zwcd=$this->rank_res_zwcd($rank['res_zwcd']),   
                
                'RES_DJXQ' => $rank['res_djxq'],                  //洞见需求
                'RES_DJXQ_SCORE' => $djxq=$this->rank_res_djxq($rank['res_djxq']),
                
                'RES_KHZJ' => $rank['res_khzj'],          //客户转介绍
                'RES_KHZJ_SCORE' => $khzj=$this->rank_res_khzj($rank['res_khzj']),
                
                'RES_TBFA' => $rank['res_tbfa'],              //投保非安产品
                'RES_TBFA_SCORE' => $tbfa=$this->rank_res_tbfa($rank['res_tbfa']),
                
                'RES_CBSX' => $rank['res_cbsx'],                  //收集参保时效
                'RES_CBSX_SCORE' => $cbsx=$this->rank_res_cbsx($rank['res_cbsx']),
                
                'RES_BQSX' => $rank['res_bqsx'],                 //收集保全时效
                'RES_BQSX_SCORE' => $bqsx=$this->rank_res_bqsx($rank['res_bqsx']),
                
                'RES_SWLP' => $rank['res_swlp'],          //收集死亡理赔时效
                'RES_SWLP_SCORE' => $swlp=$this->rank_res_sjlp($rank['res_swlp']),
                
                'RES_SCLP' => $rank['res_sclp'],          //收集伤残理赔时效
                'RES_SCLP_SCORE' => $sclp=$this->rank_res_sjlp($rank['res_sclp']),
                
                'RES_YLLP' => $rank['res_yllp'],              //收集医疗理赔时效
                'RES_YLLP_SCORE' => $yllp=$this->rank_res_sjlp($rank['res_yllp']),
                 
                'RES_GAHD' => $rank['res_gahd'],              //关爱活动
                'RES_GAHD_SCORE' => $gahd=$this->rank_res_gahd($rank['res_gahd']),
                
                'RES_LPXC' => $rank['res_lpxc'],              //重大理赔宣传
                'RES_LPXC_SCORE' => $lpxc=$this->rank_res_lpxc($rank['res_lpxc']), 
                 
                'RES_CBXY' => $rank['res_cbxy'],        //参保响应
                'RES_CBXY_SCORE' => $cbxy=$this->rank_res_cbxy($rank['res_cbxy']),
                                   
                'RES_SCORE' => $rank_sum=($bfgm+$cbrs+$xbsx+$xbrs+$lxxb+$jmpc+$zwcd+$djxq+$khzj+$tbfa+$cbsx+$bqsx+$swlp+$sclp+$yllp+$gahd+$lpxc+$cbxy),                 //评级总分
                'RES_RANK' => $this->rank_leven($rank_sum)];                 //评级等级
        
        Db::table('ENTER_RES_RECORD')->insert($data1);
        echo "<script>alert('修改成功')</script>";
				return $this->fetch('index');	 
        }
        else{
        echo "<script>alert('系统错误'.$res.'，请联系管理员')</script>";
        				return $this->fetch('index');
        }
    }    
    
/*------获取企业当年保费金额---------*/	
	public function bfgm($enter_name,$year)
	{
			     //获取企业名称
			$info=Db::table('BASE_POLICY')
						->field('SUM(PREMIUM) as PREMIUM')
						->where('ENTER_NAME',$enter_name)
						->where('POLICY_PAY_DATE','LIKE','%'.$year.'%')
						#->where('INSURANCE_TYPE','1')        //状态1为主保单
						->select();
			if(empty($info)){			
				return 0;
				}
			else{
                $premium=$info[0]['PREMIUM'];
                return $premium;
			}
	}
    
/*------企业当年保费评分---------*/    
    public function rank_res_bfgm($n)
    {

        if($n<"5"){
            return "2";    
        }
        if($n>="5" and $n<"10"){
            return "4";
        }
        if($n>="10" and $n<"20"){
            return "5"; 
        }
        if($n>="20"){
            return "6"; 
        }
    }
		
		
/*-------获取企业当年参保人数-------*/
	public function cbrs($enter_name,$year)
	{
			$info=Db::table('BASE_POLICY')
					->field('SUM(POLICY_PR) as 	CBRS')
					->where('ENTER_NAME',$enter_name)
					->where('POLICY_PAY_DATE','LIKE','%'.$year.'%')
					->where('PREMIUM','>','0')
					->select();
			if(empty($info)){			
				return "0";
				}
			else{			
				$cbrs=$info[0]['CBRS'];
				return $cbrs/2;
			}

		}

/*------企业当年参保人数评分---------*/ 
    public function rank_res_cbrs($n)
    {
        if($n<"50"){
            return "2";    
        }
        if($n>="50" and $n<"200"){
            return "4";
        }
        if($n>="200" and $n<"500"){
            return "5"; 
        }
        if($n>="500"){
            return "6"; 
        }   
        
    }

/*-------获取企业续保时效-------*/
	public function xbsx($enter_name,$year)
	{
        //$year='2018';
        $year=$year-1;
        //$enter_name='昆明市东川银光铝材有限公司';
		$old=Db::table('BASE_POLICY')
					//->field('POLICY_BEGIN_DATE')
					->where('ENTER_NAME',$enter_name)
					//->where('POLICY_BEGIN_DATE','LIKE','%'.$year.'%')
					->where('POLICY_BEGIN_DATE','LIKE','%'.$year.'%')
					->where('INSURANCE_TYPE','1')
					//->whereOr('INSURANCE_TYPE','0')
					->where('FINANCIAL_CODE','EA47')
					->select();
        if(empty($old)){			
				return "365";   // 无上一年度的承保记录评分结果为0分
				}
        else{
            $policy_end=$old[0]['POLICY_END_DATE'];
            $new=Db::table('BASE_POLICY')
					//->field('POLICY_BEGIN_DATE')
					->where('ENTER_NAME',$enter_name)
					//->where('POLICY_BEGIN_DATE','LIKE','%'.$year.'%')
					->where('POLICY_BEGIN_DATE','>=',$policy_end)
					->where('INSURANCE_TYPE','1')
					//->whereOr('INSURANCE_TYPE','0')
					->where('FINANCIAL_CODE','EA47')
					->select();      
                if(empty($new)){			
				        return "365";
				        }
			     else{			
				        //print_r($old[0]['POLICY_END_DATE']);
                        //echo '<br>';
                        //print_r($new[0]['POLICY_SING_DATE']);
				        //echo '<br>'; //return $cbrs/2;
                        $d=(strtotime($new[0]['POLICY_SING_DATE'])-strtotime($old[0]['POLICY_END_DATE']))/3600/24; 
                        return $d;
			         }
			}	
		//SELECT * FROM `BASE_POLICY` WHERE ENTER_NAME='昆明和安矿业有限公司' AND POLICY_BEGIN_DATE LIKE '%2018%' AND INSURANCE_TYPE='1'
	}
/*------企业续保时效评分---------*/ 
    public function rank_res_xbsx($n)
    {
        if($n<="3"){
            return "7";    
        }
        if($n>="4" and $n<="30"){
            return "5";
        }
        if($n>="31" and $n<="60"){
            return "4"; 
        }
        if($n>="61" and $n<="90"){
            return "2"; 
        }  
        if($n>="91"){
            return "0"; 
        } 
        
    }
  
/*-------获取计算续保人数占比-------*/	

	public function xbrs($enter_name,$year)
	{
        //$year='2018';
        $old_year=$year-1;
        //$enter_name='个旧市皓天建材有限责任公司';
		$old=Db::table('BASE_POLICY')
					->field('SUM(POLICY_PR) as 	CBRS')
					->where('ENTER_NAME',$enter_name)
					//->where('POLICY_BEGIN_DATE','LIKE','%'.$year.'%')
					->where('POLICY_PAY_DATE','LIKE','%'.$old_year.'%')
					->where('PREMIUM','>','0')
					//->whereOr('INSURANCE_TYPE','0')
					->where('FINANCIAL_CODE','EA47')
					->select();
        if(empty($old[0]['CBRS'])){			
				return "0";   // 无上一年度续保人数占比为0
				}
        else{
        $new=Db::table('BASE_POLICY')
					->field('SUM(POLICY_PR) as 	CBRS')
					->where('ENTER_NAME',$enter_name)
					//->where('POLICY_BEGIN_DATE','LIKE','%'.$year.'%')
					->where('POLICY_BEGIN_DATE','LIKE','%'.$year.'%')
					->where('PREMIUM','>','0')
					//->whereOr('INSURANCE_TYPE','0')
					->where('FINANCIAL_CODE','EA47')
					->select();     
                if(empty($new[0]['CBRS'])){			
				        return "0";     //// 无上今年续保人数占比为0
				        } 
			     else{	
                        //echo '上一年<br>';		
				        //print_r($old[0]['CBRS']);
                        //echo '<br>今年<br>';
                        //print_r($new[0]['CBRS']);
				        //echo '<br>'; //return $cbrs/2;
                        $x=($new[0]['CBRS']/$old[0]['CBRS']); 
                        return sprintf('%.2f',$x);        
			         }
			}	
		//SELECT * FROM `BASE_POLICY` WHERE ENTER_NAME='昆明和安矿业有限公司' AND POLICY_BEGIN_DATE LIKE '%2018%' AND INSURANCE_TYPE='1'
	}    
    
/*------企业续保人数占比评分---------*/ 
    public function rank_res_xbrs($n)
    {
        if($n>"0.8"){
            return "6";    
        }
        if($n<="0.8" and $n>"0.6"){
            return "5";
        }
        if($n<="0.6" and $n>"0.5"){
            return "4"; 
        }
        if($n<="0.5"){
            return "2"; 
       
        } 
        
    }    
    
/*-------/获取计算连续续保年数-------*/	

	public function lxxb($enter_name="",$year="")
	{
        //$year='2018';
        //$year=$year+1;
        //$x=0;
        //$enter_name='昆明华腾兴矿业有限公司';
        for($i=0;$i<=4;$i++){
            //$x++;
            
            $t=Db::table('BASE_POLICY')
					//->field('SUM(POLICY_PR) as 	CBRS')
					->where('ENTER_NAME',$enter_name)
					//->where('POLICY_BEGIN_DATE','LIKE','%'.$year.'%')
					->where('POLICY_BEGIN_DATE','LIKE','%'.$year.'%')
					//->where('PREMIUM','>','0')
					->where('INSURANCE_TYPE','1')
					//->where('FINANCIAL_CODE','EA47')
					->select(); 
             if(!empty($t)){
                 $year--;
                 //$x++;
             }
             else{
                 break;
             }
        }
        //echo $i;
        //echo "<br>";
        //echo $year;
        //echo "<br>";
        return $i;

    }
/*------企业连续续保年数评分-------*/	
    public function rank_res_lxxb($n)
    {
        switch($n){
            case 0:
            return "2";
            break;       
            
            case 1:
            return "2";
            break; 
                
            case 2:
            return "3";
            break;
            
            case 3:
            return "5";
            break;
                
            default:
            return "7";
            break;
        }
    } 
    
/*-------获取见面频次----预估值2----*/
    public function jmpc()
    {
      return 2;        
    } 
        
/*------企业见面频次评分------*/
    public function  rank_res_jmpc($n)
    {
        switch($n){
            case 0:
            return 0;
            break; 
                
            case 1:
            return 2;
            break;       
            
            case 2:
            return 4;
            break; 
                
            case 3:
            return 5;
            break;
            
            case 4:
            return 5;
            break;
                
            default:
            return 6;
            break;

            }
    }
    
    
/*-------获取客户掌握程度----预估值1----*/
    public function zwcd()
    {
      return 1;        
    } 

/*------企业客户掌握度评分------*/
    public function  rank_res_zwcd($n)
    {
        switch($n){
            case 1:
            return 2;
            break; 
                
            case 2:
            return 5;
            break;       
            
            case 3:
            return 6;
            break; 
                
            case 4:
            return 7;
            break;
                
            default:
            return 0;
            break;

            }
    }  

/*-------获取洞见服务需求----预估值1----*/
    public function djxq()
    {
      return 1;        
    } 

/*------企业洞见服务需求评分------*/
    public function  rank_res_djxq($n)
    {
        switch($n){
            case 0:
            return 0;
            break; 
                
            case 1:
            return 2;
            break;       
            
            case 2:
            return 4;
            break; 
                
            case 3:
            return 5;
            break;
            
            case 4:
            return 6;
            break;
                
            default:
            return 0;
            break;

            }
    } 
 /*-------获取客户转介绍数----预估值0----*/
    public function khzj()
    {
      return 0;        
    } 

/*------企业客户转介绍数评分------*/
    public function  rank_res_khzj($n)
    {
        switch($n){
            case 0:
            return 3;
            break; 
                
            case 1:
            return 5;
            break;       
            
            case 2:
            return 6;
            break; 
                
            case 3:
            return 7;
            break;
                
            default:
            return 0;
            break;

            }
    }  
 /*-------获取投保非安产品-----预估值1---*/
    public function tbfa()
    {
      return 1;        
    } 

/*------企业投保非安产品评分------*/
    public function  rank_res_tbfa($n)
    {
        switch($n){
            case 1:
            return 2;
            break; 
                
            case 2:
            return 5;
            break;       
            
            case 3:
            return 6;
            break; 
                
            case 4:
            return 7;
            break;
                
            default:
            return 0;
            break;

            }
    } 
    
 /*-------获取企业参保时效-------*/	

	public function cbsx($enter_name="",$year="")
	{
		//$year=2018;
        $info=Db::table('BASE_POLICY')
					//->field('SUM(POLICY_PR) as 	CBRS')
					->where('ENTER_NAME',$enter_name)
					//->where('POLICY_BEGIN_DATE','LIKE','%'.$year.'%')
					->where('POLICY_BEGIN_DATE','LIKE','%'.$year.'%')
					->where('INSURANCE_TYPE','1')
					//->whereOr('INSURANCE_TYPE','0')
					->where('FINANCIAL_CODE','EA47')
					->select();
		if(empty($info)){			
				return 365;
				}
			else{			
				//print_r($info[0]['POLICY_SING_DATE']);
                //echo '<br>';
                //print_r($info[0]['POLICY_PAY_DATE']);
                $d=(strtotime($info[0]['POLICY_PAY_DATE'])-strtotime($info[0]['POLICY_SING_DATE']))/3600/24; 
				//echo '<br>';
                return $d;
               
			}
    } 
/*------企业参保时效评分---------*/ 
    public function rank_res_cbsx($n)
    {
        if($n<=9){
            return 4;    
        }elseif($n<=10){
            return 3;
        }elseif($n<=15 and $n>10){
            return 2; 
        }elseif($n<=30 and $n>15){
            return 1; 
        }elseif($n>=31){
            return 0; 
        }else{
            return 0;
        } 
        
    }
    
/*-------收集保全资料时效-------*/	

	public function bqsx($enter_name="",$year="")
	{
		//$enter_name="云南建投矿业工程有限公司云锡工程项目部";
        //$year=2018;
        $sign=0;
        $apply=0;
        $n=Db::table('BASE_BAOQUAN')
					->where('ENTER_NAME',$enter_name)
					->where('SIGN_DATE','LIKE','%'.$year.'%')
					->count();
		if(empty($n)){			
				return 0;
        }
			else{
                $info=Db::table('BASE_BAOQUAN')
				->where('ENTER_NAME',$enter_name)
				->where('SIGN_DATE','LIKE','%'.$year.'%')
                ->select();
            }
		for($i=0;$i<$n;$i++){
            $apply=$apply+strtotime($info[$i]['APPLY_DATE']);
            $sign=$sign+strtotime($info[$i]['SIGN_DATE']);
        }
        //print_r($n);
        //echo "<br>";
        //print_r($info[$n-1]['APPLY_DATE']);
        //echo "<br>";
        //print_r($info[$n-1]['SIGN_DATE']);
        //echo "<br>";
        //print_r($apply);
        //echo "<br>";
        //print_r($sign);
        //echo "<br>";
        $x=round(($sign-$apply)/3600/24/$n);
        return $x;
	}

/*------企业收集保全资料时效评分---------*/ 
    public function rank_res_bqsx($n)
    {
        if($n<=2){
            return 4;    
        }elseif($n<=3){
            return 3;
        }elseif($n<=5 and $n>=4){
            return 2; 
        }elseif($n<=6 and $n>=10){
            return 1; 
        }elseif($n>=11){
            return 0; 
        }else{
            return 0;
        } 
        
    }
/*-------收集理赔资料时效-------*/	

	public function sjlp($enter_name="",$year="",$type="")   //type1医疗2伤残3死亡
	{
		//$enter_name="昆明风景矿业有限公司";
        //$year=2018;
        //$type=3;
        $sign=0;
        $apply=0;
        $n=Db::table('BASE_LIPEI')
					//->field('SUM(POLICY_PR) as 	CBRS')
					->where('ENTER_NAME',$enter_name)
					//->where('POLICY_BEGIN_DATE','LIKE','%'.$year.'%')
					->where('SIGN_DATE','LIKE','%'.$year.'%')
					->where('LP_TYPE',$type)
					//->whereOr('INSURANCE_TYPE','0')
					//->where('FINANCIAL_CODE','EA47')
					->count();
		if(empty($n)){			
				return 0;
        }
			else{
                $info=Db::table('BASE_LIPEI')
				->where('ENTER_NAME',$enter_name)
				->where('SIGN_DATE','LIKE','%'.$year.'%')
                ->where('LP_TYPE',$type)
                ->select();
            }
			//print_r($n);
		for($i=0;$i<$n;$i++){
            $apply=$apply+strtotime($info[$i]['APPLY_DATE']);
            $sign=$sign+strtotime($info[$i]['SIGN_DATE']);
        }
        //echo $type."<br>";
        //print_r($n);
        //echo "<br>";
        //print_r($info[$n-1]['APPLY_DATE']);
        //echo "<br>";
        //print_r($info[$n-1]['SIGN_DATE']);
        //echo "<br>";
        //print_r($apply);
        //echo "<br>";
        //print_r($sign);
        //echo "<br>";
        $x=round(($sign-$apply)/3600/24/$n);
        return $x;
    }
/*------企业收集理赔资料时效评分---------*/ 
    public function rank_res_sjlp($n)
    {
        if($n<=20){
            return 4;    
        }elseif($n<=45 and $n>=21){
            return 3;
        }elseif($n<=55 and $n>=46){
            return 2; 
        }elseif($n<=85 and $n>=56){
            return 1; 
        }elseif($n>=85){
            return 0; 
        }else{
            return 0;
        } 
        
    }

/*-------获取关爱活动时效----预估值5----*/
    public function gahd()
    {
      return 5;        
    } 

/*------企业关爱活动时效评分------*/
    public function  rank_res_gahd($n)
    {
        if($n<=5){
            return 4;    
        }elseif($n<=10 and $n>=6){
            return 3;
        }elseif($n<=15 and $n>=11){
            return 2; 
        }elseif($n<=20 and $n>=16){
            return 1; 
        }elseif($n>=21){
            return 0; 
        }else{
            return 0;
        } 
        
    } 
/*-------获取重大理赔宣传时效----预估值5----*/
    public function lpxc()
    {
      return 5;        
    } 

/*------企业重大理赔宣传时效评分------*/
    public function  rank_res_lpxc($n)
    {
        if($n<=5){
            return 4;    
        }elseif($n<=10 and $n>=6){
            return 3;
        }elseif($n<=15 and $n>=11){
            return 2; 
        }elseif($n<=20 and $n>=16){
            return 1; 
        }elseif($n>=21){
            return 0; 
        }else{
            return 0;
        } 
        
    } 
/*-------获取参保相应时效-----预估值3---*/
    public function cbxy()
    {
      return 3;        
    } 

/*------企业参保相应时效评分------*/
    public function  rank_res_cbxy($n)
    {
        switch($n){
            case 1:
            return 7;
            break; 
                
            case 2:
            return 6;
            break;       
            
            case 3:
            return 5;
            break; 
                
            case 4:
            return 2;
            break;
                
            default:
            return 0;
            break;

            }
    }  

/*------评级等级结果----------*/
    public function rank_leven($n)
    {
        if($n>="90"){
            return "甲A";    
        }
        if($n<"90" and $n>="85"){
            return "甲B";
        }
        if($n<"85" and $n>="80"){
            return "甲C"; 
        }
        if($n<"80" and $n>="70"){
            return "乙A"; 
       
        }  
        if($n<"70" and $n>="65"){
            return "乙B"; 
       
        }   
        if($n<"65" and $n>="60"){
            return "乙C"; 
       
        }   
        if($n<"60" and $n>="50"){
            return "丙A"; 
       
        }   
        if($n<"50" and $n>="40"){
            return "丙B"; 
       
        }
        if($n<"40" and $n>="30"){
            return "丙C"; 
       
        }   
        if($n<"30" and $n>="25"){
            return "丁A"; 
       
        }   
        if($n<"25" and $n>="20"){
            return "丁B"; 
       
        }   
        if($n<"20"){
            return "丁C"; 
       
        }   
        
    }

	
	/*----------企业评级明细数据查询页面------------*/
	public function pjsjcx($enter_city="",$enter_county="",$enter_leixing="",$enter_id="",$enter_name="",$year="")
    {
        #$this -> assign()$year"2019";
        $this -> assign('year',$year);
		$this -> assign('enter_city',$enter_city);
		$this -> assign('enter_county',$enter_county);
		$this -> assign('enter_leixing',$enter_leixing);
		$this -> assign('enter_id',$enter_id);
		$this -> assign('enter_name',$enter_name);

		$year==""?"":$map['RES_YEAR'] = $year;
		$enter_city==""?"":$map['ENTER_CITY'] = $enter_city;
		$enter_county==""?"":$map['ENTER_COUNTY'] = $enter_county;
		$enter_leixing==""?"":$map['ENTER_LEIXING'] = $enter_leixing;
		$enter_id==""?"":$map['ENTER_ID'] = $enter_id;
		$enter_name==""?"":$map['ENTER_NAME'] = $enter_name;
		if(empty($map))        //如果输入的查询条件判定为无，输出全部数据作为查询结果
			{
/*			$list = Db::table('ENTER_RESULTS')
						->select(); */
			$list='';
			$this -> assign('list',$list);
			
			
	    	return $this->fetch('pjsjcx');
			}
		else{  
		
		//$info=Db::table('ENTER_BASIC_INFO')->where($map)->count();
    		$list = Db::table('ENTER_RESULTS')
						->where($map)
						->select();
						//->paginate($info); 
					if(empty($list))     //如果数据库查询结果为空，提示用户并显示所有数据为查询结果
						{
							//$info=Db::table('ENTER_BASIC_INFO')->count();
    						//$list = Db::table('ENTER_BASIC_INFO')->paginate($info);    
							//$this -> assign('list',$list);
							$this -> assign('list',$list);
							//$this -> assign('enter_city',$enter_city);
							//$this -> assign('enter_county',$enter_county);
							//$this -> assign('enter_leixing',$enter_leixing);
							//$this -> assign('enter_id',$enter_id);
							//$this -> assign('enter_name',$enter_name);
							echo "<script>alert('没有符合条件的单位信息')</script>";
	    					return $this->fetch('pjsjcx');
						}
					else{            //如果查询到结果，在列表显示，并保留筛选条件
					
					$this -> assign('list',$list);
					//$this -> assign('enter_city',$enter_city);
					//$this -> assign('enter_county',$enter_county);
					//$this -> assign('enter_leixing',$enter_leixing);
					//$this -> assign('enter_id',$enter_id);
					//$this -> assign('enter_name',$enter_name);
					
	   				return $this->fetch('pjsjcx');
						}
			}
	
	}


	/*----------/企业基础数据导出------------*/
	
	
	
	public function pjsjdc()
	{			
		$enter = $_POST;		
		$csv=new \think\csv\Csv();  //调用数据生成的类文件


		$enter['enter_city']==""?"":$map['ENTER_CITY'] = $enter['enter_city'];
		$enter['enter_county']==""?"":$map['ENTER_COUNTY'] = $enter['enter_county'];
		$enter['enter_leixing']==""?"":$map['ENTER_LEIXING'] = $enter['enter_leixing'];
		$enter['enter_id']==""?"":$map['ENTER_ID'] = $enter['enter_id'];
		$enter['enter_name']==""?"":$map['ENTER_NAME'] = $enter['enter_name'];
		if(empty($map)){        //如果输入的查询条件判定为无，输出全部数据作为查询结果
				$list=Db::table('ENTER_RESULTS')
                    ->field('ENTER_CITY,ENTER_COUNTY,ENTER_LEIXING,ENTER_NAME,RES_BFGM,RES_BFGM_SCORE,RES_CBRS,RES_CBRS_SCORE,RES_XBSX,RES_XBSX_SCORE,RES_XBRS,RES_XBRS_SCORE,RES_LXXB,RES_LXXB_SCORE,RES_JMPC,RES_JMPC_SCORE,RES_ZWCD,RES_ZWCD_SCORE,RES_DJXQ,RES_DJXQ_SCORE,RES_KHZJ,RES_KHZJ_SCORE,RES_TBFA,RES_TBFA_SCORE,RES_CBSX,RES_CBSX_SCORE,RES_BQSX,RES_BQSX_SCORE,RES_SWLP,RES_SWLP_SCORE,RES_SCLP,RES_SCLP_SCORE,RES_YLLP,RES_YLLP_SCORE,RES_GAHD,RES_GAHD_SCORE,RES_LPXC,RES_LPXC_SCORE,RES_CBXY,RES_CBXY_SCORE,RES_SCORE,RES_RANK')  
				    ->select();       //查询数据，可以进行处理
				$csv_title=array('机构','县区','企业类型','单位名称','保费规模','保费规模评分','参保人数','参保人数评分','续保时效','续保时效评分','续保人数占比','续保人数占比评分','续保连续','续保连续评分','面访次数','面访次数评分','客户掌握度','客户掌握度评分','洞见需求','洞见需求评分','客户转介绍','客户转介绍评分','投保非安','投保非安评分','收集参保天数','收集参保评分','收集保全天数','收集保全评分','死亡理赔时效','死亡理赔评分','伤残理赔时效','伤残理赔评分','医疗理赔时效','医疗理赔评分','关爱活动','关爱活动评分','理赔宣传','理赔宣传评分','参保响应','参保响应评分','总分','评级结果');
    			$csv->put_csv($list,$csv_title);
						}	
					
		else{  
    			$list = Db::table('ENTER_RESULTS')
						->where($map)
                        ->field('ENTER_CITY,ENTER_COUNTY,ENTER_LEIXING,ENTER_NAME,RES_BFGM,RES_BFGM_SCORE,RES_CBRS,RES_CBRS_SCORE,RES_XBSX,RES_XBSX_SCORE,RES_XBRS,RES_XBRS_SCORE,RES_LXXB,RES_LXXB_SCORE,RES_JMPC,RES_JMPC_SCORE,RES_ZWCD,RES_ZWCD_SCORE,RES_DJXQ,RES_DJXQ_SCORE,RES_KHZJ,RES_KHZJ_SCORE,RES_TBFA,RES_TBFA_SCORE,RES_CBSX,RES_CBSX_SCORE,RES_BQSX,RES_BQSX_SCORE,RES_SWLP,RES_SWLP_SCORE,RES_SCLP,RES_SCLP_SCORE,RES_YLLP,RES_YLLP_SCORE,RES_GAHD,RES_GAHD_SCORE,RES_LPXC,RES_LPXC_SCORE,RES_CBXY,RES_CBXY_SCORE,RES_SCORE,RES_RANK')  
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
					
                        $csv_title=array('机构','县区','企业类型','单位名称','保费规模','保费规模评分','参保人数','参保人数评分','续保时效','续保时效评分','续保人数占比','续保人数占比评分','续保连续','续保连续评分','面访次数','面访次数评分','客户掌握度','客户掌握度评分','洞见需求','洞见需求评分','客户转介绍','客户转介绍评分','投保非安','投保非安评分','收集参保天数','收集参保评分','收集保全天数','收集保全评分','死亡理赔时效','死亡理赔评分','伤残理赔时效','伤残理赔评分','医疗理赔时效','医疗理赔评分','关爱活动','关爱活动评分','理赔宣传','理赔宣传评分','参保响应','参保响应评分','总分','评级结果');
                        $csv->put_csv($list,$csv_title);
						}	
			}
	}
    
    
    
/*-------/测试1-------*/	

	public function test($enter_name="",$year="",$type="")   //type1医疗2伤残3死亡
	{
		$enter_name="昆明风景矿业有限公司";
        $year=2018;
        $type=3;
        $sign=0;
        $apply=0;
        $n=Db::table('BASE_LIPEI')
					//->field('SUM(POLICY_PR) as 	CBRS')
					->where('ENTER_NAME',$enter_name)
					//->where('POLICY_BEGIN_DATE','LIKE','%'.$year.'%')
					->where('SIGN_DATE','LIKE','%'.$year.'%')
					->where('LP_TYPE',$type)
					//->whereOr('INSURANCE_TYPE','0')
					//->where('FINANCIAL_CODE','EA47')
					->count();
		if(empty($n)){			
				return "无理赔";
        }
			else{
                $info=Db::table('BASE_LIPEI')
				->where('ENTER_NAME',$enter_name)
				->where('SIGN_DATE','LIKE','%'.$year.'%')
                ->where('LP_TYPE',$type)
                ->select();
            }
			//print_r($n);
		for($i=0;$i<$n;$i++){
            $apply=$apply+strtotime($info[$i]['APPLY_DATE']);
            $sign=$sign+strtotime($info[$i]['SIGN_DATE']);
        }
        echo $type."<br>";
        print_r($n);
        echo "<br>";
        print_r($info[$n-1]['APPLY_DATE']);
        echo "<br>";
        print_r($info[$n-1]['SIGN_DATE']);
        echo "<br>";
        print_r($apply);
        echo "<br>";
        print_r($sign);
        echo "<br>";
        echo round(($sign-$apply)/3600/24/$n);//SELECT * FROM `BASE_POLICY` WHERE ENTER_NAME='昆明和安矿业有限公司' AND POLICY_BEGIN_DATE LIKE '%2018%' AND INSURANCE_TYPE='1'
	}

    
/*-------/获取测试2-------*/	

	public function test1($enter_name="",$year="")
	{
        $year='2018';
        //$year=$year+1;
        //$x='0';
        $enter_name='昆明华腾限公司';
        for($i=0;$i<=4;$i++){
            //$x=1;
            
            $t=Db::table('BASE_POLICY')
					//->field('SUM(POLICY_PR) as 	CBRS')
					->where('ENTER_NAME',$enter_name)
					//->where('POLICY_BEGIN_DATE','LIKE','%'.$year.'%')
					->where('POLICY_BEGIN_DATE','LIKE','%'.$year.'%')
					//->where('PREMIUM','>','0')
					->where('INSURANCE_TYPE','1')
					//->where('FINANCIAL_CODE','EA47')
					->select(); 
             if(!empty($t)){
                 $year--;
             }
             else{
                 break;
             }
        }
        echo $i;
        echo "<br>";
        echo $year;
        echo "<br>";
        print_r($t);
    }

    public function post($enter_name="",$enter_id="",$year="")
    {
/*     $enter_name=$POST['enter_name'];
    $year=$POST['year']; */
    print_r($enter_name);
    print_r($year);
    }

	
}










