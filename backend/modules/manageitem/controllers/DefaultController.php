<?php
namespace backend\modules\manageitem\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use app\models\Item;
use app\models\Common;

use yii\base\ErrorException;

class DefaultController extends Controller{


     public $access = array(
        'view' => 22,'edit' => 23,'new' => 24,'save' => 25,
        'change' => 26,'delete' => 27,'print' => 28);

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    public function actionVerifyaccess($accesstype,$trno){      
        Yii::$app->backend->AjaxVerification($this); 
        $return = Yii::$app->sbccontroller->jverifyaccess($this,$this->access[$accesstype],$accesstype,$trno);
        echo json_encode(array('verified'=>$return)); 
    }


    //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
        if(Yii::$app->sbccontroller->verifyaccess($this->access['view'])){
            if(isset(Yii::$app->session['loggeduser'])){
                $moduleid = $this->module->id;
                Yii::$app->view->params['moduleid'] = $moduleid;
                $this->layout = "@app/views/layouts/backend/main";
                return $this->render('index',array('moduleid'=>$moduleid));
            }else{
                return $this->redirect(Url::to(['/admin/default/login']));
            }//END IF
        }else{
            return $this->redirect(Url::to(['/admin/default/401']));
        }//end if

    }//END ACTION INDEX

    public function actionLoadmanageitems() {
    	Yii::$app->backend->AjaxVerification($this);
    	// $params['controller'] = $this;
    	return Yii::$app->automator->loadManageitems();
    }


    public function actionGetclass(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateClasslookup($this);
    }

    public function actionGetbrand(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateBrandlookup($this);
    }

    public function actionGetgroup(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateGrouplookup($this);
    }//end action

    public function actionGetmodel(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateModellookup($this);
    }//end action

    public function actionSavemenuitem() {
    	Yii::$app->backend->AjaxVerification($this);
    	$params = Yii::$app->backend->sanitize($_POST,'ARRAY');
    	$item = new Item;
    	$common = new Common;
    	if($params['menutype'] == 'new') {
            $pref = "IT";
            $last_barcode=$item->getlast_barcode($pref);
            $start=$common->SearchPosition($last_barcode);
            $seq=substr($last_barcode, $start) +1;
            if(Yii::$app->systemsettings->setDefaultBarcodeLength() == 0) { $clseq= ""; } else { $clseq=$pref.$seq; }
            $length=$common->barcodelength();
            $new_barcode=$common->PadJ($clseq, $length);
            if($params['cost'] == '') {$params['cost'] = 0;}
            if($params['amt'] == '') {$params['amt'] = 0;}
            if($params['cooktime'] == '') {$params['cooktime'] = 0;}
            if($params['preptime'] == '') {$params['preptime'] = 0;}
            
            $qrychecker = "select part_id,part_name from part_masterfile where part_name = 'MENU'";
            $partdetails = Yii::$app->sbccommon->opentable($qrychecker);

            if(empty($partdetails)){
            	$qryinsert = "insert into part_masterfile(part_name) values('MENU')";
				$status = Yii::$app->sbccommon->execqry($qryinsert);
            	if($status){
            		$qryselect = "select part_id from part_masterfile where part_name = 'MENU'";
            		$partid = Yii::$app->sbccommon->datareader($qryselect);
            	}//end if
            }else{
            	$qryselect = "select part_id from part_masterfile where part_name = 'MENU'";
            	$partid = Yii::$app->sbccommon->datareader($qryselect);
            }//end if

    		if(Yii::$app->sbccommon->execqry("insert into item(barcode, itemname, shortname, class, brand, groupid, uom, cost, amt, kds, cooking_time, prep_time, istaxable, model, printer2, printer3, printer4, printer5, part) values('$new_barcode', '{$params['itemname']}', '{$params['shortname']}', '{$params['catid']}', '{$params['majcatid']}', '{$params['groupings']}', '{$params['uom']}', '{$params['cost']}', '{$params['amt']}', '{$params['kds']}', '{$params['cooktime']}', '{$params['preptime']}', '{$params['istaxable']}', '{$params['model1']}', '{$params['model2']}', '{$params['model3']}', '{$params['model4']}', '{$params['model5']}', '".$partid."')")) {
    			$uom = Yii::$app->sbccommon->opentable("select itemid, uom from item order by itemid desc limit 1");
    			Yii::$app->sbccommon->execqry("insert into uom(itemid, uom, factor) values('{$uom[0]['itemid']}', '{$uom[0]['uom']}', 1)");
    			$msg = "Saved";
    			$status = true;
    		} else {
    			$msg = "Error Saving";
    			$status = false;
    		}
    	} else {
    		if(Yii::$app->sbccommon->execqry("update item set itemname = '{$params['itemname']}', shortname = '{$params['shortname']}', class = '{$params['catid']}', brand = '{$params['majcatid']}', groupid = '{$params['groupings']}', uom = '{$params['uom']}', cost = '{$params['cost']}', amt = '{$params['amt']}', kds = '{$params['kds']}', cooking_time = '{$params['cooktime']}', prep_time = '{$params['preptime']}', istaxable = '{$params['istaxable']}', model = '{$params['model1']}', printer2 = '{$params['model2']}', printer3 = '{$params['model3']}', printer4 = '{$params['model4']}', printer5 = '{$params['model5']}', isinactive = '{$params['isinactive']}' where itemid = '{$params['itemid']}'")) {
    			$msg = "Updated";
    			$status = true;
    		} else {
    			$msg = "Error Updating";
    			$status = false;
    		}
    	}
    	return json_encode(array('msg'=>$msg,'status'=>$status));
    }


    public function actionGetitem() {
    	Yii::$app->backend->AjaxVerification($this);
    	$barcode = $_GET['barcode'];
    	$data = Yii::$app->sbccommon->opentable("select item.itemid, item.barcode, class.cl_name as classname, item.class as catid, brand.brand_desc as brand, item.itemname, item.shortname,
    		`group`.stockgrp_name as groupname, item.uom, item.cost, item.amt, item.kds, item.cooking_time, item.prep_time, item.istaxable, model1.model_name as printer1,
    		model2.model_name as printer2, model3.model_name as printer3, model4.model_name as printer4, model5.model_name as printer5, item.model as printerid1,
    		item.printer2 as printerid2, item.printer3 as printerid3, item.printer4 as printerid4, item.printer5 as printerid5, item.brand as brandid, item.groupid,
    		item.isinactive, itimages.picture from item
    			left join item_class as class on class.cl_id = item.class
    			left join frontend_ebrands as brand on brand.brandid = item.brand
    			left join stockgrp_masterfile as `group` on `group`.stockgrp_id = item.groupid
    			left join model_masterfile as model1 on model1.model_id = item.model
    			left join model_masterfile as model2 on model2.model_id = item.printer2
    			left join model_masterfile as model3 on model3.model_id = item.printer3
    			left join model_masterfile as model4 on model4.model_id = item.printer4
    			left join model_masterfile as model5 on model5.model_id = item.printer5
    			left join itimages on itimages.codeid = item.itemid
    		where item.barcode = '$barcode'");
    	return json_encode(array('data'=>$data));
    }


    public function actionItemlookupsearch(){                 
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateItemlookupGV($params);
    }

    public function actionLoadcomponentitems() {
    	Yii::$app->backend->AjaxVerification($this);
    	$params = $_POST;
    	$params['controller'] = $this;
    	return Yii::$app->automator->automateComponentitems($params);
    }

    public function actionLoadsetmenuchoicesmenu() {
    	Yii::$app->backend->AjaxVerification($this);
    	$params = $_POST;
    	$params['controller'] = $this;
    	return Yii::$app->automator->automateSetmenuchoicesmenu($params);
    }

    public function actionLoadsetchoices() {
    	Yii::$app->backend->AjaxVerification($this);
    	$params = $_POST;
    	$params['controller'] = $this;
    	return Yii::$app->automator->automateSetChoices($params);
    }

    public function actionLoadsetmenuchoices() {
    	Yii::$app->backend->AjaxVerification($this);
    	$params = $_POST;
    	$params['controller'] = $this;
    	return Yii::$app->automator->automateSetmenuChoices($params);
    }


	public function actionGetitembalance(){
		Yii::$app->backend->AjaxVerification($this);
		$params = $_GET;
		$return=Yii::$app->sbccontroller->sbcGetitembalance($this,$params);  
		if($return['verifyuser']==1) {
			return $this->redirect(Url::to(['/admin/default/login']));
		} elseif($return['verifyaccess']==1) {
			return $this->redirect(Url::to(['/admin/default/401']));
		} else {
			echo json_encode(array('postedpobal'=>$return['postedpobal'],
			'unpostedpobal'=>$return['unpostedpobal'],'postedsobal'=>$return['postedsobal'],
			'unpostedsobal'=>$return['unpostedsobal'],'bal'=>$return['bal']));
		}
	}

	public function actionLoaditembal() {
		Yii::$app->backend->AjaxVerification($this);
		$params = $_POST;
		$params['controller'] = $this;
		return Yii::$app->automator->automateItembal($params);
	}


	public function actionSavecomponentitem() {
		Yii::$app->backend->AjaxVerification($this);
		$params = Yii::$app->backend->sanitize($_GET,'ARRAY');
		$data = [];
		if($params['line'] == '0') { // new record
			if(Yii::$app->sbccommon->execqry("insert into component(itemid, barcode, itemname, isqty, qty, uom) values('{$params['itemid']}', '{$params['barcode']}', '{$params['itemname']}', '{$params['qty']}', '{$params['qty']}', '{$params['uom']}')")) {
				$data = Yii::$app->sbccommon->opentable("select line, itemid from component where itemid = '{$params['itemid']}' order by line desc limit 1");
				$msg = "Component Saved";
				$status = true;
			} else {
				$msg = "Error Saving Component";
				$status = false;
			}
		} else { // update record
			if(Yii::$app->sbccommon->execqry("update component set qty = '{$params['qty']}', isqty = '{$params['qty']}' where line = '{$params['line']}'")) {
				$msg = "Component Updated";
				$status = true;
			} else {
				$msg = "Error Updating Component";
				$status = false;
			}
		}
		return json_encode(array('data'=>$data,'msg'=>$msg,'status'=>$status));
	}

	public function actionSavequickadds() {
		Yii::$app->backend->AjaxVerification($this);
		$params = Yii::$app->backend->sanitize($_POST,'ARRAY');
		$data = [];
		if($params['txt'] == '') {
			$msg = "Please enter".$params['type'];
			$status = false;
		} else {
			switch($params['type']) {
				case 'Category':

					if(Yii::$app->sbccommon->execqry("insert into item_class(cl_name) values('{$params['txt']}')")) {
						$data = Yii::$app->sbccommon->opentable("select cl_id as line from item_class order by line desc limit 1");
						$msg = "Category Saved";
						$status = true;
					} else {
						$msg = "Error Saving Category";
						$status = false;
					}
				break;
				case 'Major Category':
					if(Yii::$app->sbccommon->execqry("insert into frontend_ebrands(brand_desc,isenabled) values('{$params['txt']}', 1)")) {
						$data = Yii::$app->sbccommon->opentable("select brandid as line from frontend_ebrands order by line desc limit 1");
						$msg = "Major Category Saved";
						$status = true;
					} else {
						$msg = "Error Saving Major Category";
						$status = false;
					}
				break;
				case 'Groupings':
					if(Yii::$app->sbccommon->execqry("insert into stockgrp_masterfile(stockgrp_name) values('{$params['txt']}')")) {
						$data = Yii::$app->sbccommon->opentable("select stockgrp_id as line from stockgrp_masterfile order by line desc limit 1");
						$msg = "Group Saved";
						$status = true;
					} else {
						$msg = "Error Saving Group";
						$status = false;
					}
				break;
				case 'Printer':
					if(Yii::$app->sbccommon->execqry("insert into model_masterfile(model_name) values('{$params['txt']}')")) {
						$data = Yii::$app->sbccommon->opentable("select model_id as line from model_masterfile order by line desc limit 1");
						$msg = "Printer Saved";
						$status = true;
					} else {
						$msg = "Error Saving Printer";
						$status = false;
					}
				break;
			}
		}
		return json_encode(array('data'=>$data,'msg'=>$msg,'status'=>$status));
	}

	public function actionGetsetmenu() {
		Yii::$app->backend->AjaxVerification($this);
		waw:
			$setmenu = Yii::$app->sbccommon->opentable("select cl_id, cl_name from item_class where cl_name = 'SET MENU' order by cl_id desc limit 1");
			if(!empty($setmenu)) {
				return json_encode(array('setmenu'=>$setmenu));
			} else {
				Yii::$app->sbccommon->opentable("insert into item_class(cl_name) values('SET MENU')");
				goto waw;
			}
	}

	public function actionSavechoicemenuitem() {
		Yii::$app->backend->AjaxVerification($this);
		$params = $_GET;
		$checking = Yii::$app->sbccommon->opentable("select * from setmenuchoices where choices='{$params['choicename']}' 
			and itemid='{$params['choiceitemid']}' and setmenuid='{$params['itemid']}'");
		if(empty($checking)){
			if(Yii::$app->sbccommon->execqry("insert into setmenuchoices(choices,itemid,setmenuid) values('{$params['choicename']}', '{$params['choiceitemid']}','{$params['itemid']}')")) {
				$msg = "Saved";
				$status = true;
			} else {
				$msg = "Error Saving";
				$status = false;
			}
		}else{
				$msg = "Cannot add existing items. Please Try Again.";
				$status = false;
		}
		return json_encode(array('msg'=>$msg,'status'=>$status));
	}//end f
	
	public function actionSavemenuchoice() {
		Yii::$app->backend->AjaxVerification($this);
		$params = $_GET;
		$data = [];
		$checking = Yii::$app->sbccommon->opentable("select * from setmenu where choices='{$params['choices']}' and itemid='{$params['itemid']}'");
		if(empty($checking)){
				if(Yii::$app->sbccommon->execqry("insert into setmenu(choices,itemid,qty) values('{$params['choices']}', '{$params['itemid']}', '{$params['qty']}')")) {
					$data = Yii::$app->sbccommon->opentable("select line from setmenu order by line desc limit 1");
					$msg = "Saved";
					$status = true;
				} else {
					$msg = "Error Saving";
					$status = false;
				}
			
		}else{
				$msg = "Duplicate choice found, Cannot save entry. Please Try Again.";
				$status = false;
		}
		return json_encode(array('data'=>$data,'msg'=>$msg,'status'=>$status));
	}//end f


	public function actionDeletechoicemenuitem() {
		Yii::$app->backend->AjaxVerification($this);
		$type = $_POST['type'];
		$line = $_POST['line'];
		if($type == 'choice') {
			if(Yii::$app->sbccommon->execqry("delete from setmenu where line = $line")) {
				if(Yii::$app->sbccommon->execqry("delete from setmenuchoices where setmenuid = $line")) {
					$msg = "Deleted";
					$status = true;
				} else {
					$msg = "Error Deleting Set Menu Choices";
					$status = false;
				}
			} else {
				$msg = "Error Deleting Set Menu";
				$status = false;
			}
		} else {
			if(Yii::$app->sbccommon->execqry("delete from setmenuchoices where line = $line")) {
				$msg = "Deleted";
				$status = true;
			} else {
				$msg = "Error Deleting Set Menu Choices";
				$status = false;
			}
		}
		return json_encode(array('msg'=>$msg,'status'=>$status));
	}


	public function actionSavemenuimg(){
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
        $files = $_FILES;
		$file_name =$_FILES['picturefile']['name'];
		$file_tmp= $_FILES['picturefile']['tmp_name'];
		$file_size=$_FILES['picturefile']['size'];
		$filearray = explode('.',$file_name);
		$file_ext = strtolower(end($filearray));
		$allowed_ext= array('jpg','jpeg','png');

		if(!in_array($file_ext,$allowed_ext)) {
			$msg = 'Extension not allowed , allowed file extensions are (jpg,jpeg,png)';
			$status = false;
		} else {
			if($file_size > 2097152){
				$msg = "File suze must be under 2mb";
				$status = false;
			} else {
				$type = pathinfo($file_tmp, PATHINFO_EXTENSION);
				$data = file_get_contents($file_tmp);
				$primarykey = $_POST['itemid'];
				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data); //STRING TO BE SAVED TO DATABASE
				// $base64 = base64_encode($data); //STRING TO BE SAVED TO DATABASE
				$item = Yii::$app->sbccommon->opentable("select codeid from itimages where codeid = '$primarykey'");
				if(empty($item)) {
					if(Yii::$app->sbccommon->execqry("insert into itimages(codeid,picture,filename) values('$primarykey','$base64','')")) {
						$msg = "Photo Saved";
						$status = true;
					} else {
						$msg = "Error Saving Photo";
						$status = false;
					}
				} else {
					if(Yii::$app->sbccommon->execqry("update itimages set picture = '$base64' where codeid = '$primarykey'")) {
						$msg = "Photo Updated";
						$status = true;
					} else {
						$msg = "Error Updating Photo";
						$status = false;
					}
				}
			}//end else for file_size validation
		}//end else for extension validation
		return json_encode(array('msg'=>$msg,'status'=>$status));
    }

    public function actionGetmenuimg() {
    	Yii::$app->backend->AjaxVerification($this);
    	$itemid = $_POST['itemid'];
    	$img = Yii::$app->sbccommon->opentable("select picture from itimages where codeid = '$itemid'");
    	if(!empty($img)) { $image = $img[0]['picture']; } else { $image = ''; }
    	return json_encode(array('img'=>$image));
    }


    public function actionDeletemenuimg() {
    	Yii::$app->backend->AjaxVerification($this);
    	$itemid = $_POST['itemid'];
    	if(Yii::$app->sbccommon->execqry("delete from itimages where codeid = '$itemid'")) {
    		$msg = "Photo Removed";
    		$status = true;
    	} else {
    		$msg = "Error Removing Photo";
    		$status = false;
    	}
    	return json_encode(array('msg'=>$msg,'status'=>$status));
    }

	public function actionSkinsavecolor(){
			Yii::$app->backend->AjaxVerification($this);
	    	$params = $_GET;
			$hex = $params['color'];
			list($r, $g, $b) = sscanf($hex, "%02x%02x%02x");
			$qry = "update item_class set skincolor='rgb(".$r.",".$g.",".$b.")' where cl_id =".$params['line'] ;
			$valid = Yii::$app->sbccommon->execqry($qry);
			return $valid;
	}//end f

	public function actionFontsavecolor(){
			Yii::$app->backend->AjaxVerification($this);
	    	$params = $_GET;
			$hex = $params['color'];
			list($r, $g, $b) = sscanf($hex, "%02x%02x%02x");
			$qry = "update item_class set fontcolor='rgb(".$r.",".$g.",".$b.")' where cl_id =".$params['line'] ;
			$valid =  Yii::$app->sbccommon->execqry($qry);
			return $valid;

	}//end f

	public function actionDeletecomponentitem() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $data = [];
            if(Yii::$app->sbccommon->execqry("delete from component where itemid={$params['itemid']} and line={$params['line']}")) {
                $msg = "Component Deleted";
                $status = true;
            } else {
                $msg = "Error Deleting Component";
                $status = false;
            }
        return json_encode(array('data'=>$data,'msg'=>$msg,'status'=>$status));
    }//end f

    public function actionDeleteitem(){
        $xxx = $_GET['params'];
        $xxx = Yii::$app->backend->sanitize($xxx,'ARRAY');
        $data = Yii::$app->weblisting->deletingitem($this,$this->access['delete'],$xxx);
        echo json_encode(array('moduledata' => $data));
    }
}//END CONTROLLER