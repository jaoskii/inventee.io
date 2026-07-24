<?php

namespace backend\modules\SOApproval\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\db\Query;
use yii\base\ErrorException;
use yii\web\Session;
use app\models\Postock;
use app\models\Log;

use yii\data\SqlDataProvider;
// use yii\data\ArrayDataProvider;

use yii\grid\GridView;
use yii\helpers\Html;

class DefaultController extends Controller
{

	public $access = array(
        'view' => 634,'edit' => 743,'new' => 744,'save' => 745,
        'change' => 746,'delete' => 747,'print' => 748);

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex(){
        $this->layout = "@app/views/layouts/backend/main";
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        return $this->render('index',['moduleid'=>$moduleid]);
    }

    public function actionSoadocnolookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcDocnolookupsearch($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            echo json_encode(array('searchitems' => $return['data']));
        }                                       
    }
    
    // public function actionSearchdocno(){
    //     Yii::$app->backend->AjaxVerification($this);
    //     $params = $_GET;
        
    //     $return=Yii::$app->sbccontroller->sbcSearchdocno($this,$params);  
    //     if($return['verifyuser']==1){
    //        return $this->redirect(Url::to(['/admin/default/login']));
    //     }elseif($return['verifyaccess']==1){
    //         echo json_encode(array('moduledata' => '','access'=> 0));
    //     }else{
    //         echo json_encode(array('moduledata' => $return['data'],'access'=> 1));
    //     }                                       
    // }//END SEARCH DOCNO

public function actionSoaupdaterem(){
    Yii::$app->backend->AjaxVerification($this);
    $qry="update hsohead set rem = '".$_GET['rem']."' where docno='".$_GET['docno']."'";
    Yii::$app->sbccommon->execqry($qry);
    $msg="SUCCESS";
    echo json_encode(['soaupdate'=>$msg]);
}//end action

public function actionSoaapprove(){
    Yii::$app->backend->AjaxVerification($this);
    $qry="update hsohead set isapproved=1, rem = '".$_GET['rem']."', reason2='".$_GET['reason']."' where docno='".$_GET['docno']."'";
    Yii::$app->sbccommon->execqry($qry);
    
    $qry2 = "select trno from transnum where docno = '".$_GET['docno']."'";
    
    $key = Yii::$app->sbccommon->datareader($qry2);
    Log::writelog('SO',$key,'SO APPROVAL',$_GET['docno'].' => '.'APPROVED',Yii::$app->session['loggeduser']['username']);
    $msg="SUCCESS";
    echo json_encode(['soaapprove'=>$msg]);
}//END SEARCH DOCNO


public function actionSoaplot(){
	try {
        Yii::$app->backend->AjaxVerification($this);
        //$params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        //$number = Yii::$app->backend->sanitize($_GET['number'],'DEFAULT');
        //$string = Yii::$app->backend->sanitize($_GET['string'],'DEFAULT');
        //$_GET['param name from js']
        if($_GET['docno']!=''){
        	$qry="select client.status as cstatus,ifnull(agent.client,'') as agentcode,ifnull(agent.clientname,'') as agentname,hsohead.reason1,
                  trno,docno,date(dateid) as dateid,hsohead.client,
                  hsohead.clientname,hsohead.rem,client.clientid from hsohead
                  left join client as agent on agent.client = hsohead.agent
			      left join client on hsohead.client=client.client 
                  where docno ='".$_GET['docno']."'";
        	//$qry="select trno,docno,date(dateid) as dateid,client,clientname,rem from hsohead where docno='".$_GET['docno']."'";	
        	$data = Yii::$app->sbccommon->openTable($qry);

            if(!empty($data)){
                $reason1 = '';
                $reasons = explode("\n", $data[0]['reason1']);
                foreach ($reasons as $key => $value) {
                    if($reason1 == ''){
                        $reason1 = $value;
                    }else{
                        $reason1 = $reason1 . ' | ' . $value;
                    }//end if
                }//end if
                $data[0]['reason1'] = $reason1;
            }else{
                $data[0]['reason1'] = '';
            }//end of
	        
            if(!empty($data)){
	        	$total=Postock::getgrandtotal($data[0]['trno'], 'SO');	
	        }//end if
	        
            if(!empty($total)){
                $data[0]['grandtotal']=$total[0]['grandtotal'];
            }else{
                $data[0]['grandtotal']=0.00;
            }//end if

	        $qry2="select crlimit from client where client='".$data[0]['client']."'";

	        $qry3="select hsohead.trno,hsohead.docno,hsostock.ext,hsostock.iss,hsostock.isamt,hsostock.isqty,
                   hsostock.qa,((hsostock.iss-hsostock.qa)/uom.factor) as unserved,hsostock.void from hsohead
				   left join hsostock on hsohead.trno=hsostock.trno 
                   left join item on item.barcode = hsostock.barcode
                   left join uom on uom.itemid = item.itemid and uom.uom = hsostock.uom
                   where hsohead.client='".$data[0]['client']."' and hsohead.trno <> ".$data[0]['trno']."";
            
	        $data2 = Yii::$app->sbccommon->openTable($qry2);
	        $data3 = Yii::$app->backend->openPDCsum($data[0]['clientid'],$data[0]['dateid']);
	        $data4 = Yii::$app->backend->getOverallUnpaidTransactions($data[0]['clientid']);
	        $data5 = Yii::$app->sbccommon->openTable($qry3);

	        if(empty($data3[0]['db'])){
	        	$data3[0]['db']=0;
	        }
	        if(empty($data3[0]['cr'])){
	        	$data3[0]['cr']=0;
	        }

	        if(empty($data4[0]['db'])){
	        	$data4[0]['db']=0;
	        }else{
                $data4[0]['db']= floatval($data4[0]['balance']);
            }//end if

	        if(empty($data4[0]['cr'])){
	        	$data4[0]['cr']=0;
	        }

	        $docloop='';
	        $totalunso=0;
	        
	        foreach ($data5 as $key => $value) {
        		if($value['iss']!=$value['qa']){
                    if($value['void'] != 1){
                        $totalunso=$totalunso+((floatval($value['ext']) / floatval($value['isqty'])) * floatval($value['unserved'])) ;
                        $docloop=$value['docno'];
                    }//end if
        		}
	        }

	        $data[0]['db']=$data3[0]['db'];
	        $data[0]['db2']=$data4[0]['db'];
	        $data[0]['crlimit']=$data2[0]['crlimit'];
	        $data[0]['unserved']=$totalunso;
	        echo json_encode(['soadata'=>$data]);
        }else{
        	echo "test";
        }
        
        

	} catch (ErrorException $e) {
		echo $e;
	}
        // $return=Yii::$app->sbccontroller->sbcSearchdocno($this,$params);  
        // if($return['verifyuser']==1){
        //    return $this->redirect(Url::to(['/admin/default/login']));
        // }elseif($return['verifyaccess']==1){
        //     echo json_encode(array('moduledata' => '','access'=> 0));
        // }else{
        //     echo json_encode(array('moduledata' => $return['data'],'access'=> 1));
        // }                                       
    }//END SOA PLOT
}
