<?php

namespace app\components;
 
use Yii;
use yii\base\Component;
use yii\db\Query;
use yii\Web\Session;
use yii\web\Request;
use yii\base\ErrorException;
use yii\helpers\Url;

//IMPORTED CLASES
use app\models\Common;
use app\models\Lahead;
use app\models\Lastock;
use app\models\Ladetail;
use app\models\Cntnum;
use app\models\Webproc;

class automator extends Component{
    
    //WTODO: [KIM][2019.10.03][automateJobnolookup]
    public function automateJobnolookup($params) {
        
        $qry = "select trno, docno from 
        (select trno,docno from jbhead union all select trno,docno from hjbhead) as a 
        where (docno like '%".$params['x']."%') order by docno";
        
        $params = ['sql' => $qry,
                'tableid' => 'jobnolookupdiv',
                'key' => 'trno',
                'txtclass' => 'bodytextbox',
                'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [
                    [
                        'name' => 'docno',
                        'editable' => false,
                        'class' => 'col-description'
                    ],[
                        'name' => 'trno',
                        'editable' => false,
                        'class' => 'col-codes'
                    ]
                ],
                'buttons' => [
                    [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickjobno btn btn-social-icon btn-bitbucket',
                    'attributes'=>[['name'=>'trno','value'=>'trno'],['name'=>'docno','value'=>'docno']]
                    ]
                ]
            ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f
    public function generateCopytransGrid($controller,$params){
        if(isset($params['x'])){
            switch ($params['x']) {
                case 'SO':
                    $qry = "select head.trno,head.doc,head.docno,left(head.dateid,10) as dateid,
                    head.client,head.clientname,head.address,head.agent,
                    head.wh,head.rem,head.shipto,head.yourref,head.ourref,
                    head.uv_picker,head.uv_checker,head.due,head.terms,head.trnx_type,head.salestype,sum(stock.ext) as ext from hsohead as head
                    left join hsostock as stock on stock.trno = head.trno
                    where stock.void <> 1 and stock.qa <> stock.iss group by head.trno";
                break;
            }//end if


            $params = [
                'sql' => $qry,
                'tableid' => 'tbl-copytrans'.$params['x'],
                'key' => 'trno',
                'txtclass' => 'bodytextbox',
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                
                'column' => [[
                        'name' => 'docno',
                        'editable' => true,
                        'type' =>'documentlink',
                        'linkdoc'=>'doc',
                        'linkparam'=>'docno',
                        'label' => 'Document #',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'clientname',
                        'label' => 'Name',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'ext',
                        'label' => 'Amount',
                        'class' => 'aimslabel col-currency',
                        'viewtype' => 'currency'
                    ],[
                        'name' => 'trnx_type',
                        'label' => 'Trans type',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'salestype',
                        'label' => 'Sales type',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'client',
                        'label' => 'Code',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'agent',
                        'label' => 'Agent',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'wh',
                        'label' => 'Warehouse',
                        'class' => 'aimslabel col-codes'
                    ]],
                
                'buttons' => [
                    [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-angle-double-down"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'selectcopytrans btn btn-social-icon btn-bitbucket',
                    'attributes'=>[['name'=>'trno','value'=>'trno']],
                    ]
                ]
            ];
            
            return Yii::$app->tblgenerator->generateGrid($params);
        }else{
            return 'Error no required params';
        }//end if
    }//end f

    public function generateMIStockview($sql,$type){
        if($type == ''){
            $readonly = true;
            $editable = true;
            $gridcheckbox = false;
            $id = 'mistockview';
            $btnset = [[
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stocksavebtn gvbtns btn btn-social-icon btn-bitbucket',
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stockdeletebtn gvbtns btn btn-social-icon btn-google'
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'showbalance gvbtns btn btn-social-icon btn-github'
                ],];
        }else{
            $readonly = false;
            $editable = false;
            $gridcheckbox = false;
            $id = 'mistockview_viewonly';
            $btnset = '';
        }//end if

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                $expreadonly = false;
            break;

            default:
                $expreadonly = true;
            break;
        }//END SWITCH

        $params = [
            'sql' => $sql,
            'tableid' => $id,
            'key' => 'line', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'checkbox' => $gridcheckbox,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode', //FIELD NAME SA QUERY
                    'editable' => $editable,
                  'readonly' => $readonly,
                    'type' => 'text',
                    'width' => '150px',
                    'class'=>'col-codes stocktxt',
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
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'uom',
                                      'colw'=>'col-min',
                                      'lookupclass'=>'gvbtns stockuomlookup',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'itemname', //FIELD NAME SA QUERY
                    'editable' => $editable,
                    'type' => 'text',
                    'width' => '250px',
                    'class'=>'col-description stocktxt',
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
                    'name' => 'whcode',
                    'editable' => $editable,
                  'readonly' => $readonly,
                    'default' => '0.00',
                    'label' => 'WH',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'warehouse',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns whlookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'loc',
                    'editable' => $editable,
                    'default' => '',
                    'label' => 'Location',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'location',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns locationlookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'expiry',
                    'editable' => $editable,
                  'readonly' => $expreadonly,
                    'default' => '1900-01-01',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'expiry',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns locationlookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'ref',
                    'editable' => $editable,
                    'default' => '----',
                    'label' => 'Reference',
                    'type' => 'text',
                    'class' => 'col-codes stocktxt txtref'
                ],[
                    'name' => 'rem',
                    'editable' => $editable,
                    'default' => '----',
                    'label' => 'Notes',
                    'type' => 'text',
                    'class' => 'col-description stocktxt txtrem'
                ],[
                    'name' => 'wh',
                    'hidden' => true,
                    'class' => 'txtstockwh txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'iss',
                    'hidden' => true,
                    'class' => 'txtstockiss txthidden',
                    'default' => '0'
                ],[
                    'name' => 'amt',
                    'hidden' => true,
                    'class' => 'txtstockamt txthidden',
                    'default' => '0'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txtstockline txthidden',
                    'default' => '0'
                ],[
                    'name' => 'refx',
                    'hidden' => true,
                    'class' => 'txtstockrefx txthidden',
                    'default' => '0'
                ],[
                    'name' => 'linex',
                    'hidden' => true,
                    'class' => 'txtstocklinex txthidden',
                    'default' => '0'
                ],[
                    'name' => 'uomfactor',
                    'hidden' => true,
                    'class' => 'txtstockuomfactor txthidden',
                    'default' => '0'
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => '0'
                ]
            ],
            
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function generatePRStockview($sql,$type){
        if($type == ''){
            $readonly = true;
            $editable = true;
            $gridcheckbox = false;
            $id = 'prstockview';
            $btnset = [[
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stocksavebtn gvbtns btn btn-social-icon btn-bitbucket',
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stockdeletebtn gvbtns btn btn-social-icon btn-google'
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'showbalance gvbtns btn btn-social-icon btn-github'
                ],];
        }else{
            $readonly = false;
            $editable = false;
            $gridcheckbox = false;
            $id = 'prstockview_viewonly';
            $btnset = '';
        }//end if

        $params = [
            'sql' => $sql,
            'tableid' => $id,
            'key' => 'line', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'checkbox' => $gridcheckbox,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                  'name' => 'barcode',
                  'editable' => $editable,
                  'readonly' => $readonly,
                  'type' => 'text',
                  'width' => '150px',
                  'class'=>'col-codes stocktxt',
                ],[
                  'name' => 'rrqty',
                  'editable' => $editable,
                  'default' => '0.00',
                  'label' => 'Qty',
                  'type' => 'text',
                  'viewtype' => 'quantity',
                  'class' => 'col-quantity stocktxt txtcompute txtrrqty'
                ],[
                  'name' => 'uom',
                  'editable' => $editable,
                  'label' => 'UOM',
                  'type' => 'lookup',
                  'lookupbutton' => ['autocall'=>'uom',
                                    'colw'=>'col-min',
                                    'lookupclass'=>'gvbtns stockuomlookup',
                                    'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'itemname',
                    'editable' => $editable,
                    'type' => 'text',
                    'width' => '250px',
                    'class'=>'col-description stocktxt',
                ],[
                    'name' => 'rrcost',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Price',
                    'type' => 'text',
                    'viewtype' => 'unitprice',
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
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'warehouse',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns whlookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'loc',
                    'editable' => $editable,
                    'default' => '',
                    'label' => 'Location',
                    'class' => 'col-currency stocktxt txtext',
                    'type' => 'text',
                    'width' => '150px;'
                ],[
                    'name' => 'rem',
                    'editable' => $editable,
                    'default' => '----',
                    'label' => 'Notes',
                    'type' => 'text',
                    'class' => 'col-description stocktxt txtrem'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'qty',
                    'hidden' => true,
                    'class' => 'txtqty txthidden',
                    'default'=>'0.00',
                ],[
                    'name' => 'cost',
                    'hidden' => true,
                    'class' => 'txtcost txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txtstockitemid txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'uomfactor',
                    'hidden' => true,
                    'class' => 'txtstockfactor txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'refx',
                    'hidden' => true,
                    'class' => 'txtstockrefx txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'linex',
                    'hidden' => true,
                    'class' => 'txtstocklinex txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'tr',
                    'hidden' => true,
                    'class' => 'txtstocklinex txthidden',
                    'default'=>'0',
                ],[
                  'name' => 'void',
                  'hidden' => true,
                  'class' => 'txtstocklinex txthidden',
                  'default'=>'0',
                ]
            ],
          'buttons' => $btnset
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function generatePCStockview($sql,$type){
        if($type == ''){
            $readonly = true;
            $editable = true;
            $gridcheckbox = false;
            $id = 'pcstockview';
            $btnset = [[
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stocksavebtn gvbtns btn btn-social-icon btn-bitbucket',
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stockdeletebtn gvbtns btn btn-social-icon btn-google'
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'showbalance gvbtns btn btn-social-icon btn-github'
                ],];
        }else{
            $readonly = false;
            $editable = false;
            $gridcheckbox = false;
            $id = 'pcstockview_viewonly';
            $btnset = '';
        }//end if

        $pandafield1 = ['name'=>''];
        $pandafield2 = ['name'=>''];

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                $expreadonly = false;
            break;

            default:
                $expreadonly = true;
            break;
        }//END SWITCH

        $params = [
            'sql' => $sql,
            'tableid' => $id,
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'checkbox' => $gridcheckbox,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'type' => 'text',
                    'width' => '150px',
                    'class'=>'col-codes stocktxt',
                ],[
                    'name' => 'itemname',
                    'editable' => $editable,
                    'type' => 'text',
                    'width' => '250px',
                    'class'=>'col-description stocktxt',
                ],$pandafield1,$pandafield2,[
                    'name' => 'rrqty',
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
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'uom',
                                      'colw'=>'col-min',
                                      'lookupclass'=>'gvbtns stockuomlookup',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'rrcost',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Price',
                    'type' => 'text',
                    'viewtype' => 'currency',
                    'class' => 'col-currency txtcompute stocktxt txtisamt'
                ],[
                    'name' => 'ext',
                    'label' => 'Total',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'class' => 'col-currency stocktxt txtext',
                    'type' => 'text',
                    'viewtype' => 'currency',
                    'width' => '150px;'
                ],[ // WTODO JAD 03-15-2019
                    'name' => 'whcode',
                    'editable' => true,
                    'readonly' => true,
                    'default' => '0.00',
                    'label' => 'WH',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'warehouse',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns whlookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                    // WTODO JAD 03-15-2019
                ],[
                    'name' => 'loc',
                    'editable' => $editable,
                    'default' => '',
                    'label' => 'Location',
                    'class' => 'col-currency stocktxt txtext',
                    'type' => 'text',
                    'width' => '150px;'
                ],[
                    'name' => 'expiry',
                    'editable' => $editable,
                    'expiry' => $expreadonly,
                    'default' => '----',
                    'label' => 'Expiry',
                    'type' => 'text',
                    'class' => 'col-description stocktxt txtexpiry'
                ],[
                    'name' => 'rem',
                    'editable' => $editable,
                    'default' => '----',
                    'label' => 'Notes',
                    'type' => 'text',
                    'class' => 'col-description stocktxt txtrem'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'qty',
                    'hidden' => true,
                    'class' => 'txtqty txthidden',
                    'default'=>'0.00',
                ],[
                    'name' => 'cost',
                    'hidden' => true,
                    'class' => 'txtcost txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'disc',
                    'hidden' => true,
                    'class' => 'txtdisc txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txtstockitemid txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'uomfactor',
                    'hidden' => true,
                    'class' => 'txtstockfactor txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'whcode',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => ''
                ]
            ],
            
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function generateTSStockview($sql,$type){
        if($type == ''){
            $readonly = true;
            $editable = true;
            $gridcheckbox = false;
            $id = 'tsstockview';
            $btnset = [[
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stocksavebtn gvbtns btn btn-social-icon btn-bitbucket',
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stockdeletebtn gvbtns btn btn-social-icon btn-google'
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'showbalance gvbtns btn btn-social-icon btn-github'
                ],];
        }else{
            $readonly = false;
            $editable = false;
            $gridcheckbox = false;
            $id = 'tsstockview_viewonly';
            $btnset = '';
        }//end if

        $pandafield1 = ['name'=>''];
        $pandafield2 = ['name'=>''];
        $kinggfield1 = ['name'=>''];
        

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'KINGGEORGE':
                $kinggfield1 = [
                    'name' => 'kgs',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Buying KG',
                    'type' => 'text',
                    'viewtype' => 'quantity',
                    'class' => 'col-quantity stocktxt txtcompute txtkgs'
                ];        
            break;
        }//END SWITHC

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                $expreadonly = false;
            break;

            default:
                $expreadonly = true;
            break;
        }//END SWITCH

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                $params = [
                    'sql' => $sql,
                    'tableid' => $id,
                    'key' => 'line',
                    'txtclass' => 'bodytextbox',
                    'checkbox' => $gridcheckbox,
                    'template'=> ['checkbox','buttons','columns'],
                    'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                    'column' => [
                        [
                            'name' => 'barcode',
                            'editable' => $editable,
                            'readonly' => $readonly,
                            'type' => 'text',
                            'width' => '150px',
                            'class'=>'col-codes stocktxt',
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
                            'type' => 'lookup',
                            'lookupbutton' => ['autocall'=>'uom',
                                              'colw'=>'col-min',
                                              'lookupclass'=>'gvbtns stockuomlookup',
                                              'lookuptxtclass'=>'minitxtcombo'],
                        ],[
                            'name' => 'expiry',
                            'editable' => $editable,
                            'readonly' => $expreadonly,
                            'default' => '',
                            'label' => 'Expiry',
                            'class' => 'col-codes stocktxt txtstockdate',
                            'type' => 'datepicker',
                        ],[
                            'name' => 'rem',
                            'editable' => $editable,
                            'default' => '----',
                            'label' => 'Notes',
                            'type' => 'text',
                            'class' => 'col-description stocktxt txtrem'
                        ],[
                            'name' => 'ref',
                            'editable' => $editable,
                            'readonly' => $readonly,
                            'default' => '',
                            'label' => 'Reference',
                            'type' => 'text',
                            'class' => 'col-codes stocktxt txtref'
                        ],[
                            'name' => 'whcode',
                            'editable' => $editable,
                            'readonly' => $readonly,
                            'default' => '0.00',
                            'label' => 'WH',
                            'type' => 'lookup',
                            'lookupbutton' => ['autocall'=>'warehouse',
                                              'colw'=>'col-codes',
                                              'lookupclass'=>'gvbtns whlookupstock',
                                              'lookuptxtclass'=>'minitxtcombo'],
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
                            'name' => 'loc',
                            'editable' => $editable,
                            'default' => '',
                            'label' => 'Location',
                            'class' => 'txthidden txtext',
                            'type' => 'text',
                            'width' => '150px;'
                        ],[
                            'name' => 'loc2',
                            'editable' => $editable,                    
                            'default' => '',
                            'label' => 'Location',
                            'class' => 'txthidden txtext',
                            'type' => 'text',
                            'width' => '150px;'
                        ],[
                            'name' => 'line',
                            'hidden' => true,
                            'class' => 'txtline txthidden',
                            'default'=>'0',
                        ],[
                            'name' => 'iss',
                            'hidden' => true,
                            'class' => 'txtiss txthidden',
                            'default'=>'0.00',
                        ],[
                            'name' => 'amt',
                            'hidden' => true,
                            'class' => 'txtamt txthidden',
                            'default'=>'0',
                        ],[
                            'name' => 'disc',
                            'hidden' => true,
                            'class' => 'txtdisc txthidden',
                            'default'=>'0',
                        ],[
                            'name' => 'itemid',
                            'hidden' => true,
                            'class' => 'txtstockitemid txthidden',
                            'default'=>'0',
                        ],[
                            'name' => 'uomfactor',
                            'hidden' => true,
                            'class' => 'txtstockfactor txthidden',
                            'default'=>'0',
                        ],[
                            'name' => 'refx',
                            'hidden' => true,
                            'class' => 'txtstockrefx txthidden',
                            'default'=>'0',
                        ],[
                            'name' => 'linex',
                            'hidden' => true,
                            'class' => 'txtstocklinex txthidden',
                            'default'=>'0',
                        ]
                    ],
                    
                    'buttons' => $btnset
                ];
            break;

            default:
                $params = [
                    'sql' => $sql,
                    'tableid' => $id,
                    'key' => 'line',
                    'txtclass' => 'bodytextbox',
                    'checkbox' => $gridcheckbox,
                    'template'=> ['checkbox','buttons','columns'],
                    'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                    'column' => [
                        [
                            'name' => 'barcode',
                            'editable' => $editable,
                            'readonly' => $readonly,
                            'type' => 'text',
                            'width' => '150px',
                            'class'=>'col-codes stocktxt',
                        ],[
                            'name' => 'itemname',
                            'editable' => $editable,
                            'type' => 'text',
                            'width' => '250px',
                            'class'=>'col-description stocktxt',
                        ],$pandafield1,$pandafield2,[
                            'name' => 'isqty',
                            'editable' => $editable,
                            'default' => '0.00',
                            'label' => 'Qty',
                            'type' => 'text',
                            'viewtype' => 'quantity',
                            'class' => 'col-quantity stocktxt txtcompute txtisqty'
                        ],$kinggfield1,[
                            'name' => 'uom',
                            'editable' => $editable,
                            'label' => 'UOM',
                            'type' => 'lookup',
                            'lookupbutton' => ['autocall'=>'uom',
                                              'colw'=>'col-min',
                                              'lookupclass'=>'gvbtns stockuomlookup',
                                              'lookuptxtclass'=>'minitxtcombo'],
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
                            'name' => 'whcode',
                            'editable' => $editable,
                            'readonly' => $readonly,
                            'default' => '0.00',
                            'label' => 'WH',
                            'type' => 'lookup',
                            'lookupbutton' => ['autocall'=>'warehouse',
                                              'colw'=>'col-codes',
                                              'lookupclass'=>'gvbtns whlookupstock',
                                              'lookuptxtclass'=>'minitxtcombo'],
                        ],[
                            'name' => 'loc',
                            'editable' => $editable,
                            'default' => '',
                            'label' => 'Location',
                            'class' => 'col-currency stocktxt txtext',
                            'type' => 'text',
                            'width' => '150px;'
                        ],[
                            'name' => 'loc2',
                            'editable' => $editable,                    
                            'default' => '',
                            'label' => 'Location',
                            'class' => 'col-currency stocktxt txtext',
                            'type' => 'text',
                            'width' => '150px;'
                        ],[
                            'name' => 'expiry',
                            'editable' => $editable,
                            'readonly' => $expreadonly,
                            'default' => '',
                            'label' => 'Expiry',
                            'class' => 'col-codes stocktxt txtstockdate',
                            'type' => 'datepicker',
                        ],[
                            'name' => 'ref',
                            'editable' => $editable,
                            'readonly' => $readonly,
                            'default' => '',
                            'label' => 'Reference',
                            'type' => 'text',
                            'class' => 'col-codes stocktxt txtref'
                        ],[
                            'name' => 'rem',
                            'editable' => $editable,
                            'default' => '----',
                            'label' => 'Notes',
                            'type' => 'text',
                            'class' => 'col-description stocktxt txtrem'
                        ],[
                            'name' => 'line',
                            'hidden' => true,
                            'class' => 'txtline txthidden',
                            'default'=>'0',
                        ],[
                            'name' => 'iss',
                            'hidden' => true,
                            'class' => 'txtiss txthidden',
                            'default'=>'0.00',
                        ],[
                            'name' => 'amt',
                            'hidden' => true,
                            'class' => 'txtamt txthidden',
                            'default'=>'0',
                        ],[
                            'name' => 'disc',
                            'hidden' => true,
                            'class' => 'txtdisc txthidden',
                            'default'=>'0',
                        ],[
                            'name' => 'itemid',
                            'hidden' => true,
                            'class' => 'txtstockitemid txthidden',
                            'default'=>'0',
                        ],[
                            'name' => 'uomfactor',
                            'hidden' => true,
                            'class' => 'txtstockfactor txthidden',
                            'default'=>'0',
                        ],[
                            'name' => 'refx',
                            'hidden' => true,
                            'class' => 'txtstockrefx txthidden',
                            'default'=>'0',
                        ],[
                            'name' => 'linex',
                            'hidden' => true,
                            'class' => 'txtstocklinex txthidden',
                            'default'=>'0',
                        ]
                    ],
                    
                    'buttons' => $btnset
                ];
            break;
        }//END SWITCH

        
          
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function generateTRStockview($sql,$type){
        if($type == ''){
            $readonly = true;
            $editable = true;
            $gridcheckbox = false;
            $id = 'trstockview';
            $btnset = [[
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stocksavebtn gvbtns btn btn-social-icon btn-bitbucket',
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stockdeletebtn gvbtns btn btn-social-icon btn-google'
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'showbalance gvbtns btn btn-social-icon btn-github'
                ],];
        }else{
            $readonly = false;
            $editable = false;
            $gridcheckbox = false;
            $id = 'trstockview_viewonly';
            $btnset = '';
        }//end if

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                $expreadonly = false;
            break;

            default:
                $expreadonly = true;
            break;
        }//END SWITCH

        $params = [
            'sql' => $sql,
            'tableid' => $id,
            'key' => 'line', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'checkbox' => $gridcheckbox,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode', //FIELD NAME SA QUERY
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'type' => 'text',
                    'width' => '150px',
                    'class'=>'col-codes stocktxt',
                ],[
                    'name' => 'rrqty',
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
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'uom',
                                      'colw'=>'col-min',
                                      'lookupclass'=>'gvbtns stockuomlookup',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'itemname', //FIELD NAME SA QUERY
                    'editable' => $editable,
                    'type' => 'text',
                    'width' => '250px',
                    'class'=>'col-description stocktxt',
                ],[
                    'name' => 'rrcost',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Price',
                    'type' => 'text',
                    'viewtype' => 'unitprice',
                    'class' => 'col-currency txtcompute stocktxt txtisamt'
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
                    'name' => 'whcode',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'default' => '0.00',
                    'label' => 'WH',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'warehouse',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns whlookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'wh',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'loc',
                    'editable' => $editable,
                    'default' => '',
                    'label' => 'Location',
                    'class' => 'col-currency stocktxt txtext',
                    'type' => 'text',
                ],[
                    'name' => 'expiry',
                    'editable' => $editable,
                    'readonly' => $expreadonly,
                    'default' => '----',
                    'label' => 'Expiry',
                    'type' => 'text',
                    'class' => 'col-description stocktxt txtexpiry'
                ],[
                    'name' => 'rem',
                    'editable' => $editable,
                    'default' => '----',
                    'label' => 'Notes',
                    'type' => 'text',
                    'class' => 'col-description stocktxt txtrem'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'qty',
                    'hidden' => true,
                    'class' => 'txtqty txthidden',
                    'default'=>'0.00',
                ],[
                    'name' => 'cost',
                    'hidden' => true,
                    'class' => 'txtcost txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'disc',
                    'hidden' => true,
                    'class' => 'txtdisc txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'void',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => '0'
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txtstockitemid txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'uomfactor',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => '0'
                ]
            ],
            
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function generateAJStockview($sql,$type){
        if($type == ''){
            $readonly = true;
            $editable = true;
            $gridcheckbox = false;
            $id = 'ajstockview';
            $btnset = [[
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stocksavebtn gvbtns btn btn-social-icon btn-bitbucket',
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stockdeletebtn gvbtns btn btn-social-icon btn-google'
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'showbalance gvbtns btn btn-social-icon btn-github'
                ],];
        }else{
            $readonly = false;
            $editable = false;
            $gridcheckbox = false;
            $id = 'ajstockview_viewonly';
            $btnset = '';
        }//end if

        $pandafield1 = ['name'=>''];
        $pandafield2 = ['name'=>''];
        $kinggfield1 = ['name'=>''];
        
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                $expreadonly = false;
            break;

            default:
                $expreadonly = true;
            break;
        }//END SWITCH

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'KINGGEORGE':
                $kinggfield1 = [
                    'name' => 'kgs',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Buying KG',
                    'type' => 'text',
                    'viewtype' => 'quantity',
                    'class' => 'col-quantity stocktxt txtcompute txtkgs'
                ];        
            break;
        }//END SWITHC
        

        $params = [
            'sql' => $sql,
            'tableid' => $id,
            'key' => 'line', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'checkbox' => $gridcheckbox,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode', //FIELD NAME SA QUERY
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'type' => 'text',
                    'width' => '150px',
                    'class'=>'col-codes stocktxt',
                ],[
                    'name' => 'itemname', //FIELD NAME SA QUERY
                    'editable' => $editable,
                    'type' => 'text',
                    'width' => '250px',
                    'class'=>'col-description stocktxt',
                ],$pandafield1,$pandafield2,[
                    'name' => 'rrqty',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Qty',
                    'type' => 'text',
                    'viewtype' => 'quantity',
                    'class' => 'col-quantity stocktxt txtcompute txtisqty'
                ],$kinggfield1,[
                    'name' => 'uom',
                    'editable' => $editable,
                    'label' => 'UOM',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'uom',
                                      'colw'=>'col-min',
                                      'lookupclass'=>'gvbtns stockuomlookup',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'rrcost',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Price',
                    'type' => 'text',
                    'viewtype' => 'currency',
                    'class' => 'col-currency txtcompute stocktxt txtisamt'
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
                    'name' => 'whcode',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'default' => '0.00',
                    'label' => 'WH',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'warehouse',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns whlookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'wh',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'loc',
                    'editable' => $editable,
                    'default' => '',
                    'label' => 'Location',
                    'class' => 'col-currency stocktxt txtext',
                    'type' => 'text',
                    'width' => '150px;'
                ],
                [
                    'name' => 'expiry',
                    'editable' => $editable,   
                    'readonly' => $expreadonly,                 
                    'default' => '----',
                    'label' => 'Expiry',
                    'type' => 'text',
                    'class' => 'col-description stocktxt txtexpiry'
                ],[
                    'name' => 'rem',
                    'editable' => $editable,
                    'default' => '----',
                    'label' => 'Notes',
                    'type' => 'text',
                    'class' => 'col-description stocktxt txtrem'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'qty',
                    'hidden' => true,
                    'class' => 'txtqty txthidden',
                    'default'=>'0.00',
                ],[
                    'name' => 'iss',
                    'hidden' => true,
                    'class' => 'txtiss txthidden',
                    'default'=>'0.00',
                ],
                [
                    'name' => 'cost',
                    'hidden' => true,
                    'class' => 'txtcost txthidden',
                    'default'=>'0',
                ],
                [
                    'name' => 'disc',
                    'hidden' => true,
                    'class' => 'txtdisc txthidden',
                    'default'=>'0',
                ],
                [
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txtstockitemid txthidden',
                    'default'=>'0',
                ],
                [
                    'name' => 'uomfactor',
                    'hidden' => true,
                    'class' => 'txtstockfactor txthidden',
                    'default'=>'0',
                ],
                [
                    'name' => 'refx',
                    'hidden' => true,
                    'class' => 'txtstockrefx txthidden',
                    'default'=>'0',
                ],
                [
                    'name' => 'linex',
                    'hidden' => true,
                    'class' => 'txtstocklinex txthidden',
                    'default'=>'0',
                ],
            ],
            
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function generateISStockview($sql,$type){
        if($type == ''){
            $readonly = true;
            $editable = true;
            $gridcheckbox = false;
            $id = 'isstockview';
            $btnset = [[
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stocksavebtn gvbtns btn btn-social-icon btn-bitbucket',
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stockdeletebtn gvbtns btn btn-social-icon btn-google'
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'showbalance gvbtns btn btn-social-icon btn-github'
                ],];
        }else{
            $readonly = false;
            $editable = false;
            $gridcheckbox = false;
            $id = 'isstockview_viewonly';
            $btnset = '';
        }//end if

        $pandafield1 = ['name'=>''];
        $pandafield2 = ['name'=>''];
        $kinggfield1 = ['name'=>''];
        

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                $expreadonly = false;
            break;

            default:
                $expreadonly = true;
            break;
        }//END SWITCH

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'KINGGEORGE':
                $kinggfield1 = [
                    'name' => 'kgs',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Buying KG',
                    'type' => 'text',
                    'viewtype' => 'quantity',
                    'class' => 'col-quantity stocktxt txtcompute txtkgs'
                ];        
            break;
        }//END SWITHC

        $params = [
            'sql' => $sql,
            'tableid' => $id,
            'key' => 'line', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'checkbox' => $gridcheckbox,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode', //FIELD NAME SA QUERY
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'type' => 'text',
                    'width' => '150px',
                    'class'=>'col-codes stocktxt',
                ],
                [
                    'name' => 'itemname', //FIELD NAME SA QUERY
                    'editable' => $editable,
                    'type' => 'text',
                    'width' => '250px',
                    'class'=>'col-description stocktxt',
                ],$pandafield1,$pandafield2,[
                    'name' => 'rrqty',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Qty',
                    'type' => 'text',
                    'viewtype' => 'quantity',
                    'class' => 'col-quantity stocktxt txtcompute txtisqty'
                ],$kinggfield1,
                [
                    'name' => 'uom',
                    'editable' => $editable,
                    'label' => 'UOM',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'uom',
                                      'colw'=>'col-min',
                                      'lookupclass'=>'gvbtns stockuomlookup',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],
                [
                    'name' => 'rrcost',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Price',
                    'type' => 'text',
                    'viewtype' => 'currency',
                    'class' => 'col-currency txtcompute stocktxt txtisamt'
                ],
                [
                    'name' => 'ext',
                    'label' => 'Total',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'class' => 'col-currency stocktxt txtext',
                    'type' => 'text',
                    'viewtype' => 'currency',
                    'width' => '150px;'
                ],[
                    'name' => 'whcode',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'default' => '0.00',
                    'label' => 'WH',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'warehouse',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns whlookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],
                [
                    'name' => 'wh',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ],
                [
                    'name' => 'loc',
                    'editable' => $editable,
                    'default' => '',
                    'label' => 'Location',
                    'class' => 'col-currency stocktxt txtext',
                    'type' => 'text',
                    'width' => '150px;'
                ],[
                    'name' => 'expiry',
                    'editable' => $editable,
                    'readonly' => $expreadonly,
                    'default' => '',
                    'label' => 'Expiry',
                    'class' => 'col-codes stocktxt txtstockdate',
                    'type' => 'datepicker',
                ],[
                    'name' => 'rem',
                    'editable' => $editable,
                    'default' => '----',
                    'label' => 'Notes',
                    'type' => 'text',
                    'class' => 'col-description stocktxt txtrem'
                ],[
                    'name' => 'ref',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'default' => '',
                    'label' => 'Reference',
                    'type' => 'text',
                    'class' => 'col-codes stocktxt txtref'
                ],
                [
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ],

                [
                    'name' => 'qty',
                    'hidden' => true,
                    'class' => 'txtqty txthidden',
                    'default'=>'0.00',
                ],
                [
                    'name' => 'cost',
                    'hidden' => true,
                    'class' => 'txtcost txthidden',
                    'default'=>'0',
                ],
                [
                    'name' => 'disc',
                    'hidden' => true,
                    'class' => 'txtdisc txthidden',
                    'default'=>'0',
                ],
                [
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txtstockitemid txthidden',
                    'default'=>'0',
                ],
                [
                    'name' => 'uomfactor',
                    'hidden' => true,
                    'class' => 'txtstockfactor txthidden',
                    'default'=>'0',
                ],
                [
                    'name' => 'refx',
                    'hidden' => true,
                    'class' => 'txtstockrefx txthidden',
                    'default'=>'0',
                ],
                [
                    'name' => 'linex',
                    'hidden' => true,
                    'class' => 'txtstocklinex txthidden',
                    'default'=>'0',
                ],
            ],
            
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function generateCMStockview($sql,$type){
        if($type == ''){
            $readonly = true;
            $editable = true;
            $gridcheckbox = false;
            $id = 'cmstockview';
            $btnset = [[
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stocksavebtn gvbtns btn btn-social-icon btn-bitbucket',
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stockdeletebtn gvbtns btn btn-social-icon btn-google'
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'showbalance gvbtns btn btn-social-icon btn-github'
                ],];
        }else{
            $readonly = false;
            $editable = false;
            $gridcheckbox = false;
            $id = 'cmstockview_viewonly';
            $btnset = '';
        }//end if

        $pandafield1 = ['name'=>''];
        $pandafield2 = ['name'=>''];
        $kinggfield1 = ['name'=>''];
        
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                $expreadonly = false;
            break;

            default:
                $expreadonly = true;
            break;
        }//END SWITCH


        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'KINGGEORGE':
                $kinggfield1 = [
                    'name' => 'kgs',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Selling KG',
                    'type' => 'text',
                    'viewtype' => 'quantity',
                    'class' => 'col-quantity stocktxt txtcompute txtkgs'
                ];        
            break;
        }//END SWITHC
        

        $params = [
            'sql' => $sql,
            'tableid' => $id,
            'key' => 'line', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'checkbox' => $gridcheckbox,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode', //FIELD NAME SA QUERY
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'type' => 'text',
                    'width' => '150px',
                    'class'=>'col-codes stocktxt',
                ],[
                    'name' => 'itemname', //FIELD NAME SA QUERY
                    'editable' => $editable,
                    'type' => 'text',
                    'width' => '250px',
                    'class'=>'col-description stocktxt',
                ],$pandafield1,$pandafield2,[
                    'name' => 'rrqty',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Qty',
                    'type' => 'text',
                    'viewtype' => 'quantity',
                    'class' => 'col-quantity stocktxt txtcompute txtisqty'
                ],$kinggfield1,[
                    'name' => 'uom',
                    'editable' => $editable,
                    'label' => 'UOM',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'uom',
                                      'colw'=>'col-min',
                                      'lookupclass'=>'gvbtns stockuomlookup',
                                      'lookuptxtclass'=>'minitxtcombo'],
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
                    'name' => 'amt',
                    'label' => 'Net Price',
                    'default' => '0.00',
                    'type' => 'text',
                    'editable' => true,
                    'readonly' => true,
                    'viewtype' => 'unitprice',
                    'class' => 'col-currency txtstockamt stocktxt',
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
                    'name' => 'whcode',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'default' => '0.00',
                    'label' => 'WH',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'warehouse',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns whlookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'loc',
                    'label' => 'Location',
                    'editable' => $editable,
                    'type' => 'text',
                    'class' => 'col-codes aimslabel stocktxt'
                ],[
                    'name' => 'expiry',
                    'editable' => $editable,
                    'readonly' => $expreadonly,
                    'type' => 'datepicker',
                    'class' => 'col-codes aimslabel stocktxt'
                ],[
                    'name' => 'ref',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'default' => '----',
                    'label' => 'Reference',
                    'type' => 'text',
                    'class' => 'col-codes stocktxt txtref'
                ],[
                    'name' => 'rem',
                    'editable' => $editable,
                    'default' => '----',
                    'label' => 'Notes',
                    'type' => 'text',
                    'class' => 'col-description stocktxt txtrem'
                ],[
                    'name' => 'wh',
                    'hidden' => true,
                    'class' => 'txtstockwh txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'qty',
                    'hidden' => true,
                    'class' => 'txtstockqty txthidden',
                    'default' => '0'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txtstockline txthidden',
                    'default' => '0'
                ],[
                    'name' => 'refx',
                    'hidden' => true,
                    'class' => 'txtstockrefx txthidden',
                    'default' => '0'
                ],[
                    'name' => 'linex',
                    'hidden' => true,
                    'class' => 'txtstocklinex txthidden',
                    'default' => '0'
                ],[
                    'name' => 'cost',
                    'hidden' => true,
                    'class' => 'txtstockcost txthidden',
                    'default' => '0'
                ],[
                    'name' => 'uomfactor',
                    'hidden' => true,
                    'class' => 'txtstockuomfactor txthidden',
                    'default' => '0'
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txtstockitemid txthidden',
                    'default'=>'0',
                ]
            ],
            
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function generateDMStockview($sql,$type){
        if($type == ''){
            $readonly = true;
            $editable = true;
            $gridcheckbox = false;
            $id = 'dmstockview';
            $btnset = [[
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stocksavebtn gvbtns btn btn-social-icon btn-bitbucket',
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stockdeletebtn gvbtns btn btn-social-icon btn-google'
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'showbalance gvbtns btn btn-social-icon btn-github'
                ],];
        }else{
            $readonly = false;
            $editable = false;
            $gridcheckbox = false;
            $id = 'dmstockview_viewonly';
            $btnset = '';
        }//end if

        $pandafield1 = ['name'=>''];
        $pandafield2 = ['name'=>''];
        $kinggfield1 = ['name'=>''];
        
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                $expreadonly = false;
            break;

            default:
                $expreadonly = true;
            break;
        }//END SWITCH

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'KINGGEORGE':
                $kinggfield1 = [
                    'name' => 'kgs',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Buying KG',
                    'type' => 'text',
                    'viewtype' => 'quantity',
                    'class' => 'col-quantity stocktxt txtcompute txtkgs'
                ];        
            break;
        }//END SWITHC
        

        $params = [
            'sql' => $sql,
            'tableid' => $id,
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'checkbox' => $gridcheckbox,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'type' => 'text',
                    'width' => '150px',
                    'class'=>'col-codes stocktxt',
                ],[
                    'name' => 'itemname', //FIELD NAME SA QUERY
                    'editable' => $editable,
                    'type' => 'text',
                    'width' => '250px',
                    'class'=>'col-description stocktxt',
                ],$pandafield1,$pandafield2,[
                    'name' => 'isqty',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Qty',
                    'type' => 'text',
                    'viewtype' => 'quantity',
                    'class' => 'col-quantity stocktxt txtcompute txtisqty'
                ],$kinggfield1,[
                    'name' => 'uom',
                    'editable' => $editable,
                    'label' => 'UOM',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'uom',
                                      'colw'=>'col-min',
                                      'lookupclass'=>'gvbtns stockuomlookup',
                                      'lookuptxtclass'=>'minitxtcombo'],
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
                ],
                [
                    'name' => 'ext',
                    'label' => 'Total',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'class' => 'col-currency stocktxt txtext',
                    'type' => 'text',
                    'viewtype' => 'currency',
                    'width' => '150px;'
                ],[
                    'name' => 'whcode',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'default' => '0.00',
                    'label' => 'WH',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'warehouse',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns whlookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'loc',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'default' => '',
                    'label' => 'Location',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'location',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns locationlookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                  'name' => 'expiry',
                    'editable' => $editable,
                    'readonly' => $expreadonly,
                    'default' => '0.00',
                    'label' => 'Expiry',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'expiry',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns locationlookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'ref',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'default' => '----',
                    'label' => 'Reference',
                    'type' => 'text',
                    'class' => 'col-codes stocktxt txtref'
                ],[
                    'name' => 'rem',
                    'editable' => $editable,
                    'default' => '----',
                    'label' => 'Notes',
                    'type' => 'text',
                    'class' => 'col-description stocktxt txtrem'
                ],[
                    'name' => 'wh',
                    'hidden' => true,
                    'class' => 'txtstockwh txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'iss',
                    'hidden' => true,
                    'class' => 'txtstockiss txthidden',
                    'default' => '0'
                ],[
                    'name' => 'amt',
                    'hidden' => true,
                    'class' => 'txtstockamt txthidden',
                    'default' => '0'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txtstockline txthidden',
                    'default' => '0'
                ],[
                    'name' => 'refx',
                    'hidden' => true,
                    'class' => 'txtstockrefx txthidden',
                    'default' => '0'
                ],[
                    'name' => 'linex',
                    'hidden' => true,
                    'class' => 'txtstocklinex txthidden',
                    'default' => '0'
                ],[
                    'name' => 'uomfactor',
                    'hidden' => true,
                    'class' => 'txtstockuomfactor txthidden',
                    'default' => '0'
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => '0'
                ]
            ],
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn


     public function generateQuoteStockview($sql,$type){
        if($type == ''){
            $readonly = true;
            $editable = true;
            $gridcheckbox = false;
            $id = 'quotestockview';
            $btnset = [[
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stocksavebtn gvbtns btn btn-social-icon btn-bitbucket',
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stockdeletebtn gvbtns btn btn-social-icon btn-google'
                ],];
        }else{
            $readonly = false;
            $editable = false;
            $gridcheckbox = false;
            $id = 'quotestockview_viewonly';
            $btnset = '';
        }//end if

        $pandafield1 = ['name'=>''];
        $pandafield2 = ['name'=>''];

        //WTODO: [KIM][2019.11.28][update quotestockview][additional number of item]
        $params = [
            'sql' => $sql,
            'tableid' => $id,
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'checkbox' => $gridcheckbox,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [ 
                    'name' => 'item',
                    'editable' => $editable,
                    'default' => '',
                    'label' => 'Item',
                    'type' => 'text',
                    'class' => 'col-quantity stocktxt txtitem'
                ],[

                    'name' => 'barcode',
                    'editable' => $editable,
                    'readonly' => false,
                    'type' => 'elookup',
                    'lookupbutton' => ['autocall'=>'',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns quotebarcodelookup',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'itemname',
                    'editable' => $editable,
                    'type' => 'text',
                    'width' => '250px',
                    'class'=>'col-description stocktxt',
                ],$pandafield1,$pandafield2,[
                    'name' => 'isqty',
                    'editable' => $editable,
                    'default' => '',
                    'label' => 'Qty',
                    'type' => 'text',
                    'class' => 'col-codes stocktxt txtisqty',
                    //WTODO: [KIM][2019.11.29][remove uom]
                ],[
                    'name' => 'isamt',
                    'editable' => $editable,
                    'default' => '',
                    'label' => 'Price',
                    'type' => 'text',
                    'class' => 'col-codes stocktxt txtisamt',
                ],[
                    //WTODO: [KIM][2019.11.29][remove disc and ext]
                    // 'name' => 'disc',
                    // 'editable' => $editable,
                    // 'default' => '',
                    // 'label' => 'Disc',
                    // 'type' => 'text',
                    // 'class' => 'col-min txtcompute stocktxt txtisdisc'
                // ],[
                //     'name' => 'ext',
                //     'label' => 'Total',
                //     'editable' => $editable,
                //     'readonly' => $readonly,
                //     'class' => 'col-currency stocktxt txtext',
                //     'type' => 'text',
                //     'width' => '150px;'
                // ],[
                    'name' => 'qa',
                    'hidden' => true,
                    'default' => '0',
                    'label' => 'Pending',
                    'class' => 'col-min stocktxt txtqa'
                ],[
                    'name' => 'whcode',
                    'hidden' => true,
                    'default' => '0.00',
                    'label' => 'WH',
                ],[
                    'name' => 'loc',
                    'hidden' => true,
                    'default' => '',
                    'label' => 'Location',

                ],[
                    'name' => 'expiry',
                    'hidden' => true,
                    'default' => '1900-01-01',
                ],[
                    //WTODO: [KIM][2019.11.29][remove notes]
                //     'name' => 'rem',
                //     'editable' => $editable,
                //     'default' => '----',
                //     'label' => 'Notes',
                //     'type' => 'text',
                //     'class' => 'col-description stocktxt txtrem'
                // ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'iss',
                    'hidden' => true,
                    'class' => 'txtiss txthidden',
                    'default'=>'',
                ],[
                    'name' => 'amt',
                    'hidden' => true,
                    'class' => 'txtamt txthidden',
                    'default'=>'',
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txtstockitemid txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'uomfactor',
                    'hidden' => true,
                    'class' => 'txtstockfactor txthidden',
                    'default'=>'1',
                ],[
                    'name' => 'void',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => '0'
                ],[
                    'name' => 'tr',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => ''
                ]
            ],
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn
    public function generateTWStockview($sql,$type){
        if($type == ''){
            $readonly = true;
            $editable = true;
            $gridcheckbox = false;
            $id = 'twstockview';
            $btnset = [[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stockdeletebtn gvbtns btn btn-social-icon btn-google'
                ]];
        }else{
            $readonly = false;
            $editable = false;
            $gridcheckbox = false;
            $id = 'twstockview_viewonly';
            $btnset = '';
        }//end if

         $fields = [[
            'name' => 'acnoname',
            'label' => 'Description',
            'class' => 'aimslabel col-description'
        ],[
            'name' => 'month',
            'label' => 'Month',
            'class' => 'aimslabel col-min'
        ],[
            'name' => 'acno',
            'label' => 'ATC',
            'class' => 'aimslabel col-codes'
        ],[
            'name' => 'rate',
            'label' => 'Tax Rate',
            'class' => 'aimslabel col-codes'
        ],[
            'name' => 'income',
            'label' => 'Income',
            'class' => 'aimslabel col-codes'
        ],[
            'name' => 'wheld',
            'label' => 'Tax Withheld',
            'class' => 'aimslabel col-codes'
        ],[
            'name' => 'line',
            'hidden' => true,
            'class' => 'txtline txthidden',
            'default'=>'0',
        ],];

        $params = [
            'sql' => $sql,
            'tableid' => $id,
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'checkbox' => $gridcheckbox,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => $fields,
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function generateSOStockview($sql,$type){
        if($type == ''){
            $readonly = true;
            $editable = true;
            $gridcheckbox = false;
            $id = 'sostockview';
            $btnset = [[
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stocksavebtn gvbtns btn btn-social-icon btn-bitbucket',
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stockdeletebtn gvbtns btn btn-social-icon btn-google'
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'showbalance gvbtns btn btn-social-icon btn-github'
                ],];
        }else{
            $readonly = false;
            $editable = false;
            $gridcheckbox = false;
            $id = 'sostockview_viewonly';
            $btnset = '';
        }//end if

        $pandafield1 = ['name'=>''];
        $pandafield2 = ['name'=>''];

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                $expreadonly = false;
            break;

            default:
                $expreadonly = true;
            break;
        }//END SWITCH

        $params = [
            'sql' => $sql,
            'tableid' => $id,
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'checkbox' => $gridcheckbox,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
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
                ],$pandafield1,$pandafield2,[
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
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'uom',
                                      'colw'=>'col-min',
                                      'lookupclass'=>'gvbtns stockuomlookup',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'isamt',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Price',
                    'type' => 'text',
                    'viewtype' => 'unitprice',
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
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'warehouse',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns whlookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'loc',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'default' => '',
                    'label' => 'Location',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'location',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns loclookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'expiry',
                    'editable' => $editable,
                    'readonly' => $expreadonly,
                    'default' => '1900-01-01',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'expiry',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns expirylookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'rem',
                    'editable' => $editable,
                    'default' => '----',
                    'label' => 'Notes',
                    'type' => 'text',
                    'class' => 'col-description stocktxt txtrem'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'iss',
                    'hidden' => true,
                    'class' => 'txtiss txthidden',
                    'default'=>'0.00',
                ],[
                    'name' => 'amt',
                    'hidden' => true,
                    'class' => 'txtamt txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txtstockitemid txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'uomfactor',
                    'hidden' => true,
                    'class' => 'txtstockfactor txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'void',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => '0'
                ],[
                    'name' => 'tr',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => ''
                ]
            ],
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn


    public function generateJBStockview($sql,$type){
        if($type == ''){
            $readonly = true;
            $editable = true;
            $gridcheckbox = false;
            $id = 'jbstockview';
            $btnset = [[
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stocksavebtn gvbtns btn btn-social-icon btn-bitbucket',
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stockdeletebtn gvbtns btn btn-social-icon btn-google'
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'showbalance gvbtns btn btn-social-icon btn-github'
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-list-alt" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'showfgdetails gvbtns btn btn-social-icon btn-pinterest',
                    'attributes'=>[['name'=>'barcode','value'=>'barcode']]
                ]];
        }else{
            $readonly = false;
            $editable = false;
            $gridcheckbox = false;
            $id = 'jbstockview_viewonly';
            $btnset = '';
        }//end if

        
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
                    'readonly' => $readonly,
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
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'uom',
                                      'colw'=>'col-min',
                                      'lookupclass'=>'gvbtns stockuomlookup',
                                      'lookuptxtclass'=>'minitxtcombo'],
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
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'warehouse',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns whlookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'loc',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'default' => '',
                    'label' => 'Location',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'location',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns loclookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'expiry',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'default' => '1900-01-01',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'expiry',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns expirylookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'rem',
                    'editable' => $editable,
                    'default' => '----',
                    'label' => 'Notes',
                    'type' => 'text',
                    'class' => 'col-description stocktxt txtrem'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'iss',
                    'hidden' => true,
                    'class' => 'txtiss txthidden',
                    'default'=>'0.00',
                ],[
                    'name' => 'amt',
                    'hidden' => true,
                    'class' => 'txtamt txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txtstockitemid txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'uomfactor',
                    'hidden' => true,
                    'class' => 'txtstockfactor txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'void',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => '0'
                ],[
                    'name' => 'tr',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => ''
                ]
            ],
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function generateRRStockview($sql,$type){
        if($type == ''){
            $readonly = true;
            $editable = true;
            $gridcheckbox = false;
            $id = 'rrstockview';
            $btnset = [[
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stocksavebtn btn btn-social-icon btn-bitbucket',
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stockdeletebtn btn btn-social-icon btn-google'
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'showbalance btn btn-social-icon btn-github'
                ],];
        }else{
            $readonly = false;
            $editable = false;
            $gridcheckbox = false;
            $id = 'rrstockview_viewonly';
            $btnset = '';
        }//end if

        $pandafield1 = ['name'=>''];
        $pandafield2 = ['name'=>''];
        $kinggfield1 = ['name'=>''];
        

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'KINGGEORGE':
                $kinggfield1 = [
                    'name' => 'kgs',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Buying KG',
                    'type' => 'text',
                    'viewtype' => 'quantity',
                    'class' => 'col-quantity stocktxt txtcompute txtkgs'
                ];        
            break;
        }//END SWITHC

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                $expreadonly = false;
            break;

            default:
                $expreadonly = true;
            break;
        }//END SWITCH
        

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'CANUMAY':
              $addedfields = [['name' => 'msako',
                              'editable' => true,
                                  // 'readonly' => true,
                              'default' => '',
                              'label' => 'Minus Sako',
                              'type' => 'text',
                              'viewtype' => 'quantity',
                              'class' => 'col-codes stocktxt txtmsako'
                              ],[
                              'name' => 'tsako',
                              'editable' => true,
                                  // 'readonly' => true,
                              'default' => '',
                              'label' => 'Total Sako',
                              'type' => 'text',
                              'viewtype' => 'quantity',
                              'class' => 'col-codes stocktxt txttsako']];
            break;

            default:
              $addedfields='';
            break;
        }//end switch

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                $cols = [
                    [
                        'name' => 'itemname', //FIELD NAME SA QUERY
                        'editable' => $editable,
                        'type' => 'text',
                        'width' => '250px',
                        'class'=>'col-description stocktxt',
                    ],[
                        'name' => 'rrqty',
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
                        'type' => 'lookup',
                        'lookupbutton' => ['autocall'=>'uom',
                                          'colw'=>'col-min',
                                          'lookupclass'=>'gvbtns stockuomlookup',
                                          'lookuptxtclass'=>'minitxtcombo'],
                    ],[
                        'name' => 'rrcost',
                        'editable' => $editable,
                        'default' => '0.00',
                        'label' => 'Price',
                        'type' => 'text',
                        'viewtype' => 'unitprice',
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
                        'name' => 'expiry',
                        'editable' => $editable,
                        'readonly' => $expreadonly,
                        'default' => '',
                        'label' => 'Expiry',
                        'class' => 'col-codes stocktxt txtstockdate',
                        'type' => 'datepicker',
                    ],[
                        'name' => 'rem',
                        'editable' => $editable,
                        'default' => '----',
                        'label' => 'Notes',
                        'type' => 'text',
                        'class' => 'col-description stocktxt txtrem'
                    ],[
                        'name' => 'barcode', //FIELD NAME SA QUERY
                        'editable' => $editable,
                        'readonly' => $readonly,
                        'type' => 'text',
                        'width' => '150px',
                        'class'=>'col-codes stocktxt',
                    ],[
                        'name' => 'whcode',
                        'editable' => $editable,
                        'readonly' => $readonly,
                        'default' => '0.00',
                        'label' => 'WH',
                        'type' => 'lookup',
                        'lookupbutton' => ['autocall'=>'warehouse',
                                          'colw'=>'col-codes',
                                          'lookupclass'=>'gvbtns whlookupstock',
                                          'lookuptxtclass'=>'minitxtcombo'],
                    ],[
                        'name' => 'loc',
                        'editable' => $editable,
                        'default' => '',
                        'label' => 'Location',
                        'class' => 'col-currency stocktxt txtstocklocation',
                        'type' => 'text',
                        'width' => '150px;'
                    ],[
                        'name' => 'ref',
                        'editable' => $editable,
                        'readonly' => $readonly,
                        'default' => '',
                        'label' => 'Reference',
                        'type' => 'text',
                        'class' => 'col-codes stocktxt txtref'
                    ],[
                        'name' => 'qa',
                        'hidden' => true,
                        'default' => '0',
                        'class' => 'txthidden'
                    ],[
                        'name' => 'line',
                        'hidden' => true,
                        'class' => 'txtline txthidden',
                        'default'=>'0',
                    ],

                    [
                        'name' => 'qty',
                        'hidden' => true,
                        'class' => 'txtqty txthidden',
                        'default'=>'0.00',
                    ],
                    [
                        'name' => 'cost',
                        'hidden' => true,
                        'class' => 'txtcost txthidden',
                        'default'=>'0',
                    ],
                    [
                        'name' => 'itemid',
                        'hidden' => true,
                        'class' => 'txtstockitemid txthidden',
                        'default'=>'0',
                    ],
                    [
                        'name' => 'uomfactor',
                        'hidden' => true,
                        'class' => 'txtstockfactor txthidden',
                        'default'=>'0',
                    ],
                    [
                        'name' => 'refx',
                        'hidden' => true,
                        'class' => 'txtstockrefx txthidden',
                        'default'=>'0',
                    ],
                    [
                        'name' => 'linex',
                        'hidden' => true,
                        'class' => 'txtstocklinex txthidden',
                        'default'=>'0',
                    ],
                ];
            break;
            
            default:
                $cols = [
                    [
                        'name' => 'barcode', //FIELD NAME SA QUERY
                        'editable' => $editable,
                        'readonly' => $readonly,
                        'type' => 'text',
                        'width' => '150px',
                        'class'=>'col-codes stocktxt',
                    ],
                    [
                        'name' => 'itemname', //FIELD NAME SA QUERY
                        'editable' => $editable,
                        'type' => 'text',
                        'width' => '250px',
                        'class'=>'col-description stocktxt',
                    ],$pandafield1,$pandafield2,[
                        'name' => 'rrqty',
                        'editable' => $editable,
                        'default' => '0.00',
                        'label' => 'Qty',
                        'type' => 'text',
                        'viewtype' => 'quantity',
                        'class' => 'col-quantity stocktxt txtcompute txtisqty'
                    ],$kinggfield1,
                    [
                        'name' => 'uom',
                        'editable' => $editable,
                        'label' => 'UOM',
                        'type' => 'lookup',
                        'lookupbutton' => ['autocall'=>'uom',
                                          'colw'=>'col-min',
                                          'lookupclass'=>'gvbtns stockuomlookup',
                                          'lookuptxtclass'=>'minitxtcombo'],
                    ],
                    [
                        'name' => 'rrcost',
                        'editable' => $editable,
                        'default' => '0.00',
                        'label' => 'Price',
                        'type' => 'text',
                        'viewtype' => 'unitprice',
                        'class' => 'col-currency txtcompute stocktxt txtisamt'
                    ],
                    [
                        'name' => 'disc',
                        'editable' => $editable,
                        'default' => '',
                        'label' => 'Disc',
                        'type' => 'text',
                        'class' => 'col-min stocktxt txtcompute txtisdisc'
                    ],
                    [
                        'name' => 'ext',
                        'label' => 'Total',
                        'editable' => $editable,
                        'readonly' => $readonly,
                        'class' => 'col-currency stocktxt txtext',
                        'type' => 'text',
                        'viewtype' => 'currency',
                        'width' => '150px;'
                    ],
                    [
                        'name' => 'qa',
                        'hidden' => true,
                        'default' => '0',
                        'class' => 'txthidden'
                    ],
                    [
                        'name' => 'whcode',
                        'editable' => $editable,
                        'readonly' => $readonly,
                        'default' => '0.00',
                        'label' => 'WH',
                        'type' => 'lookup',
                        'lookupbutton' => ['autocall'=>'warehouse',
                                          'colw'=>'col-codes',
                                          'lookupclass'=>'gvbtns whlookupstock',
                                          'lookuptxtclass'=>'minitxtcombo'],
                    ],
                    [
                        'name' => 'loc',
                        'editable' => $editable,
                        'default' => '',
                        'label' => 'Location',
                        'class' => 'col-currency stocktxt txtstocklocation',
                        'type' => 'text',
                        'width' => '150px;'
                    //     'type' => 'lookup',
                    //     'lookupbutton' => ['autocall'=>'location',
                    //                       'colw'=>'col-codes',
                    //                       'lookupclass'=>'gvbtns loclookupstock',
                    //                       'lookuptxtclass'=>'minitxtcombo'],
                    ],
                    [
                        'name' => 'expiry',
                        'editable' => $editable,
                        'readonly' => $expreadonly,
                        'default' => '',
                        'label' => 'Expiry',
                        'class' => 'col-codes stocktxt txtstockdate',
                        'type' => 'datepicker',
                    ],
                    [
                        'name' => 'rem',
                        'editable' => $editable,
                        'default' => '----',
                        'label' => 'Notes',
                        'type' => 'text',
                        'class' => 'col-description stocktxt txtrem'
                    ],
                    [
                        'name' => 'ref',
                        'editable' => $editable,
                        'readonly' => $readonly,
                        'default' => '',
                        'label' => 'Reference',
                        'type' => 'text',
                        'class' => 'col-codes stocktxt txtref'
                    ],
                    [
                        'name' => 'line',
                        'hidden' => true,
                        'class' => 'txtline txthidden',
                        'default'=>'0',
                    ],

                    [
                        'name' => 'qty',
                        'hidden' => true,
                        'class' => 'txtqty txthidden',
                        'default'=>'0.00',
                    ],
                    [
                        'name' => 'cost',
                        'hidden' => true,
                        'class' => 'txtcost txthidden',
                        'default'=>'0',
                    ],
                    [
                        'name' => 'itemid',
                        'hidden' => true,
                        'class' => 'txtstockitemid txthidden',
                        'default'=>'0',
                    ],
                    [
                        'name' => 'uomfactor',
                        'hidden' => true,
                        'class' => 'txtstockfactor txthidden',
                        'default'=>'0',
                    ],
                    [
                        'name' => 'refx',
                        'hidden' => true,
                        'class' => 'txtstockrefx txthidden',
                        'default'=>'0',
                    ],
                    [
                        'name' => 'linex',
                        'hidden' => true,
                        'class' => 'txtstocklinex txthidden',
                        'default'=>'0',
                    ],
                ];
            break;
        }//end switch

        $params = [
            'sql' => $sql,
            'tableid' => $id,
            'key' => 'line', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'checkbox' => $gridcheckbox,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => $cols,
            'buttons' => $btnset
        ];
        
        if($addedfields!=''){
          Yii::$app->backend->appendArrays($params['column'],$addedfields);
        }//end if
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function generatePOStockview($sql,$type){
        if($type == ''){
            $readonly = true;
            $editable = true;
            $gridcheckbox = false;
            $id = 'postockview';
            $btnset = [[
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stocksavebtn gvbtns btn btn-social-icon btn-bitbucket',
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stockdeletebtn gvbtns btn btn-social-icon btn-google'
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'showbalance  gvbtns btn btn-social-icon btn-github'
                ]];
        }else{
            $readonly = false;
            $editable = false;
            $gridcheckbox = false;
            $id = 'postockview_viewonly';
            $btnset = '';
        }//end if

        $pandafield1 = ['name'=>''];
        $pandafield2 = ['name'=>''];

        

        $params = [
            'sql' => $sql,
            'tableid' => $id,
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'checkbox' => $gridcheckbox,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'type' => 'text',
                    'width' => '150px',
                    'class'=>'col-codes stocktxt',
                ],[
                    'name' => 'itemname',
                    'editable' => $editable,
                    'type' => 'text',
                    'width' => '250px',
                    'class'=>'col-description stocktxt',
                ],$pandafield1,$pandafield2,[
                    'name' => 'rrqty',
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
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'uom',
                                      'colw'=>'col-min',
                                      'lookupclass'=>'gvbtns stockuomlookup',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'rrcost',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Price',
                    'type' => 'text',
                    'viewtype' => 'unitprice',
                    'class' => 'col-currency txtcompute stocktxt txtisamt'
                ],[
                    'name' => 'disc',
                    'editable' => $readonly,
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
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'warehouse',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns whlookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'loc',
                    'editable' => $editable,
                    'default' => '',
                    'label' => 'Location',
                    'class' => 'col-currency stocktxt txtext',
                    'type' => 'text',
                    'width' => '150px;'
                ],[
                    'name' => 'rem',
                    'editable' => $editable,
                    'default' => '----',
                    'label' => 'Notes',
                    'type' => 'text',
                    'class' => 'col-description stocktxt txtrem'
                ],[
                    'name' => 'ref',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'default' => '',
                    'label' => 'Reference',
                    'type' => 'text',
                    'class' => 'col-codes stocktxt txtref'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'qty',
                    'hidden' => true,
                    'class' => 'txtqty txthidden',
                    'default'=>'0.00',
                ],[
                    'name' => 'cost',
                    'hidden' => true,
                    'class' => 'txtcost txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txtstockitemid txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'uomfactor',
                    'hidden' => true,
                    'class' => 'txtstockfactor txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'refx',
                    'hidden' => true,
                    'class' => 'txtstockrefx txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'linex',
                    'hidden' => true,
                    'class' => 'txtstocklinex txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'void',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => '0'
                ],[
                    'name' => 'tr',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => ''
                ]
            ],
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end if

    public function generateSJStockview($sql,$type,$controller){
        if($controller->access['changeamount']){
            $amtreadonly = false;
        }else{
            $amtreadonly = true;
        }//end if
        
         switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                $expreadonly = false;

                if($controller->access['changedisc']){
                    $discreadonly = false;
                }else{
                    $discreadonly = true;
                }//end if
            break;

            default:
                $discreadonly = false;
                $expreadonly = true;
            break;
        }//END SWITCH

        if($type == ''){
            $readonly = true;
            $editable = true;
            $amtreadonly = true;
            $discreadonly = true;
            $gridcheckbox = true;
            $id = 'sjstockview';
            $btnset = [[
                'name' => '',
                'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                'class' => 'stocksavebtn btn btn-social-icon btn-bitbucket',
            ],[
                'name' => '',
                'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                'class' => 'stockdeletebtn btn btn-social-icon btn-google'
            ],[
                'name' => '',
                'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                'class' => 'showbalance btn btn-social-icon btn-github'
            ],];
        }else{
            $readonly = false;
            $editable = false;
            $gridcheckbox = true;
            $id = 'sjstockview_viewonly';
            $btnset = '';
        }//end if

        $tenplusfield1 = ['name'=>''];
        $tenplusfield2 = ['name'=>''];
        $universefield1 = ['name'=>''];
        $universefield2 = ['name'=>''];
        $pandafield1 = ['name'=>''];
        $pandafield2 = ['name'=>''];
        $kinggfield1 = ['name'=>''];
        
        $remfield = [
            'name' => 'rem',
            'editable' => $editable,
            'default' => '----',
            'label' => 'Notes',
            'type' => 'text',
            'class' => 'col-description stocktxt txtrem'
        ];


        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                $universefield1 = ['name' => 'agent',
                                  'editable' => $editable,
                                  'default' => '',
                                  'label' => 'Agent',
                                  'type' => 'lookup',
                                  'lookupbutton' => ['autocall'=>'agentstock',
                                  'colw'=>'col-codes',
                                  'lookupclass'=>'gvbtns agentstocklookup',
                                  'lookuptxtclass'=>'agentstock minitxtcombo'],
                                ];

                $universefield2 = ['name' => 'original_qty',
                                  'editable' => true,
                                  'default' => '',
                                  'readonly' => true,
                                  'label' => 'Org. Qty',
                                  'type' => 'text',
                                  'class' => 'col-min stocktxt'
                                ];
            break;
        }//end switch

        $params = [
            'sql' => $sql,
            'tableid' => $id,
            'key' => 'line', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'checkbox' => $gridcheckbox,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
               [
                    'name' => 'itemname', //FIELD NAME SA QUERY
                    'editable' => $editable,
                    'type' => 'text',
                    'width' => '250px',
                    'class'=>'col-description stocktxt',
                ],$pandafield1,$pandafield2,[
                    'name' => 'isqty',
                    'editable' => $editable,
                    'default' => '0.00',
                    'label' => 'Qty',
                    'type' => 'text',
                    'viewtype' => 'quantity',
                    'class' => 'col-quantity stocktxt txtcompute txtisqty'
                ],$universefield2,$kinggfield1,[
                    'name' => 'uom',
                    'editable' => $editable,
                    'label' => 'UOM',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'uom',
                                      'colw'=>'col-min',
                                      'lookupclass'=>'gvbtns stockuomlookup',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'isamt',
                    'editable' => $editable,
                    'readonly' => $amtreadonly,
                    'default' => '0.00',
                    'label' => 'Price',
                    'type' => 'text',
                    'viewtype' => 'unitprice',
                    'class' => 'col-currency txtcompute stocktxt txtisamt'
                ],[
                    'name' => 'disc',
                    'editable' => $editable,
                    'readonly' => $discreadonly,
                    'default' => '',
                    'label' => 'Disc',
                    'type' => 'text',
                    'class' => 'col-min stocktxt txtcompute txtisdisc'
                ],[
                    'name' => 'amt',
                    'label' => 'Net Price',
                    'default' => '0.00',
                    'type' => 'text',
                    'editable' => true,
                    'readonly' => true,
                    'viewtype' => 'unitprice',
                    'class' => 'col-currency txtstockamt stocktxt',
                ],
                $tenplusfield1,$tenplusfield2
                ,[
                    'name' => 'ext',
                    'label' => 'Total',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'class' => 'col-currency stocktxt txtext',
                    'type' => 'text',
                    'viewtype' => 'currency',
                    'width' => '150px;'
                ],[
                    'name' => 'whcode',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'default' => '0.00',
                    'label' => 'WH',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'warehouse',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns whlookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'loc',
                    'editable' => $editable,
                    'default' => '',
                    'label' => 'Location',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'location',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns locationlookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'expiry',
                    'editable' => $editable,
                    'readonly' => $expreadonly,
                    'default' => '1900-01-01',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'expiry',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns locationlookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'ref',
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'default' => '----',
                    'label' => 'Reference',
                    'type' => 'text',
                    'class' => 'col-codes stocktxt txtref'
                ],
                $universefield1,[
                    'name' => 'barcode', //FIELD NAME SA QUERY
                    'editable' => $editable,
                    'readonly' => $readonly,
                    'type' => 'text',
                    'width' => '150px',
                    'class'=>'col-codes stocktxt',
                ],
                $remfield,[
                    'name' => 'wh',
                    'hidden' => true,
                    'class' => 'txtstockwh txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'iss',
                    'hidden' => true,
                    'class' => 'txtstockiss txthidden',
                    'default' => '0'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txtstockline txthidden',
                    'default' => '0'
                ],[
                    'name' => 'refx',
                    'hidden' => true,
                    'class' => 'txtstockrefx txthidden',
                    'default' => '0'
                ],[
                    'name' => 'linex',
                    'hidden' => true,
                    'class' => 'txtstocklinex txthidden',
                    'default' => '0'
                ],[
                    'name' => 'uomfactor',
                    'hidden' => true,
                    'class' => 'txtstockuomfactor txthidden',
                    'default' => '0'
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => '0'
                ]
            ],
            
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function generateSVStockview($sql,$type){
        $readonly = false;
        $editable = false;
        $gridcheckbox = false;
        $id = 'sjstockview';
        $btnset = '';

        $params = [
            'sql' => $sql,
            'tableid' => $id,
            'key' => 'line', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'checkbox' => $gridcheckbox,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode',
                    'label' => 'Barcode',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'rrqty',
                    'label' => 'Qty',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'uom',
                    'label' => 'Barcode',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'itemname',
                    'label' => 'Barcode',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'rrcost',
                    'label' => 'Price',
                    'class' => 'aimslabel col-currency'
                ],[
                    'name' => 'disc',
                    'label' => 'Discount',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'ext',
                    'label' => 'Total',
                    'class' => 'aimslabel col-currency'
                ],[
                    'name' => 'wh',
                    'label' => 'Warehouse',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'loc',
                    'label' => 'Location',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'expiry',
                    'label' => 'Expiry',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'ref',
                    'label' => 'Reference',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'rem',
                    'label' => 'Remarks',
                    'class' => 'aimslabel col-codes'
                ],
            ],
            
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function automateAgentcheckerlookup($params){
        $qry = Yii::$app->backend->searchagentchecker($params['controller'],$params['controller']->access['view'],$params['x']);

        $params = [
            'sql' => $qry,
            'tableid' => 'tbl-checkerlookup',
            'key' => 'agid',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            
            'column' => [[
                    'name' => 'agcode',
                    'label' => 'Agent Code',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'agname',
                    'label' => 'Agent Name',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'agadd',
                    'label' => 'Address',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'agtel',
                    'label' => 'Tel #',
                    'class' => 'aimslabel col-min'
                ]],
            
            'buttons' => [
                [
                'name' => '',
                'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-eye"></i>',
                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                'class' => 'btnagentlookup btn btn-social-icon btn-bitbucket',
                'attributes'=>[['name'=>'id','value'=>'agid'],['name'=>'agcode','value'=>'agcode'],['name'=>'agname','value'=>'agname']],
                ]
            ]
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn agent checker lookup

    public function automateAgentpickerlookup($params){
        $qry = Yii::$app->backend->searchagentpicker($params['controller'],$params['controller']->access['view'],$params['x']);

        $params = [
            'sql' => $qry,
            'tableid' => 'tbl-pickerlookup',
            'key' => 'agid',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            
            'column' => [[
                    'name' => 'agcode',
                    'label' => 'Agent Code',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'agname',
                    'label' => 'Agent Name',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'agadd',
                    'label' => 'Address',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'agtel',
                    'label' => 'Tel #',
                    'class' => 'aimslabel col-min'
                ]],
            
            'buttons' => [
                [
                'name' => '',
                'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                'class' => 'btnagentlookup btn btn-social-icon btn-bitbucket',
                'attributes'=>[['name'=>'id','value'=>'agid'],['name'=>'agcode','value'=>'agcode'],['name'=>'agname','value'=>'agname']],
                ]
            ]
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn end agent picker lookup

    public function automatePrincipallookup($params) {
        $qry = "select line,code,name from uv_principal where name like '%".$params['x']."%' order by line";

        $params = [
                'sql' => $qry,
                'tableid' => 'principal-lookup',
                'key' => 'line',
                'txtclass' => 'bodytextbox',
                'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [
                    [
                        'name' => 'code',
                        'editable' => false,
                        'class' => 'col-codes principaltxt txtcode'
                    ],[
                        'name' => 'name',
                        'editable' => false,
                        'class' => 'col-description principaltxt txtname'
                    ],[
                        'name' => 'line',
                        'hidden' => true,
                        'class' => 'txthidden',
                        'default' => ''
                    ]
                ],
                'buttons' => [
                    [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickprincipal btn btn-social-icon btn-bitbucket',
                    'attributes'=>[['name'=>'line','value'=>'line'],['name'=>'name','value'=>'name']]
                    ]
                ]
            ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f


    public function automatePrincipal2lookup($params){

        $sql = Yii::$app->backend->searchPrincipals($params['controller'],$params['controller']->access['view'],$params['x']);
        $params = [
            'sql' => $sql,
            'tableid' => 'principalstockview',
            'key' => 'line',
            'txtclass' => 'principaltextbox',
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'code',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes principaltxt txtcode'
                ],[
                    'name' => 'name',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes principaltxt txtname'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => ''
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'saveprincipal gvbtns btn btn-social-icon btn-bitbucket',
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'deleteprincipal gvbtns btn btn-social-icon btn-google'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function automateDivisionlookup($controller,$params) {
        $filter = "";

        if(!isset($params['principalid']) || $params['principalid'] == ""){
            if(isset($params['x'])){
                $filter = " where stockgrp_name like '%".$params['x']."%' ";
            }//end if

            $qry = "select stockgrp_id,stockgrp_code,stockgrp_name from stockgrp_masterfile ".$filter." order by stockgrp_id";
        }else{
            if(isset($params['x'])){
                $filter = " and stockgrp.stockgrp_name like '%".$params['x']."%' ";
            }//end if

            $qry = "select item.groupid as stockgrp_id, stockgrp.stockgrp_name from item
                    left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid
                    where item.uv_principal = ".$params['principalid']." ".$filter." group by item.groupid";
        }//end if

        $params = [
                'sql' => $qry,
                'tableid' => 'division-lookup',
                'key' => 'stockgrp_id',
                'txtclass' => 'bodytextbox',
                'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [
                   [
                        'name' => 'stockgrp_name',
                        'editable' => false,
                        'class' => 'col-description divisiontxt txtname'
                    ],[
                        'name' => 'stockgrp_id',
                        'hidden' => true,
                        'class' => 'txthidden',
                        'default' => ''
                    ]
                ],
                'buttons' => [
                    [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickdivision btn btn-social-icon btn-bitbucket',
                    'attributes'=>[['name'=>'stockgrp_id','value'=>'stockgrp_id'],['name'=>'stockgrp_name','value'=>'stockgrp_name']]
                    ]
                ]
            ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function automateUvcategorylookup($controller) {
        
        $qry = "select part_id,part_code,part_name from part_masterfile order by part_id";
       
        $params = [
                'sql' => $qry,
                'tableid' => 'uvcategory-lookup',
                'key' => 'part_id',
                'txtclass' => 'bodytextbox',
                'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [
                   [
                        'name' => 'part_name',
                        'editable' => false,
                        'class' => 'col-description'
                    ],[
                        'name' => 'part_id',
                        'hidden' => true,
                        'class' => 'txthidden',
                        'default' => ''
                    ]
                ],
                'buttons' => [
                    [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickuvcategory btn btn-social-icon btn-bitbucket',
                    'attributes'=>[['name'=>'part_id','value'=>'part_id'],['name'=>'part_name','value'=>'part_name']]
                    ]
                ]
            ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    //WTODO: [KIM][2019.09.16][automateProdtypelookup]
    public function automateProdtypelookup($controller) {
        
        $qry = "select id, code,name from prodtype_masterfile order by id";
        
        $params = [
                'sql' => $qry,
                'tableid' => 'prodtype-lookup',
                'key' => 'id',
                'txtclass' => 'bodytextbox',
                'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [
                    [
                        'name' => 'code',
                        'editable' => false,
                        'class' => 'col-codes'
                    ],[
                        'name' => 'name',
                        'editable' => false,
                        'class' => 'col-description'
                    ],[
                        'name' => 'id',
                        'hidden' => true,
                        'class' => 'txthidden',
                        'default' => ''
                    ]
                ],
                'buttons' => [
                    [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickprodtype btn btn-social-icon btn-bitbucket',
                    'attributes'=>[['name'=>'id','value'=>'id'],['name'=>'name','value'=>'name']]
                    ]
                ]
            ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f


    //WTODO: [KIM][2019.09.16]7[automateMateriallookup]
    public function automateMateriallookup($controller) {
        
        $qry = "select id,code,name from fg_material order by id";
        
        $params = [
                'sql' => $qry,
                'tableid' => 'material-lookup',
                'key' => 'id',
                'txtclass' => 'bodytextbox',
                'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [
                    [
                        'name' => 'code',
                        'editable' => false,
                        'class' => 'col-codes'
                    ],[
                        'name' => 'name',
                        'editable' => false,
                        'class' => 'col-description'
                    ],[
                        'name' => 'id',
                        'hidden' => true,
                        'class' => 'txthidden',
                        'default' => ''
                    ]
                ],
                'buttons' => [
                    [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickmaterial btn btn-social-icon btn-bitbucket',
                    'attributes'=>[['name'=>'id','value'=>'id'],['name'=>'name','value'=>'name']]
                    ]
                ]
            ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f
    
    public function automateComputepacking($params) {
        // var_dump($params);
        // return 0;
        $qry = Yii::$app->backend->searchComputepacking($params['controller'],$params['controller']->access['view'],$params['itemid']);
        // var_dump($qry);
        // return 0;
        $params = [
            'sql' => $qry,
            'tableid' => 'computepacking',
            'key' => 'itemid', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'packaging',
                    'label' => 'Packaging',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'price',
                    'label' => 'Price',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'discount',
                    'label' => 'Discount',
                    'class' => 'aimslabel col-description'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function automateComputecomponents($params) {
        $qry = Yii::$app->backend->searchComputecomponents($params['controller'],$params['controller']->access['view'],$params['itemid']);
        $params = [
            'sql' => $qry,
            'tableid' => 'computecomponents',
            'key' => 'itemid', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode',
                    'label' => 'Barcode',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'itemname',
                    'label' => 'Item Description',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'isqty',
                    'label' => 'Quantity',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'uom',
                    'label' => 'UOM',
                    'class' => 'aimslabel col-description'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function automateComputesupplier($params) {
        $qry = Yii::$app->backend->searchComputesupplier($params['controller'],$params['controller']->access['view'],$params['itemid'],$params['date'],$params['uom'],$params['wh']);
        // echo $qry;
        // return 0;
        $costaccess = Yii::$app->session['loggeduser']['access'][368];

        // var_dump($costaccess);
        // return 0;
        if($costaccess == 1) {
            $c = [
                'name' => 'cost',
                'label' => 'Unit Cost',
                'class' => 'aimslabel col-currency'
            ];
        } else {
            $c = ['name'=>''];
        }
        $columns = [
            [
                'name' => 'client',
                'label' => 'Code',
                'class' => 'aimslabel col-min'
            ],[
                'name' => 'clientname',
                'label' => 'Name',
                'class' => 'aimslabel col-description'
            ],$c,[
                'name' => 'rem',
                'label' => 'Remarks',
                'class' => 'aimslabel col-description'
            ]
        ];
        $params = [
            'sql' => $qry,
            'tableid' => 'computesupplier',
            'key' => 'trno', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => $columns
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function automateSchedGV($params){
        // var_dump($params);
        // return 0;
        if($params['controller']->module->id == 'admin') {
            
            $qry = Yii::$app->backend->loadSchedg1();
            $params = [
                'sql' => $qry,
                'tableid' => 'schedtable1',
                'key' => 'userid',
                'txtclass' => 'sched1textbox',
                'actionheader'=>'&nbspVIEW',
                'column' => [
                    [
                        'name' => 'username',
                        'label' => 'USER',
                        'class'=>'col-min aimslabel',
                    ]
                ],
                
                'buttons' => 
                [
                    [
                        'name' => '',
                        'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                        'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                        'class' => 'indexpageviewsched btn btn-social-icon btn-bitbucket',
                        'attributes' => [['name' => 'username',
                                          'value' => 'userid'],
                                          ['name' => 'sched_type',
                                          'value' => 'sched_type'],
                                         ['name' => 'event_tagging',
                                          'value' => 'event_tagging']
                                        ],
                    ]
                ]

            ];

        } 
       
        return Yii::$app->tblgenerator->generateGrid($params);
    }
    
        public function automateSched2GV($params){
       if($params['controller']->module->id == 'admin') {
       $qry = Yii::$app->backend->loadSchedg2($params);
            $params = 
            [
                'sql' => $qry,
                'tableid' => 'sched2table2',
                'key' => 'username',
                'txtclass' => 'sched2textbox',
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspVIEW&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => 
                [
                   [
                        'name' => 'username',
                        'label' => 'USER',
                        'class' => 'col-code aimslabel'
                    ],[
                        'name' => 'clientname',
                        'label' => 'CUSTOMER',
                        'class' => 'col-code aimslabel'
                    ],[
                        'name' => 'sched_desc',
                        'label' => 'DESCRIPTION',
                        'class' => 'col-code aimslabel'
                    ],[
                        'name' => 'date1',
                        'label' => 'START DATE',
                        'class' => 'col-code aimslabel'
                    ],[
                        'name' => 'date2',
                        'label' => 'END DATE',
                        'class' => 'col-code aimslabel'
                    ],[
                        'name' => 'createdate',
                        'label' => 'CREATEDATE',
                        'class' => 'col-code aimslabel'
                    ],[
                        'name' => 'event_tagging',
                        'label' => 'STATUS',
                        'class' => 'col-code aimslabel'
                    ]
                ],
                
            ];
            return Yii::$app->tblgenerator->generateGrid($params);
        }  
    }
    
    public function automateTransGV($params){
        if($params['controller']->module->id == 'admin') {
            $qry = Yii::$app->backend->loadTransg1();
            
            $params = 
            [
                'sql' => $qry,
                'tableid' => 'transtable1',
                'key' => 'trno',
                'txtclass' => 'trans1textbox',
                'actionheader'=>'&nbspOPTIONS',
                'column' => [
                    [
                        'name' => 'doc',
                        'label' => 'DOCUMENT',
                        'class'=>'col-min aimslabel',
                    ],[
                        'name' => 'counts',
                        'label' => 'COUNT',
                        'class' => 'col-min aimslabel'
                    ]
                ],
                
                'buttons' => 
                [
                    [
                        'name' => '',
                        'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                        'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                        'class' => 'indexpageviewtrans btn btn-social-icon btn-bitbucket',
                        'attributes' => [['name' => 'doc', 'value' => 'doc2']]
                    ]
                ]
            ];
        } 
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function automateTrans2GV($params){
        if($params['controller']->module->id == 'admin') {
            $qry = Yii::$app->backend->loadTransg2($params['x']);
            // echo $qry;
            $params = 
            [
                'sql' => $qry,
                'tableid' => 'trans2table2',
                'key' => 'trno',
                'txtclass' => 'trans2textbox',
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOPTIONS&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => 
                [
                    [
                        'name' => 'dateid',
                        'label' => 'DATE',
                        'class'=>'col-code aimslabel',
                    ],[
                        'name' => 'doc2',
                        'label' => 'DOCUMENT #',
                        'class' => 'col-code aimslabel'
                    ],[
                        'name' => 'clientname',
                        'label' => 'CLIENT',
                        'class' => 'col-description aimslabel'
                    ],[
                        'name' => 'centername',
                        'label' => 'CENTER',
                        'class' => 'col-code aimslabel'
                    ],[
                        'name' => 'trans',
                        'label' => 'STATUS',
                        'class' => 'col-code aimslabel'
                    ]
                ]
                
            ];
            return Yii::$app->tblgenerator->generateGrid($params);
        }  
    }

    public function automateUnp2GV($params){
        if($params['controller']->module->id == 'admin') {
            $qry = Yii::$app->backend->loadUnpostedg2($params['x']);
            // echo $qry;
            $params = 
            [
                'sql' => $qry,
                'tableid' => 'unptable2',
                'key' => 'trno',
                'txtclass' => 'unp2textbox',
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOPTIONS&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => 
                [
                    [
                        'name' => 'dateid',
                        'label' => 'DATE',
                        'class'=>'col-min aimslabel',
                    ],[
                        'name' => 'docno',
                        'label' => 'DOCUMENT #',
                        'class' => 'col-code aimslabel'
                    ],[
                        'name' => 'clientname',
                        'label' => 'CLIENT',
                        'class' => 'col-code aimslabel'
                    ],[
                        'name' => 'centername',
                        'label' => 'CENTER',
                        'class' => 'col-code aimslabel'
                    ]
                ]
                
            ];
            return Yii::$app->tblgenerator->generateGrid($params);
        }  
    }

    public function automateUnpGV($params){
        if($params['controller']->module->id == 'admin') {
            $qry = Yii::$app->backend->loadUnpostedg1();
            
            $params = 
            [
                'sql' => $qry,
                'tableid' => 'unptable1',
                'key' => 'trno',
                'txtclass' => 'unp1textbox',
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOPTIONS&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [
                    [
                        'name' => 'doc',
                        'label' => 'DOCUMENT',
                        'class'=>'col-codes aimslabel',
                    ],[
                        'name' => 'counts',
                        'label' => 'COUNT',
                        'class' => 'col-min aimslabel'
                    ]
                ],
                
                'buttons' => 
                [
                    [
                        'name' => '',
                        'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                        'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                        'class' => 'indexpageviewunp btn btn-social-icon btn-bitbucket',
                        'attributes' => [['name' => 'doc', 'value' => 'doc2']]
                    ]
                ]
            ];
        } 
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function automateComputeunposted($params) {
        $qry = Yii::$app->backend->searchComputeunposted($params['controller'],$params['controller']->access['view'],$params['itemid'],$params['date'],$params['uom'],$params['wh']);
        $costaccess = Yii::$app->session['loggeduser']['access'][368];
        if($costaccess == 1) {
            $c = [
                'name' => 'cost',
                'label' => 'Unit Cost',
                'class' => 'aimslabel col-currency'
            ];
        } else {
            $c = ['name'=>''];
        }
        $columns = [
            [
                'name' => 'client',
                'label' => 'Code',
                'class' => 'aimslabel col-min'
            ],[
                'name' => 'clientname',
                'label' => 'Name',
                'class' => 'aimslabel col-description'
            ],$c,[
                'name' => 'rem',
                'label' => 'Remarks',
                'class' => 'aimslabel col-description'
            ]
        ];
        $params = [
            'sql' => $qry,
            'tableid' => 'computesupplier',
            'key' => 'trno', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => $columns
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function automateSetChoices($params) {
        $qry = Yii::$app->backend->getSetchoices($params['controller']->access['view'],$params['x']);
        $params = [
            'sql' => $qry,
            'tableid' => 'setchoicesgrid',
            'key' => 'line',
            'txtclass' => 'setchoicestxt',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'choices',
                    'label' => 'Choice Of',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'qty',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'class' => 'col-min'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'default' => '0'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'deletechoices btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name'=>'itemid','value'=>'line']]
                ],[
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-eye"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'viewsetmenuchoices btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name'=>'itemid','value'=>'line'],['name'=>'choices','value'=>'choices']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function automateComponentitems($params) {
        $qry = Yii::$app->backend->getComponentitems($params['controller']->access['view'],$params['x']);
        $params = [
            'sql' => $qry,
            'tableid' => 'componentitemsgrid',
            'key' => 'line',
            'txtclass' => 'componentitemtextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'itemname',
                    'label' => 'Item Description',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'class' => 'col-description'
                ],[
                    'name' => 'qty',
                    'label' => 'Quantity',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-quantity'
                ],
                [
                    'name' => 'uom',
                    'editable' => true,
                    'label' => 'Unit',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'uom',
                                      'colw'=>'col-min',
                                      'lookupclass'=>'selectuomstockpop',
                                      'lookuptxtclass'=>'stocktextuomlook'],
                ],
                [
                    'name' => 'itemid',
                    'hidden' => true,
                    'default' => '0'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'default' => '0'
                ],
                [
                    'name' => 'uomfactor',
                    'hidden' => true,
                    'class' => 'txtstockuomfactor',
                    'default'=>'0',
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-save"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'savecomponentitem btn btn-social-icon btn-bitbucket',

                ],
                [
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'deletecomponentitem btn btn-social-icon btn-google'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function automateSetmenuChoices($params) {
        $qry = Yii::$app->backend->getSetmenuchoices($params['controller']->access['view'],$params['x']);
        $params = [
            'sql' => $qry,
            'tableid' => 'setmenuchoicesgrid',
            'key' => 'itemid',
            'txtclass' => 'setmenuchoicestxt',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'choices',
                    'class' => 'col-min'
                ],[
                    'name' => 'itemname',
                    'label' => 'Menu',
                    'class' => 'col-description'
                ],[
                    'name' => 'qty',
                    'label' => 'Quantity',
                    'class' => 'col-quantity'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function automateSetmenuchoicesmenu($params) {

        $qry = Yii::$app->backend->getSetmenuchoicesmenu($params['controller']->access['view'],$params['x'],$params['choices'],$params['menuid']);
        $params = [
            'sql' => $qry,
            'tableid' => 'setmenuchoicesmenugrid',
            'key' => 'line',
            'txtclass' => 'setmenuchoicesmenutxt',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode',
                    'class' => 'col-codes'
                ],[
                    'name' => 'itemname',
                    'class' => 'col-description'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'deletemenuchoices btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name'=>'itemid','value'=>'line']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function loadManageitems() {
        $qry = Yii::$app->backend->getManageitems();
        $params = [
            'sql' => $qry,
            'tableid' => 'manageitemsgrid',
            'key' => 'barcode',
            'txtclass' => 'manageitemstextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'category',
                    'label' => 'Item Category',
                    'class' => 'col-min'
                ],[
                    'name' => 'groupings',
                    'label' => 'Item Groupings',
                    'class' => 'col-min'
                ],[
                    'name' => 'kds',
                    'label' => 'KDS Name',
                    'class' => 'col-min'
                ],[
                    'name' => 'itemname',
                    'label' => 'Item Name',
                    'class' => 'col-description'
                ],[
                    'name' => 'amt',
                    'label' => 'Amount',
                    'class' => 'col-currency'
                ]
            ],

            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pull-left editmenu btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name'=>'barcode','value'=>'barcode']]
                ],[
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pull-left deletemenuitem btn btn-social-icon btn-google',
                    'attributes' => [['name'=>'barcode','value'=>'barcode'],['name'=>'itemid','value'=>'itemid']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function automateEndingEntries($doc,$dateasof,$trno){
        try {
        $status = false;
        $msg = '';
        $return = [];
        //TODO: CREATE ACCESS CHECKER BEF0RE CHECKING /D0ING ANYTHING 6/9/2018 5:24:22 PM
        $qryunpostedchecker = "select 'U' as tr,head.trno,head.doc,head.docno,left(head.dateid,10) as dateid,
                        head.client,head.clientname,head.rem,detail.line,
                        detail.acno,detail.acnoname,detail.db,detail.cr,coa.alias,detail.ref as ref,detail.postdate,detail.client as dclient,
                        detail.rem as drem,detail.checkno as checkno,coa.acnoid from lahead as head
                        left join ladetail as detail on detail.trno = head.trno
                        left join coa on coa.acno = detail.acno
                        left join client on client.client = head.client
                        left join cntnum on cntnum.trno = head.trno
                        where head.doc in ('SJ','CR','GJ','CV') and
                        ifnull(coa.acno,'')<>'' and head.dateid <= '".$dateasof."' and coa.cat in ('R','E')
                        and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'";
        $unpostedtrans = Yii::$app->sbccommon->openTable($qryunpostedchecker);

        if(!empty($unpostedtrans)){
            //SETS MSG FAILED 
            $msg = 'Generating Ending Entries Failed. Please try again.';
        }else{
            $qryentrygenerator = "select A.acno,A.acnoname,sum(A.db) as db,sum(A.cr) as cr,sum(A.cr)-sum(A.db) as total,cat from (
                        select 'P' as tr,head.trno,head.doc,head.docno,left(head.dateid,10) as dateid,
                        client.client,head.clientname,head.rem,detail.line,
                        coa.acno,detail.acnoname,detail.db,detail.cr,coa.alias,detail.ref as ref,detail.postdate,
                        dclient.client as dclient,detail.rem as drem,detail.checkno as checkno,coa.acnoid,coa.cat
                        from glhead as head
                        left join gldetail as detail on detail.trno = head.trno
                        left join coa on coa.acnoid = detail.acnoid
                        left join client on client.clientid = head.clientid
                        left join client as dclient on dclient.clientid = detail.clientid
                        left join cntnum on cntnum.trno = head.trno
                        where head.doc in ('SJ','CR','GJ','CV') and
                        ifnull(coa.acno,'')<>'' and head.dateid <= '".$dateasof."' and coa.cat in ('R','E')
                        and cntnum.center = '".Yii::$app->session['loggeduser']['center']."') as a
                        group by a.acno,a.acnoname order by a.acno";
            $qryentries = Yii::$app->sbccommon->openTable($qryentrygenerator);
            $status = true;
            
            $clientqry = 'select client from lahead where trno = ' . $trno;
            $client = Yii::$app->sbccommon->datareader($clientqry);

            $dataobj = new Ladetail;
            foreach ($qryentries as $key => $value) {
                $dataobj->postdate = $dateasof;
                $dataobj->templine = 0;
                $dataobj->trno = $trno;
                $dataobj->checkno = '';
                $dataobj->acno = $value['acno'];
                $dataobj->acnoname = $value['acnoname'];
                $dataobj->client = $client;

                if($value['cat'] == 'R'){
                    //if R => (+) CR (-) DB    
                    if($value['total'] < 0){
                        $dataobj->db = str_replace(',','',abs($value['total']));
                        $dataobj->cr = str_replace(',','',0);
                    }else{
                        $dataobj->db = str_replace(',','',0);
                        $dataobj->cr = str_replace(',','',abs($value['total']));
                    }//end if
                }else{
                    //if E => (+) DB (-) CR
                    if($value['total'] < 0){
                        $dataobj->db = str_replace(',','',0);
                        $dataobj->cr = str_replace(',','',abs($value['total']));
                    }else{
                        $dataobj->db = str_replace(',','',abs($value['total']));
                        $dataobj->cr = str_replace(',','',0);
                    }//end if
                }//end if

                $dataobj->rem = 'AUTOMATED ENTRIES FOR CLOSING';
                $dataobj->ref = '';
                $dataobj->refx = 0;
                $dataobj->linex = 0;   
                $line=Ladetail::getLastLine($trno,$doc) + 1;
                $return['stockline']['gvrow-'.$line] = ['postdate'=>$dateasof,
                                                        'trno'=>$trno,
                                                        'checkno'=>'',
                                                        'acno' => $value['acno'],
                                                        'acnoname' => $value['acnoname'],
                                                        'client'=>$client,
                                                        'db'=> $dataobj->db,
                                                        'cr' => $dataobj->cr,
                                                        'rem' => $dataobj->rem,
                                                        'ref' => '',
                                                        'line' => $line,
                                                        'refx' => 0,
                                                        'linex' => 0,
                                                        'status'=>true,
                                                        'msg'=>'',
                                                        'savingtype'=>'add'];
                Ladetail::insertdetail($trno,$dataobj,'ladetail', 'GJ');
            }//end for each
            $return['istransposted'] = false;
        }//end if

        return ['msg'=>$msg,'status'=>$status,'data'=>$return];

            
        } catch (ErrorException $e) {
            echo $e;
        }
    }//end funct

 public function automateSjtaglookup($params) {
            $doc = $params['controller']->module->id;
            switch($doc) {
                default:
                    $col = "clientname";
                    $label = "Customer";
                break;
            }//END SWITCH
            
            $qry = Yii::$app->backend->searchSjtag($params['controller'],$params['controller']->access['view'],$params);
            // echo $qry;
            // return 0;
            $params = [
                'sql' => $qry,
                'tableid' => 'tbl-docnolookup',
                'key' => 'trno',
                'txtclass' => 'bodytextbox',
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [[
                        'name' => 'dateid',
                        'label' => 'Date',
                        'class' => 'aimslabel col-min'
                    ],[
                        'name' => 'docno',
                        'label' => 'Document #',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => $col,
                        'label' => $label,
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'yourref',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'ourref',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'postdate',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'postedby',
                        'label' => 'Posted by',
                        'class' => 'aimslabel col-description'
                    ]],
                'buttons' => [
                    [
                        'name' => '',
                        'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                        'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                        'class' => 'sjtagpick btn btn-social-icon btn-bitbucket',
                        'attributes' => [['name'=>'id','value'=>'docno'],['name'=>'trno','value'=>'trno']]
                    ]
                ]
            ];
            return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function automateModelreplookup($params) {
        $qry = Yii::$app->backend->searchModelrep($params['x']);
        $params = [
            'sql' => $qry,
            'tableid' => 'modelrep-lookup',
            'key' => 'model_id',
            'txtclass' => 'bodytextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'model_name','class' => 'aimslabel col-description','label' => 'Generic']
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickmodelrep btn btn-social-icon btn-bitbucket',
                    'attributes'=>[['name'=>'id','value'=>'model_id'],['name'=>'model','value'=>'model_name']],
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end function
 
 public function automateEWTLookupGV($creds = []){
        $qry = "select line,code,rate,description from ewtlist order by description";
        $params = [
            'sql' => $qry,
            'tableid' => 'ewt-lookup',
            'key' => 'line', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'code',
                    'editable' => false,
                    'class'=>'col-codes ewttxt',
                ],[
                    'name' => 'rate',
                    'label' => 'Rates (%)',
                    'editable' => false,
                    'class'=>'col-codes ewttxt',
                ],[
                    'name' => 'description',
                    'editable' => false,
                    'class' => 'col-codes ewttxt'
                ]
            ],
            
            'buttons' => [
                [
                'name' => '',
                'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                'style' => 'width:18px;height:18px;margin-top:-2px;',
                'class' => 'selectewt btn btn-social-icon btn-bitbucket',
                'attributes'=>[['name'=>'line',
                               'value'=>'line'],
                               ['name'=>'code',
                               'value'=>'code'],//THIS PART IS NEED TO BE PART OF THE QUERY
                               ['name'=>'rate',
                               'value'=>'rate'],
                               ['name'=>'description',
                               'value'=>'description'],
                              ],
                ],//END BUTTON ARRAY
            ]
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function automateLocationlookupGV($creds){
        try {
            $qry = Yii::$app->backend->getAvailableLocation2($creds['barcode'],$creds['factor']);
            $params = [
                'sql' => $qry,
                'tableid' => 'location-lookup',
                'key' => 'whcode', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
                'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [
                    [
                        'name' => 'whname',
                        'label' => 'WH Name',
                        'class' => 'aimslabel col-description'
                    ],
                    [
                        'name' => 'bal',
                        'label' => 'Balance',
                        'class' => 'aimslabel col-quantity'
                    ],
                    [
                        'name' => 'expiry',
                        'class' => 'aimslabel col-codes'
                    ],
                    [
                        'name' => 'loc',
                        'label' => 'Location',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'whcode', //FIELD NAME SA QUERY
                        'label' => 'WH Code',
                        'class' => 'aimslabel col-codes'
                    ],
                ],
                
                'buttons' => [
                    [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;',
                    'class' => 'selectloc btn btn-social-icon btn-bitbucket',
                    'attributes'=>[['name'=>'wh',
                                'value'=>'whcode'],//THIS PART IS NEED TO BE PART OF THE QUERY
                                ['name'=>'loc',
                                'value'=>'loc'],
                                ['name'=>'expiry',
                                'value'=>'expiry'],
                                ['name'=>'whname',
                                'value'=>'whname'],
                                ],
                    ],//END BUTTON ARRAY
                ]
            ];
            
            return Yii::$app->tblgenerator->generateGrid($params);
            
            
        } catch (ErrorException $e) {
            echo $e;
        }
    }

    public function automateLocationlookupFilterGV($creds){
        try {
            $qry = Yii::$app->backend->getAvailableLocationForFilter($creds['barcode'],$creds['factor']);
            $params = [
                'sql' => $qry,
                'tableid' => 'location-lookup',
                'key' => 'whcode', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
                'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [
                    [
                        'name' => 'whname',
                        'label' => 'WH Name',
                        'class' => 'aimslabel col-description'
                    ],
                    [
                        'name' => 'bal',
                        'label' => 'Balance',
                        'class' => 'aimslabel col-quantity'
                    ],
                    [
                        'name' => 'expiry',
                        'class' => 'aimslabel col-codes'
                    ],
                    [
                        'name' => 'loc',
                        'label' => 'Location',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'whcode', //FIELD NAME SA QUERY
                        'label' => 'WH Code',
                        'class' => 'aimslabel col-codes'
                    ],
                ],
                
                'buttons' => [
                    [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;',
                    'class' => 'selectloc btn btn-social-icon btn-bitbucket',
                    'attributes'=>[['name'=>'wh',
                                'value'=>'whcode'],//THIS PART IS NEED TO BE PART OF THE QUERY
                                ['name'=>'loc',
                                'value'=>'loc'],
                                ['name'=>'expiry',
                                'value'=>'expiry'],
                                ['name'=>'whname',
                                'value'=>'whname'],
                                ],
                    ],//END BUTTON ARRAY
                ]
            ];
            
            return Yii::$app->tblgenerator->generateGrid($params);
            
            
        } catch (ErrorException $e) {
            echo $e;
        }
    }


    public function automateComponentslookup($params){
        if($params['x'] == '') {
            $sql = "select itemid,line, barcode, itemname, isqty, uom from component where outputid='".$params['itemid']."'";
        } else {
            $sql = "select itemid,line, barcode, itemname, isqty, uom from component where itemname like '%".$params['x']."%' and outputid='".$params['itemid']."'";
        }
        $params = [
            'sql' => $sql,
            'tableid' => 'itemcomponentsgrid',
            'key' => 'line',
            'txtclass' => 'comptextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode',
                    'editable' => true,
                    'readonly' => true,
                    'label' => 'Barcode',
                    'type' => 'lookup',
                    'class' => 'col-codes aimslabel',
                    'lookupbutton' => ['autocall'=>'',
                                      'colw'=>'col-min',
                                      'lookupclass'=>'gvbtns compbarcodelookup',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'itemname',
                    'label' => 'Item Name',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'class' => 'aimslabel stocktxt col-description'
                ],[
                    'name' => 'isqty',
                    'label' => 'Qty',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'aimslabel stocktxt col-quantity'
                ],[
                    'name' => 'uom',
                    'label' => 'UOM',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'class' => 'aimslabel stocktxt col-codes'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'default' => '0',
                    'class' => 'txthidden'
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'default' => '0',
                    'class' => 'txthidden'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-save"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;',
                    'class' => 'savecomponents btn btn-social-icon btn-bitbucket'
                ],[
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-trash"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;',
                    'class' => 'deletecomponent btn btn-social-icon btn-google',
                    'attributes' => [['name' => 'line','value' => 'line']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
}


    public function automateClasslookup($params) {
        $qry = Yii::$app->backend->searchClass($params['controller'],$params['controller']->access['view'],$params['x']);
        switch ($params['controller']->module->id) {
            case 'manageitem':
                $ChangingClass = 'Category';
            break;
            
            default:
                $ChangingClass = 'Classic';
            break;
        }

        switch ($params['controller']->module->id) {
            case 'manageitem':
                $params = [
                'sql' => $qry,
                'tableid' => 'classlookupdiv',
                'key' => 'classid',
                'txtclass' => 'mnglookupcls',
                'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [
                    ['name' => 'classic','class' => 'aimslabel col-description','label'=>$ChangingClass],

                                [
                                    'name' => 'classid',
                                    'hidden' => true,
                                    'default' => '0',
                                    'class' => 'aimslabel txthidden'
                                ],
                                [
                                    'name' => 'skincolor',
                                    'editable' => true,
                                    'type' => 'text',
                                    'class' => 'jscolor col-min aimslabel'
                                 ], 
                                 [
                                    'name' => 'fontcolor',
                                    'editable' => true,
                                    'type' => 'text',
                                    'class' => 'jscolor col-min aimslabel'
                                 ],                               

                        ],

                        'buttons' => [
                            [
                                'name' => '',
                                'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                                'class' => 'pickclass btn btn-social-icon btn-bitbucket',
                                'attributes' => [['name' => 'cls','value'=>'classic'],['name' => 'classid','value' => 'classid']]
                            ]
                        ]
                    ];
                break;
            
            default:
                 $params = [
                'sql' => $qry,
                'tableid' => 'classlookupdiv',
                'key' => 'classid',
                'txtclass' => 'bodytextbox',
                'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [
                    ['name' => 'classic','class' => 'aimslabel col-description','label'=>$ChangingClass],

                                [
                                    'name' => 'classid',
                                    'hidden' => true,
                                    'default' => '0',
                                    'class' => 'aimslabel txthidden'
                                ],
                        ],
                        'buttons' => [
                            [
                                'name' => '',
                                'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                                'class' => 'pickclass btn btn-social-icon btn-bitbucket',
                                'attributes' => [['name' => 'cls','value'=>'classic'],['name' => 'classid','value' => 'classid']]
                            ]
                        ]
                    ];
                break;
        }
       
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function automateTables($controller,$params) {
        $qry = Yii::$app->backend->searchTables($controller->access['view'],$params['x']);
        $params = [
            'sql' => $qry,
            'tableid' => 'tablesgrid',
            'key' => 'line',
            'txtclass' => 'tablestextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'clientname',
                    'label' => 'Table',
                    'editable' => false,
                    'class' => 'col-description'
                ],[
                    'name' => 'inactive',
                    'editable' => true,
                    'type' => 'checkbox',
                    'class' => 'col-codes chktablesinactive',
                ],
                [
                    'name' => 'clientid',
                    'hidden' => true,
                    'default' => '0'
                ],
                [
                    'name' => 'line',
                    'hidden' => true,
                    'default' => '0'
                ],[
                    'name' => 'isinactive',
                    'hidden' => true,
                    'default' => '0'
                ]
            ],
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }



    public function automateBodylookup($params) {
        $qry = Yii::$app->backend->searchBody($params['controller'],$params['controller']->access['view'],$params['x']);
        $params = [
            'sql' => $qry,
            'tableid' => 'body-lookup',
            'key' => 'body',
            'txtclass' => 'bodytextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'body','class' => 'aimslabel col-description']
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickbody btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name' => 'body','value'=>'body']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function automateProvincelookup($controller) {
        $qry = Yii::$app->backend->searchProvince($controller,$controller->access['view']);
        $params = [
            'sql' => $qry,
            'tableid' => 'province-lookup',
            'key' => 'province',
            'txtclass' => 'bodytextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'province','class' => 'aimslabel col-description']
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickprovince btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name' => 'province','value'=>'province']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function automateRegionlookup($controller) {
        $qry = Yii::$app->backend->searchRegion($controller,$controller->access['view']);
        $params = [
            'sql' => $qry,
            'tableid' => 'region-lookup',
            'key' => 'region',
            'txtclass' => 'bodytextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'region','class' => 'aimslabel col-description']
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickregion btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name' => 'region','value'=>'region']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function automateReminders() {
        $qry = Yii::$app->backend->getReminderListing();
        $name = Yii::$app->session['loggeduser']['name'];
        $userid = Yii::$app->session['loggeduser']['userid'];
        Yii::$app->systemsettings->setDefaultTimeZone();
        $createdate = date("Y-m-d H:i:s");
        $params = [
            'sql' => $qry,
            'tableid' => 'reminderslookup',
            'key' => 'reminderid',
            'txtclass' => 'reminderstxt',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'createdby',
                    'label' => 'User',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'default' => $name,
                    'class' => 'col-codes aimslabel'
                ],[
                    'name' => 'title',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-description aimslabel'
                ],[
                    'name' => 'description',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-description aimslabel'
                ],[
                    'name' => 'date1',
                    'label' => 'Date From',
                    'editable' => true,
                    'type' => 'datepicker',
                    'class' => 'col-codes aimslabel'
                ],[
                    'name' => 'date2',
                    'label' => 'Date To',
                    'editable' => true,
                    'type' => 'datepicker',
                    'class' => 'col-codes aimslabel'
                ],[
                    'name' => 'createdate',
                    'label' => 'Created',
                    'editable' => true,
                    'readonly' => true,
                    'default' => $createdate,
                    'type' => 'text',
                    'class' => 'col-codes aimslabel'
                ],[
                    'name' => 'reminderid',
                    'hidden' => true,
                    'default' => '0',
                    'class' => 'txthidden'
                ],[
                    'name' => 'userid',
                    'hidden' => true,
                    'default' => $userid,
                    'class' => 'txthidden'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'savereminder btn btn-social-icon btn-bitbucket'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function automateAnnouncements() {
        $qry = Yii::$app->backend->getAnnouncementListing();
        Yii::$app->systemsettings->setDefaultTimeZone();
        $datenow = date('Y-m-d');
        $userid = Yii::$app->session['loggeduser']['userid'];
        $uname = Yii::$app->sbccommon->opentable("select name from useraccess where userid = $userid");
        $params = [
            'sql' => $qry,
            'tableid' => 'annontable',
            'key' => 'anonid',
            'txtclass' => 'annontextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'createdby',
                    'label' => 'User',
                    'editable' => true,
                    'default' => $uname[0]['name'],
                    'readonly' => true,
                    'type' => 'text',
                    'class' => 'aimslabel col-codes txtannon'
                ],[
                    'name' => 'title',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'aimslabel col-description txtannon'
                ],[
                    'name' => 'description',
                    'label' => 'Details',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'aimslabel col-description txtannon'
                ],[
                    'name' => 'date1',
                    'label' => 'Date From',
                    'editable' => true,
                    'type' => 'datepicker',
                    'class' => 'aimslabel col-codes txtannon'
                ],[
                    'name' => 'date2',
                    'label' => 'Date To',
                    'editable' => true,
                    'type' => 'datepicker',
                    'class' => 'aimslabel col-codes txtannon'
                ],[
                    'name' => 'createdate',
                    'label' => 'Created',
                    'editable' => 'true',
                    'default' => $datenow,
                    'readonly' => true,
                    'type' => 'text',
                    'class' => 'aimslabel col-codes txtannon'
                ],[
                    'name' => 'anonid',
                    'hidden' => true,
                    'default' => '0',
                    'class' => 'txthidden'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-save"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'saveanon btn btn-social-icon btn-bitbucket'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }


    public function automateComputeacctg($params) {
        $qry = Yii::$app->backend->searchComputeacctg($params['controller'],$params['controller']->access['view'],$params['clientid'],$params['date'],$params['type']);

        switch($params['type']) {
            case 'AP':
                $columns = [
                    [
                        'name' => 'docno',
                        'label' => 'Document #',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'dateid',
                        'label' => 'Date',
                        'class' => 'aimslabel col-min'
                    ],[
                        'name' => 'db',
                        'label' => 'Debit',
                        'viewtype' => 'currency',
                        'class' => 'aimslabel col-currency'
                    ],[
                        'name' => 'cr',
                        'label' => 'Credit',
                        'viewtype' => 'currency',
                        'class' => 'aimslabel col-currency'
                    ],[
                        'name' => 'bal',
                        'label' => 'Balance',
                        'viewtype' => 'currency',
                        'class' => 'aimslabel col-currency'
                    ],[
                        'name' => 'ref',
                        'label' => 'Reference',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'status',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'rem',
                        'label' => 'Notes',
                        'class' => 'aimslabel col-codes'
                    ]
                ];
            break;
            case 'AR':
                if($params['controller']->module->id == 'supplier') {
                    $columns = [
                        [
                            'name' => 'docno',
                            'label' => 'Document #',
                            'class' => 'aimslabel col-codes'
                        ],[
                            'name' => 'dateid',
                            'label' => 'Date',
                            'class' => 'aimslabel col-min'
                        ],[
                            'name' => 'db',
                            'label' => 'Debit',
                            'viewtype' => 'currency',
                            'class' => 'aimslabel col-currency'
                        ],[
                            'name' => 'cr',
                            'label' => 'Credit',
                            'viewtype' => 'currency',
                            'class' => 'aimslabel col-currency'
                        ],[
                            'name' => 'bal',
                            'label' => 'Balance',
                            'viewtype' => 'currency',
                            'class' => 'aimslabel col-currency'
                        ],
                        [
                            'name' => 'ref',
                            'label' => 'Reference',
                            'class' => 'aimslabel col-description'
                        ],[
                            'name' => 'status',
                            'class' => 'aimslabel col-codes'
                        ]
                    ];
                } else {
                    $columns = [
                        [
                            'name' => 'docno',
                            'label' => 'Document #',
                            'class' => 'aimslabel col-codes'
                        ],[
                            'name' => 'dateid',
                            'label' => 'Date',
                            'class' => 'aimslabel col-min'
                        ],[
                            'name' => 'db',
                            'label' => 'Debit',
                            'viewtype' => 'currency',
                            'class' => 'aimslabel col-currency'
                        ],[
                            'name' => 'cr',
                            'label' => 'Credit',
                            'viewtype' => 'currency',
                            'class' => 'aimslabel col-currency'
                        ],[
                            'name' => 'bal',
                            'label' => 'Balance',
                            'viewtype' => 'currency',
                            'class' => 'aimslabel col-currency'
                        ],
                        [
                            'name' => 'ref',
                            'label' => 'Reference',
                            'class' => 'aimslabel col-description'
                        ],[
                            'name' => 'krdoc',
                            'label' => 'KR',
                            'class' => 'aimslabel col-codes'
                        ],[
                            'name' => 'status',
                            'class' => 'aimslabel col-codes'
                        ]
                    ];
                }
            break;
            case 'PDC':
                $columns = [
                    [
                        'name' => 'docno',
                        'label' => 'Document #',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'db',
                        'label' => 'Debit',
                        'viewtype' => 'currency',
                        'class' => 'aimslabel col-currency'
                    ],[
                        'name' => 'cr',
                        'label' => 'Credit',
                        'viewtype' => 'currency',
                        'class' => 'aimslabel col-currency'
                    ],[
                        'name' => 'checkdate',
                        'label' => 'Check Date',
                        'class' => 'aimslabel col-min'
                    ],[
                        'name' => 'checkno',
                        'label' => 'Check #',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'rem',
                        'label' => 'Notes',
                        'class' => 'aimslabel col-description'
                    ]
                ];
            break;
            case 'RC':
                $columns = [
                    [
                        'name' => 'docno',
                        'label' => 'Document #',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'dateid',
                        'label' => 'Date',
                        'class' => 'aimslabel col-min'
                    ],[
                        'name' => 'db',
                        'label' => 'Debit',
                        'viewtype' => 'currency',
                        'class' => 'aimslabel col-currency'
                    ],[
                        'name' => 'cr',
                        'label' => 'Credit',
                        'viewtype' => 'currency',
                        'class' => 'aimslabel col-currency'
                    ],[
                        'name' => 'bal',
                        'label' => 'Balance',
                        'viewtype' => 'currency',
                        'class' => 'aimslabel col-currency'
                    ],[
                        'name' => 'ref',
                        'label' => 'Reference',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'rem',
                        'label' => 'Notes',
                        'class' => 'aimslabel col-description'
                    ]
                ];
            break;
        }
        $params = [
            'sql' => $qry,
            'tableid' => 'computeaccttbl',
            'key' => 'trno', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => $columns
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }


    public function automateComputeinv($params) {
        $qry = Yii::$app->backend->searchComputeinv($params['controller'],$params['controller']->access['view'],$params['clientid'],$params['date'],$params['filter']);
        $costaccess = Yii::$app->backend->viewcostAccess();
        if($costaccess == 1) {
            $col = [
                'name' => 'cost',
                'label' => 'Unit Cost',
                'viewtype' => 'currency',
                'class' => 'aimslabel col-currency'
            ];
        }//end function

        if($params['controller']->module->id == "customer") {
           $col2 = [
                'name' => 'isamt',
                'label' => 'Unit Price',
                'viewtype' => 'currency',
                'class' => 'aimslabel col-currency'
            ];
        }else{
            $col2 = ['name' => ''];
        }//end function

        $columns = [
            [
                'name' => 'docno',
                'label' => 'Document #',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'dateid',
                'label' => 'Date',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'barcode',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'itemname',
                'label' => 'Description',
                'class' => 'aimslabel col-description'
            ],[
                'name' => 'uom',
                'label' => 'Unit',
                'class' => 'aimslabel col-min'
            ],[
                'name' => 'disc',
                'label' => 'Discount',
                'class' => 'aimslabel col-min'
            ],$col,$col2,[
                'name' => 'rrqty',
                'label' => 'IN',
                'viewtype' => 'quantity',
                'class' => 'aimslabel col-quantity'
            ],[
                'name' => 'isqty',
                'label' => 'OUT',
                'viewtype' => 'quantity',
                'class' => 'aimslabel col-quantity'
            ],[
                'name' => 'loc',
                'label' => 'Location',
                'class' => 'aimslabel col-codes'
            ]
        ];
        $params = [
            'sql' => $qry,
            'tableid' => 'computeinvtbl',
            'key' => 'trno', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => $columns
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }


    public function automateStats($controller,$params){
     if($controller->module->id == 'customer'){
        $qry = Yii::$app->backend->searchCustomerStat($params['yfilter'],$params['q'],$params['statview']);
     }else{
        $qry = Yii::$app->backend->searchSupplierStat($params['yfilter'],$params['q'],$params['statview']);
     }//end if

        $params = [
            'sql' => $qry,
            'tableid' => 'tbl-showclientstats',
            'key' => 'trno',
            'txtclass' => 'bodytextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [  
                    'name' => 'grp',
                    'label' => 'Month',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'stats',
                    'label' => 'Total'
                    ,'class' => 'aimslabel col-currency'
                ]
            ],
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
}

    public function automateArealookup($controller) {
        $qry = Yii::$app->backend->searchArea($controller,$controller->access['view']);
        $params = [
            'sql' => $qry,
            'tableid' => 'area-lookup',
            'key' => 'area',
            'txtclass' => 'bodytextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'area','class' => 'aimslabel col-description']
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickarea btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name' => 'area','value'=>'area']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function automatePrioritylookup($params) {
        $qry = Yii::$app->backend->searchPriority($params['controller'],$params['controller']->access['view'],$params['x']);
        $attr = [['name' => 'priority', 'value' => 'priority']];
        $params = [
            'sql' => $qry,
            'tableid' => 'priority-lookup',
            'key' => 'priority',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'priority','class' => 'aimslabel col-description']
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickpriority btn btn-social-icon btn-bitbucket',
                    'attributes' => $attr
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function automateDepartmentlookup($params) {
        $qry = Yii::$app->backend->searchDepartment($params['controller'],$params['controller']->access['view'],$params['x']);
        $attr = [['name' => 'department', 'value' => 'department']];
        $params = [
            'sql' => $qry,
            'tableid' => 'department-lookup',
            'key' => 'department',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'department','class' => 'aimslabel col-description']
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickdepartment btn btn-social-icon btn-bitbucket',
                    'attributes' => $attr
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function automateSuppItemCodelookup($params) {
        $qry = Yii::$app->backend->searchSuppItemCode($params['controller'],$params['controller']->access['view'],$params['x']);
        $attr = [['name' => 'suppitemcode', 'value' => 'suppitemcode']];
        $params = [
            'sql' => $qry,
            'tableid' => 'suppitemcode-lookup',
            'key' => 'suppitemcode',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'suppitemcode','class' => 'aimslabel col-description']
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'picksuppitemcode btn btn-social-icon btn-bitbucket',
                    'attributes' => $attr
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function automateCategorylookup($params) {
        $qry = Yii::$app->backend->searchCategory($params['controller'],$params['controller']->access['view'],$params['x']);
        if($params['controller']->module->id == 'customer' || $params['controller']->module->id == 'supplier') {
            $attr = [['name' => 'category', 'value' => 'category'],['name' => 'catid', 'value' => 'catid']];
        } else {
            $attr = [['name' => 'category', 'value' => 'category']];
        }
        $params = [
            'sql' => $qry,
            'tableid' => 'category-lookup',
            'key' => 'category',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'category','class' => 'aimslabel col-description']
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickcategory btn btn-social-icon btn-bitbucket',
                    'attributes' => $attr
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }


    public function automateComputeso($params) {
        $qry = Yii::$app->backend->searchComputeso($params['controller'],$params['controller']->access['view'],$params['itemid'],$params['date'],$params['uom'],$params['wh']);
        $params = [
            'sql' => $qry,
            'tableid' => 'computeso',
            'key' => 'trno', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'docno',
                    'editable' => true,
                    'type' =>'documentlink',
                    'linkdoc'=>'doc',
                    'linkparam'=>'docno',
                    'label' => 'Document #',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'dateid',
                    'label' => 'Date',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'clientname',
                    'label' => 'Customer',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'iss',
                    'label' => 'Ordered',
                    'viewtype' => 'quantity',
                    'class' => 'aimslabel col-quantity'
                ],[
                    'name' => 'qa',
                    'label' => 'Sold',
                    'viewtype' => 'quantity',
                    'class' => 'aimslabel col-quantity'
                ],[
                    'name' => 'balance',
                    'label' => 'Pending',
                    'viewtype' => 'quantity',
                    'class' => 'aimslabel col-quantity'
                ],[
                    'name' => 'void',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'rem',
                    'label' => 'Remarks',
                    'class' => 'aimslabel col-description'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }


    public function automateComputepo($params) {
        $qry = Yii::$app->backend->searchComputepo($params['controller'],$params['controller']->access['view'],$params['itemid'],$params['date'],$params['uom'],$params['wh']);
        $params = [
            'sql' => $qry,
            'tableid' => 'computepo',
            'key' => 'trno', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'docno',
                    'editable' => true,
                    'type' =>'documentlink',
                    'linkdoc'=>'doc',
                    'linkparam'=>'docno',
                    'label' => 'Document #',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'dateid',
                    'label' => 'Date',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'clientname',
                    'label' => 'Supplier',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'qty',
                    'label' => 'Ordered',
                    'viewtype' => 'quantity',
                    'class' => 'aimslabel col-quantity'
                ],[
                    'name' => 'qa',
                    'label' => 'Received',
                    'viewtype' => 'quantity',
                    'class' => 'aimslabel col-quantity clickable viewservedrr'
                ],[
                    'name' => 'balance',
                    'label' => 'Pending',
                    'viewtype' => 'quantity',
                    'class' => 'aimslabel col-quantity'
                ],[
                    'name' => 'void',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'rem',
                    'label' => 'Remarks',
                    'class' => 'aimslabel col-description'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function automateComputespc($params) {
        $qry = Yii::$app->backend->searchComputespc($params['controller'],$params['controller']->access['view'],$params['itemid'],$params['date']);
        $params = [
            'sql' => $qry,
            'tableid' => 'computespc',
            'key' => 'trno', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'docno',
                    'label' => 'Document #',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'dateid',
                    'label' => 'Date',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'effectdate',
                    'label' => 'Effective Date',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'supp',
                    'label' => 'Supplier',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'rrcost2',
                    'label' => 'Gross',
                    'class' => 'aimslabel col-quantity'
                ],[
                    'name' => 'disc2',
                    'label' => 'Disc',
                    'class' => 'aimslabel col-quantity'
                ],[
                    'name' => 'ext2',
                    'label' => 'Net',
                    'class' => 'aimslabel col-quantity'
                ],
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function automateComputewh($params) {
        try {
        $qry = Yii::$app->backend->computeWh($params['controller'],$params['controller']->access['view'],$params['itemid']);
        
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'GALANG': case 'MLCP':
            $locfield =  [
                    'name' => 'loc',
                    'label' => 'Location',
                    'class' => 'aimslabel col-codes'
            ];

            $purchasebalfield = ['name'=>''];
            break;
            
            case 'UNIVERSE':
                $locfield =  [
                        'name' => 'loc',
                        'label' => 'Location',
                        'class' => 'aimslabel col-codes'
                ];
                
                $purchasebalfield = [
                        'name' => 'purchasebal',
                        'label' => 'Purchase UOM Bal',
                        'class' => 'aimslabel col-codes'
                ];
            break;

            default:
                $locfield = ['name'=>''];
                $purchasebalfield = ['name'=>''];
            break;
        }//end swich 
        
        $columns = [
            [
                'name' => 'whname',
                'label' => 'Warehouse Name',
                'class' => 'aimslabel col-description'
            ],$locfield,[
                'name' => 'bal',
                'label' => 'Balance',
                'class' => 'aimslabel col-quantity'
            ],$purchasebalfield
        ];

        $params = [
            'sql' => $qry,
            'tableid' => 'computewh',
            'key' => 'whid', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => $columns
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);

            
        } catch (ErrorException $e) {
            echo $e;
        }
    }//end fn

    public function automateComputereceiving($params) {
        $qry = Yii::$app->backend->searchComputereceiving($params['controller'],$params['controller']->access['view'],$params['itemid'],$params['date'],$params['uom'],$params['wh']);

        $costaccess = Yii::$app->session['loggeduser']['access'][368];
        
        if($costaccess == 1) {
            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'UNIVERSE':
                    $c = [
                        'name' => 'rrcostvat',
                        'label' => 'Gross Amount',
                        'viewtype' => 'unitprice',
                        'class' => 'aimslabel col-codes'
                    ];

                    $cc = [
                        'name' => 'rrcostgross',
                        'label' => 'Net Amount',
                        'viewtype' => 'unitprice',
                        'class' => 'aimslabel col-codes'
                    ];
                break;

                default:
                    $c = [
                        'name' => 'cost',
                        'label' => 'Unit Cost',
                        'viewtype' => 'unitprice',
                        'class' => 'aimslabel col-currency'
                    ];

                    $cc = ['name'=>''];
                break;
            }//end switch
        } else {
            $c = ['name'=>''];
            $cc = ['name'=>''];
        }//end if

        $columns = [
            [
                'name' => 'docno',
                'editable' => true,
                'type' =>'documentlink',
                'linkdoc'=>'doc',
                'linkparam'=>'docno',
                'label' => 'Document #',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'clientname',
                'label' => 'Name',
                'class' => 'aimslabel col-description'
            ],[
                'name' => 'dateid',
                'label' => 'Date',
                'class' => 'aimslabel col-codes'
            ],$c,[
                'name' => 'disc',
                'label' => 'Discount',
                'class' => 'aimslabel col-min'
            ],$cc,[
                'name' => 'qty',
                'label' => 'Quantity',
                'viewtype' => 'quantity',
                'class' => 'aimslabel col-quantity'
            ],[
                'name' => 'uom',
                'label' => 'UOM',
                'class' => 'aimslabel col-min'
            ],[
                'name' => 'expiry',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'rem',
                'label' => 'Remarks',
                'class' => 'aimslabel col-description'
            ],[
                'name' => 'yourref',
                'label' => 'Yourref',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'status',
                'class' => 'aimslabel col-description'
            ],[
                'name' => 'loc',
                'label' => 'Location',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'vat_status',
                'label' => 'Vat Encoded Status',
                'class' => 'aimslabel col-codes'
            ]
        ];

        $params = [
            'sql' => $qry,
            'tableid' => 'computereceiving',
            'key' => 'trno', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => $columns
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);

    }


    public function automateComputeledger($params) {
        $qry = Yii::$app->backend->searchComputeledger($params['controller'],$params['controller']->access['view'],$params['itemid'],$params['date'],$params['uom'],$params['wh']);

        $costaccess = Yii::$app->session['loggeduser']['access'][368];
        
        if($costaccess == 1) {
            $c = [
                'name' => 'cost',
                'label' => 'Landed Cost',
                'viewtype' => 'unitprice',
                'class' => 'aimslabel col-currency'
            ];
        } else {
            $c = ['name'=>''];
        }//end if

        $columns = [
            [
                'name' => 'posted',
                'label' => 'Status',
                'class' => 'aimslabel col-min'
            ],[
                'name' => 'docno',
                'editable' => true,
                'type' =>'documentlink',
                'linkdoc'=>'doc',
                'linkparam'=>'docno',
                'label' => 'Document #',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'dateid',
                'label' => 'Date',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'clientname',
                'label' => 'Supplier/Customer',
                'class' => 'aimslabel col-description'
            ],[
                'name' => 'qty',
                'label' => 'Qty IN',
                'viewtype' => 'quantity',
                'class' => 'aimslabel col-quantity'
            ],[
                'name' => 'iss',
                'label' => 'Qty OUT',
                'viewtype' => 'quantity',
                'class' => 'aimslabel col-quantity'
            ],[
                'name' => 'expiry',
                'class' => 'aimslabel col-codes'
            ],$c,[
                'name' => 'amt',
                'label' => 'Price',
                'viewtype' => 'currency',
                'class' => 'aimslabel col-currency'
            ],[
                'name' => 'disc',
                'label' => 'Discount',
                'class' => 'aimslabel col-min'
            ],[
                'name' => 'yourref',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'ourref',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'rem',
                'label' => 'Remarks',
                'class' => 'aimslabel col-description'
            ],[
                'name' => 'wh',
                'label' => 'Warehouse',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'loc',
                'label' => 'Location',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'vat_status',
                'label' => 'Vat Encoded Status',
                'class' => 'aimslabel col-codes'
            ]
        ];
        $params = [
            'sql' => $qry,
            'tableid' => 'computeledger',
            'key' => 'trno', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => $columns
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function automatePdclookup($params){
        $qry=Yii::$app->sbccontroller->sbcLoadpdcchecks($params['controller'],$params['x']);
        $params = [
            'sql' => $qry,
            'tableid' => 'table-pdcchecks',
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'checkbox' => true,
            'column' => [[
                    'name' => 'checkno',
                    'label' => 'Check Detail',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'checkdate',
                    'label' => 'Check Date',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'amount',
                    'label' => 'Check Amount',
                    'class' => 'aimslabel col-currency'
                ],[
                    'name' => 'notes',
                    'class' => 'aimslabel col-description'
                ]]
            ];
         return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function automateUomprintlookup($controller,$id) {
            $qry = Yii::$app->backend->searchUomprint($id,$controller->access['view']);
        
        $params = [
            'sql' => $qry,
            'tableid' => 'uomprint-lookup',
            'key' => 'itemid',
            'txtclass' => 'bodytextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'uom','class' => 'aimslabel col-description']
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickuomprint btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name' => 'uom','value'=>'uom'],['name' => 'itemid','value' => 'itemid']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }
    

    public function automateAudittrail($sql,$doc) {
        if($doc  == 'CL' || $doc == 'SK') {
            $column = [
                [
                    'name' => 'userid',
                    'label' => 'User',
                    'class' => 'col-codes aimslabel'
                ],[
                    'name' => 'client',
                    'label' => 'Code',
                    'class' => 'col-codes aimslabel'
                ],[
                    'name' => 'clientname',
                    'label' => 'Name',
                    'class' => 'col-description aimslabel'
                ],[
                    'name' => 'task',
                    'class' => 'col-codes aimslabel'
                ],[
                    'name' => 'oldversion',
                    'label' => 'Activity',
                    'class' => 'col-description aimslabel'
                ],[
                    'name' => 'dateid',
                    'label' => 'Date',
                    'class' => 'col-min aimslabel'
                ]
            ];
        } else {
            $column = [
                [
                    'name' => 'userid',
                    'label' => 'User',
                    'class' => 'col-codes aimslabel'
                ],[
                    'name' => 'task',
                    'class' => 'col-codes aimslabel'
                ],[
                    'name' => 'oldversion',
                    'label' => 'Activity',
                    'class' => 'col-description aimslabel'
                ],[
                    'name' => 'dateid',
                    'label' => 'Date',
                    'class' => 'col-min aimslabel'
                ]
            ];
        }
        $params = [
            'sql' => $sql,
            'tableid' => 'audittrailtbl',
            'key' => 'userid',
            'column' => $column
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function automateGrouplookup($params,$searchstr = '') {
    try {
        
        if($params['controller']->module->id == 'changeitem') {
            $keyid = 'groupid';
            $qry = Yii::$app->backend->searchGroup($params['controller'],$params['controller']->access['view'],$params['x']);
        } else if($params['controller']->module->id == 'customer' || $params['controller']->module->id == 'supplier' || $params['controller']->module->id == 'agent') {
            $keyid = 'stockgrp';
            $qry = Yii::$app->backend->getClientGrplist($searchstr);
        } else {
            $keyid = 'groupid';
            $qry = Yii::$app->backend->searchGroup($params['controller'],$params['controller']->access['view'],$params['x']);
        }
        

         switch ($params['controller']->module->id) {
            case 'manageitem':
                $ChangingGroup = 'Groupings';
            break;
            
            default:
                $ChangingGroup = 'Groupings';
            break;
        }//end switch

        $params = [
            'sql' => $qry,
            'tableid' => 'group-lookup',
            'key' => $keyid,
            'txtclass' => 'bodytextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'stockgrp','class' => 'aimslabel col-description','label'=>$ChangingGroup]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickgroupid btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name' => $keyid,'value'=>$keyid],['name' => 'stockgrp', 'value' => 'stockgrp']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);

    } catch (ErrorException $e) {
        echo $e;
    }
    }

    public function automateSizelookup($params) {
        if($params['controller']->module->id == 'changeitem') {
            $qry = Yii::$app->backend->searchSize($params['controller'],'','');
        } else {
            $qry = Yii::$app->backend->searchSize($params['controller'],$params['controller']->access['view'],$params['x']);
        }
        $params = [
            'sql' => $qry,
            'tableid' => 'size-lookup',
            'key' => 'sizeid',
            'txtclass' => 'bodytextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'sizeid','class' => 'aimslabel col-description']
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'picksize btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name' => 'sizeid','value'=>'sizeid']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }


   public function automateModellookup($params) {
        try {
        if($params['controller']->module->id == 'changeitem') {
            $qry = Yii::$app->backend->searchModel($params['controller'],'','');
        } else {
            $qry = Yii::$app->backend->searchModel($params['controller'],$params['controller']->access['view'],$params['x']);
        }
        if($params['controller']->module->id == 'stockcard' || $params['controller']->module->id == 'manageitem' || $params['controller']->module->id =='posstockcard') {
            $attr = [['name' => 'model', 'value' => 'model'],['name' => 'modelid', 'value' => 'modelid']];
        } else {
            $attr = [['name' => 'model', 'value' => 'model'],['name' => 'modelid', 'value' => 'modelid']];
        }



        switch ($params['controller']->module->id) {
            case 'manageitem':
                $ChangingModel = 'Printer';
            break;
            
            default:
                $ChangingModel = 'Model';
            break;
        }
        $params = [
            'sql' => $qry,
            'tableid' => 'model-lookup',
            'key' => 'model',
            'txtclass' => 'bodytextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'model','class' => 'aimslabel col-description','label'=>$ChangingModel]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickmodel btn btn-social-icon btn-bitbucket',
                    'attributes' => $attr
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);

            
        } catch (ErrorException $e) {
            echo $e;
        }
    }

    public function automatePartlookup($params) {

        
        $qry = Yii::$app->backend->searchPart($params['controller'],$params['controller']->access['view'],$params['x']);
        
        if($params['controller']->module->id == 'stockcard' || $params['controller']->module->id == 'posstockcard') {
            $attr = [['name' => 'partid', 'value' => 'partid'],['name' => 'part', 'value' => 'part']];
        } else {
            $attr = [['name' => 'partid', 'value' => 'partid'],['name' => 'part', 'value' => 'part']];
        };

        $params = [
            'sql' => $qry,
            'tableid' => 'part-lookup',
            'key' => 'part',
            'txtclass' => 'bodytextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'part','class' => 'aimslabel col-description']
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickpart btn btn-social-icon btn-bitbucket',
                    'attributes' => $attr
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function automateEquipToolGrid($controller){
        $qry = Yii::$app->backend->loadEquiptoolqry($controller,$controller->access['view']);
        $params = [
            'sql' => $qry,
            'tableid' => 'equiptoolgrid',
            'key' => 'barcode',
            'txtclass' => 'equiptooltextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode',
                    'label' => 'Barcode',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'itemname',
                    'label' => 'Itemname',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'uom',
                    'label' => 'UOM',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'groupid',
                    'label' => 'Group',
                    'class' => 'aimslabel col-currency'
                ],[
                    'name' => 'model',
                    'label' => 'Model',
                    'class' => 'aimslabel col-currency'
                ],[
                    'name' => 'part',
                    'label' => 'Part',
                    'class' => 'aimslabel col-currency'
                ],[
                    'name' => 'category',
                    'label' => 'Category',
                    'class' => 'aimslabel col-codes'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);

    }//end fn

    public function automateMasterfileGrid($params) {
        $qry = Yii::$app->backend->loadMasterqry($params['controller'],$params['controller']->access['view'],$params['x']);
        switch($params['controller']->module->id) {
            case 'collection': case 'distribution': 
            case 'fg_material': case 'fg_process': case 'fg_cylinder':
            case 'mlocation': //WTODO: [KIM][2019.10.30][add case for mlocation]
                $columns = [
                    ['name' => 'line', 'hidden' => true, 'default' => '0', 'class' => 'txtrequired txthidden'],
                    ['name' => 'Code', 'editable' => true, 'type' => 'text', 'class' => 'stocktxt aimslabel col-description'],
                    ['name' => 'Name', 'editable' => true, 'type' => 'text', 'class' => 'txtrequired stocktxt aimslabel col-xxxl'],
                ];
            break;

            case 'fg_colors': 
                $columns = [
                    ['name' => 'line', 'hidden' => true, 'default' => '0', 'class' => 'txtrequired txthidden'],
                    ['name' => 'Code', 'editable' => true, 'type' => 'text', 'class' => 'stocktxt aimslabel col-description'],
                    ['name' => 'Name', 'editable' => true, 'type' => 'text', 'class' => 'txtrequired stocktxt aimslabel col-description'],
                    ['name' => 'unit', 'editable' => true, 'type' => 'text', 'class' => 'txtrequired stocktxt aimslabel col-min'],
                    ['name' => 'amt', 'editable' => true, 'type' => 'text', 'class' => 'txtrequired stocktxt aimslabel col-currency'],
                ];
            break;
            case 'stockgrp': case 'model': case 'part': case 'itemclass': case 'categories': case 'principal': case 'categories':
                if($params['controller']->module->id == 'stockgrp') { $colname = "Group Name"; }
                if($params['controller']->module->id == 'model') { $colname = "Model Name"; }
                if($params['controller']->module->id == 'part') { $colname = "Part Name"; }
                if($params['controller']->module->id == 'itemclass') { $colname = "Class Name"; }
                if($params['controller']->module->id == 'categories') { $colname = "Categories Name"; }
                
                $columns = [
                    ['name' => 'line', 'hidden' => true, 'default' => '0', 'class' => 'txtrequired txthidden'],
                    ['name' => 'Code', 'label' => 'Code', 'editable' => true, 'type' => 'text', 'class' => 'stocktxt aimslabel col-min'],
                    ['name' => 'Name', 'label' => $colname, 'editable' => true, 'type' => 'text', 'class' => 'txtrequired stocktxt aimslabel col-xxxl'],
                ];
            break;
            case 'taxmenu':
                $columns = [
                    ['name' => 'line', 'hidden' => true, 'default' => '0', 'class' => 'txtrequired txthidden'],
                    ['name' => 'name', 'editable' => true, 'type' => 'text', 'class' => 'txtrequired stocktxt aimslabel col-description'],
                    ['name' => 'atc', 'editable' => true, 'type' => 'text', 'class' => 'txtrequired stocktxt aimslabel col-description'],
                    ['name' => 'rate', 'editable' => true, 'type' => 'text', 'class' => 'txtrequired stocktxt aimslabel col-description'],
                ];
            break;
            case 'stype':
                $columns = [
                    ['name' => 'type', 'editable' => true, 'type' => 'text', 'class' => 'txtrequired stocktxt aimslabel col-xxxl'],
                    ['name' => 'line', 'hidden' => true, 'default' => '0', 'class' => 'txtrequired txthidden']
                ];
            break;

            // WTODO[JAD][2019.09.03]
            case 'prodtype': case 'transform': case 'sealing': case 'plastic':
            case 'prodspec': case 'inout': case 'reject':
                $columns = [
                    ['name' => 'line', 'hidden' => true, 'default' => 0, 'class'=> 'txtrequired stocktxt'],
                    ['name' => 'code', 'editable' => true, 'type' => 'text', 'class' => 'stocktxt aimslabel col-codes'],
                    ['name' => 'name', 'editable' => true, 'type' => 'text', 'class' => 'txtrequired stocktxt aimslabel col-xxxl']
                ];
            break;
        }
        $params = [
            'sql' => $qry,
            'tableid' => 'mastergrid',
            'key' => 'line',
            'txtclass' => 'mastertextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => $columns,
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-save"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'mastersave btn btn-social-icon btn-bitbucket'
                ],[
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'masterdelete btn btn-social-icon btn-github'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }


    public function automateClientunpaid($params) {
        $qry = Yii::$app->backend->searchClientunpaid($params['controller'],$params['controller']->access['view'],$params['x'],$params['clientcode'],$params['unpaidlookuptype']);
        $params = [
            'sql' => $qry,
            'tableid' => 'clientunpaidtbl',
            'key' => 'trno',
            'txtclass' => 'txtclientunpaid',
            'checkbox' => true,
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'dateid',
                    'label' => 'Date',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'docno',
                    'label' => 'Document #',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'acnoname',
                    'label' => 'Account Name',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'db',
                    'label' => 'AR',
                    'class' => 'aimslabel col-currency'
                ],[
                    'name' => 'cr',
                    'label' => 'AP',
                    'class' => 'aimslabel col-currency'
                ],[
                    'name' => 'bal',
                    'label' => 'Amt Due',
                    'class' => 'aimslabel col-currency'
                ],[
                    'name' => 'yourref',
                    'label' => 'Ref',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => '0'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }

        public function automateRoutelookup($controller) {
            $qry = Yii::$app->backend->searchRoutes($controller->access['view']);
            $params = [
                'sql' => $qry,
                'tableid' => 'tblroutes',
                'key' => 'route_id',
                'txtclass' => 'bodytextbox',
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [[
                        'name' => 'route_name',
                        'label' => 'Route',
                        'class' => 'aimslabel col-description'
                    ]],
                'buttons' => [
                    [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickroute btn btn-social-icon btn-bitbucket',
                    'attributes'=>[['name'=>'routeid','value'=>'route_id'],['name'=>'route','value'=>'route_name']]
                    ]
                ]
            ];
            
            return Yii::$app->tblgenerator->generateGrid($params);
        }


        public function automateAgentlookup($params) {
            if(isset($params['type'])){
                switch ($params['type']) {
                    case 'uv_picker':
                        $qry = Yii::$app->backend->search_uvpickers($params['controller'],$params['controller']->access['view'],$params['x']);
                    break;
                    
                    case 'uv_checker':
                        $qry = Yii::$app->backend->search_uvcheckers($params['controller'],$params['controller']->access['view'],$params['x']);
                    break;

                    default:
                        $qry = Yii::$app->backend->searchagents($params['controller'],$params['controller']->access['view'],$params['x']);
                    break;
                }//end switch
            }else{
                $qry = Yii::$app->backend->searchagents($params['controller'],$params['controller']->access['view'],$params['x']);
            }//end if

            $params = [
                'sql' => $qry,
                'tableid' => 'tbl-customerlookup',
                'key' => 'agid',
                'txtclass' => 'bodytextbox',
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                
                'column' => [[
                        'name' => 'agcode',
                        'label' => 'Agent Code',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'agname',
                        'label' => 'Agent Name',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'agadd',
                        'label' => 'Address',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'agtel',
                        'label' => 'Tel #',
                        'class' => 'aimslabel col-min'
                    ]],
                
                'buttons' => [
                    [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'btnagentlookup btn btn-social-icon btn-bitbucket',
                    'attributes'=>[['name'=>'id','value'=>'agid'],['name'=>'agcode','value'=>'agcode'],['name'=>'agname','value'=>'agname']],
                    ]
                ]
            ];
            
            return Yii::$app->tblgenerator->generateGrid($params);
        }


        public function automateItembal($params) {
            if($params['controller']->module->id == 'admin') {
                $qry = Yii::$app->backend->searchItembal($params['controller'],'',$params['x'],$params['factor']);
            } else {
                $qry = Yii::$app->backend->searchItembal($params['controller'],$params['controller']->access['view'],$params['x'],$params['factor']);
            }
            $params = [
                'sql' => $qry,
                'tableid' => 'itembaltbl',
                'key' => 'itemid',
                'column' => [
                    [
                        'name' => 'whname',
                        'label' => 'Warehouse',
                        'class' => 'col-codes'
                    ],[
                        'name' => 'bal',
                        'label' => 'Balance',
                        'class' => 'col-quantity'
                    ],[
                        'name' => 'loc',
                        'label' => 'Location',
                        'class' => 'col-codes'
                    ],[
                        'name' => 'expiry',
                        'label' => 'Expiration',
                        'class' => 'col-codes'
                    ]
                ]
            ];
            return Yii::$app->tblgenerator->generateGrid($params);
        }




        
        public function automateClientlookup($params) {
            switch ($params['controller']->module->id) {
                case 'reportlist':
                    $qry= Yii::$app->backend->ReportsearchClient('',$params['x'],'customer');
                break;
                
                default:
                    $qry= Yii::$app->backend->searchClient($params['controller'],$params['controller']->access['view'],$params['x']);
                break;
            }//end switch

            switch ($params['controller']->module->id) {
                case 'SJ': case 'customer':
                    $hide_last10 = "display:table-inline;";
                break;

                default:
                    $hide_last10 = "display:none;";
                break;
            }//End switch

            $params = [
                'sql' => $qry,
                'tableid' => 'tbl-customerlookup',
                'key' => 'clientid', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
                'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                
                'column' => [[
                        'name' => 'client',
                        'label' => 'Customer Code',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'clientname',
                        'label' => 'Customer Name',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'addr',
                        'label' => 'Address',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'contact',
                        'label' => 'Contact Person',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'tel',
                        'label' => 'Tel #',
                        'class' => 'aimslabel col-min'
                    ]],
                
                'buttons' => [
                    [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'btncustomerlookup btn btn-social-icon btn-bitbucket',
                    'attributes'=>[['name'=>'id','value'=>'clientid'],['name'=>'client','value'=>'client'],['name'=>'clientname','value'=>'clientname'],['name' => 'type', 'value' => 'type']],
                    ],[
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-list-alt"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;'.$hide_last10,
                    'class' => 'btnlast10trans btn btn-social-icon btn-github',
                    'attributes'=>[['name'=>'id','value'=>'clientid'],
                                  ['name'=>'client','value'=>'client'],['name'=>'clientname','value'=>'clientname']],
                    ]
                ]
            ];
            
            return Yii::$app->tblgenerator->generateGrid($params);
        }


      public function fnGetLast10Trans($id,$code){
        $qry = "select yourref,trno,docno,itemname,left(dateid,10) as dateid,
                round(isamt,2) as isamt,round(isqty,2) as isqty,round(ext,2) as ext from (
                select head.yourref,head.trno,head.doc,head.docno,stock.itemname,head.dateid,stock.isqty,
                stock.isamt,stock.ext from lahead as head
                left join lastock as stock on stock.trno = head.trno
                where head.doc = 'SJ' and stock.itemname is not null
                and head.client = '".$code."'
                UNION ALL
                select head.yourref,head.trno,head.doc,head.docno,stock.itemname,head.dateid,stock.isqty,
                stock.isamt,stock.ext from glhead as head
                left join glstock as stock on stock.trno = head.trno
                where head.doc = 'SJ' and stock.itemname is not null
                and head.clientid = ".$id.") as tbl order by dateid desc limit 20";

        $params = [
                'sql' => $qry,
                'tableid' => 'tbl-last10trans',
                'key' => 'trno', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
                'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                
                'column' => [[
                        'name' => 'docno',
                        'label' => 'Trans #',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'itemname',
                        'label' => 'Itemname',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'dateid',
                        'label' => 'Date',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'yourref',
                        'label' => 'Ref #',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'isamt',
                        'label' => 'Amount',
                        'class' => 'aimslabel col-currency'
                    ],[
                        'name' => 'isqty',
                        'label' => 'Qty',
                        'class' => 'aimslabel col-quantity'
                    ],[
                        'name' => 'ext',
                        'label' => 'Total',
                        'class' => 'aimslabel col-currency'
                    ]],
            ];
            
            return Yii::$app->tblgenerator->generateGrid($params);
    }//end if
    
      public function automateMultivoid($params) {
        $qry = Yii::$app->backend->getItemsAvailableForVoid($params['controller']->module->id,$params['pkey'],$params['x']);
        $params = [
            'sql' => $qry,
            'tableid' => 'tbl-multivoid',
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'checkbox' => true,
            'column' => [
                [
                    'name' => 'barcode',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'itemname',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'uom',
                    'label' => 'UOM',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'qty',
                    'class' => 'aimslabel col-quantity'
                ],[
                    'name' => 'bal',
                    'label' => 'Served',
                    'class' => 'aimslabel col-quantity'
                ]
            ]
        ];

        return Yii::$app->tblgenerator->generateGrid($params);
    }



    public function automateUomlookup($params) {
            $qry = Yii::$app->backend->searchUom($params['controller'],$params['controller']->access['view'],$params['itemid']);

            $mlcpfield1 = ['name'=>''];
            $mlcpfield2 = ['name'=>''];
            $mlcpfield1_view = ['name'=>''];
            $mlcpfield2_view = ['name'=>''];
            
            $amtfield_view = [
                'name' => 'amt',
                'label' => 'Amount',
                'class' => 'col-currency'
            ];

            $descriptionfield_view = [
                'name' => 'uom_desc',
                'label' => 'Description',
                'class' => 'col-description'
            ];

            $amtfield = [
                'name' => 'amt',
                'label' => 'Amount',
                'editable' => true,
                'default' => '0',
                'type' => 'text',
                'class'=>'col-currency stocktxt input-sm',
            ];

            $descriptionfield = [
                'name' => 'uom_desc',
                'label' => 'Description',
                'editable' => true,
                'type' => 'text',
                'default' => '',
                'class'=>'col-description stocktxt input-sm',
            ];

            switch (Yii::$app->systemsettings->companyConfig()) {
              case 'MLCP':
                $mlcpfield1 = [
                                  'name' => 'kilos',
                                  'editable' => true,
                                  'default' => '',
                                  'label' => 'Kilo',
                                  'type' => 'text',
                                  'class' => 'col-min stocktxt txtkilo'
                ];

                $mlcpfield1_view = [
                        'name' => 'kilos',
                        'label' => 'Kilo',
                        'class' => 'col-codes'
                ];

                $mlcpfield2 = [
                      'name' => 'cbm',
                      'editable' => true,
                      'default' => '',
                      'label' => 'CBM',
                      'type' => 'text',
                      'class' => 'col-min stocktxt txtcbm'
                ];

                $mlcpfield2_view = [
                        'name' => 'cbm',
                        'label' => 'CBM',
                        'class' => 'col-codes'
                ];

                $amtfield_view = ['name'=>''];
                $descriptionfield_view = ['name'=>''];
                $amtfield = ['name'=>''];
                $descriptionfield = ['name'=>''];
              break;
            }//end switch

            if($params['type'] == 'pick') {
                $column = [
                    [
                        'name' => 'uom',
                        'label' => 'UOM',
                        'class' => 'col-codes'
                    ],[
                        'name' => 'factor',
                        'class' => 'col-currency'
                    ],$amtfield_view,$descriptionfield_view,$mlcpfield1_view,$mlcpfield2_view
                ];
                $buttons = [
                    [
                        'name' => '',
                        'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                        'style' => 'width:18px;height:18px;margin-top:-2px;',
                        'class' => 'selecitemtuom btn btn-social-icon btn-success',
                        'attributes' => [
                            ['name' => 'uom', 'value' => 'uom'],
                            ['name' => 'kilos', 'value' => 'kilos'],
                            ['name' => 'uom_desc', 'value' => 'uom_desc'],
                            ['name' => 'factor', 'value' => 'factor'],
                            ['name' => 'amt', 'value' => 'amt'],
                            ['name' => 'isfromitem', 'value' => 'isfromitem'],
                            ['name' => 'line', 'value' => 'line']
                        ]
                    ]
                ];
            } else {
                $column = [
                    [
                        'name' => 'uom',
                        'label' => 'UOM',
                        'editable' => true,
                        'type' => 'text',
                        'default' => '',
                        'class'=>'col-codes stocktxt input-sm',
                    ],[
                        'name' => 'factor',
                        'editable' => true,
                        'type' => 'text',
                        'default' => '0',
                        'class'=>'col-currency stocktxt input-sm',
                    ],$amtfield,$descriptionfield,$mlcpfield1,$mlcpfield2,[
                        'name' => 'line',
                        'hidden' => true,
                        'default' => '0',
                        'class' => 'aimslabel txthidden'
                    ],[
                        'name' => 'prevuom',
                        'hidden' => true,
                        'default' => '',
                        'class' => 'aimslabel txthidden'
                    ]
                ];
                $buttons = [
                    [
                        'name' => '',
                        'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-save"></i>',
                        'style' => 'width:18px;height:18px;margin-top:-2px;',
                        'class' => 'uomformsave btn btn-social-icon btn-bitbucket'
                    ],
                    [
                        'name' => '',
                        'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-trash"></i>',
                        'style' => 'width:18px;height:18px;margin-top:-2px;',
                        'class' => 'uomformdelete btn btn-social-icon btn-google',
                        'attributes' => [['name' => 'line','value' => 'line'],['name' => 'uom', 'value' => 'uom']]
                    ]
                ];
            }
            $params = [
                'sql' => $qry,
                'tableid' => 'uomlookup',
                'key' => 'line', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
                'txtclass' => 'txtuomlookup', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => $column,
                'buttons' => $buttons
            ];
            return Yii::$app->tblgenerator->generateGrid($params);
        }


    public function automateCheckslookup($params) {
        $qry = Yii::$app->backend->searchChecks($params['controller'],$params['controller']->access['view'],$params['x']);
        $params = [
            'sql' => $qry,
            'tableid' => 'checkslookuptbl',
            'key' => 'trno',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'checkbox' => true,
            'column' => [[
                    'name' => 'acnoname',
                    'label' => 'Acc Name',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'checkno',
                    'label' => 'Check #',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'checkdate',
                    'label' => 'Check date',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'docno',
                    'label' => 'Document #',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'db',
                    'label' => 'DB',
                    'class' => 'aimslabel col-currency'
                ],[
                    'name' => 'cr',
                    'label' => 'CR',
                    'class' => 'aimslabel col-currency'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => '0'
                ]]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    
      public function automateAcctg($controller,$params){
         $qry = Yii::$app->backend->getDistributionlist($params['x']);
        
        $params = [
            'sql' => $qry,
            'tableid' => 'modal-modulelog',
            'key' => 'line', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            
            'column' => [
                [
                    'name' => 'acno',
                    'label' => 'Account No.',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'acnoname',
                    'label' => 'Account Name',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'db',
                    'label'=>'Debit',
                    'viewtype' => 'currency',
                    'class' => 'aimslabel col-currency'
                ],[
                    'name' => 'cr',
                    'label' => 'Credit',
                    'viewtype' => 'currency',
                    'class' => 'aimslabel col-currency'
                ],[
                    'name' => 'checkno',
                    'label' => 'Check Detail',
                    'class' => 'aimslabel col-codes'
                ],//END BUTTON ARRAY
            ]
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end function

      public function automateLocationlookup($params) {
            $qry = Yii::$app->backend->getAvailableLocation($params['x']);
            // return $qry;
            $params = [
                'sql' => $qry,
                'tableid' => 'tbllocation',
                'key' => 'expiry', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
                'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                
                'column' => [[
                        'name' => 'whcode',
                        'label' => 'WH Code',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'whname',
                        'label' => 'WH Name',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'loc',
                        'label' => 'Location',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'expiry',
                        'label' => 'Expiry',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'bal',
                        'label' => 'Balance',
                        'class' => 'aimslabel col-codes'
                    ]
                ],
                'buttons' => [
                    [
                        'name' => '',
                        'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                        'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                        'class' => 'selectloc btn btn-social-icon btn-bitbucket',
                        'attributes'=>[
                            ['name'=>'whcode','value'=>'whcode'], ['name'=>'whname','value'=>'whname'], ['name'=>'loc','value'=>'loc'],['name'=>'expiry','value'=>'expiry'], ['name'=>'bal','value'=>'bal']
                        ]
                    ]
                ]
            ];
            
            return Yii::$app->tblgenerator->generateGrid($params);
        }

        public function automateDistro($params) {
            $qry = Yii::$app->backend->searchdistro($params['controller'],$params['controller']->access['view'],$params['x']);
            $params = [
                'sql' => $qry,
                'tableid' => 'tbl-acctg',
                'key' => 'line',
                'txtclass' => 'bodytextbox',
                'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [
                    [
                        'name' => 'acno',
                        'label' => 'Account #',
                        'class' => 'aimslabel col-codes'
                    ],
                    [
                        'name' => 'acnoname',
                        'label' => 'Account Name',
                        'class' => 'aimslabel col-description'
                    ],
                    [
                        'name' => 'db',
                        'label' => 'DB',
                        'class' => 'aimslabel col-currency'
                    ],
                    [
                        'name' => 'cr',
                        'label' => 'CR',
                        'class' => 'aimslabel col-currency'
                    ],
                    [
                        'name' => 'checkno',
                        'label' => 'Check Details',
                        'class' => 'col-codes aimslabel'
                    ]
                ]
            ];
            return Yii::$app->tblgenerator->generateGrid($params);
        }

        public function automateCostcenter($params) {
            $qry = Yii::$app->backend->searchCostcenter($params['controller'],$params['controller']->access['view']);
            $params = [
                'sql' => $qry,
                'tableid' => 'tblcostcenters',
                'key' => 'line',
                'txtclass' => 'bodytextbox',
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspSelect&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [
                    [
                        'name' => 'code',
                        'label' => 'Cost Center Code',
                        'class' => 'col-codes aimslabel'
                    ],[
                        'name' => 'name',
                        'label' => 'Cost Center Name',
                        'class' => 'col-description aimslabel'
                    ]
                ],
                'buttons' => [
                    [
                        'name' => '',
                        'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                        'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                        'class' => 'selectcostcenter btn btn-social-icon btn-bitbucket',
                        'attributes'=>[['name'=>'line','value'=>'line'],['name'=>'costcode','value'=>'code'],['name'=>'costname','value'=>'name']]
                    ]
                ]
            ];
            return Yii::$app->tblgenerator->generateGrid($params);
        }

       public function automateContralookup($params) {
            if($params['controller']->module->id == 'branch') {
                $qry = Yii::$app->backend->searchContra2($params['controller'],$params['controller']->access['view'],$params['x'],$params['contratype']);
            } else {
                $qry = Yii::$app->backend->searchContra($params['controller'],$params['controller']->access['view'],$params['x']);
            }
            $params = [
                'sql' => $qry,
                'tableid' => 'tbl_contra',
                'key' => 'acnoid', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
                'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                
                'column' => [[
                        'name' => 'acnoname',
                        'label' => 'Account Name',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'acno',
                        'class' => 'aimslabel col-codes'
                    ]],
                'buttons' => [
                    [
                        'name' => '',
                        'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                        'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                        'class' => 'searchcontrabtn btn btn-social-icon btn-bitbucket',
                        'attributes'=>[
                            ['name'=>'id','value'=>'acnoid'],['name'=>'acnoname','value'=>'acnoname'],['name'=>'acno','value'=>'acno'],['name'=>'alias','value'=>'alias']
                        ]
                    ]
                ]
            ];
            
            return Yii::$app->tblgenerator->generateGrid($params);
        }

        public function automateContrabanklookup($params) {
            $qry = "select acno,acnoid,acnoname,left(alias,2) as alias from coa where acnoname like '%".$params['x']."%'
                    and left(alias,2) = 'CB' or acno like '%\\".$params['x']."%' and left(alias,2) = 'CB'
                    order by acnoname LIMIT 50";

            $params = [
                'sql' => $qry,
                'tableid' => 'tbl_contra',
                'key' => 'acnoid', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
                'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                
                'column' => [[
                        'name' => 'acnoname',
                        'label' => 'Account Name',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'acno',
                        'class' => 'aimslabel col-codes'
                    ]],
                'buttons' => [
                    [
                        'name' => '',
                        'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                        'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                        'class' => 'searchcontrabtn btn btn-social-icon btn-bitbucket',
                        'attributes'=>[
                            ['name'=>'id','value'=>'acnoid'],['name'=>'acnoname','value'=>'acnoname'],['name'=>'acno','value'=>'acno'],['name'=>'alias','value'=>'alias']
                        ]
                    ]
                ]
            ];
            
            return Yii::$app->tblgenerator->generateGrid($params);
        }


        public function automateRequiredcoa($params) {
            $qry = Yii::$app->backend->searchRequiredcoa($params['controller'],$params['controller']->access['view']);
            $params = [
                'sql' => $qry,
                'tableid' => 'tbl_alias',
                'key' => 'alias',
                'txtclass' => 'bodytextbox',
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [
                    [
                        'name' => 'alias',
                        'editable' => false,
                        'class' => 'aimslabel col-min'
                    ],[
                        'name' => 'acno',
                        'label' => 'Code',
                        'editable' => false,
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'acnoname',
                        'label' => 'Accountname',
                        'editable' => false,
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'type',
                        'editable' => false,
                        'class' => 'aimslabel col-min'
                    ]
                ]
            ];
            return Yii::$app->tblgenerator->generateGrid($params);
        }




    public function automateSupplierpodetailed($params) {
        $qry = Yii::$app->backend->searchSupplierPODetailed($params['controller'],$params['controller']->access['view'],$params['x'],$params['clientcode']);
        switch($params['controller']->module->id) {
            case 'CM': case 'PO': case 'RR': case 'DM': case 'TS': case 'MX':
                $column = [
                    [
                        'name' => 'yourref',
                        'label' => 'Reference',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'docno',
                        'label' => 'Doc #',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'barcode',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'itemname',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'rrcost',
                        'label' => 'Amt',
                        'class' => 'aimslabel col-currency'
                    ],[
                        'name' => 'uom',
                        'label' => 'UOM',
                        'class' => 'aimslabel col-min'
                    ],[
                        'name' => 'disc',
                        'label' => 'Discount',
                        'class' => 'aimslabel col-min'
                    ],[
                        'name' => 'rrqty',
                        'label' => 'Order',
                        'class' => 'aimslabel col-quantity'
                    ],[
                        'name' => 'pending',
                        'class' => 'aimslabel col-quantity'
                    ],[
                        'name' => 'qa',
                        'label' => 'Served',
                        'class' => 'aimslabel col-quantity'
                    ],[
                        'name' => 'ext',
                        'label' => 'Amt',
                        'class' => 'aimslabel col-quantity'
                    ],[
                        'name' => 'wh',
                        'label' => 'WH',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'line',
                        'hidden' => true,
                        'class' => 'txtline txthidden',
                        'default' => '0'
                    ]
                ];
            break;
            case 'SJ': case 'SO': case 'customer': case 'QA':
                $column = [
                    [
                        'name' => 'yourref',
                        'label' => 'Reference',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'docno',
                        'label' => 'Doc #',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'barcode',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'itemname',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'isamt',
                        'label' => 'Amt',
                        'class' => 'aimslabel col-currency'
                    ],[
                        'name' => 'uom',
                        'label' => 'UOM',
                        'class' => 'aimslabel col-min'
                    ],[
                        'name' => 'disc',
                        'label' => 'Discount',
                        'class' => 'aimslabel col-min'
                    ],[
                        'name' => 'isqty',
                        'label' => 'Order',
                        'class' => 'aimslabel col-quantity'
                    ],[
                        'name' => 'pending',
                        'class' => 'aimslabel col-quantity'
                    ],[
                        'name' => 'qa',
                        'label' => 'Served',
                        'class' => 'aimslabel col-quantity'
                    ],[
                        'name' => 'ext',
                        'label' => 'Amt',
                        'class' => 'aimslabel col-quantity'
                    ],[
                        'name' => 'wh',
                        'label' => 'WH',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'line',
                        'hidden' => true,
                        'class' => 'txtline txthidden',
                        'default' => '0'
                    ]
                ];
            break;
        }
        $params = [
            'sql' => $qry,
            'tableid' => 'clientpodetailed',
            'key' => 'trno',
            'txtclass' => 'bodytextbox',
            'checkbox' => true,
            'column' => $column
        ];

        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function automateSupplierposummarized($params) {
        $qry= Yii::$app->backend->searchSupplierPOSummarized($params['controller'],$params['controller']->access['view'],$params['x'],$params['clientcode']);
        $params = [
            'sql' => $qry,
            'tableid' => 'clientposummarized',
            'key' => 'trno', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'checkbox' => true,
            'column' => [[
                    'name' => 'yourref',
                    'label' => 'Reference',
                    'class' => 'aimslabel col-codes'
                ],[
                        'name' => 'docno',
                        'label' => 'Document #',
                        'editable'=>true,
                        'type' =>'documentlink',
                        'linkdoc'=>'doc',
                        'linkparam'=>'docno',
                        'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'dateid', 
                    'label' => 'Date',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'totalamt',
                    'label' => 'Amt',
                    'class' => 'aimslabel col-codes'
                ]]
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function automateLog($controller,$params){
        switch ($controller->module->id) {
            case 'useraccess':
                $qry = Yii::$app->backend->useraccessLog($params['x']);
            break;
            
            default:
               $qry = Yii::$app->backend->searchLog($controller,$params['x']);
            break;
        }//end swtich

        $params = [
            'sql' => $qry,
            'tableid' => 'modal-modulelog',
            'key' => 'trno',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'userid',
                    'label' => 'User',
                    'class' => 'aimslabel col-user'
                ],[
                    'name' => 'field',
                    'label' => 'Level',
                    'class' => 'aimslabel col-level'
                ],[
                    'name' => 'oldversion',
                    'label'=>'Activity',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'dateid',
                    'label' => 'Date Occured',
                    'class' => 'aimslabel col-date'
                ],
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function loadUsers() {
        $qry = Yii::$app->backend->getUsers2();
        $params = [
            'sql' => $qry,
            'tableid' => 'userstbl',
            'key' => 'userid',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'username',
                    'label' => 'User',
                    'class' => 'aimslabel col-description'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickuser btn btn-social-icon btn-bitbucket',
                    'attributes'=>[
                        ['name'=>'userid','value'=>'userid'],['name'=>'accessid','value'=>'accessid'],['name'=>'username','value'=>'username'],['name'=>'uname','value'=>'name']
                    ]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function loadPrefixes($doc) {
        $qry = Yii::$app->backend->getprefixes($doc);
        $params = [
            'sql' => $qry,
            'tableid' => 'userstbl',
            'key' => 'userid',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'info',
                    'label' => 'Prefix',
                    'class' => 'aimslabel col-description'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickbref btn btn-social-icon btn-bitbucket',
                    'attributes'=>[['name'=>'bref','value'=>'info']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }


public function automateUOMlookupGV($params){
    try {
        $qry = Yii::$app->backend->loadAvailableuom2($params['itemid']);
        $params = [
            'sql' => $qry,
            'tableid' => 'uom-lookup',
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            
            'column' => [[
                    'name' => 'uom',
                    'label' => 'UOM',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'factor',
                    'label' => 'Factor',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'amt',
                    'label' => 'Amount',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'uom_desc',
                    'label' => 'Description',
                    'class' => 'aimslabel col-description'
                ],],
            
            'buttons' => [
                [
                'name' => '',
                'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                'style' => 'width:18px;height:18px;margin-top:-2px;',
                'class' => 'selectuom btn btn-social-icon btn-bitbucket',
                'attributes'=>[['name'=>'uom',
                               'value'=>'uom'],//THIS PART IS NEED TO BE PART OF THE QUERY
                               ['name'=>'uomfactor',
                               'value'=>'factor'],
                              ],
                ],//END BUTTON ARRAY
            ]
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    } catch (ErrorException $e) {
        echo $e;
    }
    }//end function
    
    //WTODO: [KIM][2019.11.11][automateFgitemlookupGV]
    public function automateFgitemlookupGV($params){
        $qry = Yii::$app->backend->searchFGItem($params['controller'],$params['controller']->access['view'],$params['x']);

        $buttons = [
            [
                'name' => '',
                'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-plus"></i>',
                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                'class' => 'stockaddfgitem btn btn-social-icon btn-bitbucket',
                'attributes'=>[['name'=>'ukey',
                               'value'=>'itemid'],
                               ['name'=>'barcode',
                               'value'=>'barcode'],
                               ['name'=>'itemname',
                               'value'=>'itemname'],
                               ['name'=>'uom',
                               'value'=>'uom'],
                               ['name'=>'amt',
                               'value'=>'amt'],
                              ],
            ],[
                'name' => '',
                'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                'class' => 'showbalance btn btn-social-icon btn-github'
            ]
        ];

        switch (Yii::$app->systemsettings->companyConfig()) {
            default:
                $fields = [[
                    'name' => 'barcode',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'itemname',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'uom',
                    'label' => 'UOM',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'part',
                    'label' => 'Part',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'category',
                    'label' => 'Category',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'model',
                    'label' => 'Model',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'groupid',
                    'label' => 'Group',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txtstockitemid txthidden',
                    'default'=>'0',
                ]];
            break;
        }//end switch

        $params = [
            'sql' => $qry,
            'tableid' => 'fgitemlookuptbl',
            'key' => 'itemid',
            'txtclass' => 'bodytextbox',
            'checkbox' => false, //OPT
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            
            'column' => $fields,
            'buttons' => $buttons
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function automateItemlookupGV($params){
        $whole_net_amt_field = ['name'=>''];

        if($params['controller']->module->id == 'admin') {
            $qry = Yii::$app->backend->searchItem($params['controller'],'',$params['x']);
            $whole_net_amt_field = [
                    'name' => 'wholesale_net',
                    'label' => 'Wholesale (Net)',
                    'class' => 'col-codes'
            ];

            $buttons = [
                [
                    'name' => '',
                    'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'quickinquirybal btn btn-social-icon btn-github',
                    'attributes' => [['name'=>'barcode','value'=>'barcode']],
                ]
            ];
        }else{
            if($params['controller']->module->id == 'SO' || $params['controller']->module->id == 'SJ'){
                $addedparams = [];
                $addedparams['clientcode'] = $params['clientcode'];
                $qry = Yii::$app->backend->searchItem($params['controller'],$params['controller']->access['view'],$params['x'], $addedparams);
            }else{
                $qry = Yii::$app->backend->searchItem($params['controller'],$params['controller']->access['view'],$params['x']);
            }//end if

            $buttons = [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-plus"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'stockaddthisitem btn btn-social-icon btn-bitbucket',
                    'attributes'=>[['name'=>'ukey',
                                   'value'=>'itemid'],
                                   ['name'=>'barcode',
                                   'value'=>'barcode'],
                                   ['name'=>'itemname',
                                   'value'=>'itemname'],
                                   ['name'=>'uom',
                                   'value'=>'uom'],
                                   ['name'=>'amt',
                                   'value'=>'amt'],
                                   ['name'=>'shortname',
                                   'value'=>'shortname'],
                                  ],
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'showbalance btn btn-social-icon btn-github'
                ]
            ];
            
        }//end switch

        $fields = [[
                    'name' => 'itemname',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'uom',
                    'label' => 'UOM',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'amt',
                    'label' => 'Price',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'disc',
                    'label' => 'Discount',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'netprice',
                    'label' => 'Net Price',
                    'class' => 'aimslabel col-codes'
                ],
                $whole_net_amt_field,
                [
                    'name' => 'uv_principal',
                    'label' => 'Principal',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'groupid',
                    'label' => 'Division',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'sizeid',
                    'label' => 'Bin',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'model',
                    'label' => 'Generic',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'body',
                    'label' => 'Form',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'part',
                    'label' => 'Category',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'class',
                    'label' => 'Classification',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txtstockitemid txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'uv_priority',
                    'label' => 'Priority',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'barcode',
                    'class' => 'aimslabel col-codes'
                ]];

        $params = [
            'sql' => $qry,
            'tableid' => 'item-lookup',
            'key' => 'itemid',
            'txtclass' => 'bodytextbox',
            'checkbox' => false, //OPT
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            
            'column' => $fields,
            'buttons' => $buttons
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end function

    public function automateTWItemlookupGV($params){
        $sql = "select line,name,atc,rate from taxmenu ";
        $keyword = explode(",", $params['x']);
        
        $criteria="";

        foreach($keyword as $key){
          if ($criteria == "") {
              $criteria = " where (
                                  name LIKE '%" . $key. "%' or
                                  atc LIKE '%" . $key. "%' or
                                  rate LIKE '%" . $key. "%'
                                 )";
          } else {
              $criteria = $criteria . " and " . "(
                                  ame LIKE '%" . $key. "%' or
                                  atc LIKE '%" . $key. "%' or
                                  rate LIKE '%" . $key. "%')";
          }//end if
        }//end for each

        $qry = $sql . " " . $criteria . " order by name asc limit 50";

        $buttons = [
            [
                'name' => '',
                'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-plus"></i>',
                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                'class' => 'stockaddthisitem btn btn-social-icon btn-bitbucket',
                'attributes'=>[['name'=>'line',
                               'value'=>'line'],
                               ['name'=>'atc',
                               'value'=>'atc'],
                               ['name'=>'rate',
                               'value'=>'rate'],
                               ['name'=>'namer',
                               'value'=>'name'],
                              ],
            ]
        ];


        $fields = [[
            'name' => 'name',
            'label' => 'NAME',
            'class' => 'aimslabel col-codes'
        ],[
            'name' => 'atc',
            'label' => 'ATC',
            'class' => 'aimslabel col-codes'
        ],[
            'name' => 'rate',
            'label' => 'RATE',
            'class' => 'aimslabel col-codes'
        ]];

        $params = [
            'sql' => $qry,
            'tableid' => 'item-lookup',
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'checkbox' => false, //OPT
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            
            'column' => $fields,
            'buttons' => $buttons
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end function

    public function automateItemJBMateriallookupGV($params){
        $qry = Yii::$app->backend->searchItem($params['controller'],$params['controller']->access['view'],$params['x']);

        $buttons = [
            [
                'name' => '',
                'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-plus"></i>',
                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                'class' => 'jb_addmaterial btn btn-social-icon btn-bitbucket',
                'attributes'=>[['name'=>'ukey',
                               'value'=>'itemid'],
                               ['name'=>'barcode',
                               'value'=>'barcode'],
                               ['name'=>'itemname',
                               'value'=>'itemname'],
                               ['name'=>'uom',
                               'value'=>'uom'],
                               ['name'=>'amt',
                               'value'=>'amt'],
                              ],
            ],[
                'name' => '',
                'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                'class' => 'showbalance btn btn-social-icon btn-github'
            ]
        ];

        switch (Yii::$app->systemsettings->companyConfig()) {
            default:
                $fields = [[
                    'name' => 'barcode',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'itemname',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'uom',
                    'label' => 'UOM',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'part',
                    'label' => 'Part',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'category',
                    'label' => 'Category',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'model',
                    'label' => 'Model',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'groupid',
                    'label' => 'Group',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txtstockitemid txthidden',
                    'default'=>'0',
                ]];
            break;
        }//end switch

        $params = [
            'sql' => $qry,
            'tableid' => 'item-lookup',
            'key' => 'itemid',
            'txtclass' => 'bodytextbox',
            'checkbox' => false, //OPT
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            
            'column' => $fields,
            'buttons' => $buttons
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end function

    public function automateItemFGlookupGV($params){
        $qry = Yii::$app->backend->searchFGItem($params['controller'],$params['controller']->access['view'],$params['x']);

        $buttons = [
            [
                'name' => '',
                'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-plus"></i>',
                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                'class' => 'stockaddthisitem btn btn-social-icon btn-bitbucket',
                'attributes'=>[['name'=>'ukey',
                               'value'=>'itemid'],
                               ['name'=>'barcode',
                               'value'=>'barcode'],
                               ['name'=>'itemname',
                               'value'=>'itemname'],
                               ['name'=>'uom',
                               'value'=>'uom'],
                               ['name'=>'amt',
                               'value'=>'amt'],
                              ],
            ],[
                'name' => '',
                'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                'class' => 'showbalance btn btn-social-icon btn-github'
            ]
        ];

        switch (Yii::$app->systemsettings->companyConfig()) {
            default:
                $fields = [[
                    'name' => 'barcode',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'itemname',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'uom',
                    'label' => 'UOM',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'part',
                    'label' => 'Part',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'category',
                    'label' => 'Category',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'model',
                    'label' => 'Model',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'groupid',
                    'label' => 'Group',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txtstockitemid txthidden',
                    'default'=>'0',
                ]];
            break;
        }//end switch

        $params = [
            'sql' => $qry,
            'tableid' => 'item-lookup',
            'key' => 'itemid',
            'txtclass' => 'bodytextbox',
            'checkbox' => false, //OPT
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            
            'column' => $fields,
            'buttons' => $buttons
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end function

    public function automateItemlookup_inactiveGV($params){
        $qry = Yii::$app->backend->searchInactiveItem($params['x']);

        $buttons = [
            [
                'name' => '',
                'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-plus"></i>',
                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                'class' => 'stockaddthisitem btn btn-social-icon btn-bitbucket',
                'attributes'=>[['name'=>'ukey',
                               'value'=>'itemid'],
                               ['name'=>'barcode',
                               'value'=>'barcode'],
                               ['name'=>'itemname',
                               'value'=>'itemname'],
                               ['name'=>'uom',
                               'value'=>'uom'],
                               ['name'=>'amt',
                               'value'=>'amt'],
                              ],
            ],[
                'name' => '',
                'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                'class' => 'showbalance btn btn-social-icon btn-github'
            ]
        ];

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'PANDATOOLS':
                $fields = [[
                    'name' => 'barcode',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'itemname',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'model',
                    'label' => 'Model',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'sizeid',
                    'label' => 'Size',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'uom',
                    'label' => 'UOM',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'part',
                    'label' => 'Part',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'category',
                    'label' => 'Category',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'groupid',
                    'label' => 'Group',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txtstockitemid txthidden',
                    'default'=>'0',
                ]];
            break;
            
            case 'UNIVERSE':
                $fields = [[
                    'name' => 'barcode',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'itemname',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'uom',
                    'label' => 'UOM',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'amt',
                    'label' => 'Retail',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'disc',
                    'label' => 'Discount',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'netprice',
                    'label' => 'Net Price',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'uv_priority',
                    'label' => 'Priority',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'uv_principal',
                    'label' => 'Principal',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'sizeid',
                    'label' => 'Bin',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'model',
                    'label' => 'Generic',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'body',
                    'label' => 'Form',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'part',
                    'label' => 'Category',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'class',
                    'label' => 'Classification',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txtstockitemid txthidden',
                    'default'=>'0',
                ]];
            break;

            default:
                $fields = [[
                    'name' => 'barcode',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'itemname',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'uom',
                    'label' => 'UOM',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'part',
                    'label' => 'Part',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'category',
                    'label' => 'Category',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'model',
                    'label' => 'Model',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'groupid',
                    'label' => 'Group',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txtstockitemid txthidden',
                    'default'=>'0',
                ]];
            break;
        }//end switch

        $params = [
            'sql' => $qry,
            'tableid' => 'item-lookup',
            'key' => 'itemid',
            'txtclass' => 'bodytextbox',
            'checkbox' => false, //OPT
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            
            'column' => $fields,
            'buttons' => $buttons
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end function


    public function automateAccountdetailslookup($params){
        $qry = Yii::$app->backend->loadAccountdetails($params['controller'],$params['controller']->access['view'],$params);
        $params = [
                'sql' => $qry,
                'tableid' => 'tbl-accountdetails',
                'key' => 'acnoid', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
                'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
               'column' => [[
                        'name' => 'docno',
                        'label' => 'Document #',
                        'editable'=>true,
                        'type' =>'documentlink',
                        'linkdoc'=>'doc',
                        'linkparam'=>'docno',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'dateid',
                        'label' => 'Date',
                        'class' => 'aimslabel col-min'
                    ],[
                        'name' => 'hclientname',
                        'label' => 'Supplier/ Customer Name',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'db',
                        'label' => 'Debit',
                        'class' => 'aimslabel col-currency',
                        'type' => 'text',
                        'viewtype' => 'currency',
                    ],[
                        'name' => 'cr',
                        'label' => 'Credit',
                        'class' => 'aimslabel col-currency',
                        'type' => 'text',
                        'viewtype' => 'currency',
                    ],[
                        'name' => 'hrem',
                        'label' => 'Notes',
                        'class' => 'aimslabel col-description'
                    ]]
            ];
            
            return Yii::$app->tblgenerator->generateGrid($params);
    }//kim end

       public function automateTermslookup($params) {
            $qry = Yii::$app->backend->loadAvailableterms($params['controller'],$params['controller']->access['view'],$params['x']);
            $params = [
                'sql' => $qry,
                'tableid' => 'tbl-terms',
                'key' => 'line', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
                'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                
                'column' => [[
                        'name' => 'terms',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'days',
                        'class' => 'aimslabel col-codes'
                    ]],
                'buttons' => [
                    [
                        'name' => '',
                        'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                        'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                        'class' => 'pickterms btn btn-social-icon btn-bitbucket',
                        'attributes'=>[
                            ['name'=>'id',
                            'value'=>'line'],
                            ['name'=>'terms',
                            'value'=>'terms'],
                            ['name'=>'days',
                            'value'=>'days']
                        ]
                    ]
                ]
            ];
            
            return Yii::$app->tblgenerator->generateGrid($params);
        }

        public function automateSupplierlookup($params) {
            switch ($params['controller']->module->id) {
                case 'useraccess':
                    $qry = Yii::$app->backend->searchSupplierNoAccess($params['controller'],$params['x']);
                break;
                
                case 'reportlist':
                    $qry = Yii::$app->backend->searchSupplierNoAccess($params['controller'],$params['x']);
                break;

                default:
                    $qry = Yii::$app->backend->searchSupplier($params['controller'],$params['controller']->access['view'],$params['x']);
                break;
            }//end swtich
            
            if($params['controller']->module->id == 'GJ') {
                $attr = [['name' => 'type', 'value' => 'type']];
            } else if($params['controller']->module->id == 'reportlist') {
                $attr = [['name' => 'code', 'value' => 'client'],['name' => 'clientname', 'value' => 'clientname']];
            } else {
                $attr = [['name' => 'code', 'value' => 'client'],['name' => 'clientname', 'value' => 'clientname']];
            }

            $params = [
                'sql' => $qry,
                'tableid' => 'tbl_supplier',
                'key' => 'clientid',
                'txtclass' => 'bodytextbox',
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                
                'column' => [[
                        'name' => 'client',
                        'label' => 'Supplier Code',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'clientname',
                        'label' => 'Supplier Name',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'addr',
                        'label' => 'Address',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'contact',
                        'label' => 'Contact Person',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'tel',
                        'label' => 'Tel #',
                        'class' => 'aimslabel col-codes'
                    ]],
                'buttons' => [
                    [
                        'name' => '',
                        'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                        'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                        'class' => 'btnsupplierlookup btn btn-social-icon btn-bitbucket',
                        'attributes' => $attr
                    ]
                ]
            ];
            
            return Yii::$app->tblgenerator->generateGrid($params);
        }

        public function automateCustomerSupplierlookup($params){
            $qry = "select clientid,clientname,contact,client,addr,tel,type from(
            select clientid,clientname,contact,client,addr,tel,'customer' as type from client
            where (clientname like '%".$params['x']."%' and iscustomer = 1) or (client like '%".$params['x']."%' and iscustomer = 1) 
            or (addr like '%".$params['x']."%' and iscustomer = 1) 
            or (tel like '%".$params['x']."%' and iscustomer = 1)
            UNION ALL 
            select clientid,clientname,contact,client,addr,tel,'supplier' as type from client
            where (clientname like '%".$params['x']."%' and issupplier = 1) or (client like '%".$params['x']."%' and issupplier = 1) 
            or (addr like '%".$params['x']."%' and issupplier = 1) 
            or (tel like '%".$params['x']."%' and issupplier = 1)
            UNION ALL
            select clientid,clientname,'---' as contact,client,addr,tel,'agent' as type from client
            where (clientname like '%".$params['x']."%' and isagent = 1) or (client like '%".$params['x']."%' and isagent = 1) 
            or (addr like '%".$params['x']."%' and isagent = 1) 
            or (tel like '%".$params['x']."%' and isagent = 1)) as tbl order by clientname,client LIMIT ". Yii::$app->systemsettings->querySearchLimit();


            $attr = [['name' => 'code', 'value' => 'client'],['name' => 'clientname', 'value' => 'clientname']];

            $params = [
                'sql' => $qry,
                'tableid' => 'tbl_supplier',
                'key' => 'clientid',
                'txtclass' => 'bodytextbox',
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                
                'column' => [[
                        'name' => 'client',
                        'label' => 'Code',
                        'class' => 'aimslabel col-codes'
                    ],[
                        'name' => 'clientname',
                        'label' => 'Name',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'addr',
                        'label' => 'Address',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'contact',
                        'label' => 'Contact Person',
                        'class' => 'aimslabel col-description'
                    ],[
                        'name' => 'tel',
                        'label' => 'Tel #',
                        'class' => 'aimslabel col-codes'
                    ]],
                'buttons' => [
                    [
                        'name' => '',
                        'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                        'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                        'class' => 'btncustsuplookup btn btn-social-icon btn-bitbucket',
                        'attributes' => $attr
                    ]
                ]
            ];
            
            return Yii::$app->tblgenerator->generateGrid($params);
        }//end fn
     
        public function loadCenters() {
            $qry = Yii::$app->backend->getCenters();
            $params = [
                'sql' => $qry,
                'tableid' => 'tblcenters',
                'key' => 'line',
                'txtclass' => 'bodytextbox',
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [[
                        'name' => 'code',
                        'class' => 'aimslabel col-min'
                    ],[
                        'name' => 'name',
                        'class' => 'aimslabel col-codes'
                    ]],
                'buttons' => [
                    [
                        'name' => '',
                        'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                        'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                        'class' => 'pickcenter btn btn-social-icon btn-bitbucket',
                        'attributes' => [['name'=>'code','value'=>'code']]
                    ]
                ]
            ];
            return Yii::$app->tblgenerator->generateGrid($params);
        }


        public function automateDocnolookup($params) {
            $doc = $params['controller']->module->id;
            switch($doc) {
                default:
                    $col = "clientname";
                    $label = "Customer";
                break;
            }
            $qry = Yii::$app->backend->searchDocument($params['controller'],$params['controller']->access['view'],$params['x']);
            switch ($doc) {
                case 'tpshipping': case 'tphandling':
                    $params = [
                        'sql' => $qry,
                        'tableid' => 'tbl-docnolookup',
                        'key' => 'trno',
                        'txtclass' => 'bodytextbox',
                        'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                        'column' => [[
                                'name' => 'docno',
                                'label' => 'Document #',
                                'class' => 'aimslabel col-description'
                            ],[
                                'name' => 'client',
                                'label' => 'Client Code',
                                'class' => 'aimslabel col-description'
                            ],[
                                'name' => 'clientname',
                                'label' => 'CLient Name',
                                'class' => 'aimslabel col-description'
                            ],[

                                'name' => 'postdate',
                                'class' => 'aimslabel col-description'
                            ],[
                                'name' => 'postedby',
                                'label' => 'Posted by',
                                'class' => 'aimslabel col-description'
                            ]],
                        'buttons' => [
                            [
                                'name' => '',
                                'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                                'class' => 'invoiceplotbtn btn btn-social-icon btn-bitbucket',
                                'attributes' => [['name'=>'id','value'=>'docno'],['name'=>'trno','value'=>'trno']]
                            ]
                        ]
                    ];
                break;


                case 'quotation':
                    $params = [
                        'sql' => $qry,
                        'tableid' => 'tbl-docnolookup',
                        'key' => 'trno',
                        'txtclass' => 'bodytextbox',
                        'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                        'column' => [[
                                'name' => 'dateid',
                                'label' => 'Date',
                                'class' => 'aimslabel col-min'
                            ],[
                                'name' => 'docno',
                                'label' => 'Document #',
                                'class' => 'aimslabel col-description'
                            ],[
                                'name' => $col,
                                'label' => $label,
                                'class' => 'aimslabel col-description'
                            ]],
                        'buttons' => [
                            [
                                'name' => '',
                                'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                                'class' => 'searchdocumentbtn btn btn-social-icon btn-bitbucket',
                                'attributes' => [['name'=>'id','value'=>'docno']]
                            ]
                        ]
                    ];
                break;
                
                default:
                    $params = [
                        'sql' => $qry,
                        'tableid' => 'tbl-docnolookup',
                        'key' => 'trno',
                        'txtclass' => 'bodytextbox',
                        'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                        'column' => [[
                                'name' => 'dateid',
                                'label' => 'Date',
                                'class' => 'aimslabel col-codes'
                            ],[
                                'name' => 'docno',
                                'label' => 'Document #',
                                'class' => 'aimslabel col-description'
                            ],[
                                'name' => $col,
                                'label' => $label,
                                'class' => 'aimslabel col-description'
                            ],[
                                'name' => 'yourref',
                                'class' => 'aimslabel col-codes'
                            ],[
                                'name' => 'ourref',
                                'class' => 'aimslabel col-codes'
                            ],[
                                'name' => 'postdate',
                                'class' => 'aimslabel col-description'
                            ],[
                                'name' => 'postedby',
                                'label' => 'Posted by',
                                'class' => 'aimslabel col-description'
                            ]],
                        'buttons' => [
                            [
                                'name' => '',
                                'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                                'class' => 'searchdocumentbtn btn btn-social-icon btn-bitbucket',
                                'attributes' => [['name'=>'id','value'=>'docno']]
                            ]
                        ]
                    ];
                break;
            }//end swtich

            return Yii::$app->tblgenerator->generateGrid($params);
        }



    public function automateWarehouselookupGV($params){
            switch ($params['controller']->module->id) {
                case 'reportlist':
                    $qry= "select clientid as whid,client as whcode, clientname as whname , addr as whadd,
                    tel as whtel from client 
                    where (clientname like '%".$params['x']."%' and iswarehouse = 1) or 
                    (client like '%".$params['x']."%' and iswarehouse = 1) or 
                    (addr like '%".$params['x']."%' and iswarehouse = 1) or 
                    (tel like '%".$params['x']."%' and iswarehouse = 1)  order by clientname LIMIT 50";
                break;
                
                default:
                    $qry = Yii::$app->backend->searchWarehouse($params['controller'],$params['controller']->access['view'],$params['x']);
                break;
            }//end switch

            $params = [
                'sql' => $qry,
                'tableid' => 'wh-lookup',
                'key' => 'whid',
                'txtclass' => 'bodytextbox',
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [
                    [
                        'name' => 'whcode',
                        'label' => 'WH Code',
                        'class' => 'aimslabel col-codes'
                    ],
                    [
                        'name' => 'whname',
                        'label' => 'WH Name',
                        'class' => 'aimslabel col-description'
                    ],
                    [
                        'name' => 'whadd',
                        'label' => 'Address',
                        'class' => 'aimslabel col-description'
                    ],
                    [
                        'name' => 'whtel',
                        'label' => 'Tel',
                        'class' => 'aimslabel col-codes'
                    ],
                ],
                
                'buttons' => [
                    [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;',
                    'class' => 'selectwh btn btn-social-icon btn-bitbucket',
                    'attributes'=>[['name'=>'wh',
                                   'value'=>'whcode'],//THIS PART IS NEED TO BE PART OF THE QUERY
                                   ['name'=>'whname',
                                   'value'=>'whname'],
                                   ['name'=>'whid',
                                   'value'=>'whid'],
                                  ],
                    ],//END BUTTON ARRAY
                ]
            ];
            
            return Yii::$app->tblgenerator->generateGrid($params);
        }//end function

       
    //alvin end
    public function automateHeadCredential($doc,$keyid,$addedparams=[]){ //THIS FUNCTION RETRIEVES DATA FOR HEAD CREDENTIALS
        switch ($doc) {
            case 'TX':
                $qry = "select shead.trno as sotrno,
                left('".Yii::$app->systemsettings->getCurrentTimeStamp()."',10) as dateid,
                thead.docno as txdocno,
                rhead.docno as rdocno,shead.docno as sdocno,
                rhead.client as agentcode,rhead.clientname as agentname,
                shead.client as customercode,shead.clientname as customername,shead.address,
                shead.wh,wh.clientname as whname,ifnull(tgrp.term_grp,'') as termgrp,ifnull(tgrp.terms,'') as terms
                from txhead as thead
                left join hrfhead as rhead on rhead.trno = thead.rftrno
                left join hsohead as shead on shead.rfno = rhead.trno
                left join client as wh on wh.client = shead.client
                left join hsostock as sstock on sstock.trno = shead.trno
                left join item on item.barcode = sstock.barcode
                left join subcatgrp as sgrp on sgrp.id = item.sc_subcatid
                left join catgrp as cgrp on cgrp.id = sgrp.cgid
                left join termgrp as tgrp on tgrp.id = cgrp.tgid
                where thead.trno = ".$keyid." group by sdocno,termgrp";
            break;

            case 'JB':
                $qry = "select left(head.dateid,10) as dateid,
                head.wh,wh.clientname as whname,customer.addr as address,head.clientname as customername,
                head.client as customercode,head.docno as ourref,head.mat_barcode as yourref,item.itemname
                from hjbhead as head
                left join client as wh on wh.client = head.client
                left join client as customer on customer.client = head.client
                left join item on item.barcode = head.mat_barcode
                where head.trno = ".$keyid;
            break;

            case 'AJ':
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'UNIVERSE':
                        $qry = "select left('".Yii::$app->systemsettings->getCurrentTimeStamp()."',10) as dateid,
                        'PC0000000000002' as wh, 'STORE AREA' as whname, '' as ourref, '' as yourref,
                        '' as address,'POSTING ADJUSTMENT (UNPOSTED TRANS.) ".Yii::$app->systemsettings->getCurrentTimeStamp()."' as rem";
                    break;
                }//end switch
            break;
        }//END FUNCTION

        return $generatelist = Yii::$app->sbccommon->openTable($qry);
    }//end function

    public function automateStockCredential($doc,$keyid,$addedparams=[]){ //THIS FUNCTION RETRIEVES DATA FOR STOCK CREDENTIALS
        switch ($doc) {
            case 'TX':
                $qry = "select thead.trno as txkey,thead.docno as txdocno, rhead.docno as rdocno,shead.docno as ref,
                sstock.barcode,sstock.itemname,sstock.uom,wh.client as wh,wh.clientname as whname,sstock.disc,sstock.rem,
                sstock.isamt,sstock.iss,sstock.amt,sstock.iss,sstock.isqty,sstock.ext,0 as void,
                sstock.trno as refx,sstock.line as linex,sstock.loc,sstock.expiry from txhead as thead
                left join hrfhead as rhead on rhead.trno = thead.rftrno
                left join hsohead as shead on shead.rfno = rhead.trno
                left join hsostock as sstock on sstock.trno = shead.trno
                left join client as wh on wh.client = sstock.wh
                left join item on item.barcode = sstock.barcode
                left join subcatgrp as sgrp on sgrp.id = item.sc_subcatid
                left join catgrp as cgrp on cgrp.id = sgrp.cgid
                left join termgrp as tgrp on tgrp.id = cgrp.tgid
                where thead.trno = ".$keyid." and tgrp.term_grp = '".$addedparams['termgrp']."' and sstock.trno = ".$addedparams['sotrno']."";
            break;

            case 'JB':
                $qry = "select item.itemid,materialtab.barcode,
                item.itemname,materialtab.qty as isqty,item.uom,uom.factor,
                head.mat_barcode as rem,head.docno as ref from jb_materialtab as materialtab
                left join item on item.barcode = materialtab.barcode 
                left join hjbhead as head on head.trno = materialtab.trno
                left join uom on uom.uom = item.uom and uom.itemid = item.itemid
                where materialtab.trno = " . $keyid;
            break;

            case 'JB_TS':
                $qry = "select cycinfo.itemid,cycinfo.barcode,
                cycinfo.itemname,1 as isqty,cycinfo.uom,1 as factor,
                item.barcode as rem,head.docno as ref from hjbhead as head
                left join item on item.barcode = head.mat_barcode
                left join fgi_cylinder as cy on cy.itemid = item.itemid
                left join item as cycinfo on cycinfo.itemid = cy.code
                where head.trno = " . $keyid;
            break;

            case 'AJ':
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'UNIVERSE':
                        $qry = "select item.itemid,stock.itemname,stock.original_qty as rrqty,
                        stock.uom,uom.factor,stock.barcode,stock.rem,0 as ext,
                        0 as rrcost,0 as cost,stock.expiry,'' as disc,
                        stock.loc,stock.wh,wh.clientid as whid from lahead as head
                        left join lastock as stock on stock.trno = head.trno
                        left join item on item.barcode = stock.barcode
                        left join uom on uom.uom = stock.uom and uom.itemid = item.itemid
                        left join client as wh on wh.client = stock.wh
                        where stock.original_qty <> 0 and stock.isqty = 0 and item.itemid is not null";
                    break;
                }//end switch
            break;
        }//end switch

        return $generatelist = Yii::$app->sbccommon->openTable($qry);
    }//end function

    public function automateDetailCredential($doc,$keyid,$addedparams=[]){ //THIS FUNCTION RETRIEVES DATA FOR DETAIL CREDENTIALS
        //PUT CODE
    }//end function

    public function automateHeadGeneration($doc_to_automate,$prefix,$params){ //FUNCTION THAT AUTOMATES HEAD GENERATTION
    try {
        $dataobj = new Lahead;
        $head = new Lahead;
        $common = new Common;
        $webproc = new Webproc;
        
        $seq = $common->getlastseq($prefix,$doc_to_automate,Yii::$app->session['loggeduser']['center']);   
        $poseq = $prefix . $seq;
        $docnolength = $common->doclength();
        $newdocno = $common->PadJ($poseq, $docnolength);

        $dataobj->docno = $newdocno;
        $dataobj->dateid = $params['dateid'];
        $dataobj->forex = 1.00;
        $dataobj->cur = 'P';
        $dataobj->tax = Yii::$app->backend->getdefaultValues('tax');

        switch($doc_to_automate) {
            case'RR':case'DM':case'CA':case'AP': {
                $contra='AP1';
                break;}
            case'CM':case'AR': {
                $contra='AR1';
                break;}
            case 'SJ':{
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'INFINITEA':
                        $contra='CA1';
                        $salestype='CASH';
                        $dataobj->salestype = $salestype;
                    break;

                    default:
                        $contra='AR1';
                        $salestype='CHARGE';
                        $dataobj->salestype = $salestype;
                    break;
                }//end switch case                            
                break;}                         
            case 'CH':{
                    $contra='CA1';
                    break; }          
            case 'PV': {
                    $contra='AP2';
                    break;}
            case 'IS':case 'AJ': case 'MI': case 'PK':{
                switch ($doc_to_automate) {
                    case 'AJ': case 'MI':
                        switch (Yii::$app->systemsettings->resellerConfig()) {
                            case 'JOYCEBU':
                                $contra='CG1';
                            break;
                            
                            default:
                                $contra='IS1';
                            break;
                        }//end swutch
                    break;

                    default:
                        $contra='IS1';
                    break;
                }//end switch
            break;}
            case 'CV':case 'DS': {
                    $contra='CB1';
                    break;}
            case 'CR': {
                    $contra='CR1';
                    break;}
            default: {
                    $contra='';
                    break;}
        }//END CASE     
        
        if($contra!=''){
            if($doc_to_automate != 'DS'){
                $dataobj->contra = Ladetail::getacno($contra) . '~' . Ladetail::getacnoname('\\'.Ladetail::getacno($contra));
            }else{
                $dataobj->contra = Ladetail::getacno($contra);
            }
        }

        if($doc_to_automate == "DS"){
            $dataobj->clientname = Ladetail::getacnoname('\\'.Ladetail::getacno($contra));
        }

        //THIS CODE BLOCK IS FOR VAT TYPE
        if($doc_to_automate == "SJ" || $doc_to_automate == "RR"){
            if($prefix == 'SJ'){ // FOR SJ VAT TYPE
                switch ($prefix) {
                    case 'SI': case 'CI': case 'CS':
                        $dataobj->vattype = 'VATABLE';
                        $dataobj->tax = 12;
                        break;
                    
                    default:
                        $dataobj->vattype = 'NON-VATABLE';
                        $dataobj->tax = 0;
                        break;
                }//end switch case
            }else{ //FOR RR VAT TYPE
                switch ($prefix) {
                    default:
                        $dataobj->vattype = 'NON-VATABLE';
                        $dataobj->tax = 0;
                        break;
                }//end switch case
            }//end if else
        }//END IF sj
        
        if(!empty($dataobj->contra)){
          $contradata = explode("~" ,$dataobj->contra);
          $dataobj->contra = $contradata[0];
        }else{
          $dataobj->contra = '';
        }//end if

        switch ($doc_to_automate) {
            case 'SJ':
                $dataobj->client = $params['customercode'];
                $dataobj->clientname = $params['customername'];
                $dataobj->address = $params['addr'];
                $dataobj->due = $params['dateid'];
                $dataobj->agentcode = $params['agentcode'];
                $dataobj->whid =  $params['whcode'];
                $dataobj->wh = $params['whname'];
                $dataobj->ourref = $params['sodocno'];
                $dataobj->terms = $params['terms'];
                $dataobj->yourref = '';
                $dataobj->rem = '';
            break;

            case 'AJ':
                $dataobj->client = $params['wh'];
                $dataobj->clientname = $params['whname'];
                $dataobj->address = $params['address'];
                $dataobj->due = $params['dateid'];
                $dataobj->whid =  $params['wh'];
                $dataobj->wh = $params['whname'];
                $dataobj->ourref = $params['ourref'];
                $dataobj->yourref = $params['yourref'];
                $dataobj->rem = $params['rem'];
            break;

            case 'MI':
                $dataobj->client = $params['customercode'];
                $dataobj->clientname = $params['customername'];
                $dataobj->address = $params['address'];
                $dataobj->due = $params['dateid'];
                $dataobj->agentcode = '';
                $dataobj->whid =  $params['wh'];
                $dataobj->wh = $params['whname'];
                $dataobj->yourref = $params['yourref'];
                $dataobj->ourref = $params['ourref'];
                $dataobj->terms = '';
                $dataobj->rem = $params['itemname'];
                $dataobj->waybilldate = '0000-00-00';
                $dataobj->billlading = '';
                $dataobj->voyage = '';
                Yii::$app->systemsettings->setDefaultTimeZone();
                $dataobj->dateid = date('Y-m-d');
            break;

            case 'TS':
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'MLCP':
                        $qryselector = "select client,clientname from client where client = 'WH0000000000002' and iswarehouse = 1";
                        $whdata = Yii::$app->sbccommon->openTable($qryselector);
                        if(empty($whdata)){
                            $dataobj->client = $params['wh'];
                            $dataobj->clientname = $params['whname'];
                        }else{
                            $dataobj->client = $whdata[0]['client'];
                            $dataobj->clientname = $whdata[0]['clientname'];
                        }//end empty
                    break;
                    
                    default:
                        $dataobj->client = $params['wh'];
                        $dataobj->clientname = $params['whname'];
                    break;
                }//END SWITCH
                
                $dataobj->address = $params['address'];
                $dataobj->due = $params['dateid'];
                $dataobj->agentcode = '';
                $dataobj->whid =  $params['wh'];
                $dataobj->wh = $params['whname'];
                $dataobj->yourref = $params['yourref'];
                $dataobj->ourref = $params['ourref'];
                $dataobj->rem = $params['itemname'];
                $dataobj->terms = '';
                $dataobj->waybilldate = '0000-00-00';
                $dataobj->billlading = '';
                $dataobj->voyage = '';
                $dataobj->routeid = 0;
                Yii::$app->systemsettings->setDefaultTimeZone();
                $dataobj->dateid = date('Y-m-d');
            break;
        }//END SWITCH CASE

        $dataobj->isposted = false;
        $dataobj->islocked = false;

        $insertcntnum = $common->insertcntnum($doc_to_automate, $dataobj->docno, $seq, $prefix,Yii::$app->session['loggeduser']['center']);

        if($insertcntnum==0){
        //IF TRANSACTION IS SAME DOCUMENT IT CREATES ANOTHER UNTIL IT COULD BE VALID DOCNO
            while ($insertcntnum == 0) {
                $pref = $common->GetPrefix($dataobj->docno);
                $docnolength = $common->doclength();
                $seq = $common->getlastseq($pref,$doc_to_automate,Yii::$app->session['loggeduser']['center']);
                $poseq = $pref . $seq;
                $newdocno = $common->PadJ($poseq, $docnolength);
                $insertcntnum = $common->insertcntnum($doc_to_automate, $newdocno, $seq, $prefix,Yii::$app->session['loggeduser']['center']);
                
                if (($dataobj->docno != $newdocno) && ($trno == "") && ($insertcntnum !=0) ) {
                    $docno = $newdocno;
                    $data->docno = $newdocno;
                }//end if
            }//end white insertcntnum --
        }//END insertcntnum 0

        $trno_ = Cntnum::getTrnodocno($dataobj->docno,$prefix,Yii::$app->session['loggeduser']['center']);
        $trno = $trno_[0]['trno'];
        $docno = $trno_[0]['docno'];
        $dataobj->trno = $trno;
        
        $i=2;
        a:                      
            if($i>0){
                $insertstatus = Lahead::inserthead($docno,$prefix, $trno, $dataobj);
                //RETURNS NORMALIZED HEAD DATA FROM OPEN HEAD
                //SETS WHERE TO OPEN TABLE
            }//end if $i >0

            //PROCESS HEAD DATA SO IT CAN FILTERED PER DOC
            if ($insertstatus) {
                $i=-1;
                $extractstatus = true;
            }else{
                $i=$i-1;
                if($i>0){
                    goto a;
                }else{
                    $tablenum = Common::gettablenum($prefix);
                    $qrydeletecntnum = "delete from ".$tablenum." where trno = ".$trno."";
                    Yii::$app->sbccommon->execqry($qrydeletecntnum);
                    $extractstatus = false;
                }//end if if($i>0)
            }//end if

        return array('status'=>$extractstatus,'trno'=>$trno);
    } catch (ErrorException $e) {
        echo $e;
    }
    }//end function 

    public function automateStockGeneration($doc_to_automate,$headkey,$line,$params){ //FUNCTION THAT AUTOMATES STOCK GENERATTION
        try {
            $dataobj = new Lastock;
            $stock = new Lastock;
            $common = new Common;
            $webproc = new Webproc;

            $dataobj->trno = $headkey;
            $dataobj->line = $line;
            $dataobj->itemname = $params['itemname'];
            $dataobj->barcode = $params['barcode'];
            $dataobj->uom = $params['uom'];
            $dataobj->wh_ = $params['whcode'];
            $dataobj->disc = $params['disc'];

            switch ($doc_to_automate) {
                case 'MI': case 'TS':
                    $dataobj->isamt = $params['isamt'];
                    $dataobj->rrcost = 0;

                    $dataobj->isqty = $params['isqty'];
                    $dataobj->rrqty = 0;
                    
                    $dataobj->amt = $params['amt'];
                    $dataobj->cost = 0;

                    $dataobj->iss = $params['iss'];
                    $dataobj->qty = 0;    
                break;

                case 'AJ':
                    $dataobj->rrqty = $params['rrqty'];
                    $dataobj->qty = $params['rrqty'];
                    $dataobj->isqty = 0;
                    $dataobj->iss = 0;
                    $dataobj->isamt = 0;
                    $dataobj->amt = 0;
                    $dataobj->rrcost = 0;
                    $dataobj->cost = 0;
                break;
            }//end switch
    
            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'MLCP':
                    switch ($doc_to_automate) {
                        case 'MI': case 'TS':
                            $dataobj->rem = $params['rem'];
                            $dataobj->ref = $params['ref'];
                            $dataobj->loc = $params['loc'];
                            $dataobj->expiry = $params['expiry'];
                        break;
                    }//END SWITCH
                break;

                default:
                    $dataobj->rem = $params['rem'];
                    $dataobj->ref = "";
                    $dataobj->loc = $params['loc'];
                    $dataobj->expiry = $params['expiry'];
                break;
            }//END SWITCH

            $dataobj->ext = $params['ext'];
            $dataobj->void = 0;
            $dataobj->iss2 = 0;
            $dataobj->isqty2 = 0;
            $dataobj->iscomponent = 0;
            $dataobj->outputid = 0;
            $dataobj->refx = 0;
            $dataobj->linex = 0;
            $dataobj->kgs = 0;


            Lastock::insertstock($doc_to_automate, $dataobj->trno, $dataobj,true);
            return true;
        } catch (ErrorException $e) {
            echo $e;
        }//end try catch
    }//end function 

    public function automateDetailGeneration($doc_to_automate,$params){ //FUNCTION THAT AUTOMATES DETAIL GENERATTION
        //PUT CODE
    }//end function 

    // WTODO JAD 06-03-2019
    public function automateTransactionPosting($uniquekey,$doc){ //FUNCTION THAT AUTOMATES POSTING OF THE TRANSACTIONS.
        switch ($doc) {
            case 'PV': case 'AJ':
                $posting = Cntnum::PostTrans($uniquekey, $doc,Yii::$app->session['loggeduser']['center']);
            break;

            default:    
                $posting = Transnum::PostTrans($uniquekey, $doc,Yii::$app->session['loggeduser']['center']);
            break;
        }//END IF
        //NOTE: You could add any functions here after the posting (FAILED or SUCCESS)
    }//end function

    public function automateCheckingNotBalanceItems(){
        $qryitems = "select barcode,itemname,itemid from item";
        $itemids = Yii::$app->sbccommon->openTable($qryitems);

        foreach ($itemids as $key => $value) {
            $qryrr = "select sum(rr.bal / 1) as bal from rrstatus as rr 
                    left join client on client.clientid=rr.clientid 
                    left join client as wh on wh.clientid=rr.whid
                    left join item on item.itemid=rr.itemid
                    left join cntnum on cntnum.trno=rr.trno
                    where rr.itemid=".$value['itemid']." and wh.client='WH0000000000001'
                    order by rr.dateid";
            $rrbal = Yii::$app->sbccommon->datareader($qryrr);

            $qryledger = "select sum(balance) as balance
                          from (select '' as posted, head.trno, head.doc, head.docno, head.dateid, stock.wh, item.itemid,
                          ifnull((stock.qty / 1),0) as qty,
                          ifnull((stock.iss / 1),0) as iss,
                          ifnull((case when stock.iss>0 then (ifnull((stock.qty / 1),0)-ifnull((stock.iss / 1),0)) else 0 end),0) as balance
                          from lahead as head left join lastock as stock on stock.trno=head.trno left join item on item.barcode=stock.barcode
                          where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS') and item.itemid=".$value['itemid']." and stock.wh='WH0000000000001'
                          union all
                          select '' as posted, head.trno, head.doc, head.docno, head.dateid, stock.wh, item.itemid,
                          ifnull((stock.qty / 1),0) as qty,
                          ifnull((stock.iss / 1),0) as iss,
                          ifnull((case when stock.iss>0 then (ifnull((stock.qty / 1),0)-ifnull((stock.iss / 1),0)) else 0 end),0) as balance
                          from lbhead as head left join lbstock as stock on stock.trno=head.trno left join item on item.barcode=stock.barcode
                          where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS') and item.itemid=".$value['itemid']." and stock.wh='WH0000000000001'
                          union all
                          select '' as posted, head.trno, head.doc, head.docno, head.dateid, stock.wh, item.itemid,
                          ifnull((stock.qty / 1),0) as qty,
                          ifnull((stock.iss / 1),0) as iss,
                          ifnull((case when stock.iss>0 then (ifnull((stock.qty / 1),0)-ifnull((stock.iss / 1),0)) else 0 end),0) as balance
                          from lchead as head left join lcstock as stock on stock.trno=head.trno left join item on item.barcode=stock.barcode
                          where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS') and item.itemid=".$value['itemid']." and stock.wh='WH0000000000001'
                          union all
                          select 'POSTED' as posted, head.trno, head.doc, head.docno, head.dateid, wh.client as wh, stock.itemid,
                          ifnull((stock.qty / 1),0) as qty,
                          ifnull((stock.iss / 1),0) as iss,
                          (ifnull((stock.qty / 1),0)-ifnull((stock.iss / 1),0)) as balance
                          from glhead as head left join glstock as stock on stock.trno=head.trno
                          left join client as wh on wh.clientid=stock.whid
                          where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS') and stock.itemid=".$value['itemid']." and wh.client='WH0000000000001'
                          union all
                          select 'POSTED' as posted, head.trno, head.doc, head.docno, head.dateid, wh.client as wh, stock.itemid,
                          ifnull((stock.qty / 1),0) as qty,
                          ifnull((stock.iss / 1),0) as iss,
                          (ifnull((stock.qty / 1),0)-ifnull((stock.iss / 1),0)) as balance
                          from hglhead as head left join hglstock as stock on stock.trno=head.trno
                          left join client as wh on wh.clientid=stock.whid
                          where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS') and stock.itemid=".$value['itemid']." and wh.client='WH0000000000001'
                        ) as sk
                        group by itemid, wh";
                        
            $ledgerbal = Yii::$app->sbccommon->datareader($qryledger);
            if(floatval($ledgerbal) != floatval($rrbal)){
                echo $value['barcode'] . ' - ' . $value['itemname'] . ' - ' . $value['itemid'] . '</br>';
            }//end if
        }//end for each
    }//end function

    public function loadTables() {
        $qry = Yii::$app->backend->getTables();
        $params = [
            'sql' => $qry,
            'tableid' => 'tablesgrid',
            'key' => 'clientid',
            'txtclass' => 'tablestextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'isinactive',
                    'editable' => true,
                    'type' => 'checkbox',
                    'class' => 'col-min chkisinactivetable'
                ],[
                    'name' => 'client',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'floor',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'clientid',
                    'hidden' => true,
                    'default' => '0'
                ],[
                    'name' => 'isinactive',
                    'hidden' => true,
                    'default' => '0'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-save"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'savetable btn btn-social-icon btn-bitbucket'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//END FUNCT

    
    public function automateBranchwh($controller,$params) {
        $qry = Yii::$app->backend->searchBranchwh($controller, $controller->access['view'], $params['x']);
        $params = [
            'sql' => $qry,
            'tableid' => 'branchwhgrid',
            'key' => 'line',
            'txtclass' => 'branchtextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspSave&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'wh',
                    'label' => 'Warehouse',
                    'editable' => true,
                    'type' => 'text',
                    'readonly' => true,
                    'width' => '100%',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'isdefault',
                    'label' => 'Default',
                    'editable' => true,
                    'type' => 'checkbox',
                    'class' => 'col-quantity chkisdefaultwh'
                ],[
                    'name' => 'isinactive',
                    'label' => 'Inactive',
                    'editable' => true,
                    'type' => 'checkbox',
                    'class' => 'col-quantity chkisinactivewh'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'default' => '0'
                ],[
                    'name' => 'isdefault',
                    'hidden' => true,
                    'default' => '0'
                ],[
                    'name' => 'isinactive',
                    'hidden' => true,
                    'default' => '0'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-save"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'savebranchgrid btn btn-social-icon btn-bitbucket'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function automateBranchstation($controller,$params) {
        $qry = "select line, clientid, station, ipaddress, localport, localdb, username, 
                password, compname, compaddress, tin, comptel,
                operatedby, footer1, footer2, footer3, footer4, footer5, serialno, min, 
                permitno, accredno, dateissued, validuntil, isinactive, sync
                from branchstation where clientid =" . $params['x'];
        $params = [
            'sql' => $qry,
            'tableid' => 'branchstationgrid',
            'key' => 'line',
            'txtclass' => 'branchstationtextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'station',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'ipaddress',
                    'label' => 'IP Address',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'localport',
                    'label' => 'Port',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-min'
                ],[
                    'name' => 'localdb',
                    'label' => 'Database',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'username',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes' 
                ],[
                    'name' => 'password',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'compname',
                    'label' => 'Company Name',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-description'
                ],[
                    'name' => 'compaddress',
                    'label' => 'Company Address',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-description'
                ],[
                    'name' => 'tin',
                    'label' => 'TIN',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-min'
                ],[
                    'name' => 'comptel',
                    'label' => 'Company Tel#',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'operatedby',
                    'label' => 'Operated By',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'footer1',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'footer2',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'footer3',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'footer4',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'footer5',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'serialno',
                    'label' => 'Serial No.',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'min',
                    'label' => 'MIN',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-min'
                ],[
                    'name' => 'permitno',
                    'label' => 'Permit No.',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'accredno',
                    'label' => 'Accreditation No.',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'dateissued',
                    'label' => 'Date Issued',
                    'editable' => true,
                    'type' => 'datepicker',
                    'class' => 'col-codes'
                ],[
                    'name' => 'isinactive',
                    'editable' => true,
                    'type' => 'checkbox',
                    'class' => 'col-min chkbranchstationisinactive'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'default' => '0'
                ],[
                    'name' => 'isinactive',
                    'hidden' => true,
                    'default' => '0'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-save"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'savebranchgrid btn btn-social-icon btn-bitbucket'
                ],[
                    'name' => '',
                    'caption' => 'SYNC',
                    'style' => 'width:40px;height:18px;margin-top:-2px;margin-left:2px;padding-left:5px;padding-right:5px;',
                    'class' => 'syncbranchstation btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name'=>'line','value'=>'line']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function automateBranchbrand($controller,$params) {
        $qry = "select b.line, b.clientid, b.brand as brandid, b.isinactive,
                brands.brand_desc as brand from branchbrand as b 
                left join frontend_ebrands as brands on b.brand = brands.brandid where b.clientid =". $params['x'];
        $params = [
            'sql' => $qry,
            'tableid' => 'branchbrandgrid',
            'key' => 'line',
            'txtclass' => 'branchbrandtextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'isinactive',
                    'editable' => true,
                    'type' => 'checkbox',
                    'class' => 'col-min chkbranchbrandisinactive'
                ],[
                    'name' => 'brand',
                    'editable' => true,
                    'type' => 'text',
                    'width' => '100%',
                    'class' => 'col-description'
                ],[
                    'name' => 'brandid',
                    'hidden' => true,
                    'default' => '0'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'default' => '0'
                ],[
                    'name' => 'isinactive',
                    'hidden' => true,
                    'default' => '0'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-save"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'savebranchgrid btn btn-social-icon btn-bitbucket'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function automateBranchagent($controller,$params) {
        $qry = "select line, clientid, client, clientname, inactive from branchagent where clientid =" . $params['x'];
        $params = [
            'sql' => $qry,
            'tableid' => 'branchagentgrid',
            'key' => 'line',
            'txtclass' => 'branchtextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'inactive',
                    'editable' => true,
                    'type' => 'checkbox',
                    'class' => 'col-min chkbranchagentinactive'
                ],[
                    'name' => 'client',
                    'label' => 'Agent',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'clientname',
                    'label' => 'Name',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'class' => 'col-description'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'default' => '0'
                ],[
                    'name' => 'inactive',
                    'hidden' => true,
                    'default' => '0'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-save"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'savebranchgrid btn btn-social-icon btn-bitbucket'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f


    public function automateBranchusers($controller,$params) {
        $qry = "select line, clientid, username, isinactive, type, dlock from branchusers where clientid =". $params['x'];
        $params = [
            'sql' => $qry,
            'tableid' => 'branchusersgrid',
            'key' => 'line',
            'txtclass' => 'branchtextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'isinactive',
                    'editable' => true,
                    'type' => 'checkbox',
                    'class' => 'col-min chkbranchuserisinactive'
                ],[
                    'name' => 'username',
                    'label' => 'User',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'type',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'default' => '0'
                ],[
                    'name' => 'isinactive',
                    'hidden' => true,
                    'default' => '0'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-save"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'savebranchgrid btn btn-social-icon btn-bitbucket'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function automateBranchbank($controller,$params) {
        $qry = "select line, clientid, username, isinactive, type, dlock from branchusers where clientid = " . $params['x'];
        $params = [
            'sql' => $qry,
            'tableid' => 'branchbankgrid',
            'key' => 'line',
            'txtclass' => 'branchbanktextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'isinactive',
                    'editable' => true,
                    'type' => 'checkbox',
                    'class' => 'col-min chkbranchbankisinactive'
                ],[
                    'name' => 'acno',
                    'label' => 'Account #',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'terminalid',
                    'label' => 'Terminal ID',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'bank',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'charges',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'default' => '0'
                ],[
                    'name' => 'isinactive',
                    'hidden' => true,
                    'default' => '0'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-save"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'savebranchgrid btn btn-social-icon btn-bitbucket'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f  

    public function automatesonote($params) {
        $qry = Yii::$app->backend->searchSonote($params['controller'],$params['controller']->access['view'],$params['x']);
        $params = [
            'sql' => $qry,
            'tableid' => 'sonotestbl',
            'key' => 'line', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'station', 'class' => 'aimslabel col-codes'],
                ['name' => 'serialno', 'label' => 'Serial #', 'class' => 'aimslabel col-codes'],
                ['name' => 'rem', 'label' => 'Remarks', 'class' => 'aimslabel col-description'],
                ['name' => 'others', 'class' => 'aimslabel col-description'],
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;',
                    'class' => 'sonotedeletebtn sonotebtn btn btn-social-icon btn-google',
                    'attributes' => [['name' => 'id', 'value' => 'line']]
                ]
            ]
        ]; 
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function automatecommdata($params) {
        $qry = Yii::$app->backend->searchcommdata($params['controller'],$params['controller']->access['view'],$params['x']);
        $params = [
            'sql' => $qry,
            'tableid' => 'commdatatbl',
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'cutoffdate', 'label' => 'Cutoff Date', 'class' => 'aimslabel col-codes'],
                ['name' => 'agentname', 'label' => 'Agent', 'class' => 'aimslabel col-codes'],
                ['name' => 'baseamt', 'label' => 'Base Amt', 'class' => 'aimslabel col-codes'],
                ['name' => 'standardpercent', 'label' => 'Standard Comm', 'class' => 'aimslabel col-codes'],
                ['name' => 'standardamt', 'label' => 'Standard Amt', 'class' => 'aimslabel col-codes'],
                ['name' => 'standardsharepercent', 'label' => 'Share Comm', 'class' => 'aimslabel col-codes'],
                ['name' => 'standardshareamt', 'label' => 'Share Amt', 'class' => 'aimslabel col-codes']
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;',
                    'class' => 'commdeletebtn btn btn-social-icon btn-google',
                    'attributes' => [['name' => 'id', 'value' => 'line']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }
    public function automateClientActnoteslookup($params) {
        $qry = Yii::$app->backend->searchClientactnotes($params['controller'],$params['controller']->access['view'],$params['x']);
        $params = [
            'sql' => $qry,
            'tableid' => 'clientactnoteslookup',
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'dateid',
                    'label' => 'Date',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'actnote',
                    'label' => 'Notes',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'user',
                    'class' => 'aimslabel col-min'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//END F

    // WTODO JAD 06-03-2019
    public function automateUsers() {
        $qry = Yii::$app->backend->getUsers2();
        $params = [
            'sql' => $qry,
            'tableid' => 'usersgrid',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'key' => 'userid',
            'column' => [
                ['name' => 'username', 'class' => 'col-codes aimslabel']
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;',
                    'class' => 'pickuser2 btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name' => 'id', 'value' => 'userid'],['name' => 'username', 'value' => 'username']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    // WTODO JAD 06-03-2019
    public function automateUserload($params) {
        $qry = Yii::$app->backend->loadUser($params['controller'],$params['controller']->access['view']);
        $params = [
            'sql' => $qry,
            'tableid' => 'tbl_user',
            'key' => 'userid',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'username', 'label' => 'UserName', 'class' => 'aimslabel col-codes'],
                ['name' => 'name', 'label' => 'Name', 'class' => 'aimslabel col-codes']
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickupvruser btn btn-social-icon btn-bitbucket',
                    'attributes'=>[
                        ['name'=>'id','value'=>'userid'],['name'=>'username','value'=>'username']
                    ]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn





    public function automateUsers2($controller) {
        $qry = Yii::$app->backend->getUsers2();
        $params = [
            'sql' => $qry,
            'tableid' => 'branchusersusergrid',
            'key' => 'userid',
            'txtclass' => 'userstxt',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'username',
                    'class' => 'col-min'
                ],[
                    'name' => 'type',
                    'class' => 'col-min'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-save"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'selectuser2 btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name'=>'username','value'=>'username'],['name'=>'usertype','value'=>'type']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f


    // WTODO JAD 06-03-2019
    public function createDocumentHead($doc,$params){
        Yii::$app->systemsettings->setDefaultTimeZone();
        switch ($doc) {
            case 'VR':
                $dataobj = new Lahead;
                $datetoday = date('Y-m-d');
                $qry = "select '".$datetoday."' as dateid,sched.userid,supp.client as usersupp,supp.clientname as usersuppname,
                    sched.clientid as cid,customer.client as ccode from member_schedule as sched
                    left join client as customer on customer.clientid = sched.clientid
                    left join useraccess as users on users.userid = sched.userid
                    left join client as supp on supp.client = users.supplier where sched.amt <> 0 and sched.userid = '".$params['userid']."' limit 1";
                    $bref = 'APV';
                    $prefix = 'PV';
            break;
        }//END SWTICH

        $headdata = Yii::$app->sbccommon->openTable($qry);
        
        if(!empty($headdata)){
            $head = new Lahead;
            $common = new Common;
            $webproc = new Webproc; 

            $seq = $common->getlastseq($bref,$prefix,Yii::$app->session['loggeduser']['center']);
            $poseq = $bref . $seq;
            $docnolength = $common->doclength();
            $newdocno = $common->PadJ($poseq, $docnolength);
            $dataobj->dateid = $headdata[0]['dateid'];
            $dataobj->docno = $newdocno;
            //THIS SWITCH CASE WILL BE USED TO UTILIZE THIS FUNCTION PER HEAD REQUIRED DATA
            switch ($doc) {
                case 'VR':
                    $dataobj->client = $headdata[0]['usersupp'];
                    $dataobj->clientname = $headdata[0]['usersuppname'];
                    $dataobj->forex = 1;
                    $dataobj->due = $dataobj->dateid;
                    $dataobj->rem = 'Automatically generated by Reimbursement Release Module.';
                break;
            }//end switch

            $dataobj->isposted = false;
            $dataobj->islocked = false;
            $insertcntnum = $common->insertcntnum($prefix,$dataobj->docno, $seq, $bref,Yii::$app->session['loggeduser']['center']);

            if($insertcntnum==0){
            //IF TRANSACTION IS SAME DOCUMENT IT CREATES ANOTHER UNTIL IT COULD BE VALID DOCNO
                while ($insertcntnum == 0) {
                    $pref = $common->GetPrefix($dataobj->docno);
                    $docnolength = $common->doclength();
                    $seq = $common->getlastseq($pref,$prefix,Yii::$app->session['loggeduser']['center']);
                    $poseq = $pref . $seq;
                    $newdocno = $common->PadJ($poseq, $docnolength);
                    $insertcntnum = $common->insertcntnum($prefix, $newdocno, $seq, $bref,Yii::$app->session['loggeduser']['center']);
                    if (($dataobj->docno != $newdocno) && ($trno == "") && ($insertcntnum !=0) ) {
                        $docno = $newdocno;
                        $data->docno = $newdocno;
                    }//end if
                }//end white insertcntnum --
            }//END insertcntnum 0

            $trno_ = Cntnum::getTrnodocno($dataobj->docno,$prefix,Yii::$app->session['loggeduser']['center']);
            $trno = $trno_[0]['trno'];
            $docno = $trno_[0]['docno'];
            $dataobj->trno = $trno;
            
            $i=2;
            a:                      
                if($i>0){
                    $insertstatus = Lahead::inserthead($docno,$prefix, $trno, $dataobj);
                    //RETURNS NORMALIZED HEAD DATA FROM OPEN HEAD
                    //SETS WHERE TO OPEN TABLE
                }//end if $i >0

                //PROCESS HEAD DATA SO IT CAN FILTERED PER DOC
                if ($insertstatus) {
                    $i=-1;
                    $status = true;
                }else{
                    $i=$i-1;
                    if($i>0){
                        goto a;
                    }else{
                        $tablenum = Common::gettablenum($prefix);
                        $qrydeletecntnum = "delete from ".$tablenum." where trno = ".$trno."";
                        Yii::$app->sbccommon->execqry($qrydeletecntnum);
                        $status = false;
                    }//end if if($i>0)
                }//end if

            return array('status'=>$status,'trno'=>$trno,'docno'=>$docno);
        }//end if
    }//end function



        // WTODO JAD 06-03-2019
    public function createDocumentDetail($doc,$params){
         switch ($doc) {
            case 'VR':
                $dataobj = new Ladetail;
                $datetoday = date('Y-m-d');
                $qry = "select 
                        (select acno from coa where alias = 'EX1') as acno,
                        (select acnoname from coa where alias = 'EX1') as acnoname,
                        sched.date1,supp.client as usersupp,customer.client as ccode,sched.amt,
                        CONCAT(sched.sched_desc,' [',sched.jonumber,']') as sched_desc from member_schedule as sched
                        left join client as customer on customer.clientid = sched.clientid
                        left join useraccess as users on users.userid = sched.userid
                        left join client as supp on supp.client = users.supplier 
                        where sched.amt <> 0 and sched_id in (".$params['filter'].")";
                $coavoucherentryqry = 'select acno,acnoname from coa where alias = "AP9"';
                $coavoucherentry = Yii::$app->sbccommon->openTable($coavoucherentryqry);
            break;
        }//END SWTICH
        $detaildata = Yii::$app->sbccommon->openTable($qry);
        if(!empty($detaildata)){
            switch ($doc) {
                case 'VR':
                    $totalamt = 0;
                    foreach ($detaildata as $key => $value) {
                    //THIS PART WILL INSERT ONLY THE SCHEDULES THAT WILL REQUIRE REIMBURSEMENTS
                        $dataobj->postdate = $detaildata[$key]['date1'];
                        $dataobj->templine = 0;
                        $dataobj->trno = $params['trno'];
                        $dataobj->checkno = '';
                        $dataobj->acno = $detaildata[$key]['acno'];
                        $dataobj->acnoname = $detaildata[$key]['acnoname'];
                        $dataobj->client = $detaildata[$key]['usersupp'];
                        $dataobj->client2 = $detaildata[$key]['ccode'];
                        //$dataobj->client2 = $detaildata[0]['ccode'];
                        $dataobj->db = str_replace(',','',$detaildata[$key]['amt']);
                        $dataobj->cr = str_replace(',','',0);
                        $dataobj->rem = $detaildata[$key]['sched_desc'];
                        $dataobj->ref = '';
                        $dataobj->refx = 0;
                        $dataobj->linex = 0;   
                        $dataobj->isewt = 0; 
                        $dataobj->isvat = 0; 
                        Ladetail::insertdetail($params['trno'],$dataobj,'ladetail', 'PV');
                        $totalamt = floatval($totalamt) + floatval($detaildata[$key]['amt']);
                    }//end for each
                break;
            }//END SWITCH
        }//end if

        return true;
    }//end function

    // WTODO JAD 06-03-2019
    public function automateEventprojectlookup($params) {
        $qry= Yii::$app->backend->searchEventproject($params['controller'],$params['controller']->access['view'],$params['x']);
        $params = [
            'sql' => $qry,
            'tableid' => 'tbl-customerlookup',
            'key' => 'projectid', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            
            'column' => [[
                    'name' => 'project_title',
                    'label' => 'Project Title',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'project_description',
                    'label' => 'Project Description',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'status',
                    'label' => 'Status',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'createdate',
                    'label' => 'Create Date',
                    'class' => 'aimslabel col-codes'
                ]],
            
            'buttons' => [
                [
                'name' => '',
                'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                'class' => 'btneventprojectlookup btn btn-social-icon btn-bitbucket',
                'attributes'=>[['name'=>'id','value'=>'projectid'],['name'=>'project_description','value'=>'project_description'],['name'=>'status','value'=>'status'],['name' => 'project_title', 'value'=> 'project_title']],
                ]
            ]
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//END F


    public function automateClientgrouplookup($params) {
        $qry = Yii::$app->backend->searchClientgroup($params['controller'],$params['controller']->access['view'],$params['x']);
        $params = [
            'sql' => $qry,
            'tableid' => 'clientgroup-lookup',
            'key' => 'groupid',
            'txtclass' => 'bodytextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'groupid','class' => 'aimslabel col-description']
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickclientgroup btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name' => 'groupid','value'=>'groupid']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    //WTODO: [JLY][2019.08.17][KINGG CONCERNS][ADD GROUP FILTER END]
    public function automateBrandlookup($params) {
        if($params['controller']->module->id == 'changeitem') {
            $qry = Yii::$app->backend->searchBrand($params['controller'],'','');
        } else {
            $qry = Yii::$app->backend->searchBrand($params['controller'],$params['controller']->access['view'],$params['x']);
        }
        
        $params = [
            'sql' => $qry,
            'tableid' => 'brand-lookup',
            'key' => 'brandid',
            'txtclass' => 'bodytextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'brand','class' => 'aimslabel col-description']
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickbrand btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name' => 'brand','value'=>'brand'],['name' => 'brandid','value' => 'brandid']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    //WTODO: [KIM][2019.10.28][automateLoclookup]
    public function automateLoclookup($params) {
        $qry = "select distinct loc from rrstatus where loc like '%".$params['x']."%'";
        
        $params = [
            'sql' => $qry,
                'tableid' => 'loclookupdiv',
                'key' => 'loc',
                'txtclass' => 'bodytextbox',
                'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [
                                [
                                    'name' => 'loc',
                                    'class' => 'aimslabel stocktxt col-codes',
                                    'label'=> 'Location'
                                ],
                        ],
                        'buttons' => [
                            [
                                'name' => '',
                                'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                                'class' => 'pickloc btn btn-social-icon btn-bitbucket',
                                'attributes' => [['name' => 'loc','value' => 'loc']]
                            ]
                        ]
                    ];
       
       
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn
}//END COMPONENTS
?>
