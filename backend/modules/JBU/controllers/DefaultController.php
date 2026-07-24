<?php

namespace backend\modules\JBU\controllers;

use Yii;
use yii\web\Controller;

use yii\helpers\Url;
use app\models\Webproc;
use app\models\Client;
use app\models\Lastock;
use app\models\Pohead;
use app\models\Log;

use yii\base\ErrorException;

class DefaultController extends Controller{
	public $access = array('view' => 769,'edit' => 770,'new' => 771,
        'save' => 772,'change' => 773,'delete' => 774,'print' => 775,
        'lock' => 776,'unlock' => 777,'post' => 778,'unpost' => 779,
        'viewdetails' => 783,'changeamount' => 780,'autocompute' => 782,'crlimit' =>781,
        'clickadditem'=>871,'clickedititem'=>872,'clickdeleteitem'=>873);
	
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionVerifyaccess($accesstype,$trno){      
        Yii::$app->backend->AjaxVerification($this); 
        $return = Yii::$app->sbccontroller->jverifyaccess($this,$this->access[$accesstype],$accesstype,$trno);
        echo json_encode(array('verified'=>$return)); 
    }//end fn 

    public function actionIndex(){   
        $return=Yii::$app->sbccontroller->sbcindex($this);
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           return $this->render('index',array('moduledata' => $return['moduledata'],'moduleid'=>$return['moduleid']));        
        }
    }//END ACTION INDEX

    public function actionJbudocsgrid(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_POST;

        $btnset = [[
          'name' => '',
          'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
          'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
          'class' => 'jbu_btnshowdetails btn btn-social-icon btn-github',
          'attributes'=>[['name'=>'trno','value'=>'trno']],
        ]];

        $filter = '';

        if($params['x'] != ''){
            $filter .= " and (head.docno like '%".$params['x']."%') ";
        }//end if

        if($params['process'] != ''){
            $filter .= " and ptab.process like '%".$params['process']."%' ";
        }//end if

        $sql = "select distinct trno,docno,dateid from (
                select head.trno,head.docno,left(head.dateid,10) as dateid,
                ptab.`process` from hjbhead as head
                left join jb_processtab as ptab on ptab.trno = head.trno
                where head.breakdownreport = '' ".$filter."
                ) as tbl;";
        
        $params = [
            'sql' => $sql,
            'tableid' => 'jodocuments_gridtbl',
            'key' => 'trno',
            'txtclass' => 'jbu',
            'checkbox' => false,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'docno',
                    'label' => 'Document #',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'dateid',
                    'label' => 'Date',
                    'class' => 'aimslabel col-min'
                ],
            ],
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end action 


    public function actionGetjoheader(){
    Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;
        $headdata = Pohead::openhead($params['q'],'JB');
        echo json_encode(['headdata'=>$headdata]);
    }//end fn

    public function actionGetjbuinventory(){
        Yii::$app->backend->AjaxVerification($this); 
        $trno = Yii::$app->backend->sanitize($_POST['x'],'DEFAULT');
        $sql = Yii::$app->tblgenerator->getStockViewQuery('JB',$trno);

        $readonly = false;
        $editable = false;
        $gridcheckbox = false;
        $id = 'jbustockview_viewonly';
        $btnset = '';

        $params = [
            'sql' => $sql,
            'tableid' => $id,
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'checkbox' => $gridcheckbox,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode',
                    'editable' => $editable,
                    //'readonly' => $readonly,
                    'type' => 'text',
                    'width' => '150px',
                    'class'=>'col-codes stocktxt txtgridbarcode',
                ],[
                    'name' => 'itemname',
                    'editable' => $editable,
                    'type' => 'text',
                    'width' => '250px',
                    'class'=>'col-description stocktxt',
                ],[
                    'name' => 'isqty',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Qty',
                    'type' => 'text',
                    'viewtype' => 'quantity',
                    'class' => 'col-quantity stocktxt txtcompute txtisqty'
                ],[
                    'name' => 'uom',
                    'editable' => $editable,
                    'label' => 'UOM',
                    'type' => 'text',
                    'class' => 'col-min stocktxt'
                ],[
                    'name' => 'isamt',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Price',
                    'type' => 'text',
                    'viewtype' => 'currency',
                    'class' => 'col-currency txtcompute stocktxt txtisamt'
                ],[
                    'name' => 'disc',
                    'editable' => $editable,
                    'default' => '',
                    'label' => 'Disc',
                    'type' => 'text',
                    'class' => 'col-min stocktxt txtcompute txtisdisc'
                ],[
                    'name' => 'ext',
                    'label' => 'Total',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'class' => 'col-currency stocktxt txtext',
                    'type' => 'text',
                    'viewtype' => 'currency',
                    'width' => '150px;'
                ],[
                    'name' => 'qa',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'default' => '0',
                    'label' => 'Pending',
                    'type' => 'text',
                    'viewtype' => 'quantity',
                    'class' => 'col-min stocktxt txtqa'
                ],[
                    'name' => 'whcode',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'default' => '0.00',
                    'label' => 'WH',
                    'type' => 'text',
                    'class' => 'col-codes stocktxt'
                ],[
                    'name' => 'loc',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'default' => '',
                    'label' => 'Location',
                    'type' => 'text',
                    'class' => 'col-codes stocktxt'
                ],[
                    'name' => 'expiry',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'default' => '1900-01-01',
                    'type' => 'text',
                    'class' => 'col-codes stocktxt'
                ],[
                    'name' => 'rem',
                    'editable' => $editable,
                    'default' => '----',
                    'label' => 'Notes',
                    'type' => 'text',
                    'class' => 'col-description stocktxt txtrem'
                ]
            ],
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function actionGetjbumaterials(){
        Yii::$app->backend->AjaxVerification($this); 
        $trno = Yii::$app->backend->sanitize($_POST['x'],'DEFAULT');

        $sql = "select tab.trno,tab.line,tab.barcode,item.itemname,
                tab.qty,tab.`process` from jb_materialtab as tab
                left join item on item.barcode = tab.barcode
                where trno = ".$trno;

        $params = [
            'sql' => $sql,
            'tableid' => 'jbushowmaterialtbl',
            'key' => 'line',
            'txtclass' => 'jbmaterialtxt',
            'checkbox' => false,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode',
                    'editable' => false,
                    'readonly' => true,
                    'type' => 'text',
                    'class' => 'col-codes aimslabel stocktxt',
                ],[
                    'name' => 'itemname',
                    'editable' => false,
                    'readonly' => true,
                    'type' => 'text',
                    'class' => 'col-description aimslabel stocktxt',
                ],[
                    'name' => 'qty',
                    'editable' => false,
                    //'readonly' => $readonly,
                    'type' => 'text',
                    'class' => 'col-min aimslabel stocktxt',
                ],[
                    'name' => 'process',
                    'editable' => false,
                    'readonly' => true,
                    'label' => 'Process',
                    'type' => 'text',
                    'class' => 'col-codes aimslabel stocktxt',
                ]
            ],
            'buttons' => ''
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end function

    public function actionGetjbuprocess(){
        Yii::$app->backend->AjaxVerification($this); 
        $trno = Yii::$app->backend->sanitize($_POST['x'],'DEFAULT');
        $btnset = [[
          'name' => '',
          'caption' => '<i class="fa fa-edit" style="font-size:12px;margin-top:-8px;"></i>',
          'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
          'class' => 'btnclickprocess gvbtns btn btn-social-icon btn-bitbucket',
          'attributes'=>[['name'=>'trno','value'=>'trno'],['name'=>'line','value'=>'line'],['name'=>'barcode','value'=>'barcode']],
        ]];

        $sql = "select barcode,line,trno,seq as sequence,code,`process`,instruct as instruction from jb_processtab where trno =" . $trno;

        $params = [
            'sql' => $sql,
            'tableid' => 'jbushowmaterialtbl',
            'key' => 'line',
            'txtclass' => 'jbprocesstxt',
            'checkbox' => false,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode',
                    'editable' => false,
                    //'readonly' => $readonly,
                    'type' => 'text',
                    'class'=>'col-codes stocktxt',
                ],[
                    'name' => 'sequence',
                    'editable' => false,
                    //'readonly' => $readonly,
                    'type' => 'text',
                    'class'=>'col-min stocktxt',
                ],[
                    'name' => 'code',
                    'editable' => false,
                    'readonly' => true,
                    'type' => 'text',
                    'class'=>'col-codes stocktxt',
                ],[
                    'name' => 'process',
                    'editable' => false,
                    'readonly' => true,
                    'type' => 'text',
                    'class'=>'col-description stocktxt',
                ],[
                    'name' => 'instruction',
                    'editable' => false,
                    //'readonly' => $readonly,
                    'type' => 'text',
                    'class'=>'col-description stocktxt',
                ]
            ],
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end function

    public function actionUpdateprocessdetail(){
        try {
            Yii::$app->backend->AjaxVerification($this); 
            $params = $_POST;

            $qry = "update jb_processtab set 
                    process_status = '".$params['processstatus']."',
                    process_date = '".$params['dateid']."',
                    process_machine = '".$params['machinenum']."',
                    process_operator = '".$params['operator']."',
                    process_qa = '".$params['qa']."',
                    process_startdate = '".$params['date_start']."',
                    process_enddate = '".$params['date_fin']."',
                    process_hrs = '".$params['numhrs']."',
                    process_notes = '".$params['rem']."',
                    process_timestart = '".$params['time_started']."',
                    process_timeed = '".$params['time_finished']."'
                    where trno = ".$params['trno']." and line = ".$params['line']." and barcode = '".$params['barcode']."'";

            $status = Yii::$app->sbccommon->execqry($qry);

            if($status){
                $msg = "Updating Process Tab successfully!";
            }else{
                $msg = "Updating Process Tab failed! Please try again.";
            }//end if

        echo json_encode(['status'=> $status,'msg'=> $msg]);
        } catch (ErrorException $e) {
            echo $e;
        }//END TRY
    }//end action

    public function actionGetprocessdetails(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;

        $qry = "select process_status,process_date,process_machine,process_operator,process_qa,process_startdate,process_enddate,
                process_hrs,process_notes,process_timestart,process_timeed from jb_processtab 
                where trno= " . $params['q'] . " and line = " . $params['line'] . " and barcode = '".$params['barcode']."'";

        $data = Yii::$app->sbccommon->opentable($qry);

        echo json_encode(['details'=>$data]);
    }//end action


    public function actionJbuinputgrid(){
        Yii::$app->backend->AjaxVerification($this); 
        $btnset = [[
          'name' => '',
          'caption' => '<i class="fa fa-sign-in" style="font-size:12px;margin-top:-8px;"></i>',
          'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
          'class' => 'btnpickinput gvbtns btn btn-social-icon btn-bitbucket',
          'attributes'=>[['name'=>'x','value'=>'name']],
        ]];

        $sql = "select id,name,mat_release from inout_masterfile";

        $params = [
            'sql' => $sql,
            'tableid' => 'jbushowinputtbl',
            'key' => 'id',
            'txtclass' => 'jbprocesstxt',
            'checkbox' => false,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'name',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'mat_release',
                    'label' => 'Material Release',
                    'class' => 'aimslabel col-description'
                ]
            ],
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end action    

    public function actionJburejectgrid(){
        Yii::$app->backend->AjaxVerification($this); 
        $btnset = [[
          'name' => '',
          'caption' => '<i class="fa fa-sign-in" style="font-size:12px;margin-top:-8px;"></i>',
          'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
          'class' => 'btnpickreject gvbtns btn btn-social-icon btn-bitbucket',
          'attributes'=>[['name'=>'x','value'=>'name']],
        ]];

        $sql = "select id,name,type from reject_masterfile";

        $params = [
            'sql' => $sql,
            'tableid' => 'jbushowrejecttbl',
            'key' => 'id',
            'txtclass' => 'jbprocesstxt',
            'checkbox' => false,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'name',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'type',
                    'label' => 'Type',
                    'class' => 'aimslabel col-description'
                ]
            ],
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end action    

    public function actionInsertinput(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_POST;
        $getlastline = "select ifnull(line,0) as line from jbu_processinputtab 
                        where trno = " . $params['trno'] . " and transline = " . $params['line'] . " 
                        and barcode = '".$params['barcode']."'";
        $lastline = Yii::$app->sbccommon->datareader($getlastline);

        if(empty($lastline)){
            $lastline = 1;
        }else{
            $lastline = floatval($lastline) + 1;
        }//emd if


        $qryinsert = "insert into jbu_processinputtab (line,rolls,kgs,meters,pcs,inputname,trno,transline,barcode)
                     values (".$lastline.",".$params['jbu_inputrolls'].",".$params['jbu_inputkgs'].",
                            ".$params['jbu_inputmeter'].",".$params['jbu_outputpcs'].",'".$params['jbu_inputcode']."',
                            ".$params['trno'].",".$params['line'].",'".$params['barcode']."')";

        $status = Yii::$app->sbccommon->execqry($qryinsert);

        if($status){
            $msg = '';
        }else{
            $msg = 'Error inserting new Input on Process. Please try again.';
        }//end if

        echo json_encode(['status'=>$status,'msg'=>$msg]);
    }//end action

    public function actionInsertoutput(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_POST;
        $getlastline = "select ifnull(line,0) as line from jbu_processoutputtab 
                        where trno = " . $params['trno'] . " and transline = " . $params['line'] ."
                        and barcode = '".$params['barcode']."'";
        $lastline = Yii::$app->sbccommon->datareader($getlastline);

        if(empty($lastline)){
            $lastline = 1;
        }else{
            $lastline = floatval($lastline) + 1;
        }//emd if

        $qryinsert = "insert into jbu_processoutputtab (line,rolls,kgs,meters,pcs,inputname,trno,transline,barcode)
                     values (".$lastline.",".$params['jbu_outputrolls'].",".$params['jbu_outputkgs'].",
                            ".$params['jbu_outputmeter'].",".$params['jbu_outputpcs'].",'".$params['jbu_outputcode']."',
                            ".$params['trno'].",".$params['line'].",'".$params['barcode']."')";

        
        $status = Yii::$app->sbccommon->execqry($qryinsert);
        
        if($status){
            $msg = '';
        }else{
            $msg = 'Error inserting new Input on Process. Please try again.';
        }//end if
        
        echo json_encode(['status'=>$status,'msg'=>$msg]);
    }//end action

    public function actionInsertreject(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_POST;
        $getlastline = "select ifnull(line,0) as line from jbu_processrejecttab 
                        where trno = " . $params['trno'] . " and transline = " . $params['line'] ."
                        and barcode = '".$params['barcode']."'";
        $lastline = Yii::$app->sbccommon->datareader($getlastline);

        if(empty($lastline)){
            $lastline = 1;
        }else{
            $lastline = floatval($lastline) + 1;
        }//emd if

        $qryinsert = "insert into jbu_processrejecttab (line,reject,operator,rolls,kgs,meters,trno,transline,barcode)
                     values (".$lastline.",'".$params['jbu_rejectcode']."',".$params['jbu_rejectoperator'].",
                            ".$params['jbu_rejectrolls'].",".$params['jbu_rejectkgs'].",'".$params['jbu_rejectmeters']."',
                            ".$params['trno'].",".$params['line'].",'".$params['barcode']."')";

    
        $status = Yii::$app->sbccommon->execqry($qryinsert);
        
        if($status){
            $msg = '';
        }else{
            $msg = 'Error inserting new Reject on Process. Please try again.';
        }//end if
        
        echo json_encode(['status'=>$status,'msg'=>$msg]);
    }//end action


    public function actionTabjbuinputgrid(){
        Yii::$app->backend->AjaxVerification($this); 
        $vars = $_POST;

        $btnset = [[
          'name' => '',
          'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
          'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
          'class' => 'removejbuprocinput gvbtns btn btn-social-icon btn-google',
          'attributes'=>[['name'=>'tabline','value'=>'line'],
                        ['name'=>'tabtrno','value'=>'trno'],
                        ['name'=>'tabtransline','value'=>'transline']],
        ]];

        $sql = "select concat(transline,'-',trno) as uniq,line,rolls,kgs,meters,pcs,
                inputname as name,trno,transline from jbu_processinputtab
                where trno = '".$vars['trno']."' and transline = ".$vars['line']." and barcode = '".$vars['barcode']."'";

        $params = [
            'sql' => $sql,
            'tableid' => 'jbuprocinputtab',
            'key' => 'uniq',
            'txtclass' => 'jbprocesstxt',
            'checkbox' => false,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'name',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'rolls',
                    'label' => 'Rolls',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'kgs',
                    'label' => 'Kgs',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'meters',
                    'label' => 'Meters',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'pcs',
                    'label' => 'PCS',
                    'class' => 'aimslabel col-min'
                ],
            ],
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end aciton

    public function actionTabjburejectgrid(){
    try {
        Yii::$app->backend->AjaxVerification($this); 
        $vars = $_POST;

        $btnset = [[
          'name' => '',
          'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
          'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
          'class' => 'removejbuprocreject gvbtns btn btn-social-icon btn-google',
          'attributes'=>[['name'=>'tabline','value'=>'line'],
                        ['name'=>'tabtrno','value'=>'trno'],
                        ['name'=>'tabtransline','value'=>'transline']],
        ]];

        $gettotalinputkgs = "select ifnull(sum(kgs),0) as kgs from jbu_processinputtab";
        $inputkgs = Yii::$app->sbccommon->datareader($gettotalinputkgs);

        $sql = "select concat(transline,'-',trno) as uniq,line,rolls,kgs,meters,operator,
                round((kgs / ".$inputkgs."),4) as kgsp,round((meters / ".$inputkgs."),4) as metersp,
                reject as name,trno,transline from jbu_processrejecttab
                where trno = '".$vars['trno']."' and transline = ".$vars['line']." and barcode = '".$vars['barcode']."'";

        $params = [
            'sql' => $sql,
            'tableid' => 'jbuprocrejecttab',
            'key' => 'uniq',
            'txtclass' => 'jbprocesstxt',
            'checkbox' => false,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'name',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'operator',
                    'label' => 'Operator',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'rolls',
                    'label' => 'Rolls',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'kgs',
                    'label' => 'KGS',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'kgsp',
                    'label' => 'KGS %',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'meters',
                    'label' => 'Meters',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'metersp',
                    'label' => 'Meters %',
                    'class' => 'aimslabel col-min'
                ],
            ],
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);

        
    } catch (ErrorException $e) {
        echo $e;
    }
    }//end aciton

    public function actionTabjbuoutputgrid(){
        Yii::$app->backend->AjaxVerification($this); 
        $vars = $_POST;

        $btnset = [[
          'name' => '',
          'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
          'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
          'class' => 'removejbuprocoutput gvbtns btn btn-social-icon btn-google',
          'attributes'=>[['name'=>'tabline','value'=>'line'],
                        ['name'=>'tabtrno','value'=>'trno'],
                        ['name'=>'tabtransline','value'=>'transline']],
        ]];

        $sql = "select concat(transline,'-',trno) as uniq,line,rolls,kgs,meters,
                pcs,inputname as name,trno,transline from jbu_processoutputtab
                where trno = '".$vars['trno']."' and transline = ".$vars['line']." and barcode = '".$vars['barcode']."'";

        $params = [
            'sql' => $sql,
            'tableid' => 'jbuprocoutputtab',
            'key' => 'uniq',
            'txtclass' => 'jbprocesstxt',
            'checkbox' => false,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'name',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'rolls',
                    'label' => 'Rolls',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'kgs',
                    'label' => 'Kgs',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'meters',
                    'label' => 'Meters',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'pcs',
                    'label' => 'PCS',
                    'class' => 'aimslabel col-min'
                ],
            ],
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end aciton

    public function actionAutocomputepcs(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;

        $qry = "select fg_repeatlength,fg_outnum from item where barcode = '".$params['q']."'";
        $data = Yii::$app->sbccommon->opentable($qry);

        if(!empty($data)){
            $params['m'] = str_replace(',', '', $params['m']);
            $data[0]['fg_repeatlength'] = str_replace(',', '', $data[0]['fg_repeatlength']);
            $data[0]['fg_outnum'] = str_replace(',', '', $data[0]['fg_outnum']);

            $pcs = ($params['m'] * 1000) / ($data[0]['fg_outnum'] * $data[0]['fg_repeatlength']);
            $pcs = round($pcs);
        }else{
            $pcs = 0;
        }//end if

        echo json_encode(['pcs'=>$pcs]);
    }//end action

    public function actionLoadfgcolors() {
        Yii::$app->backend->AjaxVerification($this);
        $qry = "select id, code, name from fg_colors order by id";
        $params = [
            'sql' => $qry,
            'tableid' => 'fgcolorsgrid',
            'key' => 'id',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'code',
                    'class' => 'col-codes'
                ],[
                    'name' => 'name',
                    'class' => 'col-description'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-save"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'btnselectjbufgcolor btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name'=>'color','value'=>'name'],['name'=>'colorcode','value'=>'code']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function actionInsertink(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_POST;

        if($params['jbu_inkline'] == '' || $params['jbu_inkline'] == 0){
            $getlastline = "select ifnull(line,0) as line from jbu_processinktab 
                        where trno = " . $params['trno'] . " and transline = " . $params['line'] ."
                        and barcode = '".$params['barcode']."'";
            $lastline = Yii::$app->sbccommon->datareader($getlastline);

            if(empty($lastline)){
                $lastline = 1;
            }else{
                $lastline = floatval($lastline) + 1;
            }//emd if

            $qryinsert = "insert into jbu_processinktab (line,colorcode,color,wt,returned,trno,transline,barcode)
                         values (".$lastline.",'".$params['jbu_inkcolorcode']."','".$params['jbu_inkcolor']."',
                                ".$params['jbu_inkwt'].",".$params['jbu_inkreturned'].",
                                ".$params['trno'].",".$params['line'].",'".$params['barcode']."')";

            $status = Yii::$app->sbccommon->execqry($qryinsert);
            
            if($status){
                $msg = '';
            }else{
                $msg = 'Error inserting new Ink Consumption on Process. Please try again.';
            }//end if
        }else{
            $qryupdate = "update jbu_processinktab set colorcode= '".$params['jbu_inkcolorcode']."',
                        color = '".$params['jbu_inkcolor']."',wt = ".$params['jbu_inkwt'].", returned = ".$params['jbu_inkreturned']."
                        where trno = " . $params['jbu_inktrno'] . " and line = " . $params['jbu_inkline'];

            $status = Yii::$app->sbccommon->execqry($qryupdate);

            if($status){
                $msg = '';
            }else{
                $msg = 'Error updating Ink Consumption on Process. Please try again.';
            }//end if
        }//end if
        
        echo json_encode(['status'=>$status,'msg'=>$msg]);
    }//end fn

    public function actionTabjbuinkgrid(){
        Yii::$app->backend->AjaxVerification($this); 
        $vars = $_POST;

        $btnset = [[
          'name' => '',
          'caption' => '<i class="fa fa-pencil" style="font-size:12px;margin-top:-8px;"></i>',
          'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
          'class' => 'editjbuprocink gvbtns btn btn-social-icon btn-github',
          'attributes'=>[['name'=>'tabline','value'=>'line'],
                        ['name'=>'tabtrno','value'=>'trno'],
                        ['name'=>'tabtransline','value'=>'transline'],
                        ['name'=>'colorcode','value'=>'colorcode'],
                        ['name'=>'color','value'=>'color'],
                        ['name'=>'wt','value'=>'wt'],
                        ['name'=>'returned','value'=>'returned']],
        ],[
          'name' => '',
          'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
          'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
          'class' => 'removejbuprocink gvbtns btn btn-social-icon btn-google',
          'attributes'=>[['name'=>'tabline','value'=>'line'],
                        ['name'=>'tabtrno','value'=>'trno'],
                        ['name'=>'tabtransline','value'=>'transline']],
        ]];

        $sql = "select concat(transline,'-',trno) as uniq,line,colorcode,color,wt,returned,
                ((wt - returned) / 2) as consumed,
                trno,transline from jbu_processinktab
                where trno = '".$vars['trno']."' and transline = ".$vars['line']." and barcode = '".$vars['barcode']."'";
        
        $params = [
            'sql' => $sql,
            'tableid' => 'jbuprocoutputtab',
            'key' => 'uniq',
            'txtclass' => 'jbprocesstxt',
            'checkbox' => false,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'colorcode',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'color',
                    'label' => 'Color Name',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'wt',
                    'label' => 'WT',
                    'class' => 'aimslabel col-currency'
                ],[
                    'name' => 'returned',
                    'label' => 'Returned',
                    'class' => 'aimslabel col-currency'
                ],[
                    'name' => 'consumed',
                    'label' => 'Consumed',
                    'class' => 'aimslabel col-currency'
                ],
            ],
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end aciton

    public function actionRemoveproctabs(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;

        switch ($params['type']) {
            case 'INK':
                $qry = "delete from jbu_processinktab 
                where trno = " . $params['q'] . " and line = " . $params['line'];

                $label = "Ink Consumption";
            break;

            case 'REJECT':
                $qry = "delete from jbu_processrejecttab where trno = " . $params['q'] . " 
                and transline = ".$params['tline']." and line = " . $params['line'];

                $label = "Reject";
            break;

            case 'OUTPUT':
                $qry = "delete from jbu_processoutputtab where trno = " . $params['q'] . " 
                and transline = ".$params['tline']." and line = " . $params['line'];

                $label = "Output";
            break;

            case 'INPUT':
                $qry = "delete from jbu_processinputtab where trno = " . $params['q'] . " 
                and transline = ".$params['tline']." and line = " . $params['line'];

                $label = "Input";
            break;
        }//end swithc


        $status = Yii::$app->sbccommon->execqry($qry);

        if($status){
            $msg = '';
        }else{
            $msg = 'Error removing '.$label.' on Process. Please try again.';
        }//end if

        echo json_encode(['msg'=>$msg,'status'=>$status]);
    }//end fn

    public function actionLoadfgprocess() {
        Yii::$app->backend->AjaxVerification($this);
        $qry = "select id, code, name from fg_process order by id";
        $params = [
            'sql' => $qry,
            'tableid' => 'fgprocessgrid',
            'key' => 'id',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'code',
                    'class' => 'col-codes'
                ],[
                    'name' => 'name',
                    'class' => 'col-description'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-save"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'btnselectjbufgprocess btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name'=>'process','value'=>'name'],['name'=>'processid','value'=>'id'],['name'=>'processcode','value'=>'code']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn


    public function actionGetdiscrepancy(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;
        $qryinput_m = "select ifnull(sum(meters),0) as input_m from jbu_processinputtab where trno = " . $params['q'];
        $input_m = Yii::$app->sbccommon->datareader($qryinput_m);

        $qryoutput_m = "select ifnull(sum(meters),0) as output_m from jbu_processoutputtab where trno = " . $params['q'];
        $output_m = Yii::$app->sbccommon->datareader($qryoutput_m);

        $qryreject_m = "select ifnull(sum(meters),0) as reject_m from jbu_processrejecttab where trno = " . $params['q'];
        $reject_m = Yii::$app->sbccommon->datareader($qryreject_m);

        $qryinput_kgs = "select ifnull(sum(kgs),0) as input_kgs from jbu_processinputtab where trno = " . $params['q'];
        $input_kgs = Yii::$app->sbccommon->datareader($qryinput_kgs);

        $discrepancy_m = (floatval($input_m) + floatval($reject_m)) - floatval($input_m);
        $m_percent = (floatval($discrepancy_m) / floatval($input_m)) * 100;
        $discrepancy_kgs = (floatval($input_kgs) + floatval($input_m)) * $discrepancy_m;

        echo json_encode(['dis_m'=>$discrepancy_m,'m_per'=>round($m_percent,4),'dis_kgs'=>$discrepancy_kgs]);
    }//end action
}//END CONTROLLER




