<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Item extends Model {

    public $line;
    public $itemid;
    public $barcode;
    public $itemname;
    public $groupid;
    public $stockgrpid;
    public $part;
    public $model;
    public $partid;
    public $modelid;
    public $brand;
    public $class;
    public $classid;
    public $body;
    public $sizeid;
    public $category;
    public $cost;
    public $uom;
    public $qty;
    public $minimum;
    public $maximum;
    public $amt;
    public $amt2;
    public $famt;
    public $amt4;

    public $amt5;
    public $amt6;
    public $amt7;
    public $amt8;
    public $amt9;
    public $amt10;
    public $amt11;
    public $amt12;
    public $amt13;
    public $amt14;
    public $amt15;

    public $disc;
    public $disc2;
    public $disc3;
    public $disc4;

    public $disc5;
    public $disc6;
    public $disc7;
    public $disc8;
    public $disc9;
    public $disc10;
    public $disc11;
    public $disc12;
    public $disc13;
    public $disc14;
    public $disc15;

    public $wh;
    public $isinactive;
    public $isimport;
    public $title;
    public $subtitle;
    public $picture;
    public $newbarcode;
    public $rename;
    public $itemrem;
    public $supplier;
    public $specs;

    public $asset;
    public $liability;
    public $revenue;
    public $expense;

    /* ledger*/
    public $action;
    public $viewby;
    public $uomby;
    public $whby;
    public $whbycode;
    public $lstatus;
    public $ldocno;
    public $ldateid;
    public $lclientname;
    public $yourref;
    public $ourref;
    public $lcost;
    public $qtyin;
    public $qtyout;
    public $lamt;
    public $ldisc;
    public $rem;
    public $encoded;
    public $totin;
    public $totout;
    public $totbal;
    public $ldoc;
    public $ltrno;
    public $url;
        
    public $srpa;
    public $srpb;
    public $srpc;
    public $srpd;
    public $srpe;
    public $srpf;
    public $srpg;
    public $srph;
    public $srpi;
    public $srpj;
    public $srpk;
    public $srpl;
    public $srpm;
    public $srpn;
    public $srpo;
    public $srpp;
    public $srpq;
    public $srpr;
    public $srps;
    public $srpt;
    public $srpu;
    public $srpv;
    public $srpw;
    public $srpx;
    public $srpy;
    public $srpz;
    
    public $srpa1;
    public $srpa2;
    public $srpa3;
    public $srpa4;
    
    public $comma;
    public $commb;
    public $commc;
    public $commd;
    public $comme;
    public $commf;
    public $commg;
    public $commh;
    public $commi;
    public $commj;
    public $commk;
    public $comml;
    public $commm;
    public $commn;
    public $commo;
    public $commp;
    public $commq;
    public $commr;
    public $comms;
    public $commt;
    public $commu;
    public $commv;
    public $commw;
    public $commx;
    public $commy;
    public $commz;
    
    public $comma1;
    public $comma2;
    public $comma3;
    public $comma4;
    
    public $icomma;
    public $icommb;
    public $icommc;
    public $icommd;
    public $icomme;
    public $icommf;
    public $icommg;
    public $icommh;
    public $icommi;
    public $icommj;
    public $icommk;
    public $icomml;
    public $icommm;
    public $icommn;
    public $icommo;
    public $icommp;
    public $icommq;
    public $icommr;
    public $icomms;
    public $icommt;
    public $icommu;
    public $icommv;
    public $icommw;
    public $icommx;
    public $icommy;
    public $icommz;
    
    public $icomma1;
    public $icomma2;
    public $icomma3;
    public $icomma4;
    public $bal;
    public $beg;
                
    public $note;
    public $daystoexpire;

    //general item
    public $bcode;
    public $itemdesc;
    public $itemshortname;
    public $itemuom;
    public $itembrand;
    public $itemcolor;
    public $itemgroup;
    public $itempart;
    public $itemmodel;
    public $itemclass;
    public $itemsize;   

    public $g1;
    public $g2;
    public $g3;
    public $g4;
    public $g5;
    public $g6;
    public $g7;
    public $g8;

    public $setfrontend;
    public $adddod;
    public $fdiscounted;
    public $invbal_uom;
    
    public $subcatgrp;
    public $catgrp;
    public $termgrp;
    public $maingrp;
    public $subcatid;
    public $commgrpid;
    public $commgrp;
    //fixedasset(itemprofile)
    //properties
    public $shortname, $subcode, $color, $isnew, $isused, $islease, $dtedisposal, $daydisposal, $depamt, $depsalvage, $deplife;
    //acquisition
    public $dteacq, $acqyr, $supp, $suppname, $buyer, $buyername, $dteinv, $inv, $dtepo, $po, $dtewarranty, $daywarranty, $dtelease, $daylease, $itemprice;
    //location info
    public $deptname, $emp, $bldg, $floor, $room, $region, $locdate;
    //vehicle info tab
    public $plate, $man, $fuel, $insurance, $vin, $manyr, $engine, $vehicleexp;  
    // itemprofile


    public $fg_isfinishedgood, $fg_client, $fg_clientname, $fg_prodtype, $fg_combi, $fg_transform, 
    $fg_addspecs, $fg_punchholesize, $fg_sealing, $fg_plasticcolor, $fg_bfilmdet, $fg_treatment, $fg_rate,
    $fg_quantity, $fg_revision, $fg_templateno, $fg_updated, $fg_effective, $fg_jowidth,
    $fg_jowidthuom, $fg_jolength, $fg_jolengthuom, $fg_thickness, $fg_thicknessuom,
    $fg_actualwidth, $fg_actualwidthuom, $fg_actuallength, $fg_actuallengthuom, $fg_colornum,
    $fg_repeatlength, $fg_repeatlengthuom, $fg_outnum, $fg_outnumuom, $fg_bfilmwidth,
    $fg_bfilmwidthuom, $fg_thickness2, $fg_thickness2uom, $fg_gramppiece1, $fg_gramppiece2;

    public $fg_isequipmenttool,$fg_serial;
    public $fg_stockcardcustomer,$fg_diameter,$fg_numcolors;

    public $payrate;

    public $payqty;

    public $freedelivery,$frcollect;



    ############# UPDATE FOR STOCKCARD (FRONTEND READY) ##########################
    public $fqty;
    public $promostart;
    public $promoend;
    public $fsaleprice;
    public $fvideourl;
    public $fproddesc;
    public $fprodnotes;
    public $fmainmaterial;
    public $ftype;
    public $fhighlights;
    public $fwhatsbox;
    public $ffreeitems;
    public $fdimensions;
    public $fprodweight;
    public $fpackheight;
    public $fpackweight;
    public $fpacklength;
    public $fpackwidth;
    public $fdeliveryopt;
    public $fminshipping;
    public $fmaxshipping;
    public $fwarrantytype;
    public $fwarrantyperiod;
    public $fwarrantypolicy;
    public $ftagging;
    ############# UPDATE FOR STOCKCARD (FRONTEND READY) ##########################

    public $defaultwh;
    
    public $critical;
    public $reorder;
    public $pwd;
    public $senior;
    //END

    public $itemcomm;
    public $itemhandling;

    public $itemhandling2;


    public $effdate;
    public $grp;
    public $packaging;
    public $linkplu;
    public $otherbar;
    public $supbar;
    public $dateupdated;
    public $quantity;
    // public $supplier;
    public $mode;
    public $istaxable;
    public $ispostitem;
    public $issenior;
    public $iszerorated;
    public $isprintable;
    public $hierparent;
    public $linkdept;
    public $points;
    public $acceptlosses;
    public $currentcost;
    public $cooktime;
    public $preptime;
    public $amt3;
    public $markup;
    public $markup2;
    public $markup3;
    public $markup4;
    public $markup5;
    public $markup6;

    public $uom1;
    public $uom2;
    public $uom3;
    public $uom4;
    public $uom5;
    public $uom6;

    public $factor1;
    public $factor2;
    public $factor3;
    public $factor4;
    public $factor5;
    public $factor6;
    

    public $uvpriority;
    public $uvdepartment;
    public $suppitemcode;
    public $isvat;
    public $isexempt;

    public $printuom;

    public $uvprincipal;
    public $uvprincipalid;

    public $uvpurchaseuom;

    public $fgunit_length;
    public $fgunit_width;
    public $fgunit_diameter;
    public $fgunit_thickness;

    public function rules() {

        return array(
            array('barcode,itemname', 'required', 'except' => 'level'),
            array('minimum, maximum, cost, famt, amt4,srpa, srpb,srpc, srpd, srpe, srpf, srpg, srph, srpi, srpj, srpk, srpl, srpm, srpn, srpo, srpp, srpq, srpr, srps, srpt, srpu, srpv, srpw, srpx, srpy, srpz,comma, commb,commc, commd, comme, commf, commg, commh, commi, commj, commk, comml, commm, commn, commo, commp, commq, commr, comms, commt, commu, commv, commw, commx, commy, commz,icomma, icommb,icommc, icommd, icomme, icommf, icommg, icommh, icommi, icommj, icommk, icomml, icommm, icommn, icommo, icommp, icommq, icommr, icomms, icommt, icommu, icommv, icommw, icommx, icommy, icommz,srpa1,srpa2,srpa3,srpa4,comma1,comma2,comma3,comma4,icomma1,icomma2,icomma3,icomma4', 'numerical'),
            array('picture', 'unique'),
            array('barcode,uom,amt,amt2', 'length', 'max' => 30),
            array('disc,disc2,disc3,disc4', 'length', 'max' => 20),
            array('groupid', 'length', 'max' => 40),
            array('itemname', 'length', 'max' => 500),
                array('note,specs', 'length', 'max' => 5000),
            array('line', 'length', 'max' => 50),
            array('picture', 'file', 'allowEmpty' => true, 'types' => 'jpg,gif,png'),
            array('barcode, itemname, line, brand,sizeid,itemrem, model,supplier, part, class ,picture,body,category,isinactive,isimport', 'safe'),
        );
        /* return array(
          array('SN, SERIAL, Copies, BarOrder, QPU, Button, NoDisc, AllowLD, IsInActive, RAW, isImport', 'numerical', 'integerOnly'=>true),
          array('BARCODE, CUR, SUPP, UOM, PC, SubCode', 'length', 'max'=>30),
          array('itemname, ItemRem, Hierarchy', 'length', 'max'=>500),
          array('GroupID, PART, MODEL, BRAND, Class, SizeID', 'length', 'max'=>150),
          array('Body', 'length', 'max'=>60),
          array('Category, Color, PartNo', 'length', 'max'=>100),
          array('ACOST, COST, AVECOST, QTY, Minimum, Maximum, OQTY, TQTY, AMT, AMT2, FAMT, DEPRE, TAX, Amt4', 'length', 'max'=>19),
          array('BCOST, REO', 'length', 'max'=>18),
          array('BIN, PG, LOCK, DISC, DISC2, DISC3, TYPE, Short, PICTURE, WH, UserID, OthCode, Caption, Supplier, UOMView', 'length', 'max'=>20),
          array('ASSET, LIABILITY, REVENUE, EXPENSE', 'length', 'max'=>7),
          array('Country, Unit, Disc4, Line, a, b, SoldAs, Engine, EditBy, sUPPnAME', 'length', 'max'=>50),
          array('ParentID', 'length', 'max'=>80),
          array('SubCat, SubClass', 'length', 'max'=>200),
          array('ASSET2', 'length', 'max'=>10),
          array('List', 'length', 'max'=>2),
          array('Code1, Code2, Code3', 'length', 'max'=>15),
          array('Title, SubTitle, Source', 'length', 'max'=>250),
          array('DLOCK, DateID, EditDate', 'safe'),
          // The following rule is used by search().
          // Please remove those attributes that should not be searched.
          array('ItemID, BARCODE, ItemName, GroupID, PART, MODEL, BRAND, Class, Body, SizeID, Category, CUR, SUPP, ACOST, BCOST, COST, AVECOST, UOM, PC, BIN, QTY, Minimum, Maximum, REO, OQTY, TQTY, AMT, AMT2, FAMT, ASSET, LIABILITY, REVENUE, EXPENSE, DEPRE, PG, Country, LOCK, DISC, DISC2, DISC3, DLOCK, SN, DateID, TAX, TYPE, SERIAL, Short, PICTURE, WH, ParentID, UserID, OthCode, Copies, BarOrder, QPU, Button, Caption, NoDisc, AllowLD, Supplier, IsInActive, RAW, SubCat, SubClass, UOMView, Unit, ASSET2, List, Amt4, Disc4, isImport, Line, Code1, Code2, Code3, ItemRem, Hierarchy, Color, a, b, SoldAs, Engine, SubCode, Title, SubTitle, PartNo, EditBy, EditDate, Source, sUPPnAME', 'safe', 'on'=>'search'),
          );
         *
         */
    }

    public function attributeLabels() {
        return array(
            'ItemID' => 'Item',
            'BARCODE' => 'Barcode',
            'ItemName' => 'Item Name',
            'GroupID' => 'Group',
            'PART' => 'Part',
            'MODEL' => 'Model',
            'BRAND' => 'Brand',
            'Class' => 'Class',
            'Body' => 'Body',
            'SizeID' => 'Size',
            'Category' => 'Category',
            'CUR' => 'Cur',
            'SUPP' => 'Supp',
            'ACOST' => 'Acost',
            'BCOST' => 'Bcost',
            'COST' => 'Cost',
            'AVECOST' => 'Avecost',
            'UOM' => 'Uom',
            'PC' => 'Pc',
            'BIN' => 'Bin',
            'QTY' => 'Qty',
            'minimum' => 'Minimum',
            'maximum' => 'Maximum',
            'REO' => 'Reo',
            'OQTY' => 'Oqty',
            'TQTY' => 'Tqty',
            'amt' => 'Retail',
            'amt2' => 'Wholesale',
            'famt' => 'ATP',
            'ASSET' => 'Asset',
            'LIABILITY' => 'Liability',
            'REVENUE' => 'Revenue',
            'EXPENSE' => 'Expense',
            'DEPRE' => 'Depre',
            'PG' => 'Pg',
            'Country' => 'Country',
            'LOCK' => 'Lock',
            'disc' => 'Discount',
            'disc2' => 'Discount2',
            'disc3' => 'Discount3',
            'DLOCK' => 'Dlock',
            'SN' => 'Sn',
            'DateID' => 'Date',
            'TAX' => 'Tax',
            'TYPE' => 'Type',
            'SERIAL' => 'Serial',
            'Short' => 'Short',
            'PICTURE' => 'Picture',
            'WH' => 'Wh',
            'ParentID' => 'Parent',
            'UserID' => 'User',
            'OthCode' => 'Oth Code',
            'Copies' => 'Copies',
            'BarOrder' => 'Bar Order',
            'QPU' => 'Qpu',
            'Button' => 'Button',
            'Caption' => 'Caption',
            'NoDisc' => 'No Disc',
            'AllowLD' => 'Allow Ld',
            'Supplier' => 'Supplier',
            'IsInActive' => 'Is In Active',
            'RAW' => 'Raw',
            'SubCat' => 'Sub Cat',
            'SubClass' => 'Sub Class',
            'UOMView' => 'Uomview',
            'Unit' => 'Unit',
            'ASSET2' => 'Asset2',
            'List' => 'List',
            'amt4' => 'Price 1',
            'disc4' => 'Discount4',
            'isImport' => 'Is Import',
            'Line' => 'Line',
            'Code1' => 'Code1',
            'Code2' => 'Code2',
            'Code3' => 'Code3',
            'ItemRem' => 'Item Rem',
            'Hierarchy' => 'Hierarchy',
            'Color' => 'Color',
            'a' => 'A',
            'b' => 'B',
            'SoldAs' => 'Sold As',
            'Engine' => 'Engine',
            'SubCode' => 'Sub Code',
            'Title' => 'Title',
            'SubTitle' => 'Sub Title',
            'PartNo' => 'Part No',
            'EditBy' => 'Edit By',
            'EditDate' => 'Edit Date',
            'Source' => 'Source',
            'sUPPnAME' => 'S Uppn Ame',
        );
    }
    
   

   public static function suggest($keywords, $limit = 25, $doc = '') {
        $keyword = explode(",", $keywords);
        $client = Yii::$app->session['supplier' . $doc];
        
                      
        $comm = Yii::$app->user->centercomm;
        $icomm = Yii::$app->user->centericomm;
        
        if (Common::getcompanyid()==3){
            
        $price = Yii::$app->user->centerprice;  
        
        }else{    
            
        $class = Yii::$app->sbccommon->datareader("select class from client where client='$client'"); //Yii::$app->session['supplier' . $doc];   
        switch ($class) {
            case'A': {
                    $price = ' item.amt ';
                    $disc = ' disc ';
                    break;
                }
            case'B': {
                    $price = ' item.amt2 ';
                    $disc = ' disc2 ';
                    break;
                }
            case'C': {
                    $price = ' item.famt ';
                    $disc = ' disc3 ';
                    break;
                }
            case'D': {
                    $price = ' item.amt4 ';
                    $disc = ' disc4 ';
                    break;
                }
            default: {
                    $price = ' item.amt ';
                    $disc = ' disc ';
                    break;
                }
        }
        }
        
        
        //pioneer
        if (Common::getcompanyid()==4){
        
        if ($doc=='SJ' || $doc=='CH' || $doc=='SO'){
        $sql = "select item.brand, item.part, item.model, item.sizeid, item.barcode, item.itemname, item.qty,uom.uom, uom.discount as disc,uom.amt as cost from item
            left join uom on uom.itemid=item.itemid and uom.uom=item.uom where ";
        }else{
            $sql = "select brand, part, model, sizeid, barcode, itemname, round($price,2) as cost, qty,uom, $disc from item where ";
        }
        $criteria = "";
        for ($i = 0; $i < count($keyword); $i++) {
            if ($criteria == "") {
                $criteria = "(
                                    item.itemname LIKE '%" . $keyword[$i] . "%' OR
                                    item.barcode LIKE '%" . $keyword[$i] . "%' OR
                                    item.brand LIKE '%" . $keyword[$i] . "%' OR
                                    item.model LIKE '%" . $keyword[$i] . "%' OR
                                    item.sizeid LIKE '%" . $keyword[$i] . "%'
                                )";
            } else {
                $criteria = $criteria . " and " . "(
                                    item.itemname LIKE '%" . $keyword[$i] . "%' OR
                                    item.barcode LIKE '%" . $keyword[$i] . "%' OR
                                    item.brand LIKE '%" . $keyword[$i] . "%' OR
                                    item.model LIKE '%" . $keyword[$i] . "%' OR
                                    item.sizeid LIKE '%" . $keyword[$i] . "%'
                                                    )";
            }
        }
        
        $models = Yii::$app->sbccommon->opentable($sql . " " . $criteria . " order by item.itemname asc limit $limit");
        
        } else {
            
        switch (Common::getcompanyid()){
            case 3: //cellboy
            $sql = "select brand, itemid, part, model, sizeid, barcode, itemname, round($price,2) as cost,$comm as comm,$icomm as icomm,groupid,category,body,class, qty,uom, disc,disc2,disc3,disc4,class from item where ";    
                break;
            default:    
            $sql = "select brand, part, model, sizeid, barcode, itemname, 0 as lcost, round($price,2) as cost, qty,uom, $disc as disc, '' as ldisc from item where ";
                break;
                
        }        
      
        $criteria = "";
        for ($i = 0; $i < count($keyword); $i++) {
            if ($criteria == "") {
                    $criteria = "(
                                    itemname LIKE '%" . $keyword[$i] . "%' OR
                                    barcode LIKE '%" . $keyword[$i] . "%' OR
                                    brand LIKE '%" . $keyword[$i] . "%' OR
                                    model LIKE '%" . $keyword[$i] . "%' OR
                                    groupid LIKE '%" . $keyword[$i] . "%' OR
                                    part LIKE '%" . $keyword[$i] . "%' OR    
                                    class LIKE '%" . $keyword[$i] . "%' OR    
                                    body LIKE '%" . $keyword[$i] . "%' OR    
                                    sizeid LIKE '%" . $keyword[$i] . "%'
                                )";
                } else {
                    $criteria = $criteria . " and " . "(
                                    itemname LIKE '%" . $keyword[$i] . "%' OR
                                    barcode LIKE '%" . $keyword[$i] . "%' OR
                                    brand LIKE '%" . $keyword[$i] . "%' OR
                                    model LIKE '%" . $keyword[$i] . "%' OR
                                    groupid LIKE '%" . $keyword[$i] . "%' OR
                                    part LIKE '%" . $keyword[$i] . "%' OR    
                                    class LIKE '%" . $keyword[$i] . "%' OR    
                                    body LIKE '%" . $keyword[$i] . "%' OR                                            
                                    sizeid LIKE '%" . $keyword[$i] . "%'
                                                    )";
                }
        }
       

        $models = Yii::$app->sbccommon->opentable($sql . " " . $criteria . " order by itemname asc limit $limit");
        }
        
        foreach ($models as $model) {
               if ($doc=='PO' || $doc=='RR' || $doc=='PC' || $doc=='PR' || $doc=='IS' || $doc=='AJ'){
                $suggest[] = array(
                'label' => $model['itemname'] . " -- " . $model['barcode'] . " -- " . $model['sizeid'] . " -- " . $model['cost'],
                'itemname' => $model['brand'] . ' ' . $model['itemname'] . ' ' . $model['part'] . ' ' . $model['model'] . ' ' . $model['sizeid'],
                'value' => $model['barcode'],
                'id' => $model['barcode'],
                'default' => "",
                'barcode' => $model['barcode'],
                'cost' => $model['lcost'],
                'rrcost' =>  $model['cost'],
                'qty' => $model['qty'],
                'disc' => $model['ldisc'],
                'uom' => $model['uom'],
//                    'comm' => $model['comm'],
//                'icomm' => $model['icomm'],
                'title' => $model['barcode'] . "  " . $model['cost'],
            );     
               } else { 
            
                   if (Common::getcompanyid()==3){
                       $suggest[] = array(
                'label' => $model['part']. " -- " .$model['model'] . " -- " . $model['class'] . " -- " . $model['brand'] . " -- " . $model['itemname'] . " -- " . $model['body']  . " -- " . $model['sizeid'],
                'itemname' => $model['brand'] . ' ' . $model['itemname'] . ' ' . $model['part'] . ' ' . $model['model'] . ' ' . $model['sizeid'],
                'value' => $model['brand'] . ' - ' . $model['itemname'] . ' - '. $model['part'] . ' - ' . $model['sizeid'] . ' - ' . $model['barcode'],
                'value' => $model['barcode'],
                'id' => $model['barcode'],
                'default' => "",
                'barcode' => $model['barcode'],
                'cost' => $model['cost'],
                'rrcost' =>  $model['cost'],
                'qty' => $model['qty'],
                'disc' => $model['disc'],
                'uom' => $model['uom'],
                'itemid' => $model['itemid'],
                'title' => $model['barcode'],
                'category' => $model['category'],
                'comm' => $model['comm'],
                'icomm' => $model['icomm'],
            );
                   } else {
            $suggest[] = array(
                'label' => $model['brand'] . ' -- ' .$model['itemname'] . " -- " . $model['barcode'] . " -- " . $model['sizeid'] . " -- " . $model['cost'],
                'itemname' => $model['brand'] . ' ' . $model['itemname'] . ' ' . $model['part'] . ' ' . $model['model'] . ' ' . $model['sizeid'],
                'value' => $model['barcode'],
                'id' => $model['barcode'],
                'default' => "",
                'barcode' => $model['barcode'],
                'cost' => $model['cost'],
                'rrcost' =>  $model['cost'],
                'qty' => $model['qty'],
                'disc' => $model['disc'],
                'uom' => $model['uom'],
//                'comm' => $model['comm'],
//                'icomm' => $model['icomm'],
                'title' => $model['barcode'] . "  " . $model['cost'],
            );
               }
               }
               }
         return $suggest;
   }


   public static function suggestpricepanda($keywords, $limit = 25, $doc = '') {
        $keyword = explode(",", $keywords);
        $client = Yii::$app->session['supplier' . $doc];

        $class = Yii::$app->sbccommon->datareader("select class from client where client='$client'"); //Yii::$app->session['supplier' . $doc];
        $disc = Yii::$app->sbccommon->datareader("select disc from client where client='$client'"); //Yii::$app->session['supplier' . $doc];
        switch ($class) {
            case'A': {
                    $price = ' amt ';
                    break;
                }
            case'B': {
                    $price = ' amt2 ';
                    break;
                }
            case'C': {
                    $price = ' famt ';
                    break;
                }
            case'D': {
                    $price = ' amt4 ';
                    break;
                }
            default: {
                    $price = ' amt ';
                    break;
                }
        }

        $sql = "select brand, part, model, sizeid, barcode, itemname, round($price,2) as cost, qty,uom, '$disc' as  disc from item where ";
        $criteria = "";
        for ($i = 0; $i < count($keyword); $i++) {
            if ($criteria == "") {
                $criteria = "(
                                    itemname LIKE '%" . $keyword[$i] . "%' OR
                                    barcode LIKE '%" . $keyword[$i] . "%' OR
                                    brand LIKE '%" . $keyword[$i] . "%' OR
                                    model LIKE '%" . $keyword[$i] . "%' OR
                                    sizeid LIKE '%" . $keyword[$i] . "%'
                                )";
            } else {
                $criteria = $criteria . " and " . "(
                                    itemname LIKE '%" . $keyword[$i] . "%' OR
                                    barcode LIKE '%" . $keyword[$i] . "%' OR
                                    brand LIKE '%" . $keyword[$i] . "%' OR
                                    model LIKE '%" . $keyword[$i] . "%' OR
                                    sizeid LIKE '%" . $keyword[$i] . "%'
                                                    )";
            }
        }
        $models = Yii::$app->sbccommon->opentable($sql . " " . $criteria . " order by itemname asc limit $limit");
        
         foreach ($models as $model) {
            $suggest[] = array(
                'label' => $model['itemname'] . " -- " . $model['model'] . " -- " . $model['barcode'] . " -- " . $model['sizeid'] . " -- " . $model['cost'],
                'itemname' => $model['brand'] . ' ' . $model['itemname'] . ' ' . $model['part'] . ' ' . $model['model'] . ' ' . $model['sizeid'],
                'value' => $model['barcode'],//$model['itemname'] . ' - ' . $model['barcode'],
                'id' => $model['barcode'],
                'default' => "",
                'barcode' => $model['barcode'],
                'cost' => $model['cost'],
                'rrcost' => $model['cost'],
                'qty' => $model['qty'],
                'disc' => $model['disc'],
                'uom' => $model['uom'],
                'title' => $model['barcode'] . "  " . $model['cost'],
            );             
         }
         return $suggest;
        }
        
        
        
        public static function suggestxxx($keywords, $limit = 25, $doc = '') {

        $keyword = explode(",", $keywords);
        switch ($doc) {
            case 'PO':
            case 'PC':
            case 'PR':
            case 'RR':
            case 'CA':
            case 'DM': {
                    $modulecat = 'purchases';
                    $basedoc = 'RR';
                    $field1 = 'rrcost';
                    $field2 = 'cost';
                    break;
                }
            case 'SO':
            case 'SJ':
            case 'CM':
            case 'TS':
            case 'AJ':
            case 'IS':
            case 'MI': {
                    $modulecat = 'others';
                    $basedoc = 'SJ';
                    $field1 = 'isamt';
                    $field2 = 'amt';
                    break;
                }
            default: {
                    break;
                    $modulecat = 'purchases';
                    $basedoc = 'RR';
                    $field1 = 'rrcost';
                    $field2 = 'cost';
                }
        }
        $client = Yii::$app->session['supplier' . $doc];

        $class = Yii::$app->sbccommon->datareader("select class from client where client='$client'"); //Yii::$app->session['supplier' . $doc];
        switch ($class) {
            case'A': {
                    $price = ' amt ';
                    $disc = ' disc ';
                    break;
                }
            case'B': {
                    $price = ' amt2 ';
                    $disc = ' disc2 ';
                    break;
                }
            case'C': {
                    $price = ' famt ';
                    $disc = ' disc3 ';
                    break;
                }
            case'D': {
                    $price = ' amt4 ';
                    $disc = ' disc4 ';
                    break;
                }
            default: {
                    $price = ' amt ';
                    $disc = ' disc ';
                    break;
                }
        }

        $sql = "select brand, part, model, sizeid, barcode, itemname, $price as cost, qty,uom, disc from item where ";
        $criteria = "";
        for ($i = 0; $i < count($keyword); $i++) {
            if ($criteria == "") {
                $criteria = "(
                                    itemname LIKE '%" . $keyword[$i] . "%' OR
                                    barcode LIKE '%" . $keyword[$i] . "%' OR
                                    brand LIKE '%" . $keyword[$i] . "%' OR
                                    model LIKE '%" . $keyword[$i] . "%' OR
                                    sizeid LIKE '%" . $keyword[$i] . "%'
                                )";
            } else {
                $criteria = $criteria . " and " . "(
                                    itemname LIKE '%" . $keyword[$i] . "%' OR
                                    barcode LIKE '%" . $keyword[$i] . "%' OR
                                    brand LIKE '%" . $keyword[$i] . "%' OR
                                    model LIKE '%" . $keyword[$i] . "%' OR
                                    sizeid LIKE '%" . $keyword[$i] . "%'
                                                    )";
            }
        }
        $models = Yii::$app->sbccommon->opentable($sql . " " . $criteria . " order by itemname asc limit $limit");

        $suggest = array();
        $tablehead = Common::localhead($doc);
        $tablestock = Common::localstock($doc);
        $glhead = Common::glhead();
        $glstock = Common::glstock();

        foreach ($models as $model) {
            $barcode = $model['barcode'];
            $default = Yii::$app->sbccommon->opentable("
                        select t.rrcost,t.cost,t.uom,t.disc from
                        (
                        select head.dateid,stock.$field1 as rrcost,stock.$field2 as cost,stock.uom,stock.disc as disc
                        from lahead as head left join lastock as stock on stock.trno=head.trno
                        where  head.doc='$basedoc' and stock.barcode='$barcode'
                        union all
                        select head.dateid,stock.$field1 as rrcost,stock.$field2 as cost,stock.uom ,stock.disc as disc
                        from lbhead as head left join lbstock as stock on stock.trno=head.trno
                        where  head.doc='$basedoc' and stock.barcode='$barcode'
                        union all
                        select head.dateid,stock.$field1 as rrcost,stock.$field2 as cost,stock.uom ,stock.disc as disc
                        from lchead as head left join lcstock as stock on stock.trno=head.trno
                        where  head.doc='$basedoc' and stock.barcode='$barcode'
                        union all
                        select head.dateid,stock.$field1 as rrcost,stock.$field2 as cost,stock.uom ,stock.disc as disc
                        from glhead as head left join glstock as stock on stock.trno=head.trno
                        left join item on item.itemid=stock.itemid
                        where head.doc='$basedoc' and item.barcode='$barcode'
                        union all
                        select head.dateid,stock.$field1 as rrcost,stock.$field2 as cost,stock.uom ,stock.disc as disc
                        from hglhead as head left join hglstock as stock on stock.trno=head.trno
                        left join item on item.itemid=stock.itemid
                        where head.doc='$basedoc' and item.barcode='$barcode' order by dateid desc limit 1
                        ) as t;
                    ");
            if (empty($default)) {
                if ($modulecat == 'purchases') {
                    $cost = 0;
                    $rrcost = 0;
                    $uom = $model['uom'];
                    $discount = $model['disc'];
                } else {
                    $cost = $model['cost'];
                    $rrcost = $model['cost'];
                    $uom = $model['uom'];
                    $discount = $model['disc'];
                }

                if ((Yii::$app->user->defaultitemprice == 'client')) {
                    $clientid = Client::checkclient($client);
                    $clientitem = new Clientitem();
                    $item = $clientitem->open($clientid, $barcode);
                    if ($item != null) {
                        $cost = $item[0]['amount'];
                        $rrcost = $item[0]['amount'];
//                    $discount=$item[0]['disc'];
                    }
                }
            } else {
                if ($modulecat == 'purchases') {
                    $cost = 0;
                    $rrcost = 0;
                    $uom = $default[0]['uom'];
                    $discount = $default[0]['disc'];
                } else {
                    $cost = $default[0]['cost'];
                    $rrcost = $default[0]['rrcost'];
                    $uom = $default[0]['uom'];
                    $discount = $default[0]['disc'];

                    
                }
                if (Yii::$app->user->defaultitemprice == 'client') {
                        $clientid = Client::checkclient($client);
                        $clientitem = new Clientitem();
                        $item = $clientitem->open($clientid, $barcode);
                        if ($item != null) {
                            $cost = $item[0]['amount'];
                            $rrcost = $item[0]['amount'];
//                    $discount=$item[0]['disc'];
                        }
                    }
            }

            $uom = $model['uom'];

            $suggest[] = array(
                'label' => $model['itemname'] . " -- " . $model['barcode'] . " -- " . $model['sizeid'] . " -- " . $cost,
                'itemname' => $model['brand'] . ' ' . $model['itemname'] . ' ' . $model['part'] . ' ' . $model['model'] . ' ' . $model['sizeid'],
                'value' => $model['itemname'] . ' - ' . $model['barcode'],
                'id' => $model['barcode'],
                'default' => "",
                'barcode' => $model['barcode'],
                'cost' => $cost,
                'rrcost' => $rrcost,
                'qty' => $model['qty'],
                'disc' => $model['disc'],
                'uom' => $uom,
                'title' => $model['barcode'] . "  " . $cost,
            );
        }
        return $suggest;
    }

    public static function suggest_pricebycenter($keywords, $limit = 25, $doc = '') {
        $price = Yii::$app->user->centerprice;                
        $comm = Yii::$app->user->centercomm;
        $icomm = Yii::$app->user->centericomm;
        
        $keyword = explode(",", $keywords);
        $sql = "select brand, itemid, part, model, sizeid, barcode, itemname, round($price,2) as cost,$comm as comm,$icomm as icomm,groupid,category,body,class, qty,uom, disc,disc2,disc3,disc4,class from item where ";
        $criteria = "";
        for ($i = 0; $i < count($keyword); $i++) {
            if ($keyword[$i] != "" || strlen($keyword[$i] != 0)) {
                if ($criteria == "") {
                    $criteria = "(
                                    itemname LIKE '%" . $keyword[$i] . "%' OR
                                    barcode LIKE '%" . $keyword[$i] . "%' OR
                                    brand LIKE '%" . $keyword[$i] . "%' OR
                                    model LIKE '%" . $keyword[$i] . "%' OR
                                    groupid LIKE '%" . $keyword[$i] . "%' OR
                                    part LIKE '%" . $keyword[$i] . "%' OR    
                                    class LIKE '%" . $keyword[$i] . "%' OR    
                                    body LIKE '%" . $keyword[$i] . "%' OR    
                                    sizeid LIKE '%" . $keyword[$i] . "%'
                                )";
                } else {
                    $criteria = $criteria . " and " . "(
                                    itemname LIKE '%" . $keyword[$i] . "%' OR
                                    barcode LIKE '%" . $keyword[$i] . "%' OR
                                    brand LIKE '%" . $keyword[$i] . "%' OR
                                    model LIKE '%" . $keyword[$i] . "%' OR
                                    groupid LIKE '%" . $keyword[$i] . "%' OR
                                    part LIKE '%" . $keyword[$i] . "%' OR    
                                    class LIKE '%" . $keyword[$i] . "%' OR    
                                    body LIKE '%" . $keyword[$i] . "%' OR                                            
                                    sizeid LIKE '%" . $keyword[$i] . "%'
                                                    )";
                }
            } else {
                $criteria = ' 1 ';
            }
        }
        $models = Yii::$app->sbccommon->opentable($sql . " " . $criteria . " order by itemname asc limit $limit");
        $suggest = array();
        foreach ($models as $model) {
            $suggest[] = array(
                'label' => $model['part']. " -- " .$model['model'] . " -- " . $model['class'] . " -- " . $model['brand'] . " -- " . $model['itemname'] . " -- " . $model['body']  . " -- " . $model['sizeid'],
                //'itemname' => $model['brand'] . ' ' . $model['itemname'] . ' ' . $model['part'] . ' ' . $model['model'] . ' ' . $model['sizeid'],
                'itemname' => $model['part'] . ' ' . $model['model'] . ' '. $model['class'] . ' ' . $model['brand'] . ' ' . $model['itemname'] . ' ' . $model['body'],
                'value' => $model['barcode'],//$model['brand'] . ' - ' . $model['itemname'] . ' - '. $model['part'] . ' - ' . $model['sizeid'] . ' - ' . $model['barcode'],
                'id' => $model['itemid'],
                'default' => "",
                'barcode' => $model['barcode'],
                'cost' => $model['cost'],
                'qty' => $model['qty'],
                'groupid'=>$model['groupid'],
                'disc' => $model['disc'],
                'uom' => $model['uom'],
                'itemid' => $model['itemid'],
                'title' => $model['barcode'],
                'category' => $model['category'],
                'comm' => $model['comm'],
                'icomm' => $model['icomm'],
            );
        }
        return $suggest;
    }

    
    
    public static function suggest_item($keywords, $limit = 25, $doc = '') {

        $keyword = explode(",", $keywords);
        $sql = "select brand, itemid, part, model, sizeid, barcode, itemname, cost as cost,groupid,category,body, qty,uom, disc,disc2,disc3,disc4,class from item where ";
        $criteria = "";
        for ($i = 0; $i < count($keyword); $i++) {
            if ($keyword[$i] != "" || strlen($keyword[$i] != 0)) {
                if ($criteria == "") {
                    $criteria = "(
                                    itemname LIKE '%" . $keyword[$i] . "%' OR
                                    barcode LIKE '%" . $keyword[$i] . "%' OR
                                    brand LIKE '%" . $keyword[$i] . "%' OR
                                    model LIKE '%" . $keyword[$i] . "%' OR
                                    groupid LIKE '%" . $keyword[$i] . "%' OR
                                    part LIKE '%" . $keyword[$i] . "%' OR
                                    class LIKE '%" . $keyword[$i] . "%' OR
                                    body LIKE '%" . $keyword[$i] . "%' OR                                        
                                    sizeid LIKE '%" . $keyword[$i] . "%'
                                )";
                } else {
                    $criteria = $criteria . " and " . "(
                                    itemname LIKE '%" . $keyword[$i] . "%' OR
                                    barcode LIKE '%" . $keyword[$i] . "%' OR
                                    brand LIKE '%" . $keyword[$i] . "%' OR
                                    model LIKE '%" . $keyword[$i] . "%' OR
                                    groupid LIKE '%" . $keyword[$i] . "%' OR
                                    part LIKE '%" . $keyword[$i] . "%' OR
                                    class LIKE '%" . $keyword[$i] . "%' OR
                                    body LIKE '%" . $keyword[$i] . "%' OR                                                                                
                                    sizeid LIKE '%" . $keyword[$i] . "%'
                                                    )";
                }
            } else {
                $criteria = ' 1 ';
            }
        }
        $models = Yii::$app->sbccommon->opentable($sql . " " . $criteria . " order by itemname asc limit $limit");
        switch (Common::getcompanyid()){
            case 1: 
                  $suggest = array();
        foreach ($models as $model) {
            $suggest[] = array(
                'label' => $model['brand']. " -- " .$model['itemname'] . " -- " . $model['part'] . " -- " . $model['sizeid'] . " -- " . $model['barcode'] . " -- " . $model['body'] . " -- " . $model['category'],
                //'itemname' => $model['brand'] . ' ' . $model['itemname'] . ' ' . $model['part'] . ' ' . $model['model'] . ' ' . $model['sizeid'],
                'itemname' => $model['brand'] . ' ' . $model['itemname'] . ' ' . $model['part'] . ' ' . $model['model'],
                'value' => $model['brand'] . ' - ' . $model['itemname'] . ' - '. $model['part'] . ' - ' . $model['sizeid'] . ' - ' . $model['barcode'],
                'id' => $model['itemid'],
                'default' => "",
                'barcode' => $model['barcode'],
                'cost' => $model['cost'],
                'qty' => $model['qty'],
                'groupid'=>$model['groupid'],
                'disc' => $model['disc'],
                'uom' => $model['uom'],
                'itemid' => $model['itemid'],
                'title' => $model['barcode'],
                'category' => $model['category'],
            );
        }
        return $suggest;
                break;
            default:
                  $suggest = array();
        foreach ($models as $model) {
            $suggest[] = array(
                'label' => $model['brand']. " -- " .$model['itemname'] . " -- " . $model['part'] . " -- " . $model['sizeid'] . " -- " . $model['barcode'] . " -- " . $model['body'] . " -- " . $model['category'],
                'itemname' => $model['brand'] . ' ' . $model['itemname'] . ' ' . $model['part'] . ' ' . $model['model'] . ' ' . $model['sizeid'],
                'value' => $model['brand'] . ' - ' . $model['itemname'] . ' - '. $model['part'] . ' - ' . $model['sizeid'] . ' - ' . $model['barcode'],
                'id' => $model['itemid'],
                'default' => "",
                'barcode' => $model['barcode'],
                'cost' => $model['cost'],
                'qty' => $model['qty'],
                'groupid'=>$model['groupid'],
                'disc' => $model['disc'],
                'uom' => $model['uom'],
                'itemid' => $model['itemid'],
                'title' => $model['barcode'],
                'category' => $model['category'],
            );
        }
        return $suggest;
                break;
                
                
            case 3: 
        $suggest = array();
        foreach ($models as $model) {
            $suggest[] = array(
                'label' => $model['part']. " -- " .$model['model'] . " -- " . $model['class'] . " -- " . $model['brand'] . " -- " . $model['itemname'] . " -- " . $model['body']  . " -- " . $model['sizeid'],
                'itemname' => $model['brand'] . ' ' . $model['itemname'] . ' ' . $model['part'] . ' ' . $model['model'] . ' ' . $model['sizeid'],
                'value' => $model['brand'] . ' - ' . $model['itemname'] . ' - '. $model['part'] . ' - ' . $model['sizeid'] . ' - ' . $model['barcode'],
                'id' => $model['itemid'],
                'default' => "",
                'barcode' => $model['barcode'],
                'cost' => $model['cost'],
                'qty' => $model['qty'],
                'groupid'=>$model['groupid'],
                'disc' => $model['disc'],
                'uom' => $model['uom'],
                'itemid' => $model['itemid'],
                'title' => $model['barcode'],
                'category' => $model['category'],
            );
        }
        return $suggest;
                break;
      }
      
    }

        public static function suggest_item_field($keywords,$field, $limit = 25) {

        $keyword = explode(",", $keywords);
        $sql = "select distinct $field from item where ";
        $criteria = "";
        for ($i = 0; $i < count($keyword); $i++) {
            if ($keyword[$i] != "" || strlen($keyword[$i] != 0)) {
                if ($criteria == "") {
                    $criteria = "(
                                    $field LIKE '%" . $keyword[$i] . "%'
                                )";
                } else {
                    $criteria = $criteria . " and " . "(
                                    $field LIKE '%" . $keyword[$i] . "%' 
                                                    )";
                }
            } else {
                $criteria = ' 1 ';
            }
        }
        $models = Yii::$app->sbccommon->opentable($sql . " " . $criteria . " order by $field asc limit $limit");

        $suggest = array();
        foreach ($models as $model) {
            $suggest[] = array(
                'label' => $model[$field],
                $field => $model[$field],
                'value' => $model[$field],
                'id' => $model[$field],
                'default' => "",
                'title' => $model[$field],
            );
        }
        return $suggest;
    }

    public static function getlast_barcode($pref) {  //to get last item with specific prefix
        $length = strlen($pref);
        $common=new Common();
        $Blength=$common->barcodelength();
        $barcode = Yii::$app->sbccommon->datareader("select barcode from item where left(barcode,$length)='$pref' and length(barcode)=$Blength order by barcode desc limit 1");
        return $barcode;
    }

    public static function getlast_barcode_() {
        return Yii::$app->sbccommon->datareader("select barcode from item order by itemid desc limit 1");
    }

    public static function itemid($barcode) {
        $item = Yii::$app->sbccommon->datareader("select itemid from item where barcode='$barcode'");
        if ($item != null || !empty($item)) {
            return $item;
        } else {
            return false;
        }
    }

    public static function barcode($itemid) {
        $item = Yii::$app->sbccommon->datareader("select barcode from item where itemid='$itemid'");
        if ($item != null || !empty($item)) {
            return $item;
        } else {
            return false;
        }
    }

    public static function getUom($barcode) {
        $data = Yii::$app->sbccommon->opentable("SELECT  uom.uom, uom.factor,uom.discount as disc,uom.amt  from item left join uom on uom.itemid=item.itemid where item.barcode='$barcode' order by factor asc");
        if (!empty($data)) {
            if ($data[0]['uom'] != null) {
                $uom = array();
                foreach ($data as $key => $data_) {
                    $uom1 = array('id' => strtoupper($data_['uom']), 'uom' => strtoupper($data_['uom']), 'factor' => $data_['factor'],'amt'=>$data_['amt'],'disc'=>$data_['disc']);
                    array_push($uom, $uom1);
                    
                }
                return $uom;
            } else {
                $data = Yii::$app->sbccommon->opentable("SELECT  itemid, uom,discount from  item where barcode='$barcode'");
                $uom = array();
                if (!empty($data)) {
                    foreach ($data as $key => $data_) {

                        $uom1 = array('id' => strtoupper($data_['uom']), 'uom' => strtoupper($data_['uom']));
                        array_push($uom, $uom1);
                    }
                    if (!empty($uom)) {
                        return $uom;
                    }
                } else {
                    return $uom;
                }
            }
        } else {
            return $data;
        }
    }

    public static function getFactor($barcode, $uom) {

        $data = Yii::$app->sbccommon->datareader("SELECT  ifNull(round(uom.factor,0),1) as factor  from item left join uom on uom.itemid=item.itemid where item.barcode='$barcode' and uom.uom='$uom'");
        if ($data) {
            return $data;
        } else {
            return 1;
        }
    }
    
    
        public static function getItemUomSellingPrice($barcode, $uom) {
            $data = Yii::$app->sbccommon->opentable("SELECT  uom.discount,uom.amt from item left join uom on uom.itemid=item.itemid where item.barcode='$barcode' and uom.uom='$uom'");        
            return $data;            
        }


   
    
    public static function getItembal($barcode) {

        $bal = Yii::$app->sbccommon->opentable("SELECT  sum(round(rrstatus.bal,0)) as bal, warehouse.client,warehouse.clientname from item
                                                left join rrstatus on rrstatus.itemid=item.itemid
                                                left join client as warehouse on warehouse.clientid=rrstatus.whid
                                                where item.barcode='$barcode' and rrstatus.bal>0 group by warehouse.client,warehouse.clientname 
                ");
        return $bal;
        
        
    }

    
    public static function getLatestPrice($doc,$barcode,$client){
        switch ($doc) {
            case 'PO': 
            case 'RR':
            case 'PC':
            case 'PR':    
            case 'DM':
            case 'IS':
            case 'AJ':
                $displayamt='rrcost';
                $computeamt='cost';
                $doc2='RR';
                break;
            case 'CA':
                $displayamt='rrcost';
                $computeamt='cost';
                $doc2='CA';
                break;
                
            default:
                $displayamt='isamt';
                $computeamt='amt';
                $doc2='SJ';
                break;
        }
        
        switch ($doc) {
            case 'PC':
            case 'PR':    
            case 'IS':    
            case 'AJ':
               switch (Common::getcompanyid()){
                case 3://cellboy
                   $sql = "select item.cost as rrcost,item.cost as cost,item.disc,item.uom,item.supplier,item.comm,item.icomm from item where  item.barcode='$barcode'";                    
                    break;
                case 1: //gameline
                  $sql = "select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from lahead as head left join lastock as stock on stock.trno=head.trno where head.doc='IS' and stock.barcode='$barcode' and stock.$displayamt<>0
                          union all 
                          select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from lbhead as head left join lbstock as stock on stock.trno=head.trno where head.doc='IS' and stock.barcode='$barcode' and stock.$displayamt<>0
                          union all 
                          select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from lchead as head left join lcstock as stock on stock.trno=head.trno where head.doc='IS' and stock.barcode='$barcode' and stock.$displayamt<>0
                          union all 
                          select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from glhead as head left join glstock as stock on stock.trno=head.trno left join item on item.itemid=stock.itemid left join client on client.clientid=head.clientid where head.doc='IS' and item.barcode='$barcode' and stock.$displayamt<>0
                          union all
                          select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from hglhead as head left join hglstock as stock on stock.trno=head.trno left join item on item.itemid=stock.itemid left join client on client.clientid=head.clientid where head.doc='IS' and item.barcode='$barcode' and stock.$displayamt<>0
                          order by dateid desc,trno desc limit 1";                                    
                    break;
                default:
                  $sql = "select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from lahead as head left join lastock as stock on stock.trno=head.trno where head.doc='$doc2' and stock.barcode='$barcode' and stock.$displayamt<>0
                          union all 
                          select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from lbhead as head left join lbstock as stock on stock.trno=head.trno where head.doc='$doc2' and stock.barcode='$barcode' and stock.$displayamt<>0
                          union all 
                          select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from lchead as head left join lcstock as stock on stock.trno=head.trno where head.doc='$doc2' and stock.barcode='$barcode' and stock.$displayamt<>0
                          union all 
                          select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from glhead as head left join glstock as stock on stock.trno=head.trno left join item on item.itemid=stock.itemid left join client on client.clientid=head.clientid where head.doc='$doc2' and item.barcode='$barcode' and stock.$displayamt<>0
                          union all
                          select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from hglhead as head left join hglstock as stock on stock.trno=head.trno left join item on item.itemid=stock.itemid left join client on client.clientid=head.clientid where head.doc='$doc2' and item.barcode='$barcode' and stock.$displayamt<>0
                          order by dateid desc,trno desc limit 1";                                    
                    break;
               }                
                break;
            case 'SJ':  
            case 'SO' :    
               switch (Common::getcompanyid()){
                case 4: //pioneer
                     $sql = "select uom.amt,uom.uom,uom.discount from item left join uom on uom.itemid=item.itemid and uom.uom=item.uom where item.barcode='$barcode'";  
                     break;

                case 1:  //gameline
                      return array($displayamt=>"0.0",$computeamt=>"0.0",'disc'=>"",'uom'=>"");                
                      break;

                default:                     
                     $sql = "select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from lahead as head left join lastock as stock on stock.trno=head.trno where head.doc='$doc2' and stock.barcode='$barcode' and head.client='$client' and stock.$displayamt<>0
                     union all 
                     select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from lbhead as head left join lbstock as stock on stock.trno=head.trno where head.doc='$doc2' and stock.barcode='$barcode' and head.client='$client' and stock.$displayamt<>0
                     union all 
                     select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from lchead as head left join lcstock as stock on stock.trno=head.trno where head.doc='$doc2' and stock.barcode='$barcode' and head.client='$client' and stock.$displayamt<>0
                     union all 
                     select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from glhead as head left join glstock as stock on stock.trno=head.trno left join item on item.itemid=stock.itemid left join client on client.clientid=head.clientid where head.doc='$doc2' and item.barcode='$barcode' and client.client='$client' and stock.$displayamt<>0
                     union all
                     select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from hglhead as head left join hglstock as stock on stock.trno=head.trno left join item on item.itemid=stock.itemid left join client on client.clientid=head.clientid where head.doc='$doc2' and item.barcode='$barcode' and client.client='$client' and stock.$displayamt<>0
                     order by dateid desc,trno desc limit 1";                      
                     break;
                  }
                break;
            case 'PO':
               switch (Common::getcompanyid()){
                  case 2: //panda
                  $sql = "select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from pohead as head left join postock as stock on stock.trno=head.trno where head.doc='$doc' and stock.barcode='$barcode' and head.client='$client' and stock.$displayamt<>0
                  union all 
                  select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from hpohead as head left join hpostock as stock on stock.trno=head.trno where head.doc='$doc' and stock.barcode='$barcode' and head.client='$client' and stock.$displayamt<>0
                    order by dateid desc,trno desc limit 1";
                      break;
                  default:                     
                  $sql = "select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from lahead as head left join lastock as stock on stock.trno=head.trno where head.doc='$doc2' and stock.barcode='$barcode' and head.client='$client' and stock.$displayamt<>0
                  union all 
                  select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from lbhead as head left join lbstock as stock on stock.trno=head.trno where head.doc='$doc2' and stock.barcode='$barcode' and head.client='$client' and stock.$displayamt<>0
                  union all 
                  select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from lchead as head left join lcstock as stock on stock.trno=head.trno where head.doc='$doc2' and stock.barcode='$barcode' and head.client='$client' and stock.$displayamt<>0
                  union all 
                  select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from glhead as head left join glstock as stock on stock.trno=head.trno left join item on item.itemid=stock.itemid left join client on client.clientid=head.clientid where head.doc='$doc2' and item.barcode='$barcode' and client.client='$client' and stock.$displayamt<>0
                  union all
                  select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from hglhead as head left join hglstock as stock on stock.trno=head.trno left join item on item.itemid=stock.itemid left join client on client.clientid=head.clientid where head.doc='$doc2' and item.barcode='$barcode' and client.client='$client' and stock.$displayamt<>0
                  order by dateid desc,trno desc limit 1";

                      break;
                  }
                break;
                
            default:  
                  $sql = "select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from lahead as head left join lastock as stock on stock.trno=head.trno where head.doc='$doc2' and stock.barcode='$barcode' and head.client='$client' and stock.$displayamt<>0
                  union all 
                  select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from lbhead as head left join lbstock as stock on stock.trno=head.trno where head.doc='$doc2' and stock.barcode='$barcode' and head.client='$client' and stock.$displayamt<>0
                  union all 
                  select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from lchead as head left join lcstock as stock on stock.trno=head.trno where head.doc='$doc2' and stock.barcode='$barcode' and head.client='$client' and stock.$displayamt<>0
                  union all 
                  select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from glhead as head left join glstock as stock on stock.trno=head.trno left join item on item.itemid=stock.itemid left join client on client.clientid=head.clientid where head.doc='$doc2' and item.barcode='$barcode' and client.client='$client' and stock.$displayamt<>0
                  union all
                  select head.trno,head.dateid,stock.$displayamt,stock.$computeamt,stock.disc,stock.uom from hglhead as head left join hglstock as stock on stock.trno=head.trno left join item on item.itemid=stock.itemid left join client on client.clientid=head.clientid where head.doc='$doc2' and item.barcode='$barcode' and client.client='$client' and stock.$displayamt<>0
                  order by dateid desc,trno desc limit 1";
                
                break;
        }

        $data= Yii::$app->sbccommon->opentable($sql);
        
         if($data!=null){
            return $data[0];
        }else{
            return array($displayamt=>"0",$computeamt=>"0",'disc'=>"",'uom'=>"");
        }
    }//END FUNCTION getLatestPrice
    
    public static function getItem($barcode) {
         switch(Common::getcompanyid()){
             case 3:  //cellboy
                 $qry="
                select brand, part, model,sizeid, barcode,
                concat(brand, itemname, part, model, sizeid) as itemname,
                cost as cost, 1 as qty,1 as iss,uom, disc,wh,".Yii::$app->user->centerprice." as amt
                from item
                where barcode='$barcode'
                ";
                 
                 break;
             default:
                 $qry="
                select brand, part, model,sizeid, barcode,
                concat(brand, itemname, part, model, sizeid) as itemname,
                cost as cost, 1 as qty,1 as iss,uom, disc,wh,amt
                from item
                where barcode='$barcode'
                ";
                 break;
             case 4:
                 $qry="
                select item.brand, item.part, item.model,item.sizeid, item.barcode,
                concat(item.brand, item.itemname, item.part, item.model, item.sizeid) as itemname,
                item.cost as cost, 1 as qty,1 as iss,item.wh,uom.amt,uom.uom,uom.discount
                from item left join uom on uom.itemid=item.itemid
                where barcode='$barcode'
                ";
                 break;
         }
        
        return Yii::$app->sbccommon->opentable($qry);
    }

    public function openitemxx($itemid) {
        $data = Yii::$app->sbccommon->opentable("
                select item.itemid, barcode, itemname, groupid, part, model, brand,
                class, body, sizeid, category, round(cost,2) as cost, uom,minimum,maximum,supplier, qty,
                amt, amt2, famt, amt4, disc, disc2,disc3,disc4, wh, isinactive,isimport, title, subtitle,line,itemrem
                from item as item
                where item.itemid='$itemid'
                ");
        if (!empty($data)) {
            return $data;
        }
    }
    
     public function openitem($itemid) {        
        $qry = "select 
                item.pwd,item.senior,item.color,item.critical,item.reorder,
                item.defaultwh,item.shortname,item.invbal_uom,ifnull(cat.cat_desc,'') as cat_desc,
                item.f_cattagging,item.setfrontend,item.fdiscounted, item.fqty,item.promostart,
                item.promoend,item.saleprice, item.f_type,item.f_mainmaterial,item.f_highlights,
                item.f_proddesc,item.f_whatsbox,item.f_freeitems,item.f_videourl,item.f_notes,
                item.f_delivopt, item.f_shippingmin,item.f_shippingmax,item.f_dimensions,item.f_prodweight,
                item.f_packheight, item.f_packlength,item.f_packweight,item.f_packwidth,item.f_warrantytype,
                item.f_warrantperiod,item.f_warrantpolicy, ifnull(item_gallery.img1,'') as g1,
                ifnull(item_gallery.img2,'') as g2, ifnull(item_gallery.img3,'') as g3,
                ifnull(item_gallery.img4,'') as g4, ifnull(item_gallery.img5,'') as g5,
                ifnull(item_gallery.img6,'') as g6, ifnull(item_gallery.img7,'') as g7,
                ifnull(item_gallery.img8,'') as g8, item.itemid,item.note, item.barcode,
                item.itemname,ifnull(stockgrp.stockgrp_name,'') as groupid,
                item.groupid as stockgrpid, ifnull(pmaster.part_name,'') as part,
                item.part as partid, ifnull(mmaster.model_name,'') as model,
                item.model as modelid, item.brand,sum(rrstatus.bal) as bal,
                item.body, item.sizeid, item.category, round(item.cost,2) as cost,
                item.uom,item.minimum,item.maximum,item.supplier, item.qty, item.amt,
                item.amt2, item.famt, item.amt4, item.disc, item.disc2,item.disc3,
                item.disc4, item.wh, item.isinactive,item.isimport, item.title,
                item.subtitle,item.line,itimages.picture,item.itemrem,item.specs,
                item.asset,item.liability,item.revenue,item.expense,item.expiryday,itemclass.cl_name as class,
                item.class as classid, 
                item.amt3,item.amt5,item.disc5,item.amt6,item.disc6,item.amt7,
                item.disc7,item.amt8,item.disc8, item.amt9,item.disc9,item.amt10,item.disc10,
                item.amt11,item.disc11,item.amt12,item.disc12, item.amt13,item.disc13,item.amt14,
                item.disc14,item.amt15,item.disc15, sgrp.id as sgrpid,sgrp.scat_grp as sgrp,
                item.markup, item.markup2, item.markup3, item.markup4, item.markup5, item.markup6, 
                item.uom,item.uom1, item.uom2, item.uom3, item.uom4, item.uom5, item.uom6,
                item.factor1, item.factor2, item.factor3, item.factor4, item.factor5, item.factor6,
                date(item.effectdate) as effectdate, item.grp, item.packaging, item.linkplu,item.othcode, item.suppcodes,
                date(item.dateupdated) as dateupdated, item.qty, item.supplier, item.mode, item.istaxable,
                item.ispostitem, item.isinactive, item.issenior, item.iszerorated, item.isprintable,
                item.hierarchy, item.linkdept, item.points, item.acceptloss, item.cost,
                item.cooking_time, item.prep_time,
                ifnull(cgrp.cat_grp,'') as catgrp,ifnull(tgrp.term_grp,'') as termgrp,
                ifnull(mgrp.main_grp,'') as maingrp,commgrp.name as commgrp,item.sc_commgrpid as commgrpid,item.itemcomm,item.itemhandling,
                item.uv_priority,item.uv_department,item.uv_suppitemcode,item.isvat,item.isexempt,gm_printuom,
                ifnull(uv_principal.name,'') as uvprincipal,item.uv_principal as uvprincipalid, item.purchase_uom,
                item.fg_isfinishedgood, item.fg_customer as fg_client, ifnull(fgc.clientname,'') as fg_clientname, 
                item.fg_prodtype, item.fg_combi, item.fg_transform,
                item.fg_addspecs, item.fg_punchholesize, item.fg_sealing, item.fg_plasticcolor, item.fg_bfilmdet,
                item.fg_treatment,
                item.payrate,item.payqty,
                item.fg_revision, item.fg_templateno, item.fg_updated, item.fg_effective,
                item.fg_jowidth, item.fg_jowidthuom,
                item.fg_jolength, item.fg_jolengthuom, item.fg_thickness, item.fg_thicknessuom,
                item.fg_actualwidth, item.fg_actualwidthuom, item.fg_actuallength,
                item.fg_actuallengthuom, item.fg_colornum, item.fg_repeatlength, item.fg_repeatlengthuom,
                item.fg_outnum, item.fg_outnumuom, item.fg_bfilmwidth,
                item.fg_bfilmwidthuom, item.fg_thickness2, item.fg_thickness2uom, item.fg_gramppiece1,item.fg_gramppiece2,
                item.fg_isequipmenttool,item.itemhandling2,item.fg_serial,item.fg_diameter,
                item.fgunit_length,item.fgunit_width,item.fgunit_diameter,item.fgunit_thickness
                from item
                left join client as fgc on item.fg_customer = fgc.client
                left join commission_masterfile as commgrp on commgrp.id = item.sc_commgrpid
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid
                left join subcatgrp as sgrp on sgrp.id = item.sc_subcatid
                left join catgrp as cgrp on cgrp.id = sgrp.cgid
                left join termgrp as tgrp on tgrp.id = cgrp.tgid
                left join maingrp as mgrp on mgrp.id = tgrp.mgid
                left join itimages on itimages.codeid = item.itemid
                left join rrstatus on rrstatus.itemid=item.itemid
                left join item_gallery on item_gallery.itemid = item.itemid
                left join frontend_categories as cat on cat.catid = item.f_cattagging
                left join item_class as itemclass on itemclass.cl_id = item.class
                left join part_masterfile as pmaster on pmaster.part_id = item.part
                left join model_masterfile as mmaster on mmaster.model_id = item.model
                left join uv_principal on item.uv_principal = uv_principal.line
                where item.itemid='$itemid'
                group by item.itemid, item.barcode, item.itemname, item.groupid,
                item.part, item.model, item.brand, item.class, item.body, item.sizeid, item.category,
                round(item.cost,2), item.uom,item.minimum,item.maximum,item.supplier, item.qty,
                item.amt, item.amt2, item.famt, item.amt4, item.disc, item.disc2,item.disc3,
                item.disc4, item.wh, item.isinactive,item.isimport, item.title, item.subtitle,
                item.line,item.picture, item.itemrem,item.specs";     
        $data = Yii::$app->sbccommon->opentable($qry);
        
        if (!empty($data)) {
            return $data;
        }//end if
    }//end item
    

    
    public function insertitem($data){
        $user=Yii::$app->session['loggeduser']['username'];
        $center=Yii::$app->session['loggeduser']['center'];
        $data->amt = str_replace(",", "", $data->amt);
        $data->amt2 = str_replace(",", "", $data->amt2);
        $data->famt = str_replace(",", "", $data->famt);
        $data->amt4 = str_replace(",", "", $data->amt4);
        $data->itemname=preg_replace( "/'/", "`", $data->itemname);
        $data->brand=preg_replace( "/'/", "`", $data->brand);
        $data->model=preg_replace( "/'/", "`", $data->model);
        $data->part=preg_replace( "/'/", "`", $data->part);
        $data->class=preg_replace( "/'/", "`", $data->class);
        $data->groupid=preg_replace( "/'/", "`", $data->groupid);
        $data->body=preg_replace( "/'/", "`", $data->body);
        $data->sizeid=preg_replace( "/'/", "`", $data->sizeid);
        $data->itemrem=preg_replace( "/'/", "`", $data->itemrem);
        $data->minimum = str_replace(",", "", $data->minimum);
        $data->maximum = str_replace(",", "", $data->maximum);
        $data->cost = str_replace(",", "", $data->cost);
        $data->supplier=preg_replace( "/'/", "`", $data->supplier);
        $data->note=preg_replace( "/'/", "`", $data->note);
        
        if ($data->reorder == '' || $data->reorder == 0 || $data->reorder == null){
            $data->reorder = '0.00';
        }//end if

        if ($data->critical == '' || $data->critical == 0 || $data->critical == null){
            $data->critical = '0.00';
        }//end if

        $data->color=preg_replace( "/'/", "`", $data->color);
        $data->senior=preg_replace( "/'/", "`", $data->senior);
        $data->pwd=preg_replace( "/'/", "`", $data->pwd);

        if ($data->effdate == '' || $data->effdate == null){ $data->effdate = '0000-00-00 00:00:00';}
        if ($data->dateupdated == '' || $data->dateupdated == null){$data->dateupdated = '0000-00-00 00:00:00';}
        if ($data->quantity == '' || $data->quantity == 0 || $data->quantity == null){$data->quantity = '0';} 
        if ($data->factor1 == '' || $data->factor1 == 0 || $data->factor1 == null){$data->factor1 = '0.00';} 
        if ($data->factor2 == '' || $data->factor2 == 0 || $data->factor2 == null){$data->factor2 = '0.00';} 
        if ($data->factor3 == '' || $data->factor3 == 0 || $data->factor3 == null){$data->factor3 = '0.00';} 
        if ($data->factor4 == '' || $data->factor4 == 0 || $data->factor4 == null){$data->factor4 = '0.00';} 
        if ($data->factor5 == '' || $data->factor5 == 0 || $data->factor5 == null){$data->factor5 = '0.00';} 
        if ($data->factor6 == '' || $data->factor6 == 0 || $data->factor6 == null){$data->factor6 = '0.00';} 

        $data->grp=preg_replace( "/'/", "`", $data->grp);
        $data->packaging=preg_replace( "/'/", "`", $data->packaging);        
        $data->otherbar=preg_replace( "/'/", "`", $data->otherbar);
        $data->supbar=preg_replace( "/'/", "`", $data->supbar);
        $data->mode=preg_replace( "/'/", "`", $data->mode);
        $data->hierparent=preg_replace( "/'/", "`", $data->hierparent);
        $data->linkdept=preg_replace( "/'/", "`", $data->linkdept);
        $data->points=preg_replace( "/'/", "`", $data->points);
        $data->currentcost=preg_replace( "/'/", "`", $data->currentcost);
        $data->cooktime=preg_replace( "/'/", "`", $data->cooktime);
        $data->preptime=preg_replace( "/'/", "`", $data->preptime);

        $data->uvpriority=preg_replace( "/'/", "`", $data->uvpriority);
        $data->uvdepartment=preg_replace( "/'/", "`", $data->uvdepartment);
        $data->suppitemcode=preg_replace( "/'/", "`", $data->suppitemcode);

        $data->uvprincipal=preg_replace("/'/","`", $data->uvprincipal);
        $data->uvprincipalid=preg_replace("/'/","`", $data->uvprincipalid);

        if ($data->printuom == '' || $data->printuom == 0 || $data->printuom == null){
            $data->printuom = '';
        }else{
            $data->printuom=preg_replace( "/'/", "`", $data->printuom);
        }//end f

        $asset = $data->asset;
        $liability = $data->liability;
        $revenue = $data->revenue;
        $expense = $data->expense;

            
        $qry = "insert into item (barcode,itemname,brand,model,part,itemrem,class,groupid,body,sizeid,note,
        amt,amt2,famt,amt4,disc,disc2,disc3,disc4,category,uom,minimum,maximum,supplier,cost,isinactive,isimport,createby,center,
        asset,liability,revenue,expense,expiryday,fqty,promostart,promoend,saleprice,f_type,f_mainmaterial,f_highlights,
        f_proddesc,f_whatsbox,f_freeitems,f_videourl,f_notes,f_delivopt,f_shippingmin,f_shippingmax,f_dimensions,f_prodweight,f_packheight,
        f_packlength,f_packweight,f_packwidth,f_warrantytype,f_warrantperiod,f_warrantpolicy,shortname,
        amt5,disc5,amt6,disc6,amt7,disc7,amt8,disc8,amt9,disc9,amt10,disc10,amt11,disc11,amt12,disc12,
        amt13,disc13,amt14,disc14,amt15,disc15,sc_subcatid,sc_commgrpid,defaultwh,itemhandling,itemcomm,
        uv_priority,uv_department,uv_suppitemcode,isvat,isexempt,gm_printuom,uv_principal,purchase_uom,
        fg_revision, fg_templateno, fg_updated, fg_effective, fg_customer, fg_prodtype, fg_combi, fg_transform, fg_addspecs, fg_punchholesize,
        fg_sealing, fg_plasticcolor, fg_bfilmdet, fg_treatment,payrate, payqty, fg_jowidth, fg_jowidthuom, fg_jolength, fg_jolengthuom,
        fg_thickness, fg_thicknessuom, fg_actualwidth, fg_actualwidthuom, fg_actuallength, fg_actuallengthuom, fg_colornum, fg_repeatlength,
        fg_repeatlengthuom, fg_outnum, fg_outnumuom, fg_bfilmwidth, fg_bfilmwidthuom, fg_thickness2, fg_thickness2uom, 
        fg_gramppiece1, fg_gramppiece2,fg_isequipmenttool,fg_numcolors,fg_diameter,itemhandling2,fg_serial,fgunit_diameter)
        values('$data->barcode','$data->itemname','$data->brand',
        '$data->modelid','$data->partid','$data->itemrem','$data->class','$data->stockgrpid',
        '$data->body','$data->sizeid','$data->note',
        '$data->amt','$data->amt2','$data->famt','$data->amt4',
        '$data->disc','$data->disc2','$data->disc3','$data->disc4',
        '$data->category','$data->uom','$data->minimum','$data->maximum','$data->supplier','$data->cost','$data->isinactive',
        '$data->isimport','$user','$center','$asset','$liability','$revenue','$expense','$data->daystoexpire',
        '$data->fqty','$data->promostart','$data->promoend','$data->fsaleprice','$data->ftype',
        '$data->fmainmaterial','$data->fhighlights','$data->fproddesc','$data->fwhatsbox','$data->ffreeitems',
        '$data->fvideourl','$data->fprodnotes','$data->fdeliveryopt','$data->fminshipping','$data->fmaxshipping',
        '$data->fdimensions','$data->fprodweight','$data->fpackheight','$data->fpacklength','$data->fpackweight',
        '$data->fpackwidth','$data->fwarrantytype','$data->fwarrantyperiod','$data->fwarrantypolicy','$data->itemshortname',
        '$data->amt5','$data->disc5','$data->amt6','$data->disc6','$data->amt7','$data->disc7','$data->amt8',
        '$data->disc8','$data->amt9','$data->disc9','$data->amt10','$data->disc10','$data->amt11','$data->disc11',
        '$data->amt12','$data->disc12','$data->amt13','$data->disc13','$data->amt14',
        '$data->disc14','$data->amt15','$data->disc15','$data->subcatid','$data->commgrpid','$data->defaultwh',
        '$data->itemhandling','$data->itemcomm','$data->uvpriority','$data->uvdepartment','$data->suppitemcode','$data->isvat','$data->isexempt',
        '$data->printuom','$data->uvprincipalid','$data->uvpurchaseuom',
        '$data->fg_revision', '$data->fg_templateno', '$data->fg_updated', '$data->fg_effective', '$data->fg_client',
        '$data->fg_prodtype', '$data->fg_combi', '$data->fg_transform', '$data->fg_addspecs',
        '$data->fg_punchholesize', '$data->fg_sealing', '$data->fg_plasticcolor',
        '$data->fg_bfilmdet', '$data->fg_treatment',
        '$data->payrate', '$data->payqty',
        '$data->fg_jowidth','$data->fg_jowidthuom', '$data->fg_jolength',
        '$data->fg_jolengthuom', '$data->fg_thickness', '$data->fg_thicknessuom', '$data->fg_actualwidth',
        '$data->fg_actualwidthuom', '$data->fg_actuallength',
        '$data->fg_actuallengthuom', '$data->fg_colornum', '$data->fg_repeatlength',
        '$data->fg_repeatlengthuom', '$data->fg_outnum','$data->fg_outnumuom',
        '$data->fg_bfilmwidth', '$data->fg_bfilmwidthuom', '$data->fg_thickness2', '$data->fg_thickness2uom',
        '$data->fg_gramppiece1', '$data->fg_gramppiece2','$data->fg_isequipmenttool',
        '$data->fg_numcolors','$data->fg_diameter','$data->itemhandling2','$data->fg_serial',
        '$data->fgunit_diameter')";

        $insert = Yii::$app->sbccommon->execqry($qry);

        $itemid = Item::itemid($data->barcode);
        Log::writelog("stockcard", $itemid, "Created new Item", $data->barcode,Yii::$app->session['loggeduser']['username']); 

        if($insert == 1) {
            Yii::$app->sbccommon->execqry("insert into uom(itemid,uom,factor,kilos)values('$itemid','$data->uom',1,1)");
            Log::writelog("stockcard", $itemid, "added default uom", $data->uom,Yii::$app->session['loggeduser']['username']); 
            
            //UPDATES FOR DLOCK TABLE (MIDDLEWARE DOWNLOADING)
            $qry = "delete from itemdlock where itemid = " . $itemid;
            Yii::$app->sbccommon->execqry($qry);
            
            $timeupdate = Yii::$app->systemsettings->getCurrentTimeStamp();
            
            $qry2 = "insert into itemdlock (itemid,dlock) values(".$itemid.",'".$timeupdate."')";
            Yii::$app->sbccommon->execqry($qry2);


            //ADD item to DOD (deal of the day)
            if($data->adddod == 1){
                Yii::$app->backend->modifyFrontendDOD($itemid,'add');
            }//end if

            return array('itemid' =>$itemid,'msg'=>'Item added sucessfully.');
        } else {
            return array('itemid' =>'','msg'=>"ERJ1: Error saving item, Please try again.");
        }//end if insert
    }//end function



    public static function updatecode($barcode,$oldbarcode,$itemid){
            Yii::$app->sbccommon->execqry("Update item set barcode='$barcode' where itemid='$itemid'");
            Yii::$app->sbccommon->execqry("Update lastock set barcode='$barcode' where barcode='$oldbarcode'");
            Yii::$app->sbccommon->execqry("Update lbstock set barcode='$barcode' where barcode='$oldbarcode'");
            Yii::$app->sbccommon->execqry("Update lcstock set barcode='$barcode' where barcode='$oldbarcode'");
            Yii::$app->sbccommon->execqry("Update postock set barcode='$barcode' where barcode='$oldbarcode'");
            Yii::$app->sbccommon->execqry("Update hpostock set barcode='$barcode' where barcode='$oldbarcode'");
            Yii::$app->sbccommon->execqry("Update pcstock set barcode='$barcode' where barcode='$oldbarcode'");
            Yii::$app->sbccommon->execqry("Update hpcstock set barcode='$barcode' where barcode='$oldbarcode'");
            Yii::$app->sbccommon->execqry("Update sostock set barcode='$barcode' where barcode='$oldbarcode'");
            Yii::$app->sbccommon->execqry("Update hsostock set barcode='$barcode' where barcode='$oldbarcode'");
            Yii::$app->sbccommon->execqry("Update component set barcode='$barcode' where barcode='$oldbarcode'");
            Log::writelog('ITEMS', $itemid, 'CHANGE', $oldbarcode.'=>'.$barcode);
    }//end update code
    
    
    public function update($data) {
        $itemid = Item::itemid($data->barcode);   
        $datax = $this->openitem($itemid);

        $user=Yii::$app->session['loggeduser']['username'];
        $data->amt = str_replace(",", "", $data->amt);
        $data->amt2 = str_replace(",", "", $data->amt2);
        $data->famt = str_replace(",", "", $data->famt);
        $data->amt4 = str_replace(",", "", $data->amt4);
        $data->itemname=preg_replace( "/'/", "`", $data->itemname);
        $data->brand=preg_replace( "/'/", "`", $data->brand);
        $data->model=preg_replace( "/'/", "`", $data->model);
        $data->part=preg_replace( "/'/", "`", $data->part);
        $data->class=preg_replace( "/'/", "`", $data->class);
        $data->groupid=preg_replace( "/'/", "`", $data->groupid);
        $data->body=preg_replace( "/'/", "`", $data->body);
        $data->sizeid=preg_replace( "/'/", "`", $data->sizeid);
        $data->itemrem=preg_replace( "/'/", "`", $data->itemrem);
        $data->minimum = str_replace(",", "", $data->minimum);
        $data->maximum = str_replace(",", "", $data->maximum);
        $data->cost = str_replace(",", "", $data->cost);
        $data->supplier=preg_replace( "/'/", "`", $data->supplier);
        $data->note=preg_replace( "/'/", "`", $data->note);
        $data->specs=preg_replace( "/'/", "`", $data->specs);

        $data->reorder=preg_replace( "/'/", "`", $data->reorder);
        $data->critical=preg_replace( "/'/", "`", $data->critical);
        $data->color=preg_replace( "/'/", "`", $data->color);
        $data->pwd=preg_replace( "/'/", "`", $data->pwd);
        $data->senior=preg_replace( "/'/", "`", $data->senior);

        $data->effdate=preg_replace( "/'/", "`", $data->effdate);
        $data->grp=preg_replace( "/'/", "`", $data->grp);
        $data->packaging=preg_replace( "/'/", "`", $data->packaging);
        // $data->linkplu=preg_replace( "/'/", "`", $data->linkplu;
        $data->otherbar=preg_replace( "/'/", "`", $data->otherbar);

        $data->supbar=preg_replace( "/'/", "`", $data->supbar);
        $data->dateupdated=preg_replace( "/'/", "`", $data->dateupdated);
        $data->quantity=preg_replace( "/'/", "`", $data->quantity);
        // $data->supplier=preg_replace( "/'/", "`", $data->supplier;
        $data->mode=preg_replace( "/'/", "`", $data->mode);

        $data->hierparent=preg_replace( "/'/", "`", $data->hierparent);
        $data->linkdept=preg_replace( "/'/", "`", $data->linkdept);
        $data->points=preg_replace( "/'/", "`", $data->points);
        // $data->acceptlosses=preg_replace( "/'/", "`", $data->acceptlosses;
        $data->currentcost=preg_replace( "/'/", "`", $data->currentcost);

        $data->cooktime=preg_replace( "/'/", "`", $data->cooktime);
        $data->preptime=preg_replace( "/'/", "`", $data->preptime);
        //END

        $data->uvpriority=preg_replace( "/'/", "`", $data->uvpriority);
        $data->uvdepartment=preg_replace( "/'/", "`", $data->uvdepartment);
        $data->suppitemcode=preg_replace( "/'/", "`", $data->suppitemcode);

        $data->printuom=preg_replace( "/'/", "`", $data->printuom);

        $data->uvprincipal=preg_replace( "/'/", "`", $data->uvprincipal);
        $data->uvprincipalid=preg_replace( "/'/", "`", $data->uvprincipalid);


        $asset = $data->asset;
        $liability = $data->liability;
        $revenue = $data->revenue;
        $expense = $data->expense;

        $prevamtqry = 'select amt from item where itemid = "' . $data->barcode .'"';
        $prevamt = Yii::$app->sbccommon->datareader($prevamtqry);

        $addonstr = "";
        
        if($data->fg_isfinishedgood == ""){
            $addonstr .= " ";
        }else{
            $addonstr .= " ,fg_isfinishedgood = '".$data->fg_isfinishedgood."' ";
        }//end if

        if($data->fg_isequipmenttool == ""){
            $addonstr .= " ";
        }else{
            $addonstr .= " ,fg_isequipmenttool = '".$data->fg_isequipmenttool."' ";
        }//end if

        $timeupdate = Yii::$app->systemsettings->getCurrentTimeStamp();

        $qry = "update item set pwd='$data->pwd',senior='$data->senior',color='$data->color',
        critical='$data->critical',reorder='$data->reorder',itemname='$data->itemname',brand='$data->brand',
        model='$data->modelid',part='$data->partid',itemrem='$data->itemrem',class='$data->class',
        groupid='$data->stockgrpid',body='$data->body',sizeid='$data->sizeid',note='$data->note',
        specs='$data->specs',
        effectdate='$data->effdate', grp='$data->grp',packaging='$data->packaging', 
        linkplu='$data->linkplu',othcode='$data->otherbar', suppcodes='$data->supbar',
        dateupdated='$data->dateupdated', qty='$data->quantity', mode='$data->mode', istaxable='$data->istaxable',
        ispostitem='$data->ispostitem', issenior='$data->issenior', iszerorated='$data->iszerorated', 
        isprintable='$data->isprintable',
        hierarchy='$data->hierparent', linkdept='$data->linkdept', points='$data->points', 
        acceptloss='$data->acceptlosses',
        cooking_time='$data->cooktime', prep_time='$data->preptime',
        amt='$data->amt',amt2='$data->amt2',famt='$data->famt',amt4='$data->amt4',
        amt5='$data->amt5',
        amt6='$data->amt6',amt7='$data->amt7',amt8='$data->amt8',amt9='$data->amt9',
        amt10='$data->amt10',
        amt11='$data->amt11',amt12='$data->amt12',amt13='$data->amt13',amt14='$data->amt14',
        amt15='$data->amt15',
        disc='$data->disc',disc2='$data->disc2',disc3='$data->disc3',disc4='$data->disc4',
        disc5='$data->disc5',
        disc6='$data->disc6',disc7='$data->disc7',disc8='$data->disc8',disc9='$data->disc9',
        disc10='$data->disc10',
        disc11='$data->disc11',disc12='$data->disc12',disc13='$data->disc13',disc14='$data->disc14',
        disc15='$data->disc15',
        category='$data->category',uom='$data->uom',minimum='$data->minimum',
        maximum='$data->maximum',cost='$data->cost',supplier='$data->supplier',isinactive='$data->isinactive',
        isimport='$data->isimport',editby='$user',editdate='".$timeupdate."',
        asset='$asset',liability='$liability',revenue='$revenue',expense='$expense',expiryday='$data->daystoexpire',
        fqty='$data->fqty',promostart = '$data->promostart',promoend = '$data->promoend',
        saleprice = '$data->fsaleprice',f_type = '$data->ftype',
        f_mainmaterial = '$data->fmainmaterial',f_highlights = '$data->fhighlights',
        f_proddesc = '$data->fproddesc',f_whatsbox = '$data->fwhatsbox',f_freeitems = '$data->ffreeitems',
        f_videourl = '$data->fvideourl',f_notes = '$data->fprodnotes',f_delivopt = '$data->fdeliveryopt',
        f_shippingmin = '$data->fminshipping',f_shippingmax = '$data->fmaxshipping',
        f_dimensions = '$data->fdimensions',f_prodweight = '$data->fprodweight',f_packheight = '$data->fpackheight',
        f_packlength = '$data->fpacklength',f_packweight = '$data->fpackweight',
        f_packwidth = '$data->fpackwidth',f_warrantytype = '$data->fwarrantytype',
        f_warrantperiod = '$data->fwarrantyperiod', f_warrantpolicy = '$data->fwarrantypolicy',
        setfrontend='$data->setfrontend',fdiscounted='$data->fdiscounted',
        invbal_uom = '$data->invbal_uom',shortname='$data->itemshortname',sc_commgrpid='$data->commgrpid',sc_subcatid='$data->subcatid',
        defaultwh='$data->defaultwh',itemhandling='$data->itemhandling',itemcomm='$data->itemcomm',
        uom1 = '$data->uom1',uom2 = '$data->uom2',uom3= '$data->uom3',uom4 = '$data->uom4',uom5 = '$data->uom5',uom6 = '$data->uom6',
        factor1 = '$data->factor1',factor2 = '$data->factor2',factor3= '$data->factor3',factor4 = '$data->factor4',
        factor5 = '$data->factor5',factor6 = '$data->factor6',
        markup = '$data->markup',markup2 = '$data->markup2',markup3= '$data->markup3',markup4 = '$data->markup4',
        markup5 = '$data->markup5',markup6 = '$data->markup6',
        color='$data->color',uv_priority='$data->uvpriority',uv_department='$data->uvdepartment',
        uv_suppitemcode='$data->suppitemcode',isvat='$data->isvat',gm_printuom='$data->printuom', uv_principal ='$data->uvprincipalid',
        purchase_uom ='$data->uvpurchaseuom',
        fg_customer = '$data->fg_client',fg_colornum ='$data->fg_colornum',fg_diameter ='$data->fg_diameter',
        itemhandling2='$data->itemhandling2',fg_prodtype ='$data->fg_prodtype',
        fg_sealing = '$data->fg_sealing',fg_serial = '$data->fg_serial',
        fg_jowidth = '$data->fg_jowidth',fg_jolength = '$data->fg_jolength',
        fg_thickness = '$data->fg_thickness',fg_plasticcolor = '$data->fg_plasticcolor',
        fg_combi = '$data->fg_combi',fg_jowidthuom = '$data->fg_jowidthuom',
        fg_jolengthuom = '$data->fg_jolengthuom',fgunit_diameter = '$data->fgunit_diameter',
        fg_thicknessuom = '$data->fg_thicknessuom' ".$addonstr." where barcode='$data->barcode'";

        $update = Yii::$app->sbccommon->execqry($qry);

        if($data->adddod == 1){
            Yii::$app->backend->modifyFrontendDOD($data->itemid,'add');
        }else{
            Yii::$app->backend->modifyFrontendDOD($data->itemid,'remove');
        }//end if

        Log::writelog("stockcard", $itemid, "Item Details Updated", $data->barcode,Yii::$app->session['loggeduser']['username']);
        //UPDATES FOR DLOCK TABLE (MIDDLEWARE DOWNLOADING)
        $qry = "delete from itemdlock where itemid = " . $data->itemid;
        Yii::$app->sbccommon->execqry($qry);
        
        $timeupdate = Yii::$app->systemsettings->getCurrentTimeStamp();
        
        $qry2 = "insert into itemdlock (itemid,dlock) values(".$data->itemid.",'".$timeupdate."')";
        Yii::$app->sbccommon->execqry($qry2);

        if($datax[0]['uom'] != $data->uom){
            if(Yii::$app->backend->UOMhastransaction($datax[0]['uom'],$itemid)){
                $uomupdate = false;
                $msg = "Item default UOM cant be changed, already have transactions.";
            }else{
                $qry = "update uom set uom = '".$data->uom."' where itemid = ".$itemid." and uom = '".$datax[0]['uom']."' and factor = 1";
                Yii::$app->sbccommon->execqry($qry);
                $qry2 = "update item set uom = '".$data->uom."' where barcode = '".$data->barcode."'";
                Yii::$app->sbccommon->execqry($qry2);
                $uomupdate = true;
                Log::writelog("stockcard", $itemid, "updated uom", $datax[0]['uom'] . "=>" . $data->uom,Yii::$app->session['loggeduser']['username']);
            }//end if uom has transaction already
        }else{
            $uomupdate = true;
        }//end 

        if($update) {
            $data->amt = str_replace(",", "", $data->amt);
            $prevamt = str_replace(",", "", $prevamt);

            if($data->amt != $prevamt){
                $timeupdate = Yii::$app->systemsettings->getCurrentTimeStamp();
                $user=Yii::$app->session['loggeduser']['username'];
                $amthistoryqry = "insert into itemamthistory (barcode,dateupdated,prevamt,recentamt,updatedby,fieldupdate)
                                  values('".$data->barcode."','".$timeupdate."','".$prevamt."','".$data->amt."','".$user."','amt')";
                Yii::$app->sbccommon->execqry($amthistoryqry);
            }//end if

            if($uomupdate){
                return array('itemid' =>$itemid,'msg'=>'Item Updated!','err_uom'=>'','errstat'=>0);
            }else{
                return array('itemid' =>$itemid,'msg'=>$msg,'err_uom'=>$datax[0]['uom'],'errstat'=>1);
            }//end if uom update 
        } else {
            return array('itemid' =>$itemid,'msg'=>"error update item",'err_uom'=>$datax[0]['uom'],'errstat'=>1);
        }//end update error
    }//end function

    public function FG_update($data) {
        $itemid = Item::itemid($data->barcode);   
        $datax = $this->openitem($itemid);

        $user=Yii::$app->session['loggeduser']['username'];
        $data->amt = str_replace(",", "", $data->amt);
        $data->amt2 = str_replace(",", "", $data->amt2);
        $data->famt = str_replace(",", "", $data->famt);
        $data->amt4 = str_replace(",", "", $data->amt4);
        $data->itemname=preg_replace( "/'/", "`", $data->itemname);
        $data->brand=preg_replace( "/'/", "`", $data->brand);
        $data->model=preg_replace( "/'/", "`", $data->model);
        $data->part=preg_replace( "/'/", "`", $data->part);
        $data->class=preg_replace( "/'/", "`", $data->class);
        $data->groupid=preg_replace( "/'/", "`", $data->groupid);
        $data->body=preg_replace( "/'/", "`", $data->body);
        $data->sizeid=preg_replace( "/'/", "`", $data->sizeid);
        $data->itemrem=preg_replace( "/'/", "`", $data->itemrem);
        $data->minimum = str_replace(",", "", $data->minimum);
        $data->maximum = str_replace(",", "", $data->maximum);
        $data->cost = str_replace(",", "", $data->cost);
        $data->supplier=preg_replace( "/'/", "`", $data->supplier);
        $data->note=preg_replace( "/'/", "`", $data->note);
        $data->specs=preg_replace( "/'/", "`", $data->specs);

        $data->reorder=preg_replace( "/'/", "`", $data->reorder);
        $data->critical=preg_replace( "/'/", "`", $data->critical);
        $data->color=preg_replace( "/'/", "`", $data->color);
        $data->pwd=preg_replace( "/'/", "`", $data->pwd);
        $data->senior=preg_replace( "/'/", "`", $data->senior);

        $data->effdate=preg_replace( "/'/", "`", $data->effdate);
        $data->grp=preg_replace( "/'/", "`", $data->grp);
        $data->packaging=preg_replace( "/'/", "`", $data->packaging);
        // $data->linkplu=preg_replace( "/'/", "`", $data->linkplu;
        $data->otherbar=preg_replace( "/'/", "`", $data->otherbar);

        $data->supbar=preg_replace( "/'/", "`", $data->supbar);
        $data->dateupdated=preg_replace( "/'/", "`", $data->dateupdated);
        $data->quantity=preg_replace( "/'/", "`", $data->quantity);
        // $data->supplier=preg_replace( "/'/", "`", $data->supplier;
        $data->mode=preg_replace( "/'/", "`", $data->mode);

        $data->hierparent=preg_replace( "/'/", "`", $data->hierparent);
        $data->linkdept=preg_replace( "/'/", "`", $data->linkdept);
        $data->points=preg_replace( "/'/", "`", $data->points);
        // $data->acceptlosses=preg_replace( "/'/", "`", $data->acceptlosses;
        $data->currentcost=preg_replace( "/'/", "`", $data->currentcost);

        $data->cooktime=preg_replace( "/'/", "`", $data->cooktime);
        $data->preptime=preg_replace( "/'/", "`", $data->preptime);
        //END

        $data->uvpriority=preg_replace( "/'/", "`", $data->uvpriority);
        $data->uvdepartment=preg_replace( "/'/", "`", $data->uvdepartment);
        $data->suppitemcode=preg_replace( "/'/", "`", $data->suppitemcode);

        $data->printuom=preg_replace( "/'/", "`", $data->printuom);

        $data->uvprincipal=preg_replace( "/'/", "`", $data->uvprincipal);
        $data->uvprincipalid=preg_replace( "/'/", "`", $data->uvprincipalid);


        $asset = $data->asset;
        $liability = $data->liability;
        $revenue = $data->revenue;
        $expense = $data->expense;

        $prevamtqry = 'select amt from item where itemid = "' . $data->barcode .'"';
        $prevamt = Yii::$app->sbccommon->datareader($prevamtqry);


        $qry = "update item set 
        fg_revision = '$data->fg_revision', fg_templateno = '$data->fg_templateno', fg_updated = '$data->fg_updated',
        fg_effective = '$data->fg_effective',
        fg_customer = '$data->fg_client', fg_prodtype = '$data->fg_prodtype', fg_combi = '$data->fg_combi',
        fg_transform = '$data->fg_transform',
        fg_addspecs = '$data->fg_addspecs', fg_punchholesize = '$data->fg_punchholesize', fg_sealing = '$data->fg_sealing',
        fg_plasticcolor = '$data->fg_plasticcolor',
        fg_bfilmdet = '$data->fg_bfilmdet', fg_treatment = '$data->fg_treatment',
        payrate = '$data->payrate', payqty = '$data->payqty',
        fg_jowidth = '$data->fg_jowidth', fg_jowidthuom = '$data->fg_jowidthuom',
        fg_jolength = '$data->fg_jolength', fg_jolengthuom = '$data->fg_jolengthuom',
        fg_thickness = '$data->fg_thickness', fg_thicknessuom = '$data->fg_thicknessuom',
        fg_actualwidth = '$data->fg_actualwidth', fg_actualwidthuom = '$data->fg_actualwidthuom',
        fg_actuallength = '$data->fg_actuallength', fg_actuallengthuom = '$data->fg_actuallengthuom',
        fg_colornum = '$data->fg_colornum', fg_repeatlength = '$data->fg_repeatlength',
        fg_repeatlengthuom = '$data->fg_repeatlengthuom', fg_outnum = '$data->fg_outnum',
        fg_outnumuom = '$data->fg_outnumuom', fg_bfilmwidth = '$data->fg_bfilmwidth',
        fg_bfilmwidthuom = '$data->fg_bfilmwidthuom', fg_thickness2 = '$data->fg_thickness2',
        fg_thickness2uom = '$data->fg_thickness2uom', fg_gramppiece1 = '$data->fg_gramppiece1',
        fg_gramppiece2 = '$data->fg_gramppiece2' where barcode='$data->barcode'";

        $update = Yii::$app->sbccommon->execqry($qry);

        
        Log::writelog("stockcard", $itemid, "FG UPDATED",'Item was update on FINISHED GOODS Module ['.$data->barcode.']',Yii::$app->session['loggeduser']['username']);

        if($update) {
            return array('itemid' =>$itemid,'msg'=>'Item Updated!','err_uom'=>'','errstat'=>0);
        } else {
            return array('itemid' =>$itemid,'msg'=>"error update item",'err_uom'=>$datax[0]['uom'],'errstat'=>1);
        }//end update error
    }//end function

    public static function getbalbydate($barcode,$wh,$loc,$date){
       $sql=" select ifnull(sum(qty-iss),0) as qty from (
           select 0 as qty,stock.iss from lahead as head left join lastock as stock on stock.trno=head.trno where stock.barcode='$barcode' and stock.wh='$wh' and stock.loc='$loc' and head.dateid<='$date' 
           union all
           select 0 as qty,stock.iss from lbhead as head left join lbstock as stock on stock.trno=head.trno where stock.barcode='$barcode' and stock.wh='$wh' and stock.loc='$loc' and head.dateid<='$date' 
           union all
           select 0 as qty,stock.iss from lchead as head left join lcstock as stock on stock.trno=head.trno where stock.barcode='$barcode' and stock.wh='$wh' and stock.loc='$loc' and head.dateid<='$date' 
           union all
           select stock.qty,stock.iss from glhead as head left join glstock as stock on stock.trno=head.trno left join item on item.itemid=stock.itemid left join client as wh on wh.clientid=stock.whid where item.barcode='$barcode' and wh.client='$wh' and stock.loc='$loc' and head.dateid<='$date' 
           union all
           select stock.qty,stock.iss from hglhead as head left join hglstock as stock on stock.trno=head.trno left join item on item.itemid=stock.itemid left join client as wh on wh.clientid=stock.whid where item.barcode='$barcode' and wh.client='$wh' and stock.loc='$loc' and head.dateid<='$date'
            ) as t ";
          $ret = Yii::$app->sbccommon->datareader($sql);
        if(empty($ret) ||$ret==''){$ret=0;}
        return $ret;                           
   }
   
public  static function getcurrentbal($barcode,$wh,$loc){
    $sql = " select ifnull(sum(rrstatus.bal),0) from rrstatus left join item on item.itemid=rrstatus.itemid
             left join client as wh on wh.clientid=rrstatus.whid where item.barcode='$barcode' and wh.client='$wh' and rrstatus.loc='$loc' and rrstatus.bal<>0        
           ";
    $ret = Yii::$app->sbccommon->datareader($sql);
    if(empty($ret) ||$ret==''){$ret=0;}
    return $ret;                                   
}   

public  static function getitemuom($barcode,$uom){
    $sql="select ifnull(uom.factor,1) as factor from item left join uom on uom.itemid=item.itemid where item.barcode='$barcode' and uom.uom='$uom'";
    $ret = Yii::$app->sbccommon->datareader($sql);
    if(empty($ret) ||$ret==''){$ret=1;}
    return $ret;                                   
    
}
    
    function checkitemtransaction($itemid){
        $sql = "select count(trno) from (select trno from lastock left join item on item.barcode=lastock.barcode where item.itemid='$itemid'
               union all
               select trno from glstock where itemid='$itemid'
               union all
               select trno from hglstock where itemid='$itemid'                   
               union all
               select trno from postock left join item on item.barcode=postock.barcode where item.itemid='$itemid'
               union all
               select trno from pistock left join item on item.barcode=pistock.barcode where item.itemid='$itemid'
               union all
               select trno from pdstock left join item on item.barcode=pdstock.barcode where item.itemid='$itemid'
               union all
               select trno from sostock left join item on item.barcode=sostock.barcode where item.itemid='$itemid'
               union all
               select trno from pcstock left join item on item.barcode=pcstock.barcode where item.itemid='$itemid'
               union all
               select trno from hpostock left join item on item.barcode=hpostock.barcode where item.itemid='$itemid'
               union all
               select trno from hpistock left join item on item.barcode=hpistock.barcode where item.itemid='$itemid'
               union all
               select trno from hpdstock left join item on item.barcode=hpdstock.barcode where item.itemid='$itemid'
               union all
               select trno from hsostock left join item on item.barcode=hsostock.barcode where item.itemid='$itemid'
               union all
               select trno from hpcstock left join item on item.barcode=hpcstock.barcode where item.itemid='$itemid'
                union all
               select component.line from component 
               left join item on item.barcode=component.barcode where item.itemid='$itemid' ) as t";
        $ret = Yii::$app->sbccommon->datareader($sql);
        if(empty($ret) ||$ret==''){$ret=0;}
        return $ret;
        }
    
    
    function deleteitem($itemid) {
        $isdownloaded = Yii::$app->backend->checkItemIsDownloaded($itemid);       
        if($isdownloaded){
            return array('status'=>0,'del_msg'=>'Item cant be deleted. Its has been downloaded for other applications.');
        }else{
            $count=$this->checkitemtransaction($itemid);
            if($count==0){
            if (Yii::$app->sbccommon->execqry("DELETE from item where itemid='$itemid'") == 1) {
                $barcode = $this->barcode($itemid);
                Log::del_log('ITEMS', $itemid, $barcode);
                Yii::$app->sbccommon->execqry("DELETE from uom where itemid='$itemid'");
                Yii::$app->sbccommon->execqry("DELETE from itemlevel where itemid='$itemid'");
                return array('status'=>1,'del_msg'=>'');
            }
            }else{
                return array('status'=>0,'del_msg'=>'Item cant be deleted , Already have transaction!');
            }
        }//end if
    }
    function deleteimg($itemid) {
        $delpic = Yii::$app->sbccommon->execqry("update item set picture ='' where itemid=$itemid");
    }

    function getpicturename($itemid) {
        $pic = Yii::$app->sbccommon->datareader("select picture from item where itemid='$itemid'");
        if (!empty($pic) || $pic != null) {
            return $pic;
        } else {
            return false;
        }
    }

   public static function checkbarcode($barcode){
        $itemid= Yii::$app->sbccommon->datareader("select ifnull(itemid,0) as itemid from item where barcode='$barcode'");
        if(empty($itemid) || $itemid==''){
            $itemid=0;
        }
        return $itemid;
    }

    
    function checkfilename($filename) {
        $item = Yii::$app->sbccommon->datareader("select itemid from item where picture='$filename'");
        if (!empty($item) || $item != null || strlen($item) != 0) {
            return $item;
        } else {
            return false;
        }
    }

    function updateitemimage($filename, $itemid) {
        return Yii::$app->sbccommon->execqry("
                    update item set picture='$filename' where itemid='$itemid'
                ");
    }

    
    
    
    function getsrp($itemid) {
        $center = Yii::$app->user->whcode;
        $level = Yii::$app->sbccommon->opentable("select srpa, srpb, srpc, srpd, srpe, srpf, srpg, srph, srpi,
            srpj, srpk, srpl, srpm, srpn, srpo, srpp, srpq, srpr, srps, srpt, srpu, srpv, srpw, srpx, srpy, srpz,
            comma, commb, commc, commd, comme, commf, commg, commh, commi,commj, commk, comml, commm, commn, commo,
            commp, commq, commr, comms, commt, commu, commv, commw, commx, commy, commz,
            icomma,icommb,icommc,icommd,icomme,icommf,icommg,icommh,icommi,icommj,icommk,icomml,icommm,
            icommn,icommo,icommp,icommq,icommr,icomms,icommt,icommu,icommv,icommw,icommx,icommy,icommz,
            srpa1,srpa2,srpa3,srpa4,comma1,comma2,comma3,comma4,icomma1,icomma2,icomma3,icomma4
            from item where itemid='$itemid' limit 1");
        
        if ($level != null || !empty($level)) {
            return $level[0];
        } else {
            return false;
        }
    }
    
   
    
    function updatesrp($data) {
        
        if (Yii::$app->sbccommon->execqry("update item set srpa=$data->srpa, srpb=$data->srpb, srpc=$data->srpc, srpd=$data->srpd, srpe=$data->srpe, srpf=$data->srpf, srpg=$data->srpg, srph=$data->srph, srpi=$data->srpi,
            srpj=$data->srpj, srpk=$data->srpk, srpl=$data->srpl, srpm=$data->srpm, srpn=$data->srpn, srpo=$data->srpo, srpp=$data->srpp, srpq=$data->srpq, srpr=$data->srpr, srps=$data->srps, srpt=$data->srpt, srpu=$data->srpu, 
            srpv=$data->srpv, srpw=$data->srpw, srpx=$data->srpx, srpy=$data->srpy, srpz=$data->srpz,
            comma=$data->comma, commb=$data->commb, commc=$data->commc, commd=$data->commd, comme=$data->comme, commf=$data->commf, commg=$data->commg, 
            commh=$data->commh, commi=$data->commi, commj=$data->commj, commk=$data->commk, comml=$data->comml, commm=$data->commm, commn=$data->commn, commo=$data->commo, commp=$data->commp, commq=$data->commq, commr=$data->commr, comms=$data->comms, 
            commt=$data->commt, commu=$data->commu, commv=$data->commv, commw=$data->commw, commx=$data->commx, commy=$data->commy, commz=$data->commz,
            icomma=$data->icomma,icommb=$data->icommb,icommc=$data->icommc,icommd=$data->icommd,icomme=$data->icomme,icommf=$data->icommf,icommg=$data->icommg,
            icommh=$data->icommh,icommi=$data->icommi,icommj=$data->icommj,icommk=$data->icommk,icomml=$data->icomml,icommm=$data->icommm,icommn=$data->icommn,icommo=$data->icommo,
            icommp=$data->icommp,icommq=$data->icommq,icommr=$data->icommr,icomms=$data->icomms,icommt=$data->icommt,icommu=$data->icommu,icommv=$data->icommv,icommw=$data->icommw,
            icommx=$data->icommx,icommy=$data->icommy,icommz=$data->icommz,
            srpa1=$data->srpa1,srpa2=$data->srpa2,srpa3=$data->srpa3,srpa4=$data->srpa4,
            comma1=$data->comma1,comma2=$data->comma2,comma3=$data->comma3,comma4=$data->comma4,
            icomma1=$data->icomma1,icomma2=$data->icomma2,icomma3=$data->icomma3,icomma4=$data->icomma4   
            where itemid=$data->itemid ") == 1) {
            return 1;
        } else {
            return "error saving item srp.";
        }
    }
    
            public static function checkitem($barcode)
        {
            return Yii::$app->sbccommon->datareader("select itemid from item where barcode='$barcode'");
        }

        public static function openStockLedger($itemid,$date,$uom,$wh)
        {
         $center=Yii::$app->session['loggeduser']['center'];
         $sql="select 'Posted' as `posted`,`glhead`.`trno` as `trno`,`glhead`.`doc` as `doc`,`glhead`.`docno` as `docno`,
            `glhead`.`dateid` as `dateid`,glstock.cost * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as cost,
            glstock.qty / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as qty,
            glstock.amt * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as amt,
            glstock.iss / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as iss,
            `glhead`.`yourref` as `yourref`,`glhead`.`ourref` as `ourref`,
            `glstock`.`disc` as `disc`,`item`.`itemid` as `itemid`,`wh`.`client` as `wh`,wh.clientname as whname,
            `glstock`.`loc` as `loc`,0 as `type`,`glhead`.`isimport` as `isimport`,`glstock`.`line` as `line`,
            `glhead`.`cur` as `cur`,`glhead`.`forex` as `forex`,`glhead`.`factor` as `factor`,
            `glstock`.`rem` as `rem`,`glstock`.`encodeddate` as `encoded`,
            client.client,client.clientname,client.addr,client.tel,client.email,client.tin,
            client.mobile,client.contact,client.fax
            from ((`glhead` left join `glstock` on((`glstock`.`trno` = `glhead`.`trno`)))
            left join `item` on((`item`.`itemid` = `glstock`.`itemid`)))
            left join uom on uom.itemid=glstock.itemid and uom.uom='$uom'
            left join client as wh on wh.clientid = glstock.whid
            left join cntnum on cntnum.trno = glhead.trno
            left join client on client.clientid = glhead.clientid where item.itemid = $itemid and glhead.dateid >='$date' and wh.client= '$wh'
            union all
            select '' as `posted`,`lahead`.`trno` as `trno`,`lahead`.`doc` as `doc`,`lahead`.`docno` as `docno`,
            `lahead`.`dateid` as `dateid`,lastock.cost * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as cost,
            lastock.qty / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as qty,
            lastock.amt * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as amt,
            lastock.iss / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as iss,
            `lahead`.`yourref` as `yourref`,`lahead`.`ourref` as `ourref`,
            `lastock`.`disc` as `disc`,`item`.`itemid` as `itemid`,`wh`.`client` as `wh`,wh.clientname as whname,
            `lastock`.`loc` as `loc`,0 as `type`,`lahead`.`isimport` as `isimport`,`lastock`.`line` as `line`,
            `lahead`.`cur` as `cur`,`lahead`.`forex` as `forex`,`lahead`.`factor` as `factor`,
            `lastock`.`rem` as `rem`,`lastock`.`encodeddate` as `encoded`,
            client.client,client.clientname,client.addr,client.tel,client.email,client.tin,
            client.mobile,client.contact,client.fax
            from ((`lahead` left join `lastock` on((`lastock`.`trno` = `lahead`.`trno`)))
            left join `item` on((`item`.`barcode` = `lastock`.`barcode`)))
            left join uom on uom.itemid=item.itemid and uom.uom='$uom'
            left join client as wh on wh.client = lastock.wh
            left join cntnum on cntnum.trno = lahead.trno
            left join client on client.client = lahead.client where item.itemid = $itemid and lahead.dateid >='$date'  and wh.client= '$wh'
            union all
            select '' as `posted`,`lbhead`.`trno` as `trno`,`lbhead`.`doc` as `doc`,`lbhead`.`docno` as `docno`,
            `lbhead`.`dateid` as `dateid`,lbstock.cost * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as cost,
            lbstock.qty / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as qty,
            lbstock.amt * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as amt,
            lbstock.iss / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as iss,
            `lbhead`.`yourref` as `yourref`,`lbhead`.`ourref` as `ourref`,
            `lbstock`.`disc` as `disc`,`item`.`itemid` as `itemid`,`wh`.`client` as `wh`,wh.clientname as whname,
            `lbstock`.`loc` as `loc`,0 as `type`,`lbhead`.`isimport` as `isimport`,`lbstock`.`line` as `line`,
            `lbhead`.`cur` as `cur`,`lbhead`.`forex` as `forex`,`lbhead`.`factor` as `factor`,
            `lbstock`.`rem` as `rem`,`lbstock`.`encodeddate` as `encoded`,
            client.client,client.clientname,client.addr,client.tel,client.email,client.tin,
            client.mobile,client.contact,client.fax
            from ((`lbhead` left join `lbstock` on((`lbstock`.`trno` = `lbhead`.`trno`)))
            left join `item` on((`item`.`barcode` = `lbstock`.`barcode`)))
            left join uom on uom.itemid=item.itemid and uom.uom='$uom'
            left join client as wh on wh.client = lbstock.wh
            left join cntnum on cntnum.trno = lbhead.trno
            left join client on client.client = lbhead.client where item.itemid = $itemid and lbhead.dateid >='$date'  and wh.client= '$wh'
            union all
            select '' as `posted`,`lchead`.`trno` as `trno`,`lchead`.`doc` as `doc`,`lchead`.`docno` as `docno`,
            `lchead`.`dateid` as `dateid`,lcstock.cost * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as cost,
            lcstock.qty / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as qty,
            lcstock.amt * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as amt,
            lcstock.iss / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as iss,
            `lchead`.`yourref` as `yourref`,`lchead`.`ourref` as `ourref`,
            `lcstock`.`disc` as `disc`,`item`.`itemid` as `itemid`,`wh`.`client` as `wh`,wh.clientname as whname,
            `lcstock`.`loc` as `loc`,0 as `type`,`lchead`.`isimport` as `isimport`,`lcstock`.`line` as `line`,
            `lchead`.`cur` as `cur`,`lchead`.`forex` as `forex`,`lchead`.`factor` as `factor`,
            `lcstock`.`rem` as `rem`,`lcstock`.`encodeddate` as `encoded`,
            client.client,client.clientname,client.addr,client.tel,client.email,client.tin,
            client.mobile,client.contact,client.fax
            from ((`lchead` left join `lcstock` on((`lcstock`.`trno` = `lchead`.`trno`)))
            left join `item` on((`item`.`barcode` = `lcstock`.`barcode`)))
            left join uom on uom.itemid=item.itemid and uom.uom='$uom'
            left join client as wh on wh.client = lcstock.wh
            left join cntnum on cntnum.trno = lchead.trno
            left join client on client.client = lchead.client where item.itemid = $itemid and lchead.dateid >='$date'  and wh.client= '$wh' order by dateid";
            //webproc::showmsg('a',$sql);
         return $sql;

        }
        
    public static function openBegStockLedger($itemid,$date,$uom,$wh)
    {
         $center=Yii::$app->session['loggeduser']['center'];
         $sql="select sum(qty-iss) as beg from(select 'Posted' as `posted`,`glhead`.`trno` as `trno`,`glhead`.`doc` as `doc`,`glhead`.`docno` as `docno`,
            `glhead`.`dateid` as `dateid`,glstock.cost * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as cost,
            glstock.qty / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as qty,
            glstock.amt * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as amt,
            glstock.iss / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as iss,
            `glhead`.`yourref` as `yourref`,`glhead`.`ourref` as `ourref`,
            `glstock`.`disc` as `disc`,`item`.`itemid` as `itemid`,`wh`.`client` as `wh`,wh.clientname as whname,
            `glstock`.`loc` as `loc`,0 as `type`,`glhead`.`isimport` as `isimport`,`glstock`.`line` as `line`,
            `glhead`.`cur` as `cur`,`glhead`.`forex` as `forex`,`glhead`.`factor` as `factor`,
            `glstock`.`rem` as `rem`,`glstock`.`encodeddate` as `encoded`,
            client.client,client.clientname,client.addr,client.tel,client.email,client.tin,
            client.mobile,client.contact,client.fax
            from ((`glhead` left join `glstock` on((`glstock`.`trno` = `glhead`.`trno`)))
            left join `item` on((`item`.`itemid` = `glstock`.`itemid`)))
            left join uom on uom.itemid=glstock.itemid and uom.uom='$uom'
            left join client as wh on wh.clientid = glstock.whid
            left join cntnum on cntnum.trno = glhead.trno
            left join client on client.clientid = glhead.clientid where item.itemid = $itemid and glhead.dateid <'$date' and wh.client= '$wh'
            union all
            select '' as `posted`,`lahead`.`trno` as `trno`,`lahead`.`doc` as `doc`,`lahead`.`docno` as `docno`,
            `lahead`.`dateid` as `dateid`,lastock.cost * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as cost,
            lastock.qty / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as qty,
            lastock.amt * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as amt,
            lastock.iss / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as iss,
            `lahead`.`yourref` as `yourref`,`lahead`.`ourref` as `ourref`,
            `lastock`.`disc` as `disc`,`item`.`itemid` as `itemid`,`wh`.`client` as `wh`,wh.clientname as whname,
            `lastock`.`loc` as `loc`,0 as `type`,`lahead`.`isimport` as `isimport`,`lastock`.`line` as `line`,
            `lahead`.`cur` as `cur`,`lahead`.`forex` as `forex`,`lahead`.`factor` as `factor`,
            `lastock`.`rem` as `rem`,`lastock`.`encodeddate` as `encoded`,
            client.client,client.clientname,client.addr,client.tel,client.email,client.tin,
            client.mobile,client.contact,client.fax
            from ((`lahead` left join `lastock` on((`lastock`.`trno` = `lahead`.`trno`)))
            left join `item` on((`item`.`barcode` = `lastock`.`barcode`)))
            left join uom on uom.itemid=item.itemid and uom.uom='$uom'
            left join client as wh on wh.client = lastock.wh
            left join cntnum on cntnum.trno = lahead.trno
            left join client on client.client = lahead.client where item.itemid = $itemid and lahead.dateid <'$date'  and wh.client= '$wh'
            union all
            select '' as `posted`,`lbhead`.`trno` as `trno`,`lbhead`.`doc` as `doc`,`lbhead`.`docno` as `docno`,
            `lbhead`.`dateid` as `dateid`,lbstock.cost * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as cost,
            lbstock.qty / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as qty,
            lbstock.amt * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as amt,
            lbstock.iss / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as iss,
            `lbhead`.`yourref` as `yourref`,`lbhead`.`ourref` as `ourref`,
            `lbstock`.`disc` as `disc`,`item`.`itemid` as `itemid`,`wh`.`client` as `wh`,wh.clientname as whname,
            `lbstock`.`loc` as `loc`,0 as `type`,`lbhead`.`isimport` as `isimport`,`lbstock`.`line` as `line`,
            `lbhead`.`cur` as `cur`,`lbhead`.`forex` as `forex`,`lbhead`.`factor` as `factor`,
            `lbstock`.`rem` as `rem`,`lbstock`.`encodeddate` as `encoded`,
            client.client,client.clientname,client.addr,client.tel,client.email,client.tin,
            client.mobile,client.contact,client.fax
            from ((`lbhead` left join `lbstock` on((`lbstock`.`trno` = `lbhead`.`trno`)))
            left join `item` on((`item`.`barcode` = `lbstock`.`barcode`)))
            left join uom on uom.itemid=item.itemid and uom.uom='$uom'
            left join client as wh on wh.client = lbstock.wh
            left join cntnum on cntnum.trno = lbhead.trno
            left join client on client.client = lbhead.client where item.itemid = $itemid and lbhead.dateid <'$date'  and wh.client= '$wh'
            union all
            select '' as `posted`,`lchead`.`trno` as `trno`,`lchead`.`doc` as `doc`,`lchead`.`docno` as `docno`,
            `lchead`.`dateid` as `dateid`,lcstock.cost * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as cost,
            lcstock.qty / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as qty,
            lcstock.amt * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as amt,
            lcstock.iss / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as iss,
            `lchead`.`yourref` as `yourref`,`lchead`.`ourref` as `ourref`,
            `lcstock`.`disc` as `disc`,`item`.`itemid` as `itemid`,`wh`.`client` as `wh`,wh.clientname as whname,
            `lcstock`.`loc` as `loc`,0 as `type`,`lchead`.`isimport` as `isimport`,`lcstock`.`line` as `line`,
            `lchead`.`cur` as `cur`,`lchead`.`forex` as `forex`,`lchead`.`factor` as `factor`,
            `lcstock`.`rem` as `rem`,`lcstock`.`encodeddate` as `encoded`,
            client.client,client.clientname,client.addr,client.tel,client.email,client.tin,
            client.mobile,client.contact,client.fax
            from ((`lchead` left join `lcstock` on((`lcstock`.`trno` = `lchead`.`trno`)))
            left join `item` on((`item`.`barcode` = `lcstock`.`barcode`)))
            left join uom on uom.itemid=item.itemid and uom.uom='$uom'
            left join client as wh on wh.client = lcstock.wh
            left join cntnum on cntnum.trno = lchead.trno
            left join client on client.client = lchead.client where item.itemid = $itemid and lchead.dateid <'$date'  and wh.client= '$wh' order by dateid) as A";
            //webproc::showmsg('a',$sql);
         return $sql;

    }

    function openStockLedgerTotal($itemid,$date,$uom,$wh)
    {
         $center=Yii::$app->session['loggeduser']['center'];
         $sql="select sum(qty) as qty,sum(iss) as iss from (select 'Posted' as `posted`,`glhead`.`trno` as `trno`,`glhead`.`doc` as `doc`,`glhead`.`docno` as `docno`,
            `glhead`.`dateid` as `dateid`,glstock.cost * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as cost,
            glstock.qty / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as qty,
            glstock.amt * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as amt,
            glstock.iss / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as iss,
            `glhead`.`yourref` as `yourref`,`glhead`.`ourref` as `ourref`,
            `glstock`.`disc` as `disc`,`item`.`itemid` as `itemid`,`wh`.`client` as `wh`,wh.clientname as whname,
            `glstock`.`loc` as `loc`,0 as `type`,`glhead`.`isimport` as `isimport`,`glstock`.`line` as `line`,
            `glhead`.`cur` as `cur`,`glhead`.`forex` as `forex`,`glhead`.`factor` as `factor`,
            `glstock`.`rem` as `rem`,`glstock`.`encodeddate` as `encoded`,
            client.client,client.clientname,client.addr,client.tel,client.email,client.tin,
            client.mobile,client.contact,client.fax
            from ((`glhead` left join `glstock` on((`glstock`.`trno` = `glhead`.`trno`)))
            left join `item` on((`item`.`itemid` = `glstock`.`itemid`)))
            left join uom on uom.itemid=glstock.itemid and uom.uom='$uom'
            left join client as wh on wh.clientid = glstock.whid
            left join cntnum on cntnum.trno = glhead.trno
            left join client on client.clientid = glhead.clientid where item.itemid = $itemid  and wh.client= '$wh'
            union all
            select '' as `posted`,`lahead`.`trno` as `trno`,`lahead`.`doc` as `doc`,`lahead`.`docno` as `docno`,
            `lahead`.`dateid` as `dateid`,lastock.cost * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as cost,
            lastock.qty / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as qty,
            lastock.amt * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as amt,
            lastock.iss / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as iss,
            `lahead`.`yourref` as `yourref`,`lahead`.`ourref` as `ourref`,
            `lastock`.`disc` as `disc`,`item`.`itemid` as `itemid`,`wh`.`client` as `wh`,wh.clientname as whname,
            `lastock`.`loc` as `loc`,0 as `type`,`lahead`.`isimport` as `isimport`,`lastock`.`line` as `line`,
            `lahead`.`cur` as `cur`,`lahead`.`forex` as `forex`,`lahead`.`factor` as `factor`,
            `lastock`.`rem` as `rem`,`lastock`.`encodeddate` as `encoded`,
            client.client,client.clientname,client.addr,client.tel,client.email,client.tin,
            client.mobile,client.contact,client.fax
            from ((`lahead` left join `lastock` on((`lastock`.`trno` = `lahead`.`trno`)))
            left join `item` on((`item`.`barcode` = `lastock`.`barcode`)))
            left join uom on uom.itemid=item.itemid and uom.uom='$uom'
            left join client as wh on wh.client = lastock.wh
            left join cntnum on cntnum.trno = lahead.trno
            left join client on client.client = lahead.client where item.itemid = $itemid  and wh.client= '$wh'
            union all
            select '' as `posted`,`lbhead`.`trno` as `trno`,`lbhead`.`doc` as `doc`,`lbhead`.`docno` as `docno`,
            `lbhead`.`dateid` as `dateid`,lbstock.cost * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as cost,
            lbstock.qty / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as qty,
            lbstock.amt * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as amt,
            lbstock.iss / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as iss,
            `lbhead`.`yourref` as `yourref`,`lbhead`.`ourref` as `ourref`,
            `lbstock`.`disc` as `disc`,`item`.`itemid` as `itemid`,`wh`.`client` as `wh`,wh.clientname as whname,
            `lbstock`.`loc` as `loc`,0 as `type`,`lbhead`.`isimport` as `isimport`,`lbstock`.`line` as `line`,
            `lbhead`.`cur` as `cur`,`lbhead`.`forex` as `forex`,`lbhead`.`factor` as `factor`,
            `lbstock`.`rem` as `rem`,`lbstock`.`encodeddate` as `encoded`,
            client.client,client.clientname,client.addr,client.tel,client.email,client.tin,
            client.mobile,client.contact,client.fax
            from ((`lbhead` left join `lbstock` on((`lbstock`.`trno` = `lbhead`.`trno`)))
            left join `item` on((`item`.`barcode` = `lbstock`.`barcode`)))
            left join uom on uom.itemid=item.itemid and uom.uom='$uom'
            left join client as wh on wh.client = lbstock.wh
            left join cntnum on cntnum.trno = lbhead.trno
            left join client on client.client = lbhead.client where item.itemid = $itemid and wh.client= '$wh'
            union all
            select '' as `posted`,`lchead`.`trno` as `trno`,`lchead`.`doc` as `doc`,`lchead`.`docno` as `docno`,
            `lchead`.`dateid` as `dateid`,lcstock.cost * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as cost,
            lcstock.qty / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as qty,
            lcstock.amt * case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as amt,
            lcstock.iss / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as iss,
            `lchead`.`yourref` as `yourref`,`lchead`.`ourref` as `ourref`,
            `lcstock`.`disc` as `disc`,`item`.`itemid` as `itemid`,`wh`.`client` as `wh`,wh.clientname as whname,
            `lcstock`.`loc` as `loc`,0 as `type`,`lchead`.`isimport` as `isimport`,`lcstock`.`line` as `line`,
            `lchead`.`cur` as `cur`,`lchead`.`forex` as `forex`,`lchead`.`factor` as `factor`,
            `lcstock`.`rem` as `rem`,`lcstock`.`encodeddate` as `encoded`,
            client.client,client.clientname,client.addr,client.tel,client.email,client.tin,
            client.mobile,client.contact,client.fax
            from ((`lchead` left join `lcstock` on((`lcstock`.`trno` = `lchead`.`trno`)))
            left join `item` on((`item`.`barcode` = `lcstock`.`barcode`)))
            left join uom on uom.itemid=item.itemid and uom.uom='$uom'
            left join client as wh on wh.client = lcstock.wh
            left join cntnum on cntnum.trno = lchead.trno
            left join client on client.client = lchead.client where item.itemid = $itemid and wh.client= '$wh') as T";
            //webproc::showmsg('a',$sql);
         return $sql;

    }

  public static  function openRR($itemid,$date,$uom,$wh)
    {
        // $center=Yii::$app->session['loggeduser']['center'];
         $sql="select cntnum.doc, rrstatus.trno, rrstatus.line, client.clientname, rrstatus.cost,
            (rrstatus.qty/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qty,
            cast((case when rrstatus.bal=0 then 'applied' else round((rrstatus.bal / (case when ifnull(uom.factor, 0)=0 then 1
            else uom.factor end)),2) end) as char(50)) as status, rrstatus.dateid, rrstatus.whid, rrstatus.uom, rrstatus.disc,
            rrstatus.docno, rrstatus.loc,wh.clientname as whname,glstock.rem
            from (((((rrstatus left join client on client.clientid=rrstatus.clientid) left join client as wh
            on wh.clientid=rrstatus.whid) left join item on item.itemid=rrstatus.itemid)
            left join uom on uom.itemid=rrstatus.itemid and uom.uom='$uom') left join cntnum on cntnum.trno=rrstatus.trno) 
            left join glstock on glstock.trno = rrstatus.trno and glstock.line = rrstatus.line
            where rrstatus.itemid=$itemid and wh.client='$wh' and rrstatus.dateid >='$date' order by rrstatus.dateid";
         return $sql;

    }
    
    public static  function openRRTotal($itemid,$date,$uom,$wh)
    {
        // $center=Yii::$app->session['loggeduser']['center'];
         $sql="select sum(qty) as qty,sum(qty-bal) as iss from (select cntnum.doc, rrstatus.trno, rrstatus.line, client.clientname, rrstatus.cost,
            (rrstatus.qty/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qty,
            cast((case when rrstatus.bal=0 then 'applied' else round((rrstatus.bal / (case when ifnull(uom.factor, 0)=0 then 1
            else uom.factor end)),2) end) as char(50)) as status,rrstatus.bal, rrstatus.dateid, rrstatus.whid, rrstatus.uom, rrstatus.disc,
            rrstatus.docno, rrstatus.loc,wh.clientname as whname
            from (((((rrstatus left join client on client.clientid=rrstatus.clientid) left join client as wh
            on wh.clientid=rrstatus.whid) left join item on item.itemid=rrstatus.itemid)
            left join uom on uom.itemid=rrstatus.itemid and uom.uom='$uom') left join cntnum on cntnum.trno=rrstatus.trno)
            where rrstatus.itemid=$itemid and wh.client='$wh' and rrstatus.dateid >='$date' order by rrstatus.dateid) as A";
         return $sql;

    }


    public static function openPO($itemid,$date,$uom,$wh)
    {
         $center=Yii::$app->session['loggeduser']['center'];
         $sql="select pohead.trno, pohead.doc, pohead.docno, pohead.dateid, clientname,
            (postock.qty/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qty,
            (qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qa,pohead.rem
            from ((postock left join pohead on pohead.trno=postock.trno) left join item
            on item.barcode=postock.barcode) left join uom on uom.itemid=item.itemid
            and uom.uom='$uom' left join transnum as cntnum on cntnum.trno = pohead.trno where item.itemid=$itemid and postock.wh ='$wh'
            and pohead.dateid>='$date' and cntnum.center ='$center'
            union all
            select hpohead.trno, hpohead.doc, hpohead.docno, hpohead.dateid, clientname,
            (hpostock.qty/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qty,
            (qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qa,hpohead.rem
            from ((hpostock left join hpohead on hpohead.trno=hpostock.trno) left join item
            on item.barcode=hpostock.barcode) left join uom on uom.itemid=item.itemid
            and uom.uom='$uom' left join transnum as cntnum on cntnum.trno = hpohead.trno where item.itemid=$itemid and hpostock.wh ='$wh'
            and hpohead.dateid>='$date' and cntnum.center ='$center' order by dateid";
         //webproc::showmsg('a',$sql);
         return $sql;

    }

    public static function openSO($itemid,$date,$uom,$wh)
    {
         $center=Yii::$app->session['loggeduser']['center'];
         $sql="select sohead.trno, sohead.doc, sohead.docno, sohead.dateid, clientname,
            (sostock.iss/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qty,
            (qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qa from
            ((sostock left join sohead on sohead.trno=sostock.trno) left join item on item.barcode=sostock.barcode)
            left join uom on uom.itemid=item.itemid and uom.uom='$uom'
            left join transnum as cntnum on cntnum.trno = sohead.trno where item.itemid=$itemid
            and sostock.wh ='$wh' and sohead.dateid>='$date' and cntnum.center ='$center'
            union all
            select hsohead.trno, hsohead.doc, hsohead.docno, hsohead.dateid,
            clientname, (hsostock.iss/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qty,
            (qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qa from
            ((hsostock left join hsohead on hsohead.trno=hsostock.trno) left join item on item.barcode=hsostock.barcode)
            left join uom on uom.itemid=item.itemid and uom.uom='$uom' left join transnum as cntnum on cntnum.trno = hsohead.trno
            where item.itemid=$itemid and hsostock.wh ='$wh' and hsohead.dateid>='$date' and cntnum.center ='$center' order by dateid";
         //webproc::showmsg('a',$sql);
         return $sql;

    }

    public static function openWHStock($itemid)
    {
         $center=Yii::$app->session['loggeduser']['center'];
         $sql="select wh.client,wh.clientname,sum(rrstatus.bal) as balance from rrstatus left join client as wh on wh.clientid=rrstatus.whid where
            rrstatus.itemid=$itemid and rrstatus.bal>0 group by wh.client,wh.clientname";
         //webproc::showmsg('a',$sql);
         return $sql;

    }

    //JAC GENERAL ITEM 2016.08.20//
    public static function openGeneralItem()
    {
         $center=Yii::$app->session['loggeduser']['center'];
         $sql="select line,bcode,itemdesc,itembrand,itempart,itemuom,itemshortname,itemgroup,itemcolor,itemmodel,itemclass,itemsize from generalitem";
         //webproc::showmsg('a',$sql);
         $data =  Yii::$app->sbccommon->opentable($sql);
         return $data;
    }

    public static function openGeneralItemline($bcode)
    {
         $center=Yii::$app->session['loggeduser']['center'];
         $sql="select line,bcode,itemdesc,itembrand,itempart,itemuom,itemshortname,itemgroup,itemcolor,itemmodel,itemclass,itemsize from generalitem where bcode = '$bcode'";
         //webproc::showmsg('a',$sql);
         $data =  Yii::$app->sbccommon->opentable($sql);
         return $data;
    }

    public static function getlast_bcode($pref) {  //to get last item with specific prefix
        $length = strlen($pref);
        $common=new Common();
        $Blength=$common->barcodelength();
        $barcode = Yii::$app->sbccommon->datareader("select bcode from generalitem where left(bcode,$length)='$pref' and length(bcode)=$Blength order by bcode desc limit 1");
        return $barcode;
    }

    public static function getlast_bcode_() {
        return Yii::$app->sbccommon->datareader("select bcode from generalitem order by line desc limit 1");
    }

    public static function checkserveasset($bcode) {
        return Yii::$app->sbccommon->datareader("select bcode from fasset where bcode = '$bcode' limit 1");
    }

     public static function deletegenitem($bcode) {
        return Yii::$app->sbccommon->execqry("delete from generalitem where bcode ='$bcode'");
    }
    //END jac


    //========================= FMM ==================================================
    public function openitemfa($itemid) {

        $strSQL="select fa.itemid,fa.barcode,fa.bcode,fa.itemname,fa.shortname,fa.groupid,fa.part,fa.model,fa.brand,fa.class,fa.sizeid,fa.category,fa.color,fa.supp,fa.suppname,fa.code1 as buyer,fa.buyername,fa.itemrem,fa.`engine`,fa.subcode,fa.inv,fa.po,fa.plate,fa.vin,fa.man,fa.manyr,fa.fuel,fa.insurance,ifnull(fa.inexp,'') as vehicleexp,fa.isnew,fa.isused,fa.islease,fa.depamt,fa.depsalvage,fa.deplife,fa.itemprice,ifnull(fa.dtedisposal,'') as dtedisposal,ifnull(datediff(fa.dtedisposal,now()),0) as daydisposal,ifnull(fa.dteacq,'') as dteacq,round(ifnull(datediff(fa.dteacq,now()),0)/365,2) as acqyr,ifnull(fa.dteinv,'') as dteinv,ifnull(fa.dtepo,'') as dtepo,ifnull(fa.dtewarranty,'') as dtewarranty,ifnull(datediff(fa.dtewarranty,now()),0)as daywarranty,ifnull(fa.dtelease,'') as dtelease,ifnull(datediff(fa.dtelease,now()),0) as daylease,fa.department,fa.deptname,fa.employee as emp,fa.bldg,fa.room,fa.floor,fa.region,ifnull(fa.dtetransfer,'') as locdate,img.picture from fasset as fa left join faimages as img on img.codeid=fa.itemid where fa.itemid='$itemid'
        ";

        $data = Yii::$app->sbccommon->opentable($strSQL);     
        if (!empty($data)) {
            return $data;
        }
    }  


    public static function getlast_barcode2($pref) {  //to get last item with specific prefix
        $length = strlen($pref);
        $common=new Common();
        $Blength=$common->barcodelength();
        $barcode = Yii::$app->sbccommon->datareader("select barcode from fasset where left(barcode,$length)='$pref' and length(barcode)=$Blength order by barcode desc limit 1");
        return $barcode;
    }        


   public static function checkbarcodefa($barcode) {
        $strSQL="select ifnull(itemid,0) as itemid from fasset where barcode='$barcode'";
        $itemid= Yii::$app->sbccommon->datareader($strSQL);
        if(empty($itemid) || $itemid==''){
            $itemid=0;
        }
         return $itemid;
    }  

   public function insertitemfa($data){
        $user=Yii::$app->session['loggeduser']['username'];
        $center=Yii::$app->session['loggeduser']['center'];
        $data->itemname=preg_replace( "/'/", "`", $data->itemname);
        $data->shortname=preg_replace( "/'/", "`", $data->shortname);
        $data->bcode=preg_replace( "/'/", "`", $data->bcode);
        $data->groupid=preg_replace( "/'/", "`", $data->groupid);
        $data->category=preg_replace( "/'/", "`", $data->category);
        $data->model=preg_replace( "/'/", "`", $data->model);
        $data->brand=preg_replace( "/'/", "`", $data->brand);        
        $data->color=preg_replace( "/'/", "`", $data->color);          
        $data->part=preg_replace( "/'/", "`", $data->part);                  
        $data->class=preg_replace( "/'/", "`", $data->class);           
        $data->subcode=preg_replace( "/'/", "`", $data->subcode);                       
        $data->sizeid=preg_replace( "/'/", "`", $data->sizeid);                               
        $data->itemrem=preg_replace( "/'/", "`", $data->itemrem);   
        $data->depamt=preg_replace( "/,/", "", $data->depamt);        
        $data->depsalvage=preg_replace( "/'/", "`", $data->depsalvage);             
        $data->supp=preg_replace( "/'/", "`", $data->supp);             
        $data->suppname=preg_replace( "/'/", "`", $data->suppname);             
        $data->buyer=preg_replace( "/'/", "`", $data->buyer);   
        $data->buyername=preg_replace( "/'/", "`", $data->buyername);   
        $data->inv=preg_replace( "/'/", "`", $data->inv);  
        $data->po=preg_replace( "/'/", "`", $data->po);  
        $data->plate=preg_replace( "/'/", "`", $data->plate);          
        $data->man=preg_replace( "/'/", "`", $data->man);             
        $data->fuel=preg_replace( "/'/", "`", $data->fuel);    
        $data->insurance=preg_replace( "/'/", "`", $data->insurance);            
        $data->vin=preg_replace( "/'/", "`", $data->vin);            
        $data->manyr=preg_replace( "/'/", "`", $data->manyr);         
        $data->engine=preg_replace( "/'/", "`", $data->engine); 

        $strField="";
        $strValue="";

        $strField=",dteacq";
        if($data->dteacq==null || $data->dteacq==''){  
            $strValue=",null";            
        }else{
             $strValue=",'$data->dteacq'";
        }

        $strField = $strField.",inexp";
        if($data->vehicleexp==null || $data->vehicleexp==''){
            $strValue = $strValue.",null";   
        }else{
            $strValue = $strValue.",'$data->vehicleexp'";              
        }

        $strField = $strField.",dtelease";
        if($data->dtelease==null || $data->dtelease==''){
            $strValue = $strValue.",null";   
        }else{
            $strValue = $strValue.",'$data->dtelease'";              
        }

        $strField = $strField.",dtewarranty";
        if($data->dtewarranty==null || $data->dtewarranty==''){
            $strValue = $strValue.",null";   
        }else{
            $strValue = $strValue.",'$data->dtewarranty'";              
        }
       
        $strField = $strField.",dtepo";
        if($data->dtepo==null || $data->dtepo==''){
            $strValue = $strValue.",null";   
        }else{
            $strValue = $strValue.",'$data->dtepo'";              
        }       
   
        $strField = $strField.",dteinv";
        if($data->dteinv==null || $data->dteinv==''){
            $strValue = $strValue.",null";   
        }else{
            $strValue = $strValue.",'$data->dteinv'";              
        }   

        $strField = $strField.",dtedisposal";
        if($data->dtedisposal==null || $data->dtedisposal==''){
            $strValue = $strValue.",null";   
        }else{
            $strValue = $strValue.",'$data->dtedisposal'";              
        }          

        $strSQL="insert into fasset (barcode,itemname,bcode,shortname,groupid,category,model,brand,color,part,class,subcode,sizeid,itemrem,supp,suppname,code1,buyername,inv,po,plate,man,fuel,insurance,vin,manyr,`engine`,depamt,depsalvage,isnew,isused,islease".$strField.") 
        values('$data->barcode','$data->itemname','$data->bcode','$data->shortname','$data->groupid','$data->category','$data->model','$data->brand','$data->color','$data->part','$data->class','$data->subcode','$data->sizeid','$data->itemrem','$data->supp','$data->suppname','$data->buyer','$data->buyername','$data->inv','$data->po','$data->plate','$data->man','$data->fuel','$data->insurance','$data->vin','$data->manyr','$data->engine','$data->depamt','$data->depsalvage',$data->isnew,$data->isused,$data->islease".$strValue.")";            

        $insert = Yii::$app->sbccommon->execqry($strSQL);
        
        $itemid = Item::itemid2($data->barcode);

        Log::writelog("stockcard", $itemid, "inserted item", $data->barcode,Yii::$app->session['loggeduser']['username']); 
        if($insert == 1) {
            return array('itemid' =>$itemid,'msg'=>'Item added sucessfully.');
        } else {
            return array('itemid' =>'','msg'=>"error insert item");
        }//end if insert
    }//end function       
    
    public static function itemid2($barcode) {
        $item = Yii::$app->sbccommon->datareader("select itemid from fasset where barcode='$barcode'");
        if ($item != null || !empty($item)) {
            return $item;
        } else {
            return false;
        }
    }        

    public function updatefa($data) {
        $itemid = Item::itemid2($data->barcode); 

        $user=Yii::$app->session['loggeduser']['username'];
        $data->itemname=preg_replace( "/'/", "`", $data->itemname);
        $data->shortname=preg_replace( "/'/", "`", $data->shortname);
        $data->bcode=preg_replace( "/'/", "`", $data->bcode);
        $data->groupid=preg_replace( "/'/", "`", $data->groupid);
        $data->category=preg_replace( "/'/", "`", $data->category);
        $data->model=preg_replace( "/'/", "`", $data->model);
        $data->brand=preg_replace( "/'/", "`", $data->brand);        
        $data->color=preg_replace( "/'/", "`", $data->color);          
        $data->part=preg_replace( "/'/", "`", $data->part);                  
        $data->class=preg_replace( "/'/", "`", $data->class);           
        $data->subcode=preg_replace( "/'/", "`", $data->subcode);                       
        $data->sizeid=preg_replace( "/'/", "`", $data->sizeid);                               
        $data->itemrem=preg_replace( "/'/", "`", $data->itemrem);   
        $data->depamt=preg_replace( "/,/", "", $data->depamt);    
        $data->depsalvage=preg_replace( "/'/", "`", $data->depsalvage);             
        $data->supp=preg_replace( "/'/", "`", $data->supp);             
        $data->suppname=preg_replace( "/'/", "`", $data->suppname);             
        $data->buyer=preg_replace( "/'/", "`", $data->buyer);   
        $data->buyername=preg_replace( "/'/", "`", $data->buyername);   
        $data->inv=preg_replace( "/'/", "`", $data->inv);  
        $data->po=preg_replace( "/'/", "`", $data->po);  
        $data->plate=preg_replace( "/'/", "`", $data->plate);          
        $data->man=preg_replace( "/'/", "`", $data->man);             
        $data->fuel=preg_replace( "/'/", "`", $data->fuel);    
        $data->insurance=preg_replace( "/'/", "`", $data->insurance);            
        $data->vin=preg_replace( "/'/", "`", $data->vin);            
        $data->manyr=preg_replace( "/'/", "`", $data->manyr);         
        $data->engine=preg_replace( "/'/", "`", $data->engine); 

        $strDate="";
        if($data->dteacq==null || $data->dteacq==''){  
            $strDate = ",dteacq=null"; 
        }else{
            $strDate = ",dteacq='$data->dteacq'"; 
        }

        if($data->vehicleexp==null || $data->vehicleexp==''){
            $strDate = $strDate.",inexp=null"; 
        }else{
            $strDate = $strDate.",inexp='$data->vehicleexp'";             
        }

        if($data->dtelease==null || $data->dtelease==''){
            $strDate = $strDate.",dtelease=null"; 
        }else{
            $strDate = $strDate.",dtelease='$data->dtelease'";             
        }

        if($data->dtewarranty==null || $data->dtewarranty==''){
            $strDate = $strDate.",dtewarranty=null"; 
        }else{
            $strDate = $strDate.",dtewarranty='$data->dtewarranty'";             
        }        

        if($data->dtepo==null || $data->dtepo==''){
            $strDate = $strDate.",dtepo=null"; 
        }else{
            $strDate = $strDate.",dtepo='$data->dtepo'";             
        }      

        if($data->dteinv==null || $data->dteinv==''){
            $strDate = $strDate.",dteinv=null"; 
        }else{
            $strDate = $strDate.",dteinv='$data->dteinv'";             
        }    

        if($data->dtedisposal==null || $data->dtedisposal==''){
            $strDate = $strDate.",dtedisposal=null"; 
        }else{
            $strDate = $strDate.",dtedisposal='$data->dtedisposal'";             
        }                      

        $strSQL = "update fasset set itemname='$data->itemname', shortname='$data->shortname',bcode='$data->bcode',groupid='$data->groupid',category='$data->category',model='$data->model',brand='$data->brand',color='$data->color',part='$data->part',class='$data->class',subcode='$data->subcode',sizeid='$data->sizeid',itemrem='$data->itemrem',depamt='$data->depamt',depsalvage='$data->depsalvage',deplife='$data->deplife',supp='$data->supp',suppname='$data->suppname',code1='$data->buyer',buyername='$data->buyername',inv='$data->inv',po='$data->po',itemprice='$data->itemprice',plate='$data->plate',man='$data->man',fuel='$data->fuel',insurance='$data->insurance',vin='$data->vin',manyr='$data->manyr',`engine`='$data->engine',isnew=$data->isnew,isused=$data->isused,islease=$data->islease".$strDate." where itemid=$data->itemid";

        $update = Yii::$app->sbccommon->execqry($strSQL);

        Log::writelog("stockcard", $itemid, "UPDATED", $data->barcode,Yii::$app->session['loggeduser']['username']);

        if($update) {
            return array('itemid' =>$itemid,'msg'=>'Item Updated!','err_uom'=>'','errstat'=>0);
        } else {
            return array('itemid' =>$itemid,'msg'=>"error update item",'errstat'=>1);
        }
    }    

    function deleteitemfa($itemid,$count) {
        if($count==0){
            if (Yii::$app->sbccommon->execqry("DELETE from fasset where itemid='$itemid'") == 1) {
            $barcode = $this->barcode($itemid);
            Log::del_log('ITEMS', $itemid, $barcode);
            return array('status'=>1,'del_msg'=>'');
           }
        }else{
            return array('status'=>0,'del_msg'=>'Item cant be deleted , Already have transaction!');
        }
    }       

    //========================================= END FMM =================================================


}