<?php

namespace backend\modules\changeitem\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\ErrorException;
use app\models\Item;


use yii\web\Response;
class DefaultController extends Controller{

    public $access = array(
        'view' => 12,'edit' => 13,'new' => 14,'save' => 15,
        'change' => 16,'delete' => 17,'print' => 18);
    
    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
        $this->layout = "@app/views/layouts/backend/main";
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        $data = Yii::$app->sbccommon->opentable("select itemid,barcode,itemname,groupid,part,model,brand,sizeid,uom,minimum,maximum,amt,cost,'' as search from item order by barcode limit 100");
        return $this->render('index',array('moduledata'=>$data,'moduleid'=>$moduleid));
    }//END ACTION INDEX


    public function actionChangeitemsaving(){
        $params = $_GET;
        $prevamtqry = 'select amt from item where itemid =' . $params['itemid'];
        $prevamt = Yii::$app->sbccommon->datareader($prevamtqry);

        $qry = "update item set itemname = '{$params['itemname']}',
                brand = '{$params['brand']}', 
                groupid = '{$params['grpid']}', 
                model = '{$params['modelid']}', 
                part = '{$params['partid']}', 
                sizeid = '{$params['sizeid']}', 
                amt = '{$params['amt']}',
                maximum = '{$params['maximum']}', 
                minimum = '{$params['minimum']}' 
                where itemid = '{$params['itemid']}'";
        $data = Yii::$app->sbccommon->execqry($qry);

        if($data){
            $newamt = Yii::$app->backend->getStockcardDatafield($params['itemid'],'amt');
            $newamt = str_replace(",", "", $newamt);
            $prevamt = str_replace(",", "", $prevamt);
            if($newamt != $prevamt){
                $timeupdate = Yii::$app->systemsettings->getCurrentTimeStamp();
                $user=Yii::$app->session['loggeduser']['username'];
                $barcode = Yii::$app->backend->getStockcardDatafield($params['itemid'],'barcode');

                $amthistoryqry = "insert into itemamthistory (barcode,dateupdated,prevamt,recentamt,updatedby,fieldupdate)
                                  values('".$barcode."','".$timeupdate."','".$prevamt."','".$newamt."','".$user."','amt')";
                Yii::$app->sbccommon->execqry($amthistoryqry);
            }//emnd if
        }//end if
    }//end funciton


    public function actionBuildstockview(){
        Yii::$app->backend->AjaxVerification($this);
        $txt = Yii::$app->backend->sanitize($_POST['x'],'DEFAULT');
        $sql = Yii::$app->tblgenerator->getStockViewQuery($this->module->id,$txt);
        $params = [
            'sql' => $sql,
            'tableid' => 'changeitemstockview',
            'key' => 'itemid',
            'txtclass' => 'changeitemtxt',
            'checkbox' => true,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'class' => 'col-codes aimslabel changetxt'
                ],[
                    'name' => 'itemname',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-description aimslabel changetxt'
                ],[
                    'name' => 'uom',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'class' => 'col-min aimslabel changetxt'
                ],[
                    'name' => 'amt',
                    'label' => 'Price',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes aimslabel changetxt'
                ],[
                    'name' => 'brand',
                    'editable' => true,
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall' => 'brand',
                                        'colw' => 'col-min',
                                        'lookupclass' => 'gvbtns brandchangelookup',
                                        'lookuptxtclass' => 'minitxtcombo']
                ],[
                    'name' => 'groupid',
                    'label' => 'Group',
                    'editable' => true,
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall' => 'group',
                                        'colw' => 'col-min',
                                        'lookupclass' => 'gvbtns stockgrouplookup',
                                        'lookuptxtclass' => 'minitxtcombo']
                ],[
                    'name' => 'grpid',
                    'hidden' => true,
                    'class' => 'changetxt txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'model',
                    'editable' => true,
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall' => 'model',
                                        'colw' => 'col-min',
                                        'lookupclass' => 'gvbtns stockmodellookup',
                                        'lookuptxtclass' => 'minitxtcombo']
                ],[
                    'name' => 'modelid',
                    'hidden' => true,
                    'class' => 'changetxt txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'part',
                    'editable' => true,
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall' => 'part',
                                        'colw' => 'col-min',
                                        'lookupclass' => 'gvbtns stockpartlookup',
                                        'lookuptxtclass' => 'minitxtcombo']
                ],[
                    'name' => 'partid',
                    'hidden' => true,
                    'class' => 'changetxt txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'sizeid',
                    'label' => 'Size',
                    'editable' => true,
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall' => 'size',
                                        'colw' => 'col-min',
                                        'lookupclass' => 'gvbtns stocksizelookup',
                                        'lookuptxtclass' => 'minitxtcombo']
                ],[
                    'name' => 'maximum',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes aimslabel changetxt'
                ],[
                    'name' => 'minimum',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes aimslabel changetxt'
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'default' => '0',
                    'class' => 'txthidden changetxt'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'changeitemsave gvbtns btn btn-social-icon btn-bitbucket',
                ]
            ]
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function actionGetiteminfo(){
        $params = $_GET;
        $item = new Item;
        $returnval = $item->openitem($params['itemid']);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['changeditem'=>$returnval];
        //echo json_encode(array('changeditem'=>$returnval));
    }//end function

    public function actionSearchiteminfo(){
        $params = $_GET;
        $data = Yii::$app->sbccommon->opentable("select itemid,barcode,itemname,ifnull(gg.stockgrp_name,'') groupid,
            ifnull(pp.part_name,'') as part,ifnull(mm.model,'') as model,
            brand,sizeid,uom,minimum,maximum,amt,'' as search from item 
            left join model_masterfile as mm on mm.model_id = item.model
            left join part_masterfile as pp on pp.part_id = item.part
            left join stockgrp_masterfile as gg on gg.stockgrp_id = item.groupid
            where item.itemname 
            like '%".$params['searchstring']."%' or barcode like '%".$params['searchstring']."%'
            or uom like '%".$params['searchstring']."%' or brand like '%".$params['searchstring']."%'
            or gg.stockgrp_name like '%".$params['searchstring']."%' or mm.model_name like '%".$params['searchstring']."%'
            or pp.part_name like '%".$params['searchstring']."%'
            or item.sizeid like '%".$params['searchstring']."%' or item.amt like '%".$params['searchstring']."%'
            or item.maximum like '%".$params['searchstring']."%'
            or item.minimum like '%".$params['searchstring']."%'
            order by item.barcode limit 100");
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['changeditem'=>$data];
        //echo json_encode(array('changeditem'=>$data));
    }//end function
    
    public function actionGetbrand(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateBrandlookup($params);
    }//end fn

    public function actionGetpart(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automatePartlookup($params);
    }

    public function actionGetmodel(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateModellookup($params);
    }//end action

    public function actionGetsize(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateSizelookup($params);
    }//end action

    public function actionGetgroup(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateGrouplookup($params);
    }//end action
}
