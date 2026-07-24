<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    
'modules' => [
            'SV' => [
                'class' => 'backend\modules\SV\SV',
            ],
            'logtracer' => [
                'class' => 'app\modules\logtracer\logtracer',
            ],
            'transupdate' => [
                'class' => 'app\modules\rttransupdate\rttransupdate',
            ],
            //WTODO: [KIM][2019.10.30][add module for mlocation]
            'mlocation' => [
                'class' => 'backend\modules\mlocation\mlocation',
            ],
            'prodtype' => [
                'class' => 'backend\modules\prodtype\prodtype',
            ],
            'transform' => [
                'class' => 'backend\modules\transform\transform',
            ],
            'sealing' => [
                'class' => 'backend\modules\sealing\sealing',
            ],
            'plastic' => [
                'class' => 'backend\modules\plastic\plastic',
            ],
            'prodspec' => [
                'class' => 'backend\modules\prodspec\prodspec',
            ],
            'inout' => [
                'class' => 'backend\modules\inout\inout',
            ],
            'reject' => [
                'class' => 'backend\modules\reject\reject',
            ],

        
            //added module for MLCP (JOB Order)
            'JB' => [
                'class' => 'backend\modules\JB\JB',
            ],
            //added module for MLCP (JOB ORDER UPDATE / PRODUCTION UPDATER)
            'JBU' => [
                'class' => 'backend\modules\JBU\JBU',
            ],

            'tphandling' => [
                'class' => 'backend\modules\tphandling\tphandling',
            ],
            //SBC EXCLUSIVE MODULES
            'VR' => [
            'class' => 'backend\modules\VR\VR',
            ],
            'VC' => [
            'class' => 'backend\modules\VC\VC',
            ],
            //SBC EXCLUSIVE MODULES end

            'quotation' => [
                'class' => 'backend\modules\quotation\quotation',
            ],
            'FG' => [
                'class' => 'backend\modules\FG\FG',
            ],
            'fg_colors' => [
                'class' => 'backend\modules\fg_colors\fg_colors',
            ],
            'fg_material' => [
                'class' => 'backend\modules\fg_material\fg_material',
            ],
            'fg_cylinder' => [
                'class' => 'backend\modules\fg_cylinder\fg_cylinder',
            ],
            'fg_process' => [
                'class' => 'backend\modules\fg_process\fg_process',
            ],
            'SP' => [ //Supplier Price Change
                'class' => 'backend\modules\SP\SP',            
             ],
            'principal' => [
                'class' => 'backend\modules\principal\principal',
            ],
            'POSRetail' => [
                'class' => 'backend\modules\POSRetail\POSRetail',
            ],
            
            'ewtsetup' => [
                'class' => 'backend\modules\ewtsetup\ewtsetup',
            ],
            'pscheme' => [
                'class' => 'backend\modules\pscheme\pscheme',
            ],
            'tpshipping' => [
                'class' => 'backend\modules\tpshipping\tpshipping',
            ],
            'services' => [
                'class' => 'backend\modules\services\services',
            ],
            'QA' => [
            'class' => 'backend\modules\QA\QA',
            ],
            'MX' => [
            'class' => 'backend\modules\MX\MX',
            ],
            'posstockcard' => [
                'class' => 'backend\modules\posstockcard\posstockcard',
            ],
            
            ///f0r web c0nnected 0n wind0ws and p0s systems
            'branch' => [
                'class' => 'backend\modules\branch\branch',
            ],
            'tbmasterfile' => [
                'class' => 'backend\modules\tbmasterfile\tbmasterfile',
            ],
            'manageitem' => [
                'class' => 'backend\modules\manageitem\manageitem',
            ],

            
            //COL TYPE MASTER FILE
            'colltype' => [
                'class' => 'backend\modules\colltype\colltype',
            ],

            //QUICK COLLECTION MODULE
            'quickcollect' => [
                'class' => 'backend\modules\quickcollect\quickcollect',
            ],

            //FOR CHATSUPPORT MODULE
            'chatsupport' => [
                'class' => 'backend\modules\chatsupport\chatsupport',
            ],
            //FOR LOGIN AND INDEX FRONT PAGE OF AIMS AND BACKEND
            
            //Sales Order Approval
            'proj' => [
                'class' => 'backend\modules\proj\proj',
            ],
            'fsitedetails' => [
                'class' => 'backend\modules\fsitedetails\fsitedetails',
            ],
            'SOApproval' => [
            'class' => 'backend\modules\SOApproval\SOApproval',
            ],
            // ASSET MASTER
            'assetmaster' => [
                'class' => 'backend\modules\assetmaster\assetmaster',
            ],
            'extractor' => [
            'class' => 'backend\modules\extractor\extractor',
             ],
            'admin' => [
            'class' => 'backend\modules\admin\admin',
             ],
//FOR E-COMMERCE (FRONTEND)
             'frontend' => [
            'class' => 'backend\modules\frontend\frontend',
             ],
//FOR E-COMMERCE MANAGER (BACKEND)
             'frontendmanager' => [
            'class' => 'backend\modules\frontendmanager\frontendmanager',
            ],
//FOR FRONTEND SETTINGS (BACKEND)
             'dashboard' => [
            'class' => 'backend\modules\dashboard\dashboard',
             ],
//FOR AIMS MODULE SO (BACKEND)
             'SO' => [ //SALES ORDER
            'class' => 'backend\modules\SO\SO',
             ],
             'PO' => [ //PURCHASE ORDER
            'class' => 'backend\modules\PO\PO',
             ],
             'RR' => [ //RECEIVING REPORT
            'class' => 'backend\modules\RR\RR',
             ],
            
             'SJ' => [ //SALES JOURNAL
            'class' => 'backend\modules\SJ\SJ',
             ],

             'CM' => [ //SALES RETURN
            'class' => 'backend\modules\CM\CM',
             ],
             'DM' => [ //PURCHASE RETURN
            'class' => 'backend\modules\DM\DM',            
             ],
             'AJ' => [ //INVENTORY ADJUSTMENT
            'class' => 'backend\modules\AJ\AJ',            
             ],
             'PC' => [ //PHYSICAL COUNT
            'class' => 'backend\modules\PC\PC',            
             ],
             'PR' => [ //PURCHASE REQUISITION
            'class' => 'backend\modules\PR\PR',            
             ],
             'TS' => [ //TRANSFER SLIP
            'class' => 'backend\modules\TS\TS',
             ],             
             'IS' => [ //INVENTORY SETUP
            'class' => 'backend\modules\IS\IS',
             ],
             'GJ' => [ //GENERAL JOURNAL
            'class' => 'backend\modules\GJ\GJ',
             ],
            'GD' => [ //DEBIT MEMO
                'class' => 'backend\modules\GD\GD',
             ],
            'GC' => [ //CREDIT MEMO
                'class' => 'backend\modules\GC\GC',
             ],
             'CV' => [ //CASH / CHECK VOUCHER
            'class' => 'backend\modules\CV\CV',
             ],
             'CR' => [ //RECIEVED PAYMENT
            'class' => 'backend\modules\CR\CR',
             ],
             'PV' => [ //ACCOUNTS PAYABLE VOUCHER
            'class' => 'backend\modules\PV\PV',
             ],
            'KR' => [ //COUNTER RECEIPT
            'class' => 'backend\modules\KR\KR',
             ],
             'AR' => [ //ACCOUNTS RECEIVABLE
            'class' => 'backend\modules\AR\AR',
             ],
             'AP' => [ //ACCOUNTS PAYABLE
            'class' => 'backend\modules\AP\AP',
            ],
             'DS' => [ //DEPOSIT SLIP
            'class' => 'backend\modules\DS\DS',
            ],
            'PI' => [ //PRODUCTION INSTRUCTION
            'class' => 'backend\modules\PI\PI',
            ],
            'PD' => [ //PRODUCTION ORDER
            'class' => 'backend\modules\PD\PD',
            ],
            'PK' => [ //PRODUCTION COMPLETION
            'class' => 'backend\modules\PK\PK',
            ],
            'CK' => [ //POST DATED CHECKS
            'class' => 'backend\modules\CK\CK',
            ],
            'TA' => [ //TRANSFER ASSET (FIXED ASSET)
            'class' => 'backend\modules\TA\TA',
            ],
            'KL' => [ //COLLECTION LIST (XANDA)
            'class' => 'backend\modules\KL\KL',
            ],
            'RF' => [//ROUTE FORMATION (XANDA)
            'class' => 'backend\modules\RF\RF',
            ],

            'TX' => [//ROUTE FORMATION (XANDA)
            'class' => 'backend\modules\TX\TX',
            ],
             
//FOR AIMS MODULE STOCKARD (BACKEND)
            'generalitem' => [ //GENERAL ITEM
            'class' => 'backend\modules\generalitem\generalitem',
            ],
            'itemprofile' => [ //GENERAL ITEM
            'class' => 'backend\modules\itemprofile\itemprofile',
            ],            
            'location' => [ //LOCATION LEDGER
            'class' => 'backend\modules\location\location',
            ],
            'vendor' => [ //VENDOR LEDGER
            'class' => 'backend\modules\vendor\vendor',
            ],
            'stockcard' => [ //STOCKCARD LEDGER
            'class' => 'backend\modules\stockcard\stockcard',
            ],
            'customer' => [ //CUSTOMER LEDGER
            'class' => 'backend\modules\customer\customer',
            ],
            'supplier' => [ //SUPPLIER LEDGER
            'class' => 'backend\modules\supplier\supplier',
            ],
            'warehouse' => [ //WAREHOUSE LEDGER
            'class' => 'backend\modules\warehouse\warehouse',
            ],
            'agent' => [ //AGENT LEDGER
            'class' => 'backend\modules\agent\agent',
            ],
            'employee' => [ //EMPLOYEE LEDGER
            'class' => 'backend\modules\employee\employee',
            ],
            'coa' => [ //CHART OF ACCOUNTS
            'class' => 'backend\modules\coa\coa',
            ],
            'useraccess' => [
            'class' => 'backend\modules\useraccess\useraccess',
            ],
            'branchaccess' => [
            'class' => 'backend\modules\branchaccess\branchaccess',
            ],
            'audittrail' => [
            'class' => 'backend\modules\audittrail\audittrail',
            ],
            'terms' => [
            'class' => 'backend\modules\terms\terms',
            ],
            'docprefix' => [
            'class' => 'backend\modules\docprefix\docprefix',
            ],
            'branchmasterfile' => [
            'class' => 'backend\modules\branchmasterfile\branchmasterfile',
            ],
            'reportlist' => [
            'class' => 'backend\modules\reportlist\reportlist',
            ],
            'changeitem' => [
            'class' => 'backend\modules\changeitem\changeitem',
            ],
            'notification' => [
            'class' => 'backend\modules\notification\notification',
            ],
            'frontendlogs' => [
            'class' => 'backend\modules\frontendlogs\frontendlogs',
            ],
            'scheduler' => [
            'class' => 'backend\modules\scheduler\scheduler',
            ],
            'themer' => [
            'class' => 'backend\modules\themer\themer',
            ],
            'bankrecon' => [
            'class' => 'backend\modules\bankrecon\bankrecon',
            ],
            'lanemanager' => [
            'class' => 'backend\modules\lanemanager\lanemanager',
            ],
            'fbmanager' => [
            'class' => 'backend\modules\fbmanager\fbmanager',
            ],
            'ordermanager' => [
            'class' => 'backend\modules\ordermanager\ordermanager',
            ],
            'fbrmanager' => [
            'class' => 'backend\modules\brandmanager\brandmanager',
            ],
            'schedmanager' => [
            'class' => 'backend\modules\schedulemanager\schedulemanager',
            ],
            'comprefix' => [
            'class' => 'backend\modules\companyprefix\companyprefix',
            ],
            'fsalemanager' => [
            'class' => 'backend\modules\fsalemanager\fsalemanager',
            ],
            'fhighlights' => [
            'class' => 'backend\modules\fhighlights\fhighlights',
            ],
            'managedod' => [ //FOR DEAL OF THE DAY MANAGER
            'class' => 'backend\modules\managedod\managedod',
            ],
            'managefdeals' => [ //FOR FLASH DEAL MANAGER
            'class' => 'backend\modules\managefdeals\managefdeals',
            ],
            //TAX

            'taxmenu' => [
            'class' => 'backend\modules\taxmenu\taxmenu',
            ],

            'TW' => [
            'class' => 'backend\modules\TW\TW',
            ],            
            //RTT MODIFICATIONS

            'categories' => [
            'class' => 'backend\modules\categories\categories',
            ],
            'collection' => [
            'class' => 'backend\modules\collection\collection',
            ],
            'distribution' => [
            'class' => 'backend\modules\distribution\distribution',
            ],
            'itemclass' => [
            'class' => 'backend\modules\itemclass\itemclass',
            ],

            // SALON MODIFICATION

            'stype' => [
            'class' => 'backend\modules\stype\stype',
            ],

            'TR' => [
                'class' => 'backend\modules\TR\TR',
            ],

            'MI' => [
            'class' => 'backend\modules\MI\MI',
            ],

        // END SALON       

            // SC MODIFICATION

            'maingroup' => [
            'class' => 'backend\modules\maingroup\maingroup',
            ],

            'termgroup' => [
            'class' => 'backend\modules\termgroup\termgroup',
            ],

            'categorygroup' => [
            'class' => 'backend\modules\categorygroup\categorygroup',
            ],

            'subcatgroup' => [
            'class' => 'backend\modules\subcatgroup\subcatgroup',
            ],

            // SC END       


            //END RTT MODIFICATIONS            
            
            //JAD MODULES
            'route' => [
                'class' => 'backend\modules\route\route',
            ],
            'part' => [
                'class' => 'backend\modules\part\part',
            ],
            'model' => [
                'class' => 'backend\modules\model\model',
            ],

            'stockgrp' => [
                'class' => 'backend\modules\stockgrp\stockgrp',
            ],
            'commission' => [
                'class' => 'backend\modules\commission\commission',
            ],
            'scterritory' => [
                'class' => 'backend\modules\scterritory\scterritory',
            ],
            'scprovince' => [
                'class' => 'backend\modules\scprovince\scprovince',
            ],
            'sccity' => [
                'class' => 'backend\modules\sccity\sccity',
            ],

            /* LET THIS MODULE ACTIVE TO HAVE A MODULAR STATUS MASTERFILE (CUSTOMER)
            'status' => [
                'class' => 'backend\modules\status\status',
            ],*/
            
            /*
            
            NOTE: THIS IS A RUNNING MODULE, PLEASE USE REVISE THIS MODULE'S CONTROLLER
                  AND USE THIS MODULE AS BODY_MASTERFILE OR SIZE MASTERFILE FOR STOCKARD 
                    -JAO (03-28-2017)

            'classes' => [
                'class' => 'backend\modules\classes\classes',
            ],*/

            //REPORTS
            'reports' => [
            'class' => 'backend\modules\reports\reports',
            ],

            //PIZZA
            'pizza' => [
            'class' => 'backend\modules\pizza\pizza',
            ],
        ],
    
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            //'urlFormat' =>'path',
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
            '<module:\w+>/<action:\w+>/<id:(.*?)>' => '<module>/default/<action>/<id>',
            '<module:\w+>/<action:\w+>' => '<module>/default/<action>',],


        ],

        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => false,
            'transport' => [
                'scheme' => 'smtps',
                'host' => 'mail.supremecluster.com',
                'username' => 'xtz_no_reply@xtzbusiness.ph',
                'password' => 'anson888',
                'port' => 465,
            ],
        ],

        'user' => [
            'identityClass' => 'app\models\UserAccess',
            'enableAutoLogin' => false,
            
        ],

        'session' => [
            'timeout' => 86400,  
        ],


        'sbccommon' => [
            'class' => 'app\components\commonfunc',
        ],

        'sbccontroller' => [
            'class' => 'app\components\systemfunc',
        ],

        'systemsettings' => [
            'class' => 'app\components\syssettings',
        ],
        
        'extractify' => [
            'class' => 'app\components\extractify',
        ],

        'quickadd' => [
            'class' => 'app\components\quickaddfunctions',
        ],

        'automator' => [
            'class' => 'app\components\automator',
        ],

        'frontend' => [
            'class' => 'app\components\frontendfunctions',
        ],

        'dashboard' => [
            'class' => 'app\components\dashboardfunctions',
        ],

        'backend' => [
            'class' => 'app\components\backendfunctions',
        ],

        'tblgenerator' => [
            'class' => 'app\components\tablegenerator',
        ],

        'webprocess' => [
            'class' => 'app\components\webprocess',
        ],

        'weblisting' => [
            'class' => 'app\components\weblisting',
        ],

        'reporter' => [
            'class' => 'app\components\sbcpdf',
        ],

        'webuser' => [
            'class' => 'app\components\Webuser',
        ],




        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        
        
        'errorHandler' => [
            'errorAction' => 'site/error',
            'maxSourceLines' => 20,
        ],

        'assetManager' => [
            'appendTimestamp' => true,
        ],
    ],
    'params' => $params,
];
