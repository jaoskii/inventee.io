<?php

namespace backend\modules\notification\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;

use app\models\Lahead;
use app\models\Lastock;

use yii\web\Response;
class DefaultController extends Controller{

    public $access = array(
        'view' => 652);

    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex(){   
        if(isset(Yii::$app->session['loggeduser'])){
            $this->layout = "@app/views/layouts/backend/main";
            $moduleid = $this->module->id;
            Yii::$app->view->params['moduleid'] = $moduleid;
            return $this->render('index',array('moduleid'=>$moduleid));
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }
    }

    public function actionLoadnotifgrid1() {
        if (Yii::$app->session['loggeduser']['access'][$this->access['view']] == 1) {
            $sql = "select distinct case(doc) when 'PR' then 'PURCHASE REQUISITION'
                                              when 'PO' then 'PURCHASE ORDER'
                                              when 'RR' then 'RECEIVING REPORT'
                                              when 'DM' then 'PURCHASE RETURN'
                                              when 'SO' then 'SALES ORDER'
                                              when 'SJ' then 'SALES JOURNAL'
                                              when 'CM' then 'SALES RETURN'
                                              when 'IS' then 'INVENTORY SETUP'
                                              when 'PC' then 'PHYSICAL COUNT'
                                              when 'TS' then 'TRANSFER SLIP'
                                              when 'AJ' then 'INVENTORY ADJUSTMENT'
                                              when 'GJ' then 'GENERAL JOURNAL'
                                              when 'DS' then 'DEPOSIT SLIP'
                                              when 'AR' then 'AR SETUP'
                                              when 'CR' then 'RECEIVED PAYMENT'
                                              when 'KR' then 'COUNTER RECEIPT'
                                              when 'AP' then 'AP SETUP'
                                              when 'PV' then 'AP VOUCHER'
                                              when 'CV' then 'CASH/CHECK VOUCHER'
                                              when 'MI' then 'MATERIAL ISSUANCE'
                                              when 'SI' then 'SALES INVOICE'
                                              when 'TR' then 'TRANSFER REQUEST'
                                              else '' end as doc,
                count(trno) as counts, trno, doc as doc2
                    from(
                        select head.trno,head.clientname as customername,head.client,head.doc as doc ,
                        head.dateid as datex , head.docno as docno from prhead as head
                        UNION ALL
                        select head.trno,head.clientname as customername,head.client,head.doc as doc ,
                        head.dateid as datex , head.docno as docno from trhead as head
                        UNION ALL
                        select head.trno,head.clientname as customername,head.client,head.doc as doc ,
                        head.dateid as datex , head.docno as docno from pohead as head
                        UNION ALL
                        select head.trno,head.clientname as customername,head.client,head.doc as doc ,
                        head.dateid as datex , head.docno as docno from sohead as head
                        UNION ALL
                        select head.trno,head.clientname as customername,head.client,head.doc as doc ,
                        head.dateid as datex , head.docno as docno from pchead as head
                        UNION ALL
                        select head.trno,head.clientname as customername,head.client,head.doc as doc ,
                        head.dateid as datex , head.docno as docno from lahead as head) as countx group by doc
                    order by doc";

            $params = [
                'sql' => $sql,
                'tableid' => 'notiftable1',
                'key' => 'trno',
                'txtclass' => 'notiftextbox',
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOPTIONS&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [
                    [
                        'name' => 'doc',
                        'label' => 'DOCUMENT',
                        'class'=>'col-description aimslabel',
                    ],[
                        'name' => 'counts',
                        'label' => 'COUNT',
                        'class' => 'col-quantity aimslabel'
                    ]
                ],
                'buttons' => [
                    [
                        'name' => '',
                        'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                        'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                        'class' => 'btnviewunpostedtrans gvbtns btn btn-social-icon btn-github',
                        'attributes' => [['name' => 'doc', 'value' => 'doc2']]
                    ]
                ]
            ];
            return Yii::$app->tblgenerator->generateGrid($params);
        }
    }

    public function actionLoadnotifgrid2() {
        $doc = $_POST['x'];
        switch ($doc) {
            case 'PR':
                $qry = "select center.name as centername,transnum.center,head.trno,head.clientname as clientname,head.client,head.doc as doc ,
                left(head.dateid,10) as dateid , head.docno as docno  , 'UNPOSTED' as status from prhead as head
                left join transnum on transnum.trno = head.trno
                left join center on center.code = transnum.center
                order by dateid asc";
            break;

            case 'PO':
                $qry = "select center.name as centername,transnum.center,head.trno,head.clientname as clientname,head.client,head.doc as doc ,
                left(head.dateid,10) as dateid , head.docno as docno  , 'UNPOSTED' as status from pohead as head
                left join transnum on transnum.trno = head.trno
                left join center on center.code = transnum.center
                where head.doc='$doc'
                order by dateid asc";
            break;

             case 'TR':
                $qry = "select center.name as centername,transnum.center,head.trno,head.clientname as clientname,head.client,head.doc as doc ,
                left(head.dateid,10) as dateid , head.docno as docno  , 'UNPOSTED' as status from trhead as head
                left join transnum on transnum.trno = head.trno
                left join center on center.code = transnum.center
                where head.doc='$doc'
                order by dateid asc";
            break;

            case 'SO':
                $qry = "select center.name as centername,transnum.center,head.trno,head.clientname as clientname,head.client,head.doc as doc ,
                left(head.dateid,10) as dateid , head.docno as docno  , 'UNPOSTED' as status from sohead as head
                left join transnum on transnum.trno = head.trno
                left join center on center.code = transnum.center
                where head.doc='$doc'
                order by dateid asc";
            break;

            case 'PC':
                $qry = "select center.name as centername,transnum.center,head.trno,head.clientname as clientname,head.client,head.doc as doc ,
                left(head.dateid,10) as dateid , head.docno as docno  , 'UNPOSTED' as status from pchead as head
                left join transnum on transnum.trno = head.trno
                left join center on center.code = transnum.center
                where head.doc='$doc'
                order by dateid asc";
            break;
            
            default:
                $qry = "select center.name as centername,cntnum.center,head.trno,head.clientname as clientname,head.client,head.doc as doc ,
                left(head.dateid,10) as dateid , head.docno as docno  , 'UNPOSTED' as status from lahead as head
                left join cntnum on cntnum.trno = head.trno
                left join center on center.code = cntnum.center
                where head.doc='$doc'
                order by dateid asc";
            break;
        }
        $params = [
            'sql' => $qry,
            'tableid' => 'notiftable2',
            'key' => 'trno',
            'txtclass' => 'notiftextbox',
            'column' => [
                [
                    'name' => 'center',
                    'label' => 'CENTER',
                    'class'=>'col-codes aimslabel',
                ],[
                    'name' => 'centername',
                    'label' => 'NAME',
                    'class' => 'col-description aimslabel'
                ],[
                    'name' => 'docno',
                    'label' => 'DOCUMENT #',
                    'class' => 'col-codes aimslabel'
                ],[
                    'name' => 'dateid',
                    'label' => 'DATE',
                    'class' => 'col-codes aimslabel'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function actionViewtrans(){   
        $doc = $_GET['doc'];
        $moduleid = $this->module->id;
     	$lahead = new Lahead;
         
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['notifdata' => $data];
        //echo json_encode((array('notifdata' => $data));
    }
}
