<?php

namespace backend\modules\bankrecon\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;

use app\models\Terms;
use yii\base\ErrorException;

use yii\web\Response;
class DefaultController extends Controller{

    public $access = array('view' => 634);

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
        if(isset(Yii::$app->session['loggeduser'])){
            if(Yii::$app->session['loggeduser']['access'][600] == 1){
                $this->layout = "@app/views/layouts/backend/main";
                $moduleid = $this->module->id;
                Yii::$app->view->params['moduleid'] = $moduleid;
                $terms = new Terms;
                $data =  $terms->openTerms($this,$this->access['view']);  
                return $this->render('index',array('termsdata'=>$data,'moduleid'=>$moduleid));
            }else{
                return $this->redirect(Url::to(['/admin/default/401']));
            }//emd if
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }//END IF
    }//END ACTION INDEX

    public function actionContrasearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateContralookup($params);
    }//END CONTRA

    public function actionGetdatarecon(){
            Yii::$app->systemsettings->setDefaultTimeZone();
            $date1 = $_GET['start'];
            $date2 = $_GET['end'];
            $clearday = $_GET['clear'];
            $contra = explode('~',$_GET['contra']);
            $acno = $contra[0];
            $data =null;
            $brdate='';
            $bal='';
            $unclear =0;
            $cleardate = '';

            
            if (($acno!='' && $date1!='' && $date2 !='') || $clearday !=''){            	
                $data = Yii::$app->backend->openBankrecon($date1,$date2,$clearday,$acno);
                
                $brdate=Yii::$app->backend->getfromBrecon2($acno, 'dateid');
                
                $bal=Yii::$app->backend->getfromBrecon($acno,$brdate,'bal');
                $unclear=Yii::$app->backend->getunclear($acno,$date2);

                $brdate = date_create($brdate);

                if($clearday == ''){
                    $cleardate = date('Y-m-d');
                }else{
                    $cleardate = $clearday;
                }//end if

                //$cleardate = date_format(date_add($brdate, date_interval_create_from_date_string('1 days')), 'Y-m-d');

                $brdate = date_format($brdate, 'm/d/Y');

                if(Yii::$app->backend->getfromBrecon2($acno, 'acno')==""){
                    $insert = Yii::$app->backend->insertBRecon($acno, $date2, 0,0, '2');
                    if($insert==1){                        
                        Yii::$app->response->format = Response::FORMAT_JSON;
                        return ['brecon' => $data,'brdate'=>$brdate,'bal'=>$bal,'unclear'=>$unclear,'cleardate'=>$cleardate,'err'=>1];
                        //echo json_encode(array('brecon' => $data,'brdate'=>$brdate,'bal'=>$bal,'unclear'=>$unclear,'cleardate'=>$cleardate,'err'=>1));
                    }else{
                       Yii::$app->response->format = Response::FORMAT_JSON;
                        return ['brecon' => $data,'brdate'=>$brdate,'bal'=>$bal,'unclear'=>$unclear,'cleardate'=>$cleardate,'err'=>0];
                        //echo json_encode(array('brecon' => $data,'brdate'=>$brdate,'bal'=>$bal,'unclear'=>$unclear,'cleardate'=>$cleardate,'err'=>0));
                    }
                }else{
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['brecon' => $data,'brdate'=>$brdate,'bal'=>$bal,'unclear'=>$unclear,'cleardate'=>$cleardate,'err'=>1];
                    //echo json_encode(array('brecon' => $data,'brdate'=>$brdate,'bal'=>$bal,'unclear'=>$unclear,'cleardate'=>$cleardate,'err'=>1));
                } 
        	}else{
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['brecon' => $data,'brdate'=>$brdate,'bal'=>$bal,'unclear'=>$unclear,'cleardate'=>$cleardate,'err'=>'All fields are required.'];
                //echo json_encode(array('brecon' => $data,'brdate'=>$brdate,'bal'=>$bal,'unclear'=>$unclear,'cleardate'=>$cleardate,'err'=>'All fields are required.'));
            }
            
    }

    public function actionGetviewdata(){


    		$clearday ='';
            $data=null;
            $deposit=0;
            $withdraw=0;
            $difference=0;
            $endbal =0;
            $interest=0;
            $deductions=0;
            $clearedbal =0;
            $begbal=0;
            $brdate ='';
            $newsdate ='';
            $newedate ='';
            $bal='';
            $unclear=0;

            
            if (isset($_POST) && $_POST['contra']!='' && $_POST['start']!='' && $_POST['end']!=''){
                
                $date1 = $_POST['start'];
                $date2 = $_POST['end'];
                $clearday = $_POST['clear'];
                $contra = explode('~',$_POST['contra']);
                $acno = $contra[0];

                $brdate = Yii::$app->backend->getfromBrecon2($acno, 'dateid');

                if ($brdate==''){
                    $brdate = $date1;
                }
                
                $bal=Yii::$app->backend->getfromBrecon($acno,$brdate,'bal');
                $unclear=Yii::$app->backend->getunclear($acno,$date2);
                

            	$begbal = strlen(Yii::$app->backend->getfromBrecon($acno,$brdate,'bal'))==0?0 : Yii::$app->backend->getfromBrecon($acno,$brdate,'bal');

                $newsdate =  substr($brdate,0,10);             
                $newedate = date_format(date_add(date_create($newsdate), date_interval_create_from_date_string('1 days')), 'Y-m-d');
                $arr= Yii::$app->backend->openDepwithdraw($newsdate, $date2, $clearday, $acno);

                if ($arr){
                    $deposit=empty($arr[0]['dep'])?0:$arr[0]['dep'];
                    $withdraw=empty($arr[0]['withdraw'])?0:$arr[0]['withdraw'];
                }   

                $interest= str_replace(",","",(strlen($_POST['interest'])==0?0 : $_POST['interest']));
                $deductions= str_replace(",","",strlen($_POST['deductions'])==0?0 : $_POST['deductions']);
                $endbal =  str_replace(",","",strlen($_POST['endbal'])==0?0 : $_POST['endbal']);

                $clearedbal = ($begbal + $interest + $deposit) - ($deductions + $withdraw);
                $difference = $clearedbal - $endbal;

                // $newsdate =  substr($brdate,0,10);             
                // $newedate = date_format(date_add(date_create($newsdate), date_interval_create_from_date_string('1 days')), 'Y-m-d');
                $brdate = date_create($brdate);
                $brdate = date_format($brdate, 'm/d/Y');

                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['endbal'=>$endbal,'interest'=>$interest,'deduction'=>$deductions,'clearedbal'=>$clearedbal,'diff'=>$difference,'deposit' => $deposit,'withdraw'=>$withdraw,'begbal'=>$begbal,'brdate'=>$brdate,'bal'=>$bal,'unclear'=>$unclear,'newsdate'=>$newsdate,'newedate'=>$newedate,'err'=>'success'];
                //echo json_encode(array('endbal'=>$endbal,'interest'=>$interest,'deduction'=>$deductions,'clearedbal'=>$clearedbal,'diff'=>$difference,'deposit' => $deposit,'withdraw'=>$withdraw,'begbal'=>$begbal,'brdate'=>$brdate,'bal'=>$bal,'unclear'=>$unclear,'newsdate'=>$newsdate,'newedate'=>$newedate,'err'=>'success'));
            }else{
                if($_POST['contra']!=''){
                    $contra = explode('~',$_POST['contra']);
                    $acno = $contra[0];
                    $brdate = Yii::$app->backend->getfromBrecon2($acno, 'dateid');

                    $newsdate =  substr($brdate,0,10);             
                    $newedate = date_format(date_add(date_create($newsdate), date_interval_create_from_date_string('1 days')), 'Y-m-d');
                    $brdate = date_create($brdate);
                    $brdate = date_format($brdate, 'm/d/Y');
                     
                }
                
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['endbal'=>$endbal,'interest'=>$interest,'deduction'=>$deductions,'clearedbal'=>$clearedbal,'diff'=>$difference,'deposit' => $deposit,'withdraw'=>$withdraw,'begbal'=>$begbal,'brdate'=>$brdate,'bal'=>$bal,'unclear'=>$unclear,'newsdate'=>$newsdate,'newedate'=>$newedate,'err'=>'All fields are required'];
                //echo json_encode(array('endbal'=>$endbal,'interest'=>$interest,'deduction'=>$deductions,'clearedbal'=>$clearedbal,'diff'=>$difference,'deposit' => $deposit,'withdraw'=>$withdraw,'begbal'=>$begbal,'brdate'=>$brdate,'bal'=>$bal,'unclear'=>$unclear,'newsdate'=>$newsdate,'newedate'=>$newedate,'err'=>'All fields are required'));
            }
  
    }

     public function actionGetsavedata(){

        try {
        $clearday = $_POST['clear'];
        $date1 = $_POST['start'];
        $date2 = $_POST['end'];
        $contra = explode('~',$_POST['contra']);
        $acno = $contra[0];
        $diff =str_replace(',', '', $_POST['diff']);
        $endbal =str_replace(',', '',$_POST['endbal']);
        $brdate ='';
        $interest= 0;
        $deductions= 0;
        $clearedbal = 0;
        $difference=0;
        $deposit=0;
        $withdraw=0;
        $unclear=0;

        if ($diff==0){
            $ac = Yii::$app->backend->getfromBrecon($acno,$date2,'acno');
            if ($ac == ""){
                Yii::$app->backend->insertBRecon($acno,$date2,$endbal,$diff,'3');
            }else{
                Yii::$app->backend->insertBRecon($acno,$date2,$endbal,$diff,'4');
            }//ac
        }//diff

        $sdate = Yii::$app->backend->getfromBrecon2($acno,'dateid');


        if ($date2 > $sdate or $sdate ==''){
            $brprev = strlen(Yii::$app->backend->getfromBrecon($acno,$date2,'bal'))==0?0 : Yii::$app->backend->getfromBrecon($acno,$date2,'bal');


            if ($brprev ==0){
                Yii::$app->backend->insertBRecon($acno,$date2,$endbal,$diff,'3');
            }else{
                Yii::$app->backend->insertBRecon($acno,$date2,$endbal,$diff,'5');

            }//brprev

            $begbal =Yii::$app->backend->getfromBrecon($acno,$date2,'bal');
            $brdate=Yii::$app->backend->getfromBrecon2($acno, 'dateid');

            //retrieve new data
                $newsdate =  substr($brdate,0,10);             
                $newedate = date_format(date_add(date_create($newsdate), date_interval_create_from_date_string('1 days')), 'Y-m-d');

                $bal=Yii::$app->backend->getfromBrecon($acno,$brdate,'bal');
                $unclear=Yii::$app->backend->getunclear($acno,$newedate);

                $arr= Yii::$app->backend->openDepwithdraw($newsdate, $newedate, $clearday, $acno);
                if ($arr){
                        $deposit=empty($arr[0]['dep'])?0:$arr[0]['dep'];
                        $withdraw=empty($arr[0]['withdraw'])?0:$arr[0]['withdraw'];
                }   

                $interest= 0;
                $deductions= 0;
                $endbal =  0;

                $clearedbal = ($begbal + $interest + $deposit) - ($deductions + $withdraw);
                $difference = $clearedbal - $endbal;

            //return json
            $brdate = date_create($brdate);
            $brdate = date_format($brdate, 'm/d/Y');

            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['endbal'=>$endbal,'interest'=>$interest,'deduction'=>$deductions,
            'clearedbal'=>$clearedbal,'diff'=>$difference,'deposit' => $deposit,
            'withdraw'=>$withdraw,'begbal'=>$begbal,'brdate'=>$brdate,'bal'=>$bal,
            'unclear'=>$unclear,'newsdate'=>$newsdate,'newedate'=>$newedate,'err'=>'success'];
            /* echo json_encode(array('endbal'=>$endbal,'interest'=>$interest,'deduction'=>$deductions,
            'clearedbal'=>$clearedbal,'diff'=>$difference,'deposit' => $deposit,
            'withdraw'=>$withdraw,'begbal'=>$begbal,'brdate'=>$brdate,'bal'=>$bal,
            'unclear'=>$unclear,'newsdate'=>$newsdate,'newedate'=>$newedate,'err'=>'success')); */

        }else{            
            $bal=Yii::$app->backend->getfromBrecon($acno,$brdate,'bal');
            $begbal =Yii::$app->backend->getfromBrecon($acno,$date2,'bal');
            $brdate=Yii::$app->backend->getfromBrecon2($acno, 'dateid');
            $newsdate =  substr($brdate,0,10);             
            $newedate = date_format(date_add(date_create($newsdate), date_interval_create_from_date_string('1 days')), 'Y-m-d');            
            $brdate = date_create($brdate);
            $brdate = date_format($brdate, 'm/d/Y');

            $sdate = date_create($sdate);
            $sdate = date_format($sdate, 'm/d/Y');
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['endbal'=>$endbal,'interest'=>$interest,'deduction'=>$deductions,'clearedbal'=>$clearedbal,'diff'=>$difference,'deposit' => $deposit,'withdraw'=>$withdraw,'begbal'=>$begbal,'brdate'=>$brdate,'bal'=>$bal,'unclear'=>$unclear,'newsdate'=>$newsdate,'newedate'=>$newedate,'err'=>'Last adjustment is: '.$sdate];
            //echo json_encode(array('endbal'=>$endbal,'interest'=>$interest,'deduction'=>$deductions,'clearedbal'=>$clearedbal,'diff'=>$difference,'deposit' => $deposit,'withdraw'=>$withdraw,'begbal'=>$begbal,'brdate'=>$brdate,'bal'=>$bal,'unclear'=>$unclear,'newsdate'=>$newsdate,'newedate'=>$newedate,'err'=>'Last adjustment is: '.$sdate));
        }//$date2>$sdate

        
            
        } catch (ErrorException $e) {
            echo $e;
        }
    }


    public function actionGetbanksumm(){

            $contra = explode('~',$_GET['contra']);
            $acno = $contra[0];
            $date1 =$_GET['date1'];
            $date2=$_GET['date2'];
        	$data = Yii::$app->backend->openBankBookSummary($acno,$date1,$date2); 
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['banksumm' => $data];
            //echo json_encode(array('banksumm' => $data));
    }

    public function actionGetbankbook(){

            $contra = explode('~',$_GET['contra']);
            $acno = $contra[0];
            $date1 = $_GET['start'];
            $date2 = $_GET['end'];
            $gatherby = $_GET['gatherby'];
            $mode = $_GET['mode'];
            $searchby = $_GET['searchby'];
            $data = null;
            $runbal =null;
            $begbal =0;
            $brdate='';
            $unclear=0;

            if ($acno !='' && $date1!='' && $date2!=''){
                $data = Yii::$app->backend->openBankBook($date1,$date2,$acno,$gatherby,$mode,$searchby);
                $begbal =Yii::$app->backend->getfromBrecon($acno,$date2,'bal');
                $unclear=Yii::$app->backend->getunclear($acno,$date2);
                $brdate=Yii::$app->backend->getfromBrecon2($acno, 'dateid');            
                $brdate = date_create($brdate);
                $brdate = date_format($brdate, 'm/d/Y');
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['bankbook' => $data,'begbal'=>$begbal,'unclear'=>$unclear,'brdate'=>$brdate,'err'=>'success'];
                //echo json_encode(array('bankbook' => $data,'begbal'=>$begbal,'unclear'=>$unclear,'brdate'=>$brdate,'err'=>'success')); 
            }else{
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['bankbook' => $data,'begbal'=>$begbal,'unclear'=>$unclear,'brdate'=>$brdate,'err'=>'All fields required.'];
                //echo json_encode(array('bankbook' => $data,'begbal'=>$begbal,'unclear'=>$unclear,'brdate'=>$brdate,'err'=>'All fields required.')); 
            }
            
        	
    }

    public function actionClearbrecon(){      
    try {
        $moduleid = $this->module->id;        
        $params = $_GET;
        $date1 = $_GET['start'];
        $date2 = $_GET['end'];
        $contra = explode('~',$_GET['contra']);
        $acno =$contra[0];
        $cleardate = $_GET['clear'];

        if ($cleardate!=""){
            $return=Yii::$app->backend->clearbrecon($params['params'],$cleardate);        
            $data = Yii::$app->backend->openBankrecon($date1,$date2,$cleardate,$acno); 
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['brecon' => $data,'err'=>1];
            //echo json_encode(array('brecon' => $data,'err'=>1)); 
        }else{
            $data = Yii::$app->backend->openBankrecon($date1,$date2,$cleardate,$acno);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['brecon' => $data,'err'=>0];
            //echo json_encode(array('brecon' => $data,'err'=>0)); 
        }
        
    } catch (ErrorException $e) {
        echo $e;
    }       
    }
}
