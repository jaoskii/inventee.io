<?php

namespace app\models;

use Yii;
use yii\base\Model;

use app\models\Client;
use yii\base\ErrorException;

class weblist extends Model{
    
     function index($controller,$POST,$GET,$accessview){
       if (Yii::$app->user->access[$accessview] != 1) {
            $title = 'Unauthorized';
            $message = 'Sorry, you are not allowed to view Supplier Ledger';
            $message .= '<br />';
            $message .= CHtml::Button('Ok', array('submit' => array('//site/index')));
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect('index.php?r=site/modules');
        } else {
            //$head = new Client();
            //$head->unsetAttributes();
            $clientid = Yii::$app->session['clientid' . $controller->id];
            //$data = Client::openclient($clientid_, $controller->id);
            //$doc = $controller->id;
            
            $action = "";
            if (isset($GET['action'])) {
                $action = $GET['action'];
            }
            if (isset($POST['Client'])) {
                if ($action == 'accept') {
                    $clientid = $POST['Client']['clientid'];
                    Yii::$app->session['clientid' . $controller->id] = $clientid;
                    $controller->redirect(array('index'));
                } elseif ($action == 'next' || $action == "previous") {
                    
                    $clientid = Common::navnext_prev($clientid, $clientid, $controller->id, $action);
                    Yii::$app->session['clientid' . $controller->id] = $clientid;
                    $controller->redirect(array('index'));
                } elseif ($action == 'first' || $action == "last") {
                    $clientid = Common::navfirst_last($clientid, $clientid, $controller->id, $action);
                    Yii::$app->session['clientid' . $controller->id] = $clientid;
                    $controller->redirect(array('index'));
                } 
            }
            
            $head = $this->loadmodel($controller,$clientid);
            
            $controller->render('mainform', array('head' => $head));
        }
    }

    
    function loadmodel($controller,$clientid){ //##################### STOCKCARD UPDATE
        try {
        $model = new Client;
        $item = new Item;
        $doc = $controller->module->id;
        //EMPLOYEE
        if($doc=='employee'){
            $model= new Employee;    
        }//end if $doc employee

        switch ($doc) {
            case 'customer': case 'supplier': case 'warehouse': case 'agent': case 'location': case 'vendor': case 'assetmaster': case 'branch':
                $data = $model->openclient($clientid, $doc);
                if ($data != null) {
                    $model->client = $data[0]['client'];
                    $model->clientid = $data[0]['clientid'];
                    $model->clientname = $data[0]['clientname'];
                    $model->addr = $data[0]['addr'];
                    $model->terms = $data[0]['terms'];
                    $model->tel = $data[0]['tel'];
                    $model->fax = $data[0]['fax'];
                    $model->aguser = $data[0]['aguser'];
                    $model->rev = $data[0]['rev'];
                    $model->agpass = $data[0]['agpass'];

                    //KEYWORD LOCATION&VENDOR
                    $model->isLocation = $data[0]['islocation'];
                    $model->isVendor = $data[0]['isvendor'];
                    $model->building = $data[0]['building'];
                    $model->floor = $data[0]['floor'];
                    $model->uv_ischecker = $data[0]['uv_ischecker'];
                    $model->uv_ispicker = $data[0]['uv_ispicker'];
                    
                    if($doc == 'customer' || $doc == 'supplier') {
                        $model->categorynameid = $data[0]['categoryid'];
                        $model->category = $data[0]['categoryname'];
                    }//end if

                    switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'UNIVERSE':
                            if($doc=='agent'){
                                $model->agentpassword = $data[0]['password'];
                            }//end if
                        break;
                    }//end switc

                    if ($doc == 'customer'){
                        $model->collectionarea = $data[0]['collectionarea'];
                        $model->collectionareaid = $data[0]['collectionareaid'];
                        $model->distributionarea = $data[0]['distributionarea'];
                        $model->distributionareaid = $data[0]['distributionareaid'];
                        $model->route = $data[0]['route'];
                        $model->routeid = $data[0]['routeid'];
                        $model->sccity = $data[0]['sccity'];
                        $model->sccityid = $data[0]['sccityid'];
                        $model->scprovname = $data[0]['scprovname'];
                        $model->scterrname = $data[0]['scterrname'];
                        $model->grpcode = $data[0]['grpcode'];
                        $model->bstyle = $data[0]['bstyle'];
                    }

                    if($doc == 'assetmaster') {
                        $model->IsInactive = $data[0]['IsInactive'];
                        $model->isasset = $data[0]['isasset'];
                        $model->rem = $data[0]['rem'];
                        $model->category2 = $data[0]['category2'];
                        $model->location = $data[0]['location'];
                        $model->acquireddate = $data[0]['acquireddate'];
                        $model->warrantexpiry = $data[0]['warrantexpiry'];
                        $model->servicedate = $data[0]['servicedate'];
                        $model->solddisposeddate = $data[0]['solddisposeddate'];
                        $model->year = $data[0]['year'];
                        $model->make = $data[0]['make'];
                        $model->model2 = $data[0]['model'];
                        $model->color = $data[0]['color'];
                        $model->motorno = $data[0]['motorno'];
                        $model->serialno = $data[0]['serialno'];
                        $model->renewaldate = $data[0]['renewaldate'];
                        $model->insurer = $data[0]['insurer'];
                        $model->insurancepol = $data[0]['insurancepol'];
                    }


                    if ($doc == 'vendor'){
                        $model->isLocation = 0;
                        $model->isVendor = $data[0]['isvendor'];
                        $model->building = "";
                        $model->floor = "";
                    }
                    //END KEYWORD LOCATION&VENDOR

                    $model->picture = $data[0]['picture'];
                    $model->contact = $data[0]['contact'];
                    $model->rem = $data[0]['rem'];
                    $model->region = $data[0]['region'];
                    $model->tel2 = $data[0]['tel2'];
                    
                    //KEYWORD LOCATION&VENDOR
                    if ($doc == 'location'){
                    $model->addr = "";
                    $model->agentcode = '';
                    $model->agent = '';
                    $model->email = "";
                    $model->IsCustomer = 0;
                    $model->IsAgent = 0;
                    $model->IsSupplier = 0;
                    $model->IsWarehouse = 0;
                    $model->IsEmployee = 0;
                    $model->IsInactive = 0;  
                    $model->isVendor = 0;
                    $model->IsExempt = 0;
                    $model->charge1 = "";
                    $model->charge2 = "";
                    $model->tax = "";
                    $model->crlimit = "";
                    $model->area = "";
                    $model->groupid = "";
                    $model->province = "";
                    $model->pricegroup = "";
                    $model->status = "";
                    $model->start = "";
                    $model->tin = "";
                    $model->type = "";
                    $model->disc = "";
                    $model->quota= "";
                    $model->start= "";    
                    } else { //END ELSE DOC
                    
                    if($doc == 'branch') {
                        $model->isallitems = $data[0]['isallitems'];
                        $model->isallwh = $data[0]['isallwh'];
                        $model->issyncbranch = $data[0]['issyncbranch'];
                        $model->acno = $data[0]['acno'];
                    }//end if
                     
                    $model->addr = $data[0]['addr'];
                    $model->terms = $data[0]['terms'];
                    if($data[0]['agentcode'] == ""){
                        $model->agentcode = '';
                        $model->agent = '';
                    }else{
                        $model->agentcode = $data[0]['agentcode'] . '~' .$data[0]['agent'];
                        $model->agent = $data[0]['agent'];
                    }       
                    //END KEYWORD LOCATION&VENDOR
                    $model->email = $data[0]['email'];
                    $model->IsCustomer = $data[0]['IsCustomer'];
                    $model->IsAgent = $data[0]['IsAgent'];
                    $model->IsSupplier = $data[0]['IsSupplier'];
                    $model->IsWarehouse = $data[0]['IsWarehouse'];
                    $model->IsEmployee = $data[0]['IsEmployee'];
                    $model->IsInactive = $data[0]['IsInactive'];
                    $model->IsExempt = $data[0]['IsExempt'];
                    $model->charge1 = $data[0]['charge1'];
                    $model->charge2 = $data[0]['charge2'];
                    $model->tax = $data[0]['tax'];
                    $model->crlimit =number_format($data[0]['crlimit'],2);
                    $model->area = $data[0]['area'];
                    $model->groupid = $data[0]['groupid'];
                    // $model->category = $data[0]['category'];
                    $model->province = $data[0]['province'];
                    $model->pricegroup = $data[0]['pricegroup'];
                    $model->status = $data[0]['status'];
                    $model->start = substr($data[0]['start'], 0, 10);
                    $model->tin = $data[0]['tin'];
                    $model->type = $data[0]['type'];
                    $model->disc = $data[0]['disc'];
                    $model->quota=$data[0]['quota'];
                    $model->start=$data[0]['start'];
                    } // END IF DOC
                }
                return $model;
            break;
            
            case 'stockcard': case 'posstockcard': case 'FG':
                $data = $item->openitem($clientid);
                if ($data != null) {
                
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'UNIVERSE':
                        $item->uvpriority=$data[0]['uv_priority'];
                        $item->uvdepartment=$data[0]['uv_department'];
                        $item->suppitemcode=$data[0]['uv_suppitemcode'];
                        $item->isvat=$data[0]['isvat'];
                        $item->uvprincipal=$data[0]['uvprincipal'];
                        $item->uvprincipalid=$data[0]['uvprincipalid'];
                        $item->uvpurchaseuom = $data[0]['purchase_uom'];
                    break;

                    case 'GAMELINE_POS':
                        $item->printuom=$data[0]['gm_printuom'];
                    break;

                    case 'TENPLUS':
                        $item->itemhandling2=$data[0]['itemhandling2'];
                    break;
                }//end switch

                $item->fg_isfinishedgood = $data[0]['fg_isfinishedgood'];
                $item->fg_isequipmenttool = $data[0]['fg_isequipmenttool'];
                $item->fg_serial = $data[0]['fg_serial'];

                /*$item->fgunit_width = $data[0]['fgunit_width'];
                $item->fgunit_length = $data[0]['fgunit_length'];*/
                $item->fgunit_diameter = $data[0]['fgunit_diameter'];
                //$item->fgunit_thickness = $data[0]['fgunit_thickness'];

                if($doc == 'FG') {
                    $item->fg_clientname = $data[0]['fg_clientname'];
                    $item->fg_client = $data[0]['fg_client'];
                    $item->fg_prodtype = $data[0]['fg_prodtype'];
                    $item->fg_combi = $data[0]['fg_combi'];
                    $item->fg_transform = $data[0]['fg_transform'];
                    $item->fg_addspecs = $data[0]['fg_addspecs'];
                    $item->fg_punchholesize = $data[0]['fg_punchholesize'];
                    $item->fg_sealing = $data[0]['fg_sealing'];
                    $item->fg_plasticcolor = $data[0]['fg_plasticcolor'];
                    $item->fg_bfilmdet = $data[0]['fg_bfilmdet'];
                    $item->fg_treatment = $data[0]['fg_treatment'];

                    $item->payrate = $data[0]['payrate'];

                    $item->payqty = $data[0]['payqty'];
                    $item->fg_revision = $data[0]['fg_revision'];
                    $item->fg_templateno = $data[0]['fg_templateno'];
                    $item->fg_updated = $data[0]['fg_updated'];
                    $item->fg_effective = $data[0]['fg_effective'];
                    $item->fg_jowidth = $data[0]['fg_jowidth'];
                    $item->fg_jowidthuom = $data[0]['fg_jowidthuom'];
                    $item->fg_jolength = $data[0]['fg_jolength'];
                    $item->fg_jolengthuom = $data[0]['fg_jolengthuom'];
                    $item->fg_thickness = $data[0]['fg_thickness'];
                    $item->fg_thicknessuom = $data[0]['fg_thicknessuom'];
                    $item->fg_actualwidth = $data[0]['fg_actualwidth'];
                    $item->fg_actualwidthuom = $data[0]['fg_actualwidthuom'];
                    $item->fg_actuallength = $data[0]['fg_actuallength'];
                    $item->fg_actuallengthuom = $data[0]['fg_actuallengthuom'];
                    $item->fg_colornum = $data[0]['fg_colornum'];
                    $item->fg_repeatlength = $data[0]['fg_repeatlength'];
                    $item->fg_repeatlengthuom = $data[0]['fg_repeatlengthuom'];
                    $item->fg_outnum = $data[0]['fg_outnum'];
                    $item->fg_outnumuom = $data[0]['fg_outnumuom'];
                    $item->fg_bfilmwidth = $data[0]['fg_bfilmwidth'];
                    $item->fg_bfilmwidthuom = $data[0]['fg_bfilmwidthuom'];
                    $item->fg_thickness2 = $data[0]['fg_thickness2'];
                    $item->fg_thickness2uom = $data[0]['fg_thickness2uom'];
                    $item->fg_gramppiece1 = $data[0]['fg_gramppiece1'];
                    $item->fg_gramppiece2 = $data[0]['fg_gramppiece2'];
                }//end f


                $item->effdate=$data[0]['effectdate'];
                $item->grp=$data[0]['grp'];
                $item->packaging=$data[0]['packaging'];
                $item->linkplu=$data[0]['linkplu'];
                $item->otherbar=$data[0]['othcode'];
                $item->supbar=$data[0]['suppcodes'];
                $item->dateupdated=$data[0]['dateupdated'];
                // $item->$quantity=$data[0]['qty'];
                $item->mode=$data[0]['mode'];
                $item->istaxable=$data[0]['istaxable'];
                $item->ispostitem=$data[0]['ispostitem'];
                $item->issenior=$data[0]['issenior'];
                $item->iszerorated=$data[0]['iszerorated'];
                $item->isprintable=$data[0]['isprintable'];
                $item->hierparent=$data[0]['hierarchy'];
                $item->linkdept=$data[0]['linkdept'];
                $item->points=$data[0]['points'];
                $item->acceptlosses=$data[0]['acceptloss'];
                $item->currentcost=$data[0]['cost'];
                $item->cooktime=$data[0]['cooking_time'];
                $item->preptime=$data[0]['prep_time'];
                $item->reorder=$data[0]['reorder'];
                $item->critical=$data[0]['critical'];
                $item->color=$data[0]['color'];
                $item->senior=$data[0]['senior'];
                $item->pwd=$data[0]['pwd'];
                //END
                $item->itemid=$data[0]['itemid'];
                $item->barcode=$data[0]['barcode'];
                $item->itemname=$data[0]['itemname'];
                $item->groupid=$data[0]['groupid'];
                $item->stockgrpid=$data[0]['stockgrpid'];
                $item->part=$data[0]['part'];
                $item->partid=$data[0]['partid'];
                $item->itemrem=$data[0]['itemrem'];
                $item->model=$data[0]['model'];
                $item->modelid=$data[0]['modelid'];
                $item->brand=$data[0]['brand'];
                $item->class=$data[0]['class'];
                $item->classid = $data[0]['classid'];
                $item->body=$data[0]['body'];
                $item->sizeid=$data[0]['sizeid'];
                $item->daystoexpire=$data[0]['expiryday'];
                $item->category=$data[0]['category'];
                $item->uom=$data[0]['uom'];
                $item->qty=$data[0]['qty'];
                $item->minimum=number_format($data[0]['minimum'],2);
                $item->maximum=number_format($data[0]['maximum'],2);
                $item->bal=number_format($data[0]['bal'],2);
                
                $item->supplier=$data[0]['supplier'];
                

                $item->amt=number_format($data[0]['amt'],2);
                $item->amt2=number_format($data[0]['amt2'],2);
                $item->amt4=number_format($data[0]['amt4'],2);
                
                $item->amt5=number_format($data[0]['amt5'],2);
                $item->amt6=number_format($data[0]['amt6'],2);
                $item->amt7=number_format($data[0]['amt7'],2);
                $item->amt8=number_format($data[0]['amt8'],2);
                $item->amt9=number_format($data[0]['amt9'],2);
                $item->amt10=number_format($data[0]['amt10'],2);
                $item->amt11=number_format($data[0]['amt11'],2);
                $item->amt12=number_format($data[0]['amt12'],2);
                $item->amt13=number_format($data[0]['amt13'],2);
                $item->amt14=number_format($data[0]['amt14'],2);
                $item->amt15=number_format($data[0]['amt15'],2);

                $item->famt=number_format($data[0]['famt'],2);
                $item->cost=number_format($data[0]['cost'],2);
                $item->disc=$data[0]['disc'];
                $item->disc2=$data[0]['disc2'];
                $item->disc3=$data[0]['disc3'];
                $item->disc4=$data[0]['disc4'];

                $item->disc5=$data[0]['disc5'];
                $item->disc6=$data[0]['disc6'];
                $item->disc7=$data[0]['disc7'];
                $item->disc8=$data[0]['disc8'];
                $item->disc9=$data[0]['disc9'];
                $item->disc10=$data[0]['disc10'];
                $item->disc11=$data[0]['disc11'];
                $item->disc12=$data[0]['disc12'];
                $item->disc13=$data[0]['disc13'];
                $item->disc14=$data[0]['disc14'];
                $item->disc15=$data[0]['disc15'];

                $item->wh=$data[0]['wh'];
                $item->isinactive=$data[0]['isinactive'];
                $item->isimport=$data[0]['isimport'];
                $item->title=$data[0]['title'];
                $item->subtitle=$data[0]['subtitle'];
                $item->picture=$data[0]['picture'];
                $item->note=$data[0]['note'];
                $item->specs=$data[0]['specs'];
                $item->g1=$data[0]['g1'];
                $item->g2=$data[0]['g2'];
                $item->g3=$data[0]['g3'];
                $item->g4=$data[0]['g4'];
                $item->g5=$data[0]['g5'];
                $item->g6=$data[0]['g6'];
                $item->g7=$data[0]['g7'];
                $item->g8=$data[0]['g8'];
                $item->fqty = $data[0]['fqty'];
                $item->promostart = $data[0]['promostart'];
                $item->promoend= $data[0]['promoend'];
                $item->fsaleprice = $data[0]['saleprice'];
                $item->fvideourl = $data[0]['f_videourl'];
                $item->fproddesc = $data[0]['f_proddesc'];
                $item->fprodnotes= $data[0]['f_notes'];
                $item->fmainmaterial = $data[0]['f_mainmaterial'];
                $item->ftype= $data[0]['f_type'];
                $item->fhighlights= $data[0]['f_highlights'];
                $item->fwhatsbox= $data[0]['f_whatsbox'];
                $item->ffreeitems= $data[0]['f_freeitems'];
                $item->fdimensions= $data[0]['f_dimensions'];
                $data[0]['f_prodweight'] = number_format($data[0]['f_prodweight'],2);
                $item->fprodweight= $data[0]['f_prodweight'];
                $data[0]['f_packheight'] = number_format($data[0]['f_packheight'],2);
                $item->fpackheight= $data[0]['f_packheight'];
                $data[0]['f_packweight'] = number_format($data[0]['f_packweight'],2);
                $item->fpackweight= $data[0]['f_packweight'];
                $data[0]['f_packlength'] = number_format($data[0]['f_packlength'],2);
                $item->fpacklength= $data[0]['f_packlength'];
                $data[0]['f_packwidth'] = number_format($data[0]['f_packwidth'],2);
                $item->fpackwidth= $data[0]['f_packwidth'];
                $item->fdeliveryopt= $data[0]['f_delivopt'];
                $item->fminshipping= $data[0]['f_shippingmin'];
                $item->fmaxshipping= $data[0]['f_shippingmax'];
                $item->fwarrantytype= $data[0]['f_warrantytype'];
                $item->fwarrantyperiod= $data[0]['f_warrantperiod'];
                $item->fwarrantypolicy= $data[0]['f_warrantpolicy'];
                $item->setfrontend= $data[0]['setfrontend'];
                $item->fdiscounted= $data[0]['fdiscounted'];
                $item->invbal_uom= $data[0]['invbal_uom'];
                $item->itemshortname= $data[0]['shortname'];
                $item->subcatid = $data[0]['sgrpid'];
                $item->subcatgrp = $data[0]['sgrp'];
                $item->termgrp = $data[0]['termgrp'];
                $item->maingrp = $data[0]['maingrp'];
                $item->catgrp = $data[0]['catgrp'];
                $item->commgrpid = $data[0]['commgrp'];
                $item->commgrp = $data[0]['commgrpid'];
                $item->defaultwh =  $data[0]['defaultwh'];

                if($data[0]['f_cattagging'] != 0){
                    $params = array('f_cattagging'=>$data[0]['f_cattagging']);
                    $cattree = Yii::$app->frontend->generateBreadcrumbs('STOCKCARD',$params);
                    $item->ftagging = $cattree;
                    $data[0]['cat_desc'] = $cattree;
                }else{
                    $item->ftagging= '';
                }//end if f_cat tagging
                
                $item->itemcomm = $data[0]['itemcomm'];
                $item->itemhandling = $data[0]['itemhandling'];

                }

                return $data;
                break;

                case 'itemprofile':
                    $data = $item->openitemfa($clientid);
                    return $data;
                break;     

                //EMPLOYEE                
            case 'employee':
                $data = $model->openemployee($clientid);
                if (!empty($data)) {
                    $model->empid = $data[0]['empid'];
                    $model->empcode = $data[0]['empcode'];
                    $model->emplast = $data[0]['emplast'];
                    $model->empfirst = $data[0]['empfirst'];
                    $model->empmiddle = $data[0]['empmiddle'];
                    $model->address = $data[0]['address'];
                    $model->city = $data[0]['city'];
                    $model->country = $data[0]['country'];
                    $model->telno = $data[0]['telno'];
                    $model->mobileno = $data[0]['mobileno'];
                    $model->email = $data[0]['email'];
                    $model->citizenship = $data[0]['citizenship'];
                    $model->religion = $data[0]['religion'];
                    $model->status = $data[0]['status'];
                    $model->gender = $data[0]['gender'];
                    $model->alias = $data[0]['alias'];
                    $model->bday = $data[0]['bday'];
                    $model->idbarcode = $data[0]['idbarcode'];
                    $model->tin = $data[0]['tin'];
                    $model->sss = $data[0]['sss'];
                    $model->hdmf = $data[0]['hdmf'];
                    $model->phic = $data[0]['phic'];
                    $model->bankacct = $data[0]['bankacct'];
                    $model->atm = $data[0]['atm'];
                    $model->paymode = $data[0]['paymode'];
                    $model->jobtitle = $data[0]['jobtitle'];
                    $model->jobcode = $data[0]['jobcode'];
                    $model->jobdesc = $data[0]['jobdesc'];
                    $model->hired = $data[0]['hired'];
                    $model->regular = $data[0]['regular'];
                    $model->resigned = $data[0]['resigned'];
                    $model->division = $data[0]['division'];
                    $model->dept = $data[0]['dept'];
                    $model->orgsection = $data[0]['orgsection'];
                    $model->supervisor = $data[0]['supervisor'];
                    $model->teu = $data[0]['teu'];
                    $model->nodeps = $data[0]['nodeps'];
                    $model->isactive = $data[0]['isactive'];
                    $model->classrate = $data[0]['classrate'];
                    $model->maidname = $data[0]['maidname'];
                    $model->isconfidential = $data[0]['isconfidential'];
                    $model->shiftcode = $data[0]['shiftcode'];
                    $model->ecola = $data[0]['ecola'];
                    $model->spclallow = $data[0]['spclallow'];
                    $model->mealallow = $data[0]['mealallow'];
                    $model->sssdef = $data[0]['sssdef'];
                    $model->philhdef = $data[0]['philhdef'];
                    $model->pibigdef = $data[0]['pibigdef'];
                    $model->wtaxdef = $data[0]['wtaxdef'];
                    $model->dyear = $data[0]['dyear'];
                    $model->chktin = $data[0]['chktin'];
                    $model->chksss = $data[0]['chksss'];
                    $model->chkphealth = $data[0]['chkphealth'];
                    $model->chkpibig = $data[0]['chkpibig'];
                    $model->lastbatch = $data[0]['lastbatch'];
                    $model->fullname = $data[0]['fullname'];
                    $model->provaddress = $data[0]['provaddress'];
                    $model->age = $data[0]['age'];
                    $model->remarks = $data[0]['remarks'];
                    $model->emprate = $data[0]['emprate'];
                    $model->level = $data[0]['level'];
                    $model->iscba = $data[0]['iscba'];
                    $model->trans = $data[0]['trans'];
                    $model->trans1 = $data[0]['trans1'];
                    $model->contact1 = $data[0]['contact1'];
                    $model->relation1 = $data[0]['relation1'];
                    $model->addr1 = $data[0]['addr1'];
                    $model->homeno1 = $data[0]['homeno1'];
                    $model->mobileno1 = $data[0]['mobileno1'];
                    $model->officeno1 = $data[0]['officeno1'];
                    $model->ext1 = $data[0]['ext1'];
                    $model->notes1 = $data[0]['notes1'];
                    $model->contact2 = $data[0]['contact2'];
                    $model->relation2 = $data[0]['relation2'];
                    $model->addr2 = $data[0]['addr2'];
                    $model->homeno2 = $data[0]['homeno2'];
                    $model->mobileno2 = $data[0]['mobileno2'];
                    $model->officeno2 = $data[0]['officeno2'];
                    $model->ext2 = $data[0]['ext2'];
                    $model->notes2 = $data[0]['notes2'];
                    $model->picture = $data[0]['picture'];  
                }
                
                return $model;
            break;              
        }


    
} catch (ErrorException $e) {
    echo $e;
}
    }//END PUBLIC
    
    function menu($controller,$POST,$GET,$accessedit,$accessnew){
              $action = "";
        if (isset($GET['action'])) {
            $action = $GET['action'];
        }

        $head = new Client();
        $head->unsetAttributes();
        $common = new Common();
        $doc = $controller->id;
        
        if ($action == "edit") {
            if (Yii::$app->user->access[$accessedit] != 1) {
                $title = 'Unauthorized';
                $message = 'Sorry, You are not allowed to perform this action';
                $message .= '<br />';
                $message .= CHtml::Button('Ok', array('submit' => array('//site/index')));
                Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                $controller->redirect(array('index'));
            } else {
                $clientid = Yii::$app->session['clientid' . $controller->id];
                if (strlen($clientid) == 0) {
                    $controller->redirect(array('index'));
                }

                $data = Client::openclient($clientid, $controller->id);
                if ($data != null) {
                    $head->client = $data[0]['client'];
                    $head->clientid = $data[0]['clientid'];
                    $head->clientname = $data[0]['clientname'];
                    $head->addr = $data[0]['addr'];
                    $head->terms = $data[0]['terms'];
                    $head->tel = $data[0]['tel'];
                    $head->fax = $data[0]['fax'];
                    $head->agent = $data[0]['agent'];
                    $head->agentcode = $data[0]['agentcode'];
                    $head->email = $data[0]['email'];
                    $head->IsCustomer = $data[0]['iscustomer'];
                    $head->IsAgent = $data[0]['isagent'];
                    $head->IsSupplier = $data[0]['issupplier'];
                    $head->IsWarehouse = $data[0]['iswarehouse'];
                    $head->IsEmployee = $data[0]['isemployee'];
                    $head->IsInactive = $data[0]['isinactive'];

                    $head->contact = $data[0]['contact'];
                    $head->tax = $data[0]['tax'];
                    $head->rem = $data[0]['rem'];
                    $head->crlimit =number_format($data[0]['crlimit'],2);
                    $head->area = $data[0]['area'];
                    $head->groupid = $data[0]['groupid'];
                    $head->province = $data[0]['province'];
                    $head->pricegroup = $data[0]['pricegroup'];
                    $head->status = $data[0]['status'];
                    $head->start = substr($data[0]['start'], 0, 10);
                    $head->region = $data[0]['region'];
                    $head->tel2 = $data[0]['tel2'];
                    $head->tin = $data[0]['tin'];
                    $head->type = $data[0]['type'];
                    $head->disc = $data[0]['disc'];
                    $head->quota=$data[0]['quota'];
                }
            }
        } elseif ($action == "new") {
            if (Yii::$app->user->access[$accessnew] != 1) {
                $title = 'Unauthorized';
                $message = 'Sorry, You are not allowed to perform this action';
                $message .= '<br />';
                $message .= CHtml::Button('Ok', array('submit' => array('//site/index')));
                Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                $controller->redirect(array('index'));
            } else {
                
                Yii::$app->session['clientid' . $controller->id] = "";
                $length = $common->clientlength();
                $pref = '';
                if (strlen($POST['Client']['client']) != 0) {
                    $pref = $common->GetPrefix($POST['Client']['client']);
                }
                
                $last_client=Client::getlast_client_($pref,$controller->id);
                if($pref=='' && strlen($last_client)!=0){
                    $pref = $common->GetPrefix($last_client);
                }else{
                    $pref=Client::getsingledefaultprefixes($controller->id);
                }
                
                //$last_client = Client::getlast_client($pref);
                $start = $common->SearchPosition($last_client);
                $seq = substr($last_client, $start) + 1;
                
                $clseq = $pref . $seq;
                $new_client = $common->PadJ($clseq, $length);
                
                $head->unsetAttributes();
                $head->client = $new_client;
                switch ($doc) {
                    case 'supplier':
                         $head->IsSupplier = 1;
                        break;
                    case 'agent':
                         $head->IsAgent = 1;
                        break;
                     case 'warehouse':
                         $head->IsWarehouse = 1;
                        break;
                         
                    default:
                        $head->IsCustomer = 1;
                        break;
                }
            }
        } else {
            $controller->redirect(array('index'));
        }

        $controller->render('head', array('head' => $head));
    }
  
    
    function save_($controller,$POST,$GET,$accesssave){
        if (Yii::$app->user->access[$accesssave] != 1) {
            $title = 'Unauthorized';
            $message = 'Sorry, You are not allowed to perform this action';
            $message .= '<br />';
            $message .= CHtml::Button('Ok', array('submit' => array('//site/index')));
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('index'));
        } else {
            $data = new Client();
            $head = new Client();
            $common = new Common();
            //$blnExisting = false;
            //$doc = $controller->id;
            $clientid = "";
            $length = $common->clientlength();

            if (isset($POST['Client'])) {
                $data->attributes = $POST['Client'];
                $clientid = $POST['Client']['clientid'];
                Yii::$app->session['clientid' . $controller->id] = $POST['Client']['clientid'];
                $data->clientid = $clientid;
                $client = $data->client;
                //$clientname = $data->clientname;
                //$email = $data->email;

                if (!$data->validate()) {
                    $error = "";
                    if ($data->hasErrors('client')) {
                        $error .=$data->getError('client') . '<br />';
                    }
                    if ($data->hasErrors('clientname')) {
                        $error .=$data->getError('clientname') . '<br />';
                    }
                    if ($data->hasErrors('email')) {
                        $error .=$data->getError('email') . '<br />';
                    }
                    $title = "Fix the FF:";
                    $message = $error;
                    $message .= '<br />';
                    //$message .= CHtml::Button('Ok', array('submit' => array('purchase/index')));
                    Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                } else {
                    if (strlen($POST['Client']['client']) != 0) {
                        
                        //$pref = $common->GetPrefix($client);
                    
                       $client = $common->PadJ($client, $length);
                    
                    $check = Client::checkclient($client);
                    
                    if ($check!=0) {      //update
                        if (strlen($data->client) !=0) {
                            $client = $data->client;
                            if(isset($POST['Client']['agent'])){
                            if($POST['Client']['agent']!=''){    
                            $data->agent = $POST['Client']['agentcode'];}
                            }
                            $result = $data->updateclient($clientid, $data);
                            
                            if($result=='0'){
                                Webproc::showmsg('Error', 'Error in Saving ledger...');
                            }
                        }
                    } else {
                        
                        if (strlen($data->client) !=0) {
                            $client = $data->client;
                            if(isset($POST['Client']['agentcode'])){
                                if($POST['Client']['agentcode']!=''){
                            $data->agent = $POST['Client']['agentcode'];
                                }
                            }
                            $data->insertclient($data);
                            $clientid = Client::checkclient($client);
                        }
                    }

                    Yii::$app->session['clientid' . $controller->id] = $clientid;
                    $controller->redirect(array('index'));
                }
                }
            }
            $controller->render('head', array('head' => $data));
        }
     }
    
     function client($controller,$POST,$GET,$accessnew,$accessview,$type){
            if(isset($POST['Client'])){
                $head=new Client();
                $client = $POST['Client']['client'];
                $common=new Common();
                //$doc=$this->module->id;
                $length=$common->clientlength();                
                //$client=$common->PadJ($client, $length);
                $new_client=$client; 
                if($length!=0){
                    $start2 = $common->SearchPositionNonZero($client);
                    if($start2==0){
                    $pref=strtoupper($client); //$common->GetPrefix($client);                    
                    $prefixes = Client::getPrefixes($type);
                    $blnExist = Client::checkPrefixes($prefixes, $pref);
                    if($blnExist){
                    $last_client = Client::getlast_client_($pref,$controller->id);
                    $start=$common->SearchPosition($last_client);
                       if($start==0){
                          $seq=1;
                          $clseq=$last_client;
                       }else{
                          $seq=substr($last_client, $start) +1;
                          $clseq=$pref.$seq; 
                          $new_client=$common->PadJ($clseq, $length);
                        }
                    }
                    else {
                         $title = 'Invalid prefix';
                         $message = 'You may use ' . $prefixes;
                         $message .= '<br />';
                         //$message .= CHtml::Button('Ok', array('submit' => array('supplier/index')));
                        Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                        $controller->redirect(array('index'));
                    }
                    }else{  //if($start2==0)
                       $client=$common->PadJ($client, $length);
                       $pref = $common->GetPrefix($client);                    
                       $prefixes = Client::getPrefixes($type);
                       $blnExist = Client::checkPrefixes($prefixes, $pref);
                         if($blnExist){
                            $new_client=$client;
                         }
                         else {
                         $title = 'Invalid prefix';
                         $message = 'You may use ' . $prefixes;
                         $message .= '<br />';
                         //$message .= CHtml::Button('Ok', array('submit' => array('supplier/index')));
                        Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                        $controller->redirect(array('index'));
                    }
                    }
                }
                $head->unsetAttributes();
                $clientexist = Client::checkclient($new_client);
                
                if($clientexist!=0){
                    $head = $this->loadmodel($controller,$clientexist);
                    Yii::$app->session['clientid'.$controller->id]=$clientexist;
                     $controller->redirect(array('index'));
                }else{

                if (Yii::$app->user->access[$accessnew] != 1) { //@todo change to allow to create new customer
                    $title = 'Unauthorized';
                    $message = 'Sorry, You are not allowed to Create New Ledger';
                    $message .= '<br />';
                    //$message .= CHtml::Button('Ok', array('submit' => array('//site/index')));
                    Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                    $controller->redirect(array('index'));
                } else {
                    switch ($controller->id)
                    {
                        case 'supplier':
                            $head->IsSupplier = 1;
                            break;
                        case 'agent':
                            $head->IsAgent = 1;
                            break;
                        case 'warehouse':
                            $head->IsWarehouse = 1;
                            break;
                        default :
                            $head->IsCustomer = 1;
                            break;
                    }
                }
                    $head->client=$new_client;
                    $controller->render('head', array('head'=>$head));
                    }
            }else
            {
                    $controller->redirect(array('index'));
            }

     }
     
     
     function change($controller,$POST,$GET,$accesschange,$type){
       if (Yii::$app->user->access[$accesschange] != 1) {
            $title = 'Unauthorized';
            $message = 'Sorry, You are not allowed to Change code';
            $message .= '<br />';
            // $message .= CHtml::Button('Ok', array('submit' => array('//site/index')));
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('index'));
        } else {
            $head = new Client();
            $common = new Common();
            $clientid = Yii::$app->session['clientid' . $controller->id];
            if (strlen($POST['Client']['newclient']) != 0) {
                $queryString = $POST['Client']['newclient'];
            }

            $length = $common->clientlength();
            $pref = $common->GetPrefix($queryString);
            $oldclient = $POST['Client']['client'];
            $newclient = $common->PadJ($queryString, $length);
            $data = Client::openclient($clientid, $controller->id);
            $prefixes = Client::getPrefixes($type);
            
            //Webproc::showmsg($controller->id, $type);
            $blnExist = Client::checkPrefixes($prefixes, $pref);
            if ($blnExist) {

                $check = Client::checkclient($newclient);

                if ($check) {
                    if ($newclient == $oldclient) {
                        $title = 'Same Code';
                        $message = 'You have entered the same code ' . $newclient;
                        $message .= '<br />';
                        //$message .= CHtml::Button('Ok', array('submit' => array('supplier/menu&action=edit')));
                        Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                        $controller->redirect(array('index'));
                    } else {
                        $title = 'Existing Customer Code';
                        $message = 'Sorry, ' . $newclient . ' is already in use.';
                        $message .= '<br />';
                        //$message .= CHtml::Button('Ok', array('submit' => array('supplier/menu&action=edit')));
                        Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                        $controller->redirect(array('index'));
                    }
                } else {
                    //update clientcode
                    $head->updatecode($newclient,$oldclient,$clientid);
                    $data = Client::openclient($clientid, $controller->id);
                    $controller->redirect(array('index'));
                }
            } else {
                $title = 'Invalid Document #';
                $message = 'Please include a prefix followed by a number';
                $message .= '<br />';
                $message .='You may use ' . $prefixes . ' as prefix';
                $message .= '<br />';
                //$message .= CHtml::Button('Ok', array('submit' => array('supplier/menu&action=edit')));
                Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                $controller->redirect(array('index'));
            }

            $head->clientid = $data[0]['clientid'];
            $head->client = $data[0]['client'];
            $head->clientname = $data[0]['clientname'];
            $head->addr = $data[0]['addr'];
            $head->terms = $data[0]['terms'];
            $head->tel = $data[0]['tel'];
            $head->agent = $data[0]['agent'];
            $head->email = $data[0]['email'];
            $head->quota=$data[0]['quota'];
            $head->IsCustomer = $data[0]['iscustomer'];
            $head->IsAgent = $data[0]['isagent'];
            $head->IsSupplier = $data[0]['issupplier'];
            $head->IsWarehouse = $data[0]['iswarehouse'];
            $head->IsEmployee = $data[0]['isemployee'];
            $head->IsInactive = $data[0]['isinactive'];
            $controller->render('head', array('head' => $head,));
        }
     }
     
     function delete($controller,$POST,$accessdelete){
      if(isset($POST['Client'])){ 
        $head = new Client();
        $clientid = $POST['Client']['clientid'];
        if (Yii::$app->user->access[$accessdelete] != 1) {
            $title = 'Unauthorized';
            $message = 'Sorry, You are not allowed to perform this action';
            $message .= '<br />';
            //$message .= CHtml::Button('Ok', array('submit' => array('//site/index')));
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('index'));
        } else {
            $head->attributes = $POST['Client'];
            $client = $POST['Client']['client'];
            $clientid = $POST['Client']['clientid'];
            $common = new Common();
            Yii::$app->session['clientid' . $controller->id] = "";
            $action = "delete";
            $newclientid = Common::navnext_prev($clientid, $clientid, $controller->id, $action);
            Yii::$app->session['clientid' . $controller->id] = $newclientid;
            $common->deleteclient($client);
            $controller->redirect(array('index'));
        }
      }
        $controller->redirect(array('index'));
     }
     
     
     
function items($controller,$POST,$GET){
        $model = new Clientitem();
        $action = '';
        $clientid = Yii::$app->session['clientid' . $controller->id];
        $items = false;
        $edit = false;
        if (isset($POST['Clientitem'])) {
            $model->attributes = $POST['Clientitem'];
            if (isset($GET['action'])) {
                $action = $GET['action'];
            }
            if ($action == 'save') {
                $model->clientid = Yii::$app->session['clientid' . $controller->id];
                if (!$model->validate()) {
                    //invalid
                } else {
                    $insert = $model->insertitem($model);
                    if ($insert == 1) {
                        $model->unsetAttributes();
                        Yii::$app->user->setFlash('message', 'item added!');
                    } else {
                        Yii::$app->user->setFlash('message', 'error!');
                    }
                }
            } elseif ($action == 'edit' || $action == 'delete') {
                $edit = true;
                $id = isset($_GET['id']) ? $_GET['id'] : 0;
                $id_ = explode('-', $id);
                $cid = isset($id_[0]) ? $id_[0] : 0;
                $bcode = isset($id_[1]) ? $id_[1] : '';
                $item = null;
                if ($cid > 0 && $bcode != '') {
                    if ($action == 'edit') {
                        $item = $model->open($cid, $bcode);
                        if ($item != null) {
                            $model->barcode = $item[0]['barcode'];
                            $model->clientid = $item[0]['clientid'];
                            $model->itemname = $item[0]['itemname'];
                            $model->amount = $item[0]['amount'];
                        }
                    } else {
                        $delete=$model->deleteitem($cid, $bcode);
                        $controller->redirect(array('items'));
                    }
                }
            } elseif ($action == 'update') {
                if (!$model->validate()) {
                    //invalid
                } else {
                    $update = $model->updateitem($model);
                    if ($update == 1) {
                        $model->unsetAttributes();
                        Yii::$app->user->setFlash('message', 'item updated!');
                    } else {
                        Yii::$app->user->setFlash('message', 'error!');
                    }
                    $controller->redirect(array('items'));
//                        var_dump($update);
                }
            }
        }
        $items = $model->getclientitems($clientid);
        $controller->render('items', array('model' => $model, 'items' => $items));
}     

//JAC general item 2016.08.20

function insertgenitem($model){   
      
    $sql = "insert into generalitem (bcode,itemdesc,itembrand,itempart,itemuom,itemshortname,itemgroup,itemcolor,itemmodel,itemclass,itemsize) values 
    ('$model->bcode','$model->itemdesc','$model->itembrand','$model->itempart','$model->itemuom','$model->itemshortname','$model->itemgroup','$model->itemcolor','$model->itemmodel','$model->itemclass','$model->itemsize')";
        
    $data = Yii::$app->sbccommon->execqry($sql);
    return $data;

}

function updategenitem($model,$line){   
      
    $sql = "update generalitem set itemdesc='$model->itemdesc',itembrand='$model->itembrand',itempart='$model->itempart',itemuom='$model->itemuom',itemshortname='$model->itemshortname',itemgroup='$model->itemgroup',itemcolor='$model->itemcolor',itemmodel='$model->itemmodel',itemclass='$model->itemclass',itemsize='$model->itemsize' where line = $line";
        
    $data = Yii::$app->sbccommon->execqry($sql);
    return $data;

}       

//end jac






}

?>
