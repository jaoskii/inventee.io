<?php

namespace app\components;
 
use Yii;
use yii\base\Component;
use yii\db\Query;
use yii\web\sessions;
use app\models\Client;
use app\models\Log;
use yii\base\ErrorException;
use app\models\Common;
use app\models\Ladetail;

use yii\web\Controller;

use yii\helpers\Url;


class systemfunc extends Component{	


public function verifyuser(){
	if(isset(Yii::$app->session['loggeduser'])){
         return true;  
	}else{
	 Yii::$app->view->params['msg'] = 'Pls log in first...';
     return false;
	}
}


public function verifyaccess($accessid){
    $loggeduser = Yii::$app->session['loggeduser'] ?? null;
    if (!is_array($loggeduser) || !isset($loggeduser['access'][$accessid])) {
        return false;
    }
    if($loggeduser['access'][$accessid] == 1){
        return true;
    }else{
    	return false;
    }
}


public function jverifyaccess($controller,$accessid,$accesstype,$trno){
	$loggeduser = Yii::$app->session['loggeduser'] ?? null;
	if (!is_array($loggeduser) || !isset($loggeduser['access'][$accessid])) {
		Yii::$app->view->params['msg'] = 'Sorry, not allowed...';
		return false;
	}
    if($loggeduser['access'][$accessid] == 1){
        return true;
    }else{
    	$doc = $controller->module->id;
    	Log::writelog($doc, $trno, $accesstype, 'Invalid Access - Try', $loggeduser['username'] ?? '');
    	Yii::$app->view->params['msg'] = 'Sorry, not allowed...';
    	return false;
    }
}


public function sbcindex($controller){
    Yii::$app->view->params['msg']='';
    Yii::$app->session['warning']='';
	if($this->verifyuser()){
		if($this->verifyaccess($controller->access['view'])){
		    $data = Yii::$app->webprocess->index($controller,$controller->access['view']);
		    $controller->layout = "@app/views/layouts/backend/main";
		    switch ($controller->module->id) {
		    	case 'SJ2':
		    		$moduleid = 'SJ';
		    		Yii::$app->view->params['moduleid'] = 'SJ';
		    	break;
		    	
		    	default:
		    		$moduleid = $controller->module->id;
		    		Yii::$app->view->params['moduleid'] = $moduleid;
		    	break;
		    }//END SWITCH

		    return array('verifyuser'=>0,'verifyaccess'=>0,'moduledata'=>$data,'moduleid'=>$moduleid);
		}else{
    		return array('verifyuser'=>0,'verifyaccess'=>1);
		}//end if
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);
	}
}//end sbcindex


public function sbcNavbuttons($controller,$get){    
        Yii::$app->view->params['msg']='';
    	if($this->verifyuser()){
    	     if($this->verifyaccess($controller->access['view'])){    			
		        if(isset($get['docno']) && isset($get['trno'])){
		            //IF PARAMETERS ARE PRESENT (REQUEST CAME FROM NEXT,PREVIOUS AND DOCUMENT LOOK UP)
		            $params = array('docno' => $get['docno'],'trno' => $get['trno']);
		        }else{
		            //IF PARAMETERS ARENT PRESENT (REQUEST CAME ONLY FROM FIRST AND LAST BUTTONS)
		            $params = "";
		        }//END IF
		        $params = $get['params'];
		        $action = $get['action'];
		        $data = Yii::$app->webprocess->viewing($controller,$controller->access['view'],$action,$params);
				//var_dump($data);
				//return 0;
		        return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$data);	    	     	   		    
   		     }else{
    		    return array('verifyuser'=>0,'verifyaccess'=>1);	
    	      }
    	}else{
    		return array('verifyuser'=>1,'verifyaccess'=>0);	
    	}
}//end sbcNavbuttons



public function sbcNewdocument($controller,$get){
	Yii::$app->view->params['msg']='';
   	if($this->verifyuser()){
    	     if($this->verifyaccess($controller->access['new'])){    			
  		        $params = array('docno' => $get['docno']);
  		        $params = Yii::$app->backend->sanitize($params,'ARRAY');
		        $data = Yii::$app->webprocess->newing($controller,$controller->access['new'],$params);  
		        return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$data);	
   		     }else{
    		    return array('verifyuser'=>0,'verifyaccess'=>1);	
    	      }
    	}else{
    		return array('verifyuser'=>1,'verifyaccess'=>0);	
    	}
}//end sbcNewdocument




public function sbcGetclientinfo($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['view'])){    			
		    $client = new Client;
	        $clientid = $get['clientid'];
	        $type = $get['type'];
	        $data = $client->openclient($clientid,$type);
	        $data[0]['crlimit_msg'] = $client->GetCRLimit($data[0]['client']);
            return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$data);
		     }else{
		    return array('verifyuser'=>0,'verifyaccess'=>1);	
	      }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}//end sbcGetclientinfo


public function sbcSavehead($controller,$params) {
	try {
		$istransposted = false;
		Yii::$app->view->params['msg']='';
		if(Yii::$app->backend->checkTransctionDateApproval($params['dateid'])) {
			if($this->verifyuser()) {
	    	    if($this->verifyaccess($controller->access['save'])) {
	    	     	$params = Yii::$app->backend->sanitize($params,'ARRAY');
	    	     	$doc = $controller->module->id;
	    	     	if(Yii::$app->backend->checkDataIfPosted($params['trno'],$doc)) {
			         	 $istransposted = true;
			         	 $data = array('trno' => '', 'docno'=> '','msg'=>'','type'=>'','head'=>'');
			        } else {
		    	     	if(Yii::$app->backend->checkHeadRequiredData($doc,$params)) {
		    	     		$data = Yii::$app->webprocess->savinghead($controller,$controller->access['save'],$params);
		    	     	} else {
		    	     		$message = 'Error Saving head, Please try again! (ERR_J1)';
		    	     		$data = array('trno' => '', 'docno'=> '','msg'=>$message,'type'=>'','head'=>'');
		    	     	}//end if
		            }//end if trans posted
		            return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$data,'istransposted'=>$istransposted);	
	   		    }else{
	    		    return array('verifyuser'=>0,'verifyaccess'=>1,'istransposted'=>$istransposted);	
	    	    }//end if
	    	}else{
	    		return array('verifyuser'=>1,'verifyaccess'=>0,'istransposted'=>$istransposted);	
	    	}//end if
    	}else{
			$msg = 'Error cannot create Document. System Date is locked from date ' . Yii::$app->systemsettings->getSystemLockdate();
			return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>['trno' => '', 'docno'=> '','msg'=>$msg,'head'=>[]],'type'=>'','istransposted'=>0);
		}//end if
	} catch (ErrorException $e) {
		echo $e;
		return 0;
	}//end try catch
}  //end sbcSavehead


public function sbcDeletedoc($controller,$params){
try {
	Yii::$app->view->params['msg']='';
	$istransposted = false;
	if($this->verifyuser()){
	    if($this->verifyaccess($controller->access['delete'])){    			
            if(Yii::$app->backend->checkDataIfPosted($params['trno'],$controller->module->id)){
		        $istransposted = true;
		        $data = '';
		    }else{
            	$data = Yii::$app->webprocess->deleting($controller,$controller->access['delete'],$params);	   		     
            }//end if transposted
            return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$data,'istransposted'=>$istransposted);	
		}else{
		    return array('verifyuser'=>0,'verifyaccess'=>1);	
	    }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
} catch (ErrorException $e) {
	echo $e;
}
}// end sbcDeletedoc



public function sbcSearchdocno($controller,$get){
	Yii::$app->view->params['msg']='';
		if($this->verifyuser()){
    	     if($this->verifyaccess($controller->access['view'])){    			
		        $docno = $get['docno'];
		        $params = array('docno' => $docno);
		        $params = Yii::$app->backend->sanitize($params,'ARRAY');
		        $access = array('view' => $controller->access['view'],'new' => $controller->access['new']);
		        $data = Yii::$app->webprocess->searching($controller,$access,'search',$params);     
		        return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$data);	
   		     }else{
    		    return array('verifyuser'=>0,'verifyaccess'=>1);	
    	      }
    	}else{
    		return array('verifyuser'=>1,'verifyaccess'=>0);	
    	}
}//end sbcSearchdocno


public function sbcProdinstructionLookup($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['view'])){    			
	        $searchstring = $get['searchstring'];
	        $searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');
	        $searchitems = Yii::$app->backend->searchProdInstruction($controller,$controller->access['view'],$searchstring); 
            return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$searchitems);	
		  }else{
		    return array('verifyuser'=>0,'verifyaccess'=>1);	
	      }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}//end sbcDocnolookupsearch

public function sbcProdOrderLookup($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['view'])){    			
	        $searchstring = $get['searchstring'];
	        $searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');
	        $searchitems = Yii::$app->backend->searchProdOrder($controller,$controller->access['view'],$searchstring); 
            return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$searchitems);	
		  }else{
		    return array('verifyuser'=>0,'verifyaccess'=>1);	
	      }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}//end sbcDocnolookupsearch

public function sbcDocnolookupsearch($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['view'])){    			
	        $searchstring = $get['searchstring'];
	        $searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');
	        $searchitems = Yii::$app->backend->searchDocument($controller,$controller->access['view'],$searchstring); 
            return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$searchitems);	
		  }else{
		    return array('verifyuser'=>0,'verifyaccess'=>1);	
	      }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}//end sbcDocnolookupsearch



public function sbcSupplierlookupsearch($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	    	     if($this->verifyaccess($controller->access['view'])){    			
			        $searchstring = $get['searchstring'];
			        $searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');
			        $searchclient = Yii::$app->backend->searchClient($controller,$controller->access['view'],$searchstring);
	   		        return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$searchclient);	
	   		     }else{
	    		    return array('verifyuser'=>0,'verifyaccess'=>1);	
	    	      }
	    	}else{
	    		return array('verifyuser'=>1,'verifyaccess'=>0);	
	    	}
}//end sbcSupplierlookupsearch




public function sbcItemlookupsearch($controller,$get){
	//Yii::$app->session['nodes'] = Yii::$app->session['nodes'] . " - " . 'sbcItemlookupsearch(systemfunc)';
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	    if($this->verifyaccess($controller->access['view'])){    			
	        $searchstring = $get['searchstring'];
	        $searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');
	        $searchitems = Yii::$app->backend->searchItem($controller,$controller->access['view'],$searchstring);
		        return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$searchitems);	
		}else{
		    return array('verifyuser'=>0,'verifyaccess'=>1);	
	    }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}//end sbcItemlookupsearch


public function sbcWarehouselookupsearch($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	    	     if($this->verifyaccess($controller->access['view'])){    			
			        $searchstring = $get['searchstring'];        
			        $searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');
			        $searchitems = Yii::$app->backend->searchWarehouse($controller,$controller->access['view'],$searchstring);
	    		    return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$searchitems);	   		     
	   		     }else{
	    		    return array('verifyuser'=>0,'verifyaccess'=>1);	
	    	      }
	    	}else{
	    		return array('verifyuser'=>1,'verifyaccess'=>0);	
	    	}
}//end sbcWarehouselookupsearch



public function sbcLoadlastdoc($controller){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	    	     if($this->verifyaccess($controller->access['view'])){    			
	               $data = Yii::$app->webprocess->index($controller,$controller->access['view']);
	    		    return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$data);	   		     
	   		     }else{
	    		    return array('verifyuser'=>0,'verifyaccess'=>1);	
	    	      }
	    	}else{
	    		return array('verifyuser'=>1,'verifyaccess'=>0);	
	    	}
} //end sbcLoadlastdoc


public function sbcComputestock($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	    if($this->verifyaccess($controller->access['edit'])){    			
		    $displayqty = $get['displayqty'];
		    $displayamt = $get['displayamt'];
		    $disc = $get['disc'];
		    $uomfactor = $get['uomfactor'];
		    $doc = $controller->module->id;
		    
		    switch (Yii::$app->systemsettings->companyConfig()) {
		    	case 'KINGGEORGE':
		    		switch ($doc) {
				    	case 'IS': case 'RR': case 'SJ': case 'CM': case 'DM': case 'AJ': case 'TS':
				    		$kgs = $get['kgs'];
				    		$displayamt = str_replace(',','',$displayamt);
				    		$displayamt = $displayamt * str_replace(',','',$kgs);
					    	//$displayamt = number_format($displayamt,Yii::$app->systemsettings->setDecimaldisplay('currency'));
				    	break;
				    }//end switch
		    	break;
		    }//end switch

		    if($doc == 'RR'){
		    	$vat = $get['vat'];
		    	$data = Yii::$app->backend->computestock($displayamt,$disc,$displayqty,$uomfactor,$controller,$vat);
		    }else{
		    	$data = Yii::$app->backend->computestock($displayamt,$disc,$displayqty,$uomfactor,$controller);
		    }//end if
		    
		    switch ($doc) {
		    	case 'RR': case 'PO':
			    	$forex = $get['forex'];
			    	$data['cost']=$data['cost'] * $forex;
		    	break;

		     	case 'DM':
			     	$forex = $get['forex'];
			     	$data['amt']=$data['amt'] * $forex;
		    	break;
		    }//end switch

	        return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$data);	
		} else {
		    return array('verifyuser'=>0,'verifyaccess'=>1);	
	    }
	} else {
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}


public function sbcComputestock2($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['edit'])){    			
		    $displayqty = $get['displayqty'];
		    $displayqty2 = $get['displayqty2'];
		    $displayamt = $get['displayamt'];
		    $disc = $get['disc'];
		    $uomfactor = $_GET['uomfactor'];
		    
		    $data = Yii::$app->backend->computestock2($displayamt,$disc,$displayqty,$displayqty2,$uomfactor,$controller);
		    
		    return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$data);	
		     }else{
		    return array('verifyuser'=>0,'verifyaccess'=>1);	
	      }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}//end sbcComputestock


	public function sbcSavestock($controller,$post){
		try {
			Yii::$app->view->params['msg']='';
			if($this->verifyuser()){
			    if($this->verifyaccess($controller->access['save'])){
					$return = Yii::$app->backend->savingStockLooping($controller,$post);
			    	$return['verifyuser'] = 0;
			    	$return['verifyaccess'] = 0;
			    	return $return;
			    	//return array('verifyuser'=>0,'verifyaccess'=>0);	 
				}else{
				    return array('verifyuser'=>0,'verifyaccess'=>1);	
			    }
			}else{
				return array('verifyuser'=>1,'verifyaccess'=>0);	
			}
		} catch (ErrorException $e) {
			echo $e;
		}
	}


	public function sbcSavedetail($controller,$post){
		Yii::$app->view->params['msg']='';
		if($this->verifyuser()){
		    if($this->verifyaccess($controller->access['save'])){ 
		     	$return = Yii::$app->backend->savingDetailLooping($controller,$post);
		     	$return['verifyuser'] = 0;
			    $return['verifyaccess'] = 0;
			    return $return;
			    //return array('verifyuser'=>0,'verifyaccess'=>0);	   		     
			}else{
			    return array('verifyuser'=>0,'verifyaccess'=>1);	
		    }
		}else{
			return array('verifyuser'=>1,'verifyaccess'=>0);	
		}
	}//end sbcSavestock





public function sbcCanceledit($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	    	     if($this->verifyaccess($controller->access['edit'])){    			
				    $trno = $get['trno'];
				    $line = $get['line'];
				    $doc = $controller->module->id;
				    switch ($doc) {
				    	case 'GJ': case 'CV': case 'DS': case 'AR': case 'AP': case 'CR': case 'PV': case 'TW':
				    		$stockdata = Yii::$app->backend->returnDetailline($controller,$trno,$line);
				    		break;
				    	
				    	default:
				    		$stockdata = Yii::$app->backend->returnStockline($controller,$trno,$line);
				    		break;
				    }//END SWITCH
	    		    return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$stockdata);	   		     
	   		     }else{
	    		    return array('verifyuser'=>0,'verifyaccess'=>1);	
	    	      }
	    	}else{
	    		return array('verifyuser'=>1,'verifyaccess'=>0);	
	    	}
}//end sbcCanceledit


public function sbcStockdelete($controller,$get){
	try {
		switch ($controller->module->id) {
			case 'PR': case 'PO': case 'DM': case 'RR':
			case 'SJ': case 'SO': case 'CM': case 'MI': case 'MX':
			case 'IS': case 'TS': case 'PC': case 'AJ': case 'TR':
				$accessindex = "clickdeleteitem";
				break;
			
			default:
				$accessindex = "delete";
				break;
		}//end swithc 

		Yii::$app->view->params['msg']='';
		$istransposted = false;
		if($this->verifyuser()) {
    	    if($this->verifyaccess($controller->access[$accessindex])) {
			    $trno = $get['trno'];
			    $line = $get['line'];
			    $params =  array('trno' => $trno,'line' => $line);
			    
			    if(Yii::$app->backend->checkDataIfPosted($trno,$controller->module->id)) {
		         	$istransposted = true;
		         	switch ($controller->module->id) {
		         		case 'GJ': case 'CR': case 'DS': case 'PV': case 'CV': case 'AR': case 'AP': case 'TW':	
		         			$passjson = array('runningdb'=>'','runningcr'=>'','isbalance'=>'','messages'=>'','istransposted'=>$istransposted);
		         			$passjson['verifyuser'] = 0;
			    			$passjson['verifyaccess'] = 0;
            				return $passjson;
            				//echo json_encode($passjson);		
		         		break;
		         	}//end switch
		        } else {
		        	switch ($controller->module->id) {
		         		case 'GJ': case 'CR': case 'DS': case 'PV': case 'CV': case 'AR': case 'AP': case 'TW':	
		         			$passjson = Yii::$app->webprocess->deletestock($controller,$controller->access[$accessindex],$params);
		         		break;

		         		default:
		         			$total = Yii::$app->webprocess->deletestock($controller,$controller->access[$accessindex],$params);

		         			if(empty($total) || $istransposted == true) {
						        $itemcount = 0.00;
						        $grandtotal = 0.00;
						        $totalforex = 0.00;
						    } else {
						        $itemcount = $total[0]['itemcount'];
						        $grandtotal = $total[0]['grandtotal'];
						        switch ($controller->module->id) {
						        	case 'RR': $totalforex = $total[0]['forexgrandtotal']; break;
						        	default: $totalforex = 0; break;
						        }//END SWITCH CASE
						    }//END IF
		         		break;
		         	}//end switch
			    }//end if trans posted
			    
   		        switch ($controller->module->id) {
	         		case 'GJ': case 'CR': case 'DS': case 'PV': case 'CV': case 'AR': case 'AP': case 'TW':	
	         			$passjson['verifyuser'] = 0;
			    		$passjson['verifyaccess'] = 0;
	         			return $passjson;
	         		break;

	         		default:
	         			return array('verifyuser'=>0,'verifyaccess'=>0,'itemcount'=>$itemcount,'grandtotal'=>$grandtotal,'forexgrandtotal'=>$totalforex,'istransposted'=>$istransposted);	
	         		break;
	         	}//end switch
   		    } else {
    		    return array('verifyuser'=>0,'verifyaccess'=>1);	
    	    }
    	} else {
    		return array('verifyuser'=>1,'verifyaccess'=>0);	
    	}
	} catch (\Exception $e) {
		echo $e;
	}
}//sbcStockdelete

 public function sbcRetrieveorderdatasummary($controller,$get) {
   
  Yii::$app->view->params['msg'] = '';
  if($this->verifyuser()) {
    if($this->verifyaccess($controller->access['view'])) {
      $params = $get['params'];
      $doc = $controller->module->id;
      $data = Yii::$app->backend->retrieveOrderdatasummary($doc,$params);
      return array('verifyuser' => 0, 'verifyaccess' => 0, 'podata' => $data);
    } else {
      return array('verifyuser' => 0, 'verifyaccess' => 1);
    }
  } else {
    return array('verifyuser' => 1, 'verifyaccess' => 0);
  }
}

public function sbcRetrieveorderdatadetailed($controller,$get) {
  Yii::$app->view->params['msg'] = '';
  if($this->verifyuser()) {
    if($this->verifyaccess($controller->access['view'])) {
      $params = $get['params'];
      $doc = $controller->module->id;
      $data = Yii::$app->backend->retrieveOrderdatadetailed($doc,$params);
      return array('verifyuser' => 0, 'verifyaccess' => 0, 'podata' => $data);
    } else {
      return array('verifyuser' => 0, 'verifyaccess' => 1);
    }
  } else {
    return array('verifyuser' => 1, 'verifyaccess' => 0);
  }
}

public function sbcPost($controller,$get){
try {
	Yii::$app->view->params['msg']='';
	$istransposted = false;
	if($this->verifyuser()){
	    	     if($this->verifyaccess($controller->access['post'])){    			
				    $params = array('trno'=>$get['trno']);
				   	if(Yii::$app->backend->checkDataIfPosted($params['trno'],$controller->module->id)){
		         	 	$istransposted = true;
		         	 	$data = array('islocked' => 0,'isposted'=>1,'error'=>'','status'=>0);
		        	}else{
				    	$data = Yii::$app->webprocess->posting($controller,$controller->access['post'],$params);
	    		    }//end if transposted
	    		    
	    		    switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'SOUTHCENTRAL':
                            switch ($controller->module->id) {
                                case 'SO':
                                    return array('verifyuser'=>0,'verifyaccess'=>0,'error_msg'=>$data['error'],
					    		    'isposted' => $data['isposted'],'islocked'=>$data['islocked'],'isapproved'=>$data['isapproved'],
					    		    'status'=>$data['status'],'istransposted'=>$istransposted);
                                break;
                                
                                default:
                                    return array('verifyuser'=>0,'verifyaccess'=>0,'error_msg'=>$data['error'],
					    		    'isposted' => $data['isposted'],'islocked'=>$data['islocked'],
					    		    'status'=>$data['status'],'istransposted'=>$istransposted);
                                break;
                            }//END SWITCH
                            break;
                        
                        default:
                            return array('verifyuser'=>0,'verifyaccess'=>0,'error_msg'=>$data['error'],
			    		    'isposted' => $data['isposted'],'islocked'=>$data['islocked'],
			    		    'status'=>$data['status'],'istransposted'=>$istransposted);
                            break;
                    }//END SWTICH

	   		     }else{
	    		    return array('verifyuser'=>0,'verifyaccess'=>1);	
	    	      }
	    	}else{
	    		return array('verifyuser'=>1,'verifyaccess'=>0);	
	    	}
} catch (ErrorException $e) {
	echo $e;
}
 }//end sbcpost




public function sbcUnpost($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	    	     if($this->verifyaccess($controller->access['view'])){    			
				    $params = array('trno'=>$get['trno']);
				    $data = Yii::$app->webprocess->unposting($controller,$controller->access['unpost'],$params);
	    		    return array('verifyuser'=>0,'verifyaccess'=>0,'error_msg'=>$data['error'],'isposted' => $data['isposted'],'islocked'=>$data['islocked'],'status'=>$data['status']);	
	   		     }else{
	    		    return array('verifyuser'=>0,'verifyaccess'=>1);	
	    	      }
	    	}else{
	    		return array('verifyuser'=>1,'verifyaccess'=>0);	
	    	}
} //end for sbcunpost


public function sbcLockunlock($controller,$get){
	Yii::$app->view->params['msg']='';
	$istransposted = false;
	if($this->verifyuser()){
	    $params = array('trno'=>$get['trno']);
	    $action = $get['action'];
	    if(Yii::$app->backend->checkDataIfPosted($params['trno'],$controller->module->id)){
     	 	$istransposted = true;
     	 	$data = array('islocked' => 0,'isposted'=>1,'error'=>'');
    	}else{
		    //DETERMINE WHAT ACTION IS CALLED

	        if($action == "lock"){
	           if($this->verifyaccess($controller->access['lock'])){
		            $data = Yii::$app->webprocess->locking($controller,$controller->access['lock'],$params);
	           }else{
	                return array('verifyuser'=>0,'verifyaccess'=>1);	       	
	           }    			
	        }else{
	           	if($this->verifyaccess($controller->access['unlock'])){
		            $data = Yii::$app->webprocess->unlocking($controller,$controller->access['unlock'],$params);
	           	}else{
	           	    return array('verifyuser'=>0,'verifyaccess'=>1);	       	
	           	}
	        }
	    }//end if transposted

        return array('verifyuser'=>0,'verifyaccess'=>0,'error_msg'=>$data['error'],'isposted' => $data['isposted'],'islocked'=>$data['islocked'],'istransposted'=>$istransposted);	
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
} //end for sbclockunlock



public function sbcLog($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['view'])){    			
		    $params = array("trno"=>$get['trno']);
		    $data = Yii::$app->webprocess->showlogs($controller,$params);   		     
		    return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$data);	
		  }else{
		    return array('verifyuser'=>0,'verifyaccess'=>1);	
	      }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
} //end for log


public function sbcGetitembalance($controller,$get) {
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()) {
		if($controller->module->id == 'admin') {
			$primarykey = $get['itemid'];
			
			$incomingbal = Yii::$app->backend->getIncomingItemBalance($primarykey);
			$data = Yii::$app->backend->getItembalance($primarykey);

			$bal = 0;
			
			foreach ($data as $key => $value) {
				$bal += $data[0]['bal'];
			}//end for each

			$bal = number_format($bal,Yii::$app->systemsettings->setDecimaldisplay('currency'));

			if(empty($incomingbal)) {
				$postedpobal = 0; $unpostedpobal = 0; $postedsobal = 0; $unpostedsobal = 0;
			} else {
				$postedpobal = number_format($incomingbal[0]['postedpo'],2);
				$unpostedpobal = number_format($incomingbal[0]['unpostedpo'],2);
				$postedsobal = number_format($incomingbal[0]['postedso'],2);
				$unpostedsobal = number_format($incomingbal[0]['unpostedso'],2);
			}
			return array('verifyuser' => 0, 'verifyaccess' => 0, 'postedpobal' => $postedpobal, 'unpostedpobal' => $unpostedpobal, 'postedsobal' => $postedsobal, 'unpostedsobal' => $unpostedsobal, 'bal' => $bal);
		} else {
			if($this->verifyaccess($controller->access['view'])) {
				$primarykey = $get['itemid'];
				$incomingbal = Yii::$app->backend->getIncomingItemBalance($primarykey);
				$data = Yii::$app->backend->getItembalance($primarykey,$get['factor']);

				$bal = 0;
			
				foreach ($data as $key => $value) {
					$bal += $data[0]['bal'];
				}//end for each

				$bal = number_format($bal,Yii::$app->systemsettings->setDecimaldisplay('currency'));

				if(empty($incomingbal)) {
					$postedpobal = 0; $unpostedpobal = 0; $postedsobal = 0; $unpostedsobal = 0;
				}else{
					$postedpobal = number_format($incomingbal[0]['postedpo'],2);
					$unpostedpobal = number_format($incomingbal[0]['unpostedpo'],2);
					$postedsobal = number_format($incomingbal[0]['postedso'],2);
					$unpostedsobal = number_format($incomingbal[0]['unpostedso'],2);
				}//end if
				
				return array('verifyuser'=>0,'verifyaccess'=>0,'postedpobal'=>$postedpobal,
				'unpostedpobal'=>$unpostedpobal,'postedsobal'=>$postedsobal,
				'unpostedsobal'=>$unpostedsobal, 'bal' => $bal);	 
			}else{
				return array('verifyuser'=>0,'verifyaccess'=>1);	
			}
		}
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}//end for sbcGetitembalance


public function sbcGetterms($controller){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['view'])){    			
		    $data = Yii::$app->backend->loadAvailableterms();
		    return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$data);		     
		 }else{
		    return array('verifyuser'=>0,'verifyaccess'=>1);	
	      }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}  //end for sbcGetterms



public function sbcGetuom($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['view'])){    			
			$barcode = $get['barcode'];
		    $itemid = Yii::$app->backend->requestItemid($barcode);
		    $data = Yii::$app->backend->loadAvailableuom($itemid,$controller->module->id);
		        return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$data);	 
		     }else{
		    return array('verifyuser'=>0,'verifyaccess'=>1);	
	      }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
} //end for sbcGetuom



public function sbcComparestocklines($controller,$post){

	    $itemdata = Yii::$app->backend->compareStocklines($controller,$post);
        $ischanged = $itemdata['ischanged'];
        $stockdata =$itemdata['stockdata'];
	    echo json_encode(array('ischanged'=>$ischanged,'stockdata'=>$stockdata));
        //echo json_encode(array('ischanged'=>0,'stockdata'=>$post));
}

public function sbcComparedetaillines($controller,$post){

	    $itemdata = Yii::$app->backend->compareDetaillines($controller,$post);
        $ischanged = $itemdata['ischanged'];
        $detaildata =$itemdata['detaildata'];
	    echo json_encode(array('ischanged'=>$ischanged,'detaildata'=>$detaildata));
}

public function sbcComparetaxmenulines($controller,$post){
	    $itemdata = Yii::$app->backend->comparetaxmenulines($controller,$post);
	    $ischanged = $itemdata['ischanged'];
        $termsdata =$itemdata['termsdata'];
	    echo json_encode(array('ischanged'=>$ischanged,'termsdata'=>$termsdata));

        //echo json_encode(array('ischanged'=>0,'stockdata'=>$post));
}



public function sbcQuickadditem($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['edit'])){    			

	     		$common = new Common;
	     		$length = $common->barcodelength();
	     		$barcode = $common->PadJ($get['barcode'], $length);
	
		        $params = array('barcode' => $barcode,'whcode' => $get['whcode'],'whname'=>$get['whname']);
		        $params = Yii::$app->backend->sanitize($params,'ARRAY');   			
		        $data = Yii::$app->backend->itemQuickadd($controller,$params);
		       	
		       	if($data['errmsg'] == ""){
		       		foreach ($data['primarydata'] as $key => $value) {
			       		foreach ($value as $key2 => $value2) {
			       			$moduledata[$key2] = $value2;	
			       		}//end 
			       	}//end for each

			       	$moduledata['trno'] = $get['trno'];
			       	$moduledata['refx'] = 0;
			       	$moduledata['linex'] = 0;
			       	$moduledata['ref'] = 0;

			       	$moduledata['qty']=$get['qty']; 
			       	$moduledata['rrqty']=$get['qty'];
			       	$moduledata['iss']=$get['qty'];
			       	$moduledata['isqty']=$get['qty'];

			       	$moduledata['amt']=$get['amt'];
			       	$moduledata['rrcost']=$get['amt'];
			       	$moduledata['isamt']=$get['amt'];
			       	$moduledata['cost']=$get['amt'];
			       	$moduledata['ext']=$get['amt']*$get['qty'];
			       	
			       	switch (Yii::$app->systemsettings->companyConfig()) {
			       		case 'CANUMAY':
							$moduledata['msako'] = 0;
							$moduledata['tsako'] = 0;			       			
			       		break;
			       	}//END WITCH

			       	$moduledata['line'] = 0;
			       	$moduledata["kgs"]= 0;

			       	$returndata = Yii::$app->webprocess->savingstock($controller,$controller->access['save'],$moduledata);
				    $return['stockline']['gvrow-'.$returndata['line']] = $returndata;
				    $return['line'] = $returndata['line'];          
				    
				    echo json_encode($return);
		       	}else{
		       		echo json_encode(array('primarydata' => $data['primarydata'],'errmsg'=>$data['errmsg']));
		       	}//end if
	    }else{
		  	return array('verifyuser'=>0,'verifyaccess'=>1);	
	    }//end if
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}//end if
}//end


public function sbcQuickaddtax($controller,$get){
	try {
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['edit'])){    			
			$params = array('name' => $get['taxname'],'atc' => $get['taxatc'],'rate'=>$get['taxrate'],
			'taxincome'=>$get['taxincome'],'taxwheld'=>$get['taxwheld'],
			'taxmonth'=>$get['taxmonth'],'line'=>$get['line'],'trno'=>$get['x']);

			$status = Yii::$app->backend->itemQuickaddtax($controller,$params); 
			$gettotal = Ladetail::getgrandtotal($get['x'],'TW');

			if(!empty($gettotal)){                
			    $runningdb = $gettotal[0]['totaldb'];
			    $runningcr = $gettotal[0]['totalcr'];
			}else{
			    $runningdb = 0;
			    $runningcr = 0;
			}//end if

			return array('verifyuser'=>0,'verifyaccess'=>0,'status' => $status,'runningdb'=>$runningdb,'runningcr'=>$runningcr);
     	}else{
	  	    return array('verifyuser'=>0,'verifyaccess'=>1);	
      	}//end if
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}

		
	} catch (ErrorException $e) {
		echo $e;
	}
}




public function sbcReqprice($controller,$get){
	try {
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['edit'])){    			
		    switch ($controller->module->id) {
			    case 'SJ2':
			        $doc = 'SJ';
			    break;


			    case 'quotation':
			    	$doc = 'QT';
			    break;
			      
			    default:
			        $doc = $controller->module->id;
			    break;
			}//END SWITCH
	        
	        switch (Yii::$app->systemsettings->companyConfig()) {
	        	case 'UNIVERSE':
	        		$params = array('barcode'=>$get['params']['barcode'],'ccode'=>$get['params']['clientcode'],'doc'=>$doc,'wh' => $get['params']['wh']);
	        	break;

	        	default:
	        		$params = array('barcode'=>$get['params']['barcode'],'ccode'=>$get['params']['clientcode'],'doc'=>$doc);
	        	break;
	        }//end switch case

	        $pricing = Yii::$app->backend->requestItemprice($params);
	        
		    return array('verifyuser'=>0,'verifyaccess'=>0,'pricedata'=>$pricing);	
	     }else{
		    return array('verifyuser'=>0,'verifyaccess'=>1);	
	      }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
	} catch (ErrorException $e) {
		echo $e;
	}
}


public function sbcContrasearch($controller,$get){
Yii::$app->view->params['msg']='';
if($this->verifyuser()){
     if($this->verifyaccess($controller->access['view'])){    			
     	
     	
		    $searchstring = $get['x'];
		    $searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');

	        $searchitems = Yii::$app->backend->searchContra($controller,$controller->access['view'],$searchstring);
      	    return array('verifyuser'=>0,'verifyaccess'=>0,'searchitems' => $searchitems);	
	     }else{
    	    return array('verifyuser'=>0,'verifyaccess'=>1);	
      }
}else{
	return array('verifyuser'=>1,'verifyaccess'=>0);	
}
}



public function sbcRequestclientpo($controller,$get){
	try {
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['view'])){    			
	        $clientcode = $get['ccode'];
	        $whcode = $get['whc'];
	        $type=$get['type'];
	        $searchparam = $get['searchparam'];
	        $doc = $controller->module->id;
	        $searchparam = Yii::$app->backend->sanitize($searchparam,'DEFAULT');
	        $clientpo = Yii::$app->backend->getClientOrder($whcode,$doc,$clientcode,$type,$searchparam);
	        return array('verifyuser'=>0,'verifyaccess'=>0,'clientpo'=>$clientpo,'type'=>$type);	
		     }else{
		    return array('verifyuser'=>0,'verifyaccess'=>1);	
	      }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	 }
	 } catch (ErrorException $e) {
		echo $e;
	}
}


public function sbcRetrieveorderdata($controller,$get){
		Yii::$app->view->params['msg']='';
		if($this->verifyuser()){
		     if($this->verifyaccess($controller->access['view'])){    			
		        $params = $get['params'];
		        $type = $get['returntype'];
		        $doc = $controller->module->id;
		       	$data = Yii::$app->backend->retrieveOrderdata($doc,$params,$type);		
			    return array('verifyuser'=>0,'verifyaccess'=>0,'returntype'=>$type,'podata'=>$data);	
			  }else{
			    return array('verifyuser'=>0,'verifyaccess'=>1);	
		      }
		}else{
			return array('verifyuser'=>1,'verifyaccess'=>0);	
		}
}



public function sbcAdjustinventory($controller,$get){
	try {
		Yii::$app->view->params['msg']='';
		if($this->verifyuser()){
		     if($this->verifyaccess($controller->access['edit'])){    			
				    $trno = $get['trno'];
				    $docno = Yii::$app->webprocess->adjustitem($trno);
				    $msg = Yii::$app->session['warning'];
				    Yii::$app->session['warning'] = "";
	    		    return array('verifyuser'=>0,'verifyaccess'=>0,'status'=>1,'error_msg'=>$msg,'ref'=>$docno);
			  }else{
			    return array('verifyuser'=>0,'verifyaccess'=>1);	
		      }
		}else{
			return array('verifyuser'=>1,'verifyaccess'=>0);	
		}//end if
	} catch (ErrorException $e) {
		return array('verifyuser'=>0,'verifyaccess'=>0,'status'=>0,'error_msg'=>'ErrorException, Please Check.','ref'=>'');
		
	}//end try catch
}//end sbcadjust inventory



//########################################################## GJ UPDATE JAOSKI
public function sbcDetailclientlookupsearch($controller,$get){
	Yii::$app->view->params['msg']='';
		if($this->verifyuser()){
		     if($this->verifyaccess($controller->access['view'])){    			
		     		$doc = $controller->module->id;
		     		$get['searchstring'] = Yii::$app->backend->sanitize($get['searchstring'],'DEFAULT');
			        $data = Yii::$app->backend->searchClient($controller,$controller->access['view'],$get['searchstring']);
		      	    return array('verifyuser'=>0,'verifyaccess'=>0,'data' => $data);	
			     }else{
		    	    return array('verifyuser'=>0,'verifyaccess'=>1);	
		      }
		}else{
			return array('verifyuser'=>1,'verifyaccess'=>0);	
		}
}//END FUNCTION




public function sbcLoadclientunpaid($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['view'])){    			
	     		$doc = $controller->module->id;
	     		$ccode = $get['clientcode'];
	     		$searchparam = $get['searchparam'];
	     		$searchparam = Yii::$app->backend->sanitize($searchparam,'DEFAULT');
		        $unpaid = Yii::$app->backend->requestUnpaidAccounts($doc,$ccode,$searchparam);
	      	    return array('verifyuser'=>0,'verifyaccess'=>0,'unpaidacc' => $unpaid);	
		     }else{
	    	    return array('verifyuser'=>0,'verifyaccess'=>1);	
	      }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}//end 




public function sbcRetrieveunpaid($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['view'])){    			
	     		$doc = $controller->module->id;
	     		if(!isset($get['lookuptype'])){
	     			$get['lookuptype'] = '';;
	     		}//end if
		        $unpaid = Yii::$app->backend->retrieveSelectedUnpaid($get['ccode'],$get['params'],$get['lookuptype']);
	      	    return array('verifyuser'=>0,'verifyaccess'=>0,'unpaid' => $unpaid);	
		     }else{
	    	    return array('verifyuser'=>0,'verifyaccess'=>1);	
	      }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}//end 


//########################################################## GJ UPDATE JAOSKI



public function sbcLoadchecks($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['view'])){    			
	     		$doc = $controller->module->id;
	     		if(!empty($get['clientcode']) || isset($get['clientcode'])){
	     			$ccode = $get['clientcode'];
	     		}else{
	     			$ccode = '';
	     		}
		        $checks = Yii::$app->backend->requestloadchecks($doc,$ccode);
	      	    return array('verifyuser'=>0,'verifyaccess'=>0,'checks' => $checks);	
		     }else{
	    	    return array('verifyuser'=>0,'verifyaccess'=>1);	
	      }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}//end 

public function sbcRetrievechecks($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['view'])){    			
	     		$doc = $controller->module->id;
	     		if(!empty($get['ccode']) && isset($get['ccode'])){
	     			$ccode = $get['ccode'];
	     		}else{
	     			$ccode = '';
	     		}
		        $checksdata = Yii::$app->backend->retrieveSelectedChecks($ccode,$get['params']);
	      	    return array('verifyuser'=>0,'verifyaccess'=>0,'checksdata' => $checksdata);	
		     }else{
	    	    return array('verifyuser'=>0,'verifyaccess'=>1);	
	      }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}//end 


public function sbcSetKRref($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['view'])){    			
	     		$doc = $controller->module->id;
		        $updateddata = Yii::$app->backend->setKRref($get['params'],$get['kr'],'SETKR');
	      	    return array('verifyuser'=>0,'verifyaccess'=>0,'updateddata' => $updateddata);	
		     }else{
	    	    return array('verifyuser'=>0,'verifyaccess'=>1);	
	      }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}//end 

public function sbcrequestDistro($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['view'])){    			
	     		$doc = $controller->module->id;
		        $distro = Yii::$app->backend->getDistributionlist($get['trno']);
	      	    return array('verifyuser'=>0,'verifyaccess'=>0,'distro' => $distro);	
		     }else{
	    	    return array('verifyuser'=>0,'verifyaccess'=>1);	
	      }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}//end 

public function sbcReportcustomerlookupsearch($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){	
		if($this->verifyaccess(22)){    			
			$searchstring = $get['searchstring'];
			$type = $get['type'];
			$searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');
			$searchclient = Yii::$app->backend->ReportsearchClient($controller->access['view'],$searchstring,$type);
	   		return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$searchclient);	
	   	}else{
	    	return array('verifyuser'=>0,'verifyaccess'=>1);	
	   	}
	}else{
	   return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}//end


public function sbcReportsupplierlookupsearch($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){	
		if($this->verifyaccess(32)){    			
			$searchstring = $get['searchstring'];
			$type = $get['type'];
			$searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');
			$searchclient = Yii::$app->backend->ReportsearchClient($controller->access['view'],$searchstring,$type);
	   		return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$searchclient);	
	   	}else{
	    	return array('verifyuser'=>0,'verifyaccess'=>1);	
	   	}
	}else{
	   return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}//end

public function sbcReportwarehouselookupsearch($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){	
		if($this->verifyaccess(52)){    			
			$searchstring = $get['searchstring'];
			$type = $get['type'];
			$searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');
			$searchclient = Yii::$app->backend->ReportsearchClient($controller->access['view'],$searchstring,$type);
	   		return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$searchclient);	
	   	}else{
	    	return array('verifyuser'=>0,'verifyaccess'=>1);	
	   	}
	}else{
	   return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}//end

public function sbcVoidItem($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){	
		$params = Yii::$app->backend->sanitize($get,'ARRAY');
		$doc = $controller->module->id;
		$voiding = Yii::$app->backend->voidItem($doc,$params['trno'],$params['line'],$params['voidval'],$params['approvedby']);
		return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$voiding);		 
	}else{
	   return array('verifyuser'=>1,'verifyaccess'=>0);	
	}//end function
}//end

//jac
public function sbcComparepdclines($controller,$post){
	    $itemdata = Yii::$app->backend->comparepdclines($controller,$post);
	    $ischanged = $itemdata['ischanged'];
        $pdcdata =$itemdata['pdcdata'];
	    echo json_encode(array('ischanged'=>$ischanged,'pdcdata'=>$pdcdata));

        //echo json_encode(array('ischanged'=>0,'stockdata'=>$post));
}

public function sbcComparetermslines($controller,$post){
	    $itemdata = Yii::$app->backend->comparetermslines($controller,$post);
	    $ischanged = $itemdata['ischanged'];
        $termsdata =$itemdata['termsdata'];
	    echo json_encode(array('ischanged'=>$ischanged,'termsdata'=>$termsdata));

        //echo json_encode(array('ischanged'=>0,'stockdata'=>$post));
}

// RTT MODIFICATIONS
public function sbcComparecategorylines($controller,$post){

	    $itemdata = Yii::$app->backend->comparecategorylines($controller,$post);
	    $ischanged = $itemdata['ischanged'];
        $categorydata =$itemdata['categorydata'];
	    echo json_encode(array('ischanged'=>$ischanged,'categorydata'=>$categorydata));
	
        //echo json_encode(array('ischanged'=>0,'stockdata'=>$post));
}

public function sbcCompareclasslines($controller,$post){

	    $itemdata = Yii::$app->backend->compareclasslines($controller,$post);
	    $ischanged = $itemdata['ischanged'];
        $classdata =$itemdata['classdata'];
	    echo json_encode(array('ischanged'=>$ischanged,'classdata'=>$classdata));
	
        //echo json_encode(array('ischanged'=>0,'stockdata'=>$post));
}

public function sbcComparecollectionlines($controller,$post){
		try {
	    $itemdata = Yii::$app->backend->comparecollectionlines($controller,$post);
	    $ischanged = $itemdata['ischanged'];
        $cllcdata =$itemdata['cllcdata'];
	    echo json_encode(array('ischanged'=>$ischanged,'cllcdata'=>$cllcdata));
	} catch (ErrorException $e) {
			echo $e;
			return 0;
		}
        //echo json_encode(array('ischanged'=>0,'stockdata'=>$post));
}

public function sbcComparedistributionlines($controller,$post){
		try {
	    $itemdata = Yii::$app->backend->comparedistributionlines($controller,$post);
	    $ischanged = $itemdata['ischanged'];
        $distdata =$itemdata['distdata'];
	    echo json_encode(array('ischanged'=>$ischanged,'distdata'=>$distdata));
	} catch (ErrorException $e) {
			echo $e;
			return 0;
		}
        //echo json_encode(array('ischanged'=>0,'stockdata'=>$post));
}

//END

public function sbcLoadpdcchecks($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
 		if(!empty($get) || isset($get)){
 			$ccode = $get;
 		}else{
 			$ccode = '';
 		}
        $pdcchecks ="select line,checkno,date(checkdate) as checkdate,amount,notes from hpostdatedchecks where client = '$ccode' and void <> 1 and refx =0";
  	    return $pdcchecks;
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}

public function sbcRetrievepdc($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['view'])){    			
	     		$doc = $controller->module->id;
	     		if(!empty($get['ccode']) && isset($get['ccode'])){
	     			$ccode = $get['ccode'];
	     		}else{
	     			$ccode = '';
	     		}
		        $pdcchecksdata = Yii::$app->backend->retrieveSelectedpdcChecks($ccode,$get['params']);

	      	    return array('verifyuser'=>0,'verifyaccess'=>0,'pdcchecksdata' => $pdcchecksdata);	
		     }else{
	    	    return array('verifyuser'=>0,'verifyaccess'=>1);	
	      }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}//retrieve pdc jac

public function sbcComparegenitemlines($controller,$post){
	    $itemdata = Yii::$app->backend->comparegenitemlines($controller,$post);
	    $ischanged = $itemdata['ischanged'];
        $genitem =$itemdata['genitem'];
        echo json_encode(array('ischanged'=>$ischanged,'genitem'=>$genitem));

        //echo json_encode(array('ischanged'=>0,'stockdata'=>$post));
}
//end jac

//TA
public function sbcRetrievefaitem($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['view'])){    			
	     		$doc = $controller->module->id;
	     		$faitem = Yii::$app->backend->insertSelectedfaitem($get);
	     		
	      	    return array('verifyuser'=>0,'verifyaccess'=>0,'faitem' => $faitem);	
		     }else{
	    	    return array('verifyuser'=>0,'verifyaccess'=>1);	
	      }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}//retrieve faitem jac

public function sbcSearchtaref($controller,$get){
	
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
		if($this->verifyaccess($controller->access['view']) && $this->verifyaccess($controller->access['new'])){    			
		    $docno = trim($get['docno']);
		    $params = array('docno' => $docno);
		    //$params = Yii::$app->backend->sanitize($params,'ARRAY');
		    $access = array('view' => $controller->access['view'],'new' => $controller->access['new']);

		    $data = Yii::$app->backend->openTransasset($docno);   	
		    
		    return array('verifyuser'=>0,'verifyaccess'=>0,'data'=>$data);	
		     }else{
		    return array('verifyuser'=>0,'verifyaccess'=>1);	
		  }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}

public function sbcPostfaitem($controller,$get){
	Yii::$app->view->params['msg']='';
	if($this->verifyuser()){
	     if($this->verifyaccess($controller->access['view'])){    			
	     		$doc = $controller->module->id;
	     		$ref = trim($get['ref']);
	     		$transfer = Yii::$app->backend->Postfaitem($ref);
	     		if ($transfer ==1){
	     			$faitem = Yii::$app->backend->openTransasset($ref);
	     		}else{
	     			$faitem = null;
	     		}
	     		
	      	    return array('verifyuser'=>0,'verifyaccess'=>0,'faitem' => $faitem);	
		     }else{
	    	    return array('verifyuser'=>0,'verifyaccess'=>1);	
	      }
	}else{
		return array('verifyuser'=>1,'verifyaccess'=>0);	
	}
}//post faitem jac
//end TA

// SC MODIFICATION

public function sbcComparemglines($controller,$post){

	    $itemdata = Yii::$app->backend->comparemglines($controller,$post);
	    $ischanged = $itemdata['ischanged'];
        $classdata =$itemdata['classdata'];
	    echo json_encode(array('ischanged'=>$ischanged,'classdata'=>$classdata));
	
        //echo json_encode(array('ischanged'=>0,'stockdata'=>$post));
}

public function sbcComparetglines($controller,$post){

	    $itemdata = Yii::$app->backend->comparetglines($controller,$post);
	    $ischanged = $itemdata['ischanged'];
        $classdata =$itemdata['classdata'];
	    echo json_encode(array('ischanged'=>$ischanged,'classdata'=>$classdata));
	
        //echo json_encode(array('ischanged'=>0,'stockdata'=>$post));
}

public function sbcComparecglines($controller,$post){

	    $itemdata = Yii::$app->backend->comparecglines($controller,$post);
	    $ischanged = $itemdata['ischanged'];
        $classdata =$itemdata['classdata'];
	    echo json_encode(array('ischanged'=>$ischanged,'classdata'=>$classdata));
	
        //echo json_encode(array('ischanged'=>0,'stockdata'=>$post));
}

public function sbcComparescglines($controller,$post){

	    $itemdata = Yii::$app->backend->comparescglines($controller,$post);
	    $ischanged = $itemdata['ischanged'];
        $classdata =$itemdata['classdata'];
	    echo json_encode(array('ischanged'=>$ischanged,'classdata'=>$classdata));
	
        //echo json_encode(array('ischanged'=>0,'stockdata'=>$post));
}

// SC END

}// COMPONENTS

?>