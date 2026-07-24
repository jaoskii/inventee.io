<?php


namespace app\models;
use Yii;
use yii\base\Model;
use yii\base\ErrorException;

date_default_timezone_set('Asia/Singapore');

class Client extends Model
{
                        //unused in view in Customer Ledger
    public $newclient; 
    public $clientid;
    public $client;
    public $clientname;
    public $terms; 
    public $rem; 
    public $province; //
    public $owner; //
    public $autochecksign; //
    public $addr;
    public $area;
    public $pricegroup;
    public $status;
    public $start;
    public $region;
    public $crlimit;
    public $groupid;
    public $category;
    public $addr2; //
    public $tel; 
    public $tel2; 
    public $tin;
    public $type; 
    public $fax; //
    public $tax; 
    public $ship; //
    public $contact; //
    public $vendorname; //
    public $pword; //
    public $agent;
    public $agentcode;
    public $parent; //
    public $IsAgent;
    public $IsCustomer;
    public $IsExempt;
    public $IsSupplier;
    public $IsWarehouse;
    public $IsEmployee;
    public $IsBranch;
    public $IsInactive;
    public $IsDefault; //
    public $clearing;  //
    public $IsZeroRated; //
    public $isLocation;
    public $isVendor;
    public $building;
    public $floor;
    public $email;
    public $disc;
    public $quota;
    public $charge1;
    public $charge2;

    public $createby;//ADDED BY JAO
    public $center;//ADDDED BY JAO
    public $picture;
    
    public $collectionarea;
    public $collectionareaid;
    public $distributionarea;
    public $distributionareaid;
    public $categoryname;
    public $categorynameid;

    public $route;
    public $routeid;
    public $sccity;
    public $sccityid;
    public $scprovname;
    public $scterrname;
    public $aguser;
    public $agpass;
    public $rev;

    public $registeredfrom;

    // ASSET MASTER
    public $isasset;
    public $category2;
    public $location;
    public $acquireddate;
    public $warrantexpiry;
    public $servicedate;
    public $solddisposeddate;
    public $year;
    public $make;
    public $model2;
    public $color;
    public $motorno;
    public $serialno;
    public $renewaldate;
    public $insurer;
    public $insurancepol;

    public $grpcode;


    public $isallitems;
    public $isallwh;
    public $issyncbranch;
    public $acno;

    public $uv_ispicker;
    public $uv_ischecker;

    public $agentpassword;
    
    public $bstyle;

    public $waybilldate;
    public $voyage;
    public $billlading;
    
	public function tableName(){
		return 'client';
	}//end f

	public function rules(){
		
		return array(
                    
                        array('client,clientname', 'required'),
                        array('client', 'length', 'max'=>15),
                        array('tax', 'length', 'max'=>19),
                        array('disc', 'length', 'max'=>40),
                        array('crlimit', 'length', 'max'=>18),
                        array('pricegroup', 'length', 'max'=>1),
                        array('clientname, province, owner,  agent, autochecksign', 'length', 'max'=>250),
                        array('terms,type', 'length', 'max'=>30),
                        array('rem', 'length', 'max'=>500),
                        array('addr, addr2, tel, tel2, fax, ship, contact, vendorname', 'length', 'max'=>150),
                        array('pword,agentcode, parent', 'length', 'max'=>20),
                        array('status,region,tin,quota', 'length', 'max'=>50),
                        array('area,groupid', 'length', 'max'=>25),
                        array('IsAgent, IsCustomer, IsSupplier, IsWarehouse, IsEmployee, IsInactive, IsDefault, clearing, IsZeroRated', 'numerical', 'integerOnly'=>true),
                        array('email', 'length', 'max'=>130),
                        array('email', 'email'),
                        array('start,building,floor,isVendor,isLocation', 'safe'),
                    /*
			array('IsAgent, IsCustomer, IsSupplier, IsWareHouse, IsEmployee, IsInActive, IsDefault, Clearing, IsZeroRated', 'numerical', 'integerOnly'=>true),
			array('client, ASS, REV, LIA', 'length', 'max'=>15),
			//array('ClientName, Province, Owner, AUTOCHECKSIGN', 'length', 'max'=>250),
			array('Email', 'length', 'max'=>130),
			array('Pword, AGENT, Parent', 'length', 'max'=>20),
			array('Addr, Addr2, Tel, Tel2, FAX, SHIP, CONTACT, VendorName', 'length', 'max'=>150),
			array('COMM, TAX, AR, AP, SA, DS', 'length', 'max'=>19),
			array('TERMS', 'length', 'max'=>30),
			array('DISC', 'length', 'max'=>40),
			array('REM', 'length', 'max'=>500),
			array('PG', 'length', 'max'=>5),
			array('DBLIMIT, CRLIMIT, Quota', 'length', 'max'=>18),
			array('CONFI', 'length', 'max'=>4),
			array('TYPE, Class', 'length', 'max'=>1),
			array('TIN, Status, Region, TEU, AccountID, Alias', 'length', 'max'=>50),
			array('Area, GroupID, Category', 'length', 'max'=>25),
			array('Password, Ship1', 'length', 'max'=>45),
			array('BDAY, LOCK, Start', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ClientID, Client, ClientName, Email, Pword, Addr, Addr2, Tel, Tel2, BDAY, FAX, SHIP, AGENT, CONTACT, COMM, TERMS, TAX, DISC, REM, ASS, REV, LIA, Parent, PG, DBLIMIT, CRLIMIT, LOCK, CONFI, TYPE, TIN, IsAgent, IsCustomer, IsSupplier, IsWareHouse, IsEmployee, Area, GroupID, Province, Class, Category, IsInActive, AR, AP, SA, DS, Status, Start, Region, IsDefault, Quota, TEU, Clearing, AccountID, Password, IsZeroRated, Alias, VendorName, Owner, AUTOCHECKSIGN, Ship1', 'safe', 'on'=>'search'),

                     *
                     */
                    );
	}
	public function attributeLabels()
	{
		return array(
			'ClientID' => 'Client',
			'Client' => 'Client',
			'ClientName' => 'Client Name',
			'email' => 'Email',
			'Pword' => 'Pword',
			'Addr' => 'Addr',
			'Addr2' => 'Addr2',
			'Tel' => 'Tel',
			'Tel2' => 'Tel2',
			'BDAY' => 'Bday',
			'FAX' => 'Fax',
			'SHIP' => 'Ship',
			'AGENT' => 'Agent',
			'CONTACT' => 'Contact',
			'COMM' => 'Comm',
			'TERMS' => 'Terms',
			'TAX' => 'Tax',
			'DISC' => 'Disc',
			'REM' => 'Rem',
			'ASS' => 'Ass',
			'REV' => 'Rev',
			'LIA' => 'Lia',
			'Parent' => 'Parent',
			'PG' => 'Pg',
			'DBLIMIT' => 'Dblimit',
			'CRLIMIT' => 'Crlimit',
			'LOCK' => 'Lock',
			'CONFI' => 'Confi',
			'TYPE' => 'Type',
			'TIN' => 'Tin',
            'quota' => 'Quota',
			'IsAgent' => 'Is Agent',
			'IsCustomer' => 'Is Customer',
			'IsSupplier' => 'Is Supplier',
			'IsWareHouse' => 'Is Ware House',
			'IsEmployee' => 'Is Employee',
			'Area' => 'Area',
			'GroupID' => 'Group',
			'Province' => 'Province',
			'Class' => 'Class',
			'Category' => 'Category',
			'IsInActive' => 'Inactive',
			'AR' => 'Ar',
			'AP' => 'Ap',
			'SA' => 'Sa',
			'DS' => 'Ds',
			'Status' => 'Status',
			'start' => 'Date Started',
			'Region' => 'Region',
			'IsDefault' => 'Default',
			'Quota' => 'Quota',
			'TEU' => 'Teu',
			'Clearing' => 'Clearing',
			'AccountID' => 'Account',
			'Password' => 'Password',
			'IsZeroRated' => 'Zero Rated',
			'Alias' => 'Alias',
			'VendorName' => 'Vendor Name',
			'Owner' => 'Owner',
			'AUTOCHECKSIGN' => 'Autochecksign',
			'Ship1' => 'Ship1',
		);
	}
        public static function getclient($clientid){
            return Yii::$app->sbccommon->datareader("select client from client where clientid='$clientid'");
        }
        public function suggestAllCLient($keywords,$limit=20)
	{
            $keyword=explode(",",$keywords);
            $sql ="select client.clientid, client.client, client.clientname, client.addr, client.terms,client.agent as agent,agent.clientname as agentname,
                client.tel, client.agent, client.email,client.quota,client.tin,
                client.iscustomer, client.isagent, client.issupplier,client.iswarehouse, client.isemployee, client.isinactive
                from client
                left join client as agent on client.agent=agent.client
                where ";

            $criteria="";

            for($i=0;$i<count($keyword);$i++)
            {
                if ($criteria=="")
                    {
                    $criteria = "(client.clientname like '%".$keyword[$i]."%' or client.client like '%".$keyword[$i]."%')";
                    }
                else
                    {
                    $criteria = $criteria." and "."(client.clientname like '%".$keyword[$i]."%' or client.client like '%".$keyword[$i]."%')";
                    }
            }

            		$models=Yii::$app->sbccommon->opentable($sql." ".$criteria."  order by client.clientname asc limit $limit");
		
        $suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model['clientname'].' - '.$model['client'],  // label for dropdown list
				'value'=>$model['clientname'],  // value for input field
				'id'=>$model['clientid'],       // return values from autocomplete
				'client_code'=>$model['client'],
				'address'=>$model['addr'],
                                'terms'=>$model['terms'],
                                'agent'=>$model['agent'],
                                'agentname'=>$model['agentname'],
                                'clientid'=>$model['clientid'],
				'client'=>$model['client'],
                                'clientname'=>$model['clientname'],
				'address'=>$model['addr'],
                                'terms'=>$model['terms'],
                                'tel'=>$model['tel'],
                                'tin'=>$model['tin'],
                                'quota'=>$model['quota'],
                                'agent'=>$model['agent'],
                                'email'=>$model['email'],
                                'iscustomer'=>$model['iscustomer'],
                                'isagent'=>$model['isagent'],
                                'issupplier'=>$model['issupplier'],
                                'iswarehouse'=>$model['iswarehouse'],
                                'isemployee'=>$model['isemployee'],
                                'isinactive'=>$model['isinactive'],

			);
		}
		return $suggest;
	}
        public function suggestAllCLientcode($keywords,$limit=20)
	{
            $keyword=explode(",",$keywords);
            $sql ="select client.clientid, client.client, client.clientname, client.addr, client.terms,client.agent as agent,agent.clientname as agentname,
                client.tel, client.agent, client.email,client.quota,client.tin,
                client.iscustomer, client.isagent, client.issupplier,client.iswarehouse, client.isemployee, client.isinactive
                from client
                left join client as agent on client.agent=agent.client
                where ";
            $criteria="";
            for($i=0;$i<count($keyword);$i++)
            {
                if ($criteria=="")
                    {
                    $criteria = "(client.clientname like '%".$keyword[$i]."%' or client.client like '%".$keyword[$i]."%')";
                    }
                else
                    {
                    $criteria = $criteria." and "."(client.clientname like '%".$keyword[$i]."%' or client.client like '%".$keyword[$i]."%')";
                    }
            }

            		$models=Yii::$app->sbccommon->opentable($sql." ".$criteria."  order by client.clientname asc limit $limit");

		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model['client'].' - '.$model['clientname'],  // label for dropdown list
				'value'=>$model['client'],  // value for input field
				'id'=>$model['clientid'],       // return values from autocomplete
				'client_code'=>$model['client'],
				'address'=>$model['addr'],
                                'terms'=>$model['terms'],
                                'agent'=>$model['agent'],
                                'agentname'=>$model['agentname'],
                                'clientid'=>$model['clientid'],
				'client'=>$model['client'],
                                'clientname'=>$model['clientname'],
				'address'=>$model['addr'],
                                'terms'=>$model['terms'],
                                'tel'=>$model['tel'],
                                'tin'=>$model['tin'],
                                'quota'=>$model['quota'],
                                'agent'=>$model['agent'],
                                'email'=>$model['email'],
                                'iscustomer'=>$model['iscustomer'],
                                'isagent'=>$model['isagent'],
                                'issupplier'=>$model['issupplier'],
                                'iswarehouse'=>$model['iswarehouse'],
                                'isemployee'=>$model['isemployee'],
                                'isinactive'=>$model['isinactive'],

			);
		}
		return $suggest;
	}
        public function suggestSupplier($keywords,$limit=20)
	{
            $keyword=explode(",",$keywords);
            $sql ="select client.clientid, client.client, client.clientname, client.addr, client.terms,client.agent as agent,agent.clientname as agentname,
                client.tel, client.agent, client.email,client.quota,client.tin,
                client.iscustomer, client.isagent, client.issupplier,client.iswarehouse, client.isemployee, client.isinactive
                from client
                left join client as agent on client.agent=agent.client
                where ";
            $criteria="";
            for($i=0;$i<count($keyword);$i++)
            {
                if ($criteria=="")
                    {
                    $criteria = "(client.clientname like '%".$keyword[$i]."%' or client.client like '%".$keyword[$i]."%')";
                    }
                else
                    {
                    $criteria = $criteria." and "."(client.clientname like '%".$keyword[$i]."%' or client.client like '%".$keyword[$i]."%')";
                    }
            }

            		$models=Yii::$app->sbccommon->opentable($sql." ".$criteria." and client.issupplier=1 order by client.clientname asc limit $limit");

		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model['clientname'].' - '.$model['client'],  // label for dropdown list
				'value'=>$model['clientname'],  // value for input field
				'id'=>$model['clientid'],       // return values from autocomplete
				'client_code'=>$model['client'],
				'address'=>$model['addr'],
                                'terms'=>$model['terms'],
                                'agent'=>$model['agent'],
                                'agentname'=>$model['agentname'],
                                'clientid'=>$model['clientid'],
				'client'=>$model['client'],
                                'clientname'=>$model['clientname'],
				'address'=>$model['addr'],
                                'terms'=>$model['terms'],
                                'tel'=>$model['tel'],
                                'tin'=>$model['tin'],
                                'quota'=>$model['quota'],
                                'agent'=>$model['agent'],
                                'email'=>$model['email'],
                                'iscustomer'=>$model['iscustomer'],
                                'isagent'=>$model['isagent'],
                                'issupplier'=>$model['issupplier'],
                                'iswarehouse'=>$model['iswarehouse'],
                                'isemployee'=>$model['isemployee'],
                                'isinactive'=>$model['isinactive'],

			);
		}
		return $suggest;
	}
        
        public function suggestlocavailable($keywords,$limit=20)
	{
            $barcode=Yii::$app->session['barcode'];
            $wh=Yii::$app->session['whcode'];
            $sql ="select rrstatus.loc as client,rrstatus.loc as locname, rrstatus.bal as clientname from rrstatus left join item on item.itemid=rrstatus.itemid left join client as wh on wh.clientid=rrstatus.whid  where item.barcode='$barcode' and wh.client='$wh' and rrstatus.bal>0";
                        
            $models=Yii::$app->sbccommon->opentable($sql." limit $limit");
                $models=Yii::$app->sbccommon->opentable($sql);
		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model['clientname'].' - '.$model['locname'],  // label for dropdown list
				'value'=>$model['locname'],  // value for input field
				'id'=>$model['client'],       // return values from autocomplete
				'client_code'=>$model['client'],                                
                                'client_name'=>$model['clientname'],
			);
		}
		return $suggest;
                
	}
        
        
        public function suggestWarehouse($keywords,$limit=20)
	{
            $keyword=explode(",",$keywords);
            $sql ="select clientid, client, clientname, addr, terms from client where ";
            $criteria="";
            for($i=0;$i<count($keyword);$i++)
            {
                if ($criteria=="")
                    {
                    $criteria = "(clientname like '%".$keyword[$i]."%' or client like '%".$keyword[$i]."%')";
                    }
                else
                    {
                    $criteria = $criteria." and "."(clientname like '%".$keyword[$i]."%' or client like '%".$keyword[$i]."%')";
                    }
            }

            		$models=Yii::$app->sbccommon->opentable($sql." ".$criteria." and iswarehouse=1 order by clientname asc limit $limit");

		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model['clientname'].' - '.$model['client'],  // label for dropdown list
				'value'=>$model['clientname'],  // value for input field
				'id'=>$model['clientid'],       // return values from autocomplete
				'client_code'=>$model['client'],
                                'clientid'=>$model['clientid'],
                                'client_name'=>$model['clientname'],
				'address'=>$model['addr'],
                                'terms'=>$model['terms'],

			);
		}
		return $suggest;
	}
        
        public function suggestWarehousecode($keywords,$limit=20)
	{
            $keyword=explode(",",$keywords);
            $sql ="select clientid, client, clientname, addr, terms from client where ";
            $criteria="";
            for($i=0;$i<count($keyword);$i++)
            {
                if ($criteria=="")
                    {
                    $criteria = "(clientname like '%".$keyword[$i]."%' or client like '%".$keyword[$i]."%')";
                    }
                else
                    {
                    $criteria = $criteria." and "."(clientname like '%".$keyword[$i]."%' or client like '%".$keyword[$i]."%')";
                    }
            }

            		$models=Yii::$app->sbccommon->opentable($sql." ".$criteria." and iswarehouse=1 order by clientname asc limit $limit");

		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model['clientname'].' - '.$model['client'],  // label for dropdown list
				'value'=>$model['client'],  // value for input field
				'id'=>$model['clientid'],       // return values from autocomplete
				'client_code'=>$model['client'],
                                'client_name'=>$model['clientname'],
				'address'=>$model['addr'],
                                'terms'=>$model['terms'],

			);
		}
		return $suggest;
	}
        public function suggestAgent($keywords,$limit=20)
	{
            $keyword=explode(",",$keywords);
            $sql ="select clientid, client, clientname, addr, terms,tin,quota from client where ";
            $criteria="";
            for($i=0;$i<count($keyword);$i++)
            {
                if ($criteria=="")
                    {
                    $criteria = "(clientname like '%".$keyword[$i]."%' or client like '%".$keyword[$i]."%')";
                    }
                else
                    {
                    $criteria = $criteria." and "."(clientname like '%".$keyword[$i]."%' or client like '%".$keyword[$i]."%')";
                    }
            }

                $models=Yii::$app->sbccommon->opentable($sql." ".$criteria." and isagent=1 order by clientname asc limit $limit");
		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model['clientname'].' - '.$model['client'],  // label for dropdown list
				'value'=>$model['clientname'],  // value for input field
				'id'=>$model['clientid'],       // return values from autocomplete
				'agent_code'=>$model['client'],
                                'agent_name'=>$model['clientname'],
				'address'=>$model['addr'],
                                'terms'=>$model['terms'],
                                'clientid'=>$model['clientid'],
                                'tin'=>$model['tin'],
                                'quota'=>$model['quota'],

			);
		}
		return $suggest;
	}
        public function suggestSupplierCode($keywords,$limit=20)
	{
            $keyword=explode(",",$keywords);
            $sql ="select client.clientid, client.client, client.clientname, client.addr, client.terms,client.agent as agent,agent.clientname as agentname
                from client
                left join client as agent on client.agent=agent.client
                where ";
            $criteria="";
            for($i=0;$i<count($keyword);$i++)
            {
                if ($criteria=="")
                    {
                    $criteria = "(client.clientname like '%".$keyword[$i]."%' or client.client like '%".$keyword[$i]."%')";
                    }
                else
                    {
                    $criteria = $criteria." and "."(client.clientname like '%".$keyword[$i]."%' or client.client like '%".$keyword[$i]."%')";
                    }
            }

                $models=Yii::$app->sbccommon->opentable($sql." ".$criteria." and client.issupplier=1 order by client.client asc limit $limit");

		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model['client'].' - '.$model['clientname'],  // label for dropdown list
				'value'=>$model['client'],  // value for input field
				'id'=>$model['clientid'],       // return values from autocomplete
				'client_code'=>$model['client'],
				'address'=>$model['addr'],
                                'name'=>$model['clientname'],
                                'terms'=>$model['terms'],
                                'agent'=>$model['agent'],
                                'agentname'=>$model['agentname'],
			);
		}
		return $suggest;
	}
        public function suggestClient($keywords,$limit=20,$iscustomer='1') // this is compatible with suggestSupplier
	{
            $keyword=explode(",",$keywords);
            $sql =" select clientid, client, clientname, addr, terms, tel, agent, email,tin,quota,
                    iscustomer, isagent, issupplier,iswarehouse, isemployee, isinactive
                    from client where ";
            $criteria="";
            for($i=0;$i<count($keyword);$i++)
            {
                if ($criteria=="")
                    {
                    $criteria = "(clientname like '%".$keyword[$i]."%' or client like '%".$keyword[$i]."%')";
                    }
                else
                    {
                    $criteria = $criteria." and "."(clientname like '%".$keyword[$i]."%' or client like '%".$keyword[$i]."%')";
                    }
            }
            if($iscustomer=='1'){
                $models=Yii::$app->sbccommon->opentable($sql." ".$criteria." and iscustomer=1 order by client asc limit $limit");
            }else{$models=Yii::$app->sbccommon->opentable($sql." ".$criteria." and issupplier=1 order by client asc limit $limit");}
		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model['client'].' - '.$model['clientname'],  // label for dropdown list
				'value'=>$model['clientname'],  // value for input field
				'id'=>$model['clientid'],       // return values from autocomplete
                                'clientid'=>$model['clientid'],
				'client'=>$model['client'],
                                'clientname'=>$model['clientname'],
				'address'=>$model['addr'],
                                'terms'=>$model['terms'],
                                'tel'=>$model['tel'],
                                'agent'=>$model['agent'],
                                'email'=>$model['email'],
                                'iscustomer'=>$model['iscustomer'],
                                'isagent'=>$model['isagent'],
                                'issupplier'=>$model['issupplier'],
                                'iswarehouse'=>$model['iswarehouse'],
                                'isemployee'=>$model['isemployee'],
                                'isinactive'=>$model['isinactive'],
                            'tin'=>$model['tin'],
                                'quota'=>$model['quota'],
			);
		}
		return $suggest;
	}
        
        public function suggestClientCode($keywords,$limit=20)
	{
            $keyword=explode(",",$keywords);
            $sql ="select client.clientid, client.client, client.clientname, client.addr, client.terms,client.agent as agent,agent.clientname as agentname
                from client
                left join client as agent on agent.client=client.agent
                where ";
            $criteria="";
            for($i=0;$i<count($keyword);$i++)
            {
                if ($criteria=="")
                    {
                    $criteria = "(client.clientname like '%".$keyword[$i]."%' or client.client like '%".$keyword[$i]."%')";
                    }
                else
                    {
                    $criteria = $criteria." and "."(client.clientname like '%".$keyword[$i]."%' or client.client like '%".$keyword[$i]."%')";
                    }
            }

                $models=Yii::$app->sbccommon->opentable($sql." ".$criteria." and client.iscustomer=1 order by client.client asc limit $limit");

		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model['client'].' - '.$model['clientname'],  // label for dropdown list
				'value'=>$model['client'],  // value for input field
				'id'=>$model['clientid'],       // return values from autocomplete
				'client_code'=>$model['client'],
				'address'=>$model['addr'],
                                'name'=>$model['clientname'],
                                'terms'=>$model['terms'],
                                'agent'=>$model['agent'],
                                'agentname'=>$model['agentname'],
			);
		}
		return $suggest;
	}
        
        public function suggestClientHo($keywords,$limit=20)
	{
            $keyword=explode(",",$keywords);
            $sql ="select client,clientname,address,tel,wh,terms,yourref,ourref from hsohead where ";
            $criteria="";
            for($i=0;$i<count($keyword);$i++)
            {
                if ($criteria=="")
                    {
                    $criteria = "(clientname like '%".$keyword[$i]."%' or client like '%".$keyword[$i]."%')";
                    $criteria = "(yourref like '%".$keyword[$i]."%' or ourref like '%".$keyword[$i]."%')";
                    }
                else
                    {
                    $criteria = $criteria." and "."(clientname like '%".$keyword[$i]."%' or client like '%".$keyword[$i]."%')";
                    $criteria = $criteria." and "."(yourref like '%".$keyword[$i]."%' or ourref like '%".$keyword[$i]."%')";
                    }
            }

                $models=Yii::$app->sbccommon->opentable($sql." ".$criteria."  order by client asc limit $limit");

		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model['client'].' - '.$model['clientname'] .' - '.$model['yourref'],  // label for dropdown list
				'value'=>$model['client'],  // value for input field
				'id'=>$model['client'],       // return values from autocomplete
				'address'=>$model['address'],
                                'name'=>$model['clientname'],
                                'warehouse'=>$model['wh'],
                                'yourref'=>$model['yourref'],
                                'ourref'=>$model['ourref'],
			);
		}
		return $suggest;
	}
        
        
        public static function getWarehouses(){
        
            $data=Yii::$app->sbccommon->opentable("SELECT  clientid, client, clientname from client where iswarehouse=1 order by clientname");

            if(!empty($data))
                {
                           $uom=array();
                        foreach($data as $key => $data_)
                            {
                            $uom1=array('id'=>strtoupper($data_['client']),'clientid'=>strtoupper($data_['clientid']),'clientname'=>$data_['clientname']);
                            array_push($uom, $uom1);
                            }
                             return $uom;
                }
            else
                {
                return $data;
                }
        }

        public static function openclient($clientid,$type){
            switch($type){
                case 'customer': case 'customerdetail' :
                    $field='iscustomer';
                    $filter = "and c.$field=1";
                break;
                
                case 'customer_scheduler':
                    $field='iscustomer';
                    $filter = "and c.$field=1";
                break;
                
                case 'supplier':
                    $field='issupplier';
                    $filter = "and c.$field=1";
                break;
                
                case 'warehouse':
                    $field='iswarehouse';
                    $filter = '';
                break;
                
                case 'agent':
                    $field='isagent';
                    $filter = "and c.$field=1";
                break;
                
                case 'location':
                    $field='islocation';
                    $filter = "and c.$field=1";
                break;
                
                case 'vendor':
                    $field='isvendor';
                    $filter = "and c.$field=1";
                break;
                
                case 'branch':
                    $field = 'isbranch';
                    $filter = "and c.$field = 1";
                break;

                default:
                    $field = '';
                    $filter = '';
                break;

            }

            $qry = "select c.sccityid,ifnull(sccity.name,'') as sccity,ifnull(scprovince.name,'') as scprovname,ifnull(scterritory.name,'') as scterrname,
                ifnull(route_masterfile.route_name,'') as route,c.scroute as routeid,c.clientid,
                c.client, c.clientname, c.addr, c.terms, c.tel, c.agent as agentcode,agent.clientname as agent,
                c.email,c.tel2,c.tin,c.quota, c.type,c.contact,c.tax,c.rem,c.crlimit,c.area,c.groupid,
                c.province,c.class as pricegroup,c.status,c.region,c.disc,
                if(left(c.start,10)='0000-00-00',null,left(c.start,10)) as start,
                c.IsCustomer, c.IsAgent, c.IsSupplier,c.IsWarehouse, c.IsEmployee, c.IsInactive,c.IsExempt,c.fax ,
                itimages.picture,c.charge1,c.charge2,c.building,c.floor,c.islocation,c.isvendor,c.category,
                collection_area.cllc_name as collectionarea,c.rtt_collectionarea as collectionareaid,distribution_area.dist_name as distributionarea,
                c.rtt_distroarea as distributionareaid,category_masterfile.cat_name as categoryname,category_masterfile.cat_id as categoryid,
                c.scusername as  aguser,c.scpassword as agpass,c.rev, c.isasset, c.category2, c.location, 
                c.acquireddate, c.warrantexpiry, c.servicedate, c.solddisposeddate, c.year, c.make, c.model, c.color, 
                c.motorno, c.serialno, c.renewaldate, c.insurer, c.insurancepol,c.grpcode,
                c.isallitems, c.isallwh, c.issyncbranch, c.acno,c.uv_ispicker,c.uv_ischecker,c.password, c.bstyle
                from client as c
                left join client as agent on agent.client=c.agent
                left join itimages on itimages.codeid = c.clientid
                left join collection_area on collection_area.cllc_id = c.rtt_collectionarea
                left join distribution_area on distribution_area.dist_id = c.rtt_distroarea
                left join category_masterfile on category_masterfile.cat_id  = c.category
                left join route_masterfile on route_masterfile.route_id = c.scroute
                left join sccity on sccity.id = c.sccityid
                left join scprovince on scprovince.id = sccity.provid
                left join scterritory on scterritory.id = scprovince.trid
                where c.clientid='$clientid' ".$filter;
            $data= Yii::$app->sbccommon->opentable($qry);
            if(!empty($data)){
                return $data;
            }
        }//END OPENCLIENT


        public static function getlast_client($pref){  //to get last client with specific prefix
            $length=strlen($pref);
            return Yii::$app->sbccommon->datareader("select client from client where left(client,$length)='$pref' order by clientid desc limit 1");
        }
        
        public static function getlast_client_($pref,$type)  //to get last client based on clientid regardless of its prefix
        {
            $length=strlen($pref);
            switch($type){
                case 'customer':{
                    $field='iscustomer';
                    break;
                }
                case 'supplier':{
                    $field='issupplier';
                    break;
                }
                case 'warehouse':{
                    $field='iswarehouse';
                    break;
                }
                case 'agent':{
                    $field='isagent';
                    break;
                }
                //KEYWORD LOCATION&VENDOR
                 case 'location':{
                    $field='islocation';
                    break;
                }
                 case 'vendor':{
                    $field='isvendor';
                    break;
                }

                case 'branch':{
                    $field = 'isbranch';
                    break;
                }//END SWTICH

                case 'assetmaster':
                    $field = 'isasset';
                break;
                //END KEYWORD LOCATION&VENDOR
            }
            
            if($length==0){
               return Yii::$app->sbccommon->datareader("select client from client where $field=1 order by client desc limit 1");
            }else{
            return Yii::$app->sbccommon->datareader("select client from client where left(client,$length)='$pref' and $field=1 order by client desc limit 1");}
        }
        
        
        
        public static function checkPrefixes($prefixes,$pref){
          $blnExist=false;  
          //Webproc::showmsg($prefixes, $pref);
          if (empty($prefixes)) {
                $blnExist = true;
            } else {
                $common = new Common();
                $b = $common->SearchPositionChar($prefixes,',');
                if($b==0){
                  if($pref==$prefixes){
                      $blnExist = true;
                  }else{$blnExist = false;} 
                }else{
                $pr2 = explode(',', $prefixes);
                for ($i = 0; $i < count($pr2); $i++) {
                    if ($pref == $pr2[$i]) {
                        $blnExist = true;
                    }
                  }                    
                }
            }
            return $blnExist;
        }
        
        
        public static function getsingledefaultprefixes($doc){
            
            Switch($doc){
                case 'customer':
                    $type='CL';
                    break;
                case 'supplier':
                    $type='SL';
                    break;
                case 'agent':
                    $type='AG';
                    break;
                case 'warehouse':
                    $type='WH';
                    break;
                case 'employee':
                    $type='EMP';
                    break;
                //KEYWORD LOCATION&VENDOR    
                case 'location':
                    $type='LC';
                    break;    
                case 'vendor':
                    $type='VD';
                    break;   
                case 'assetmaster':
                    $type = 'AM';
                break;

                case 'branch':
                    $type = 'BR';
                break; 

                //END KEYWORD LOCATION&VENDOR
                default:
                    $type='';
                    break;
            }
                $prefixes = Client::getPrefixes($type);
                $common = new Common();
                $b = $common->SearchPositionChar($prefixes,',');
                if($b==0){
                    return $prefixes;
                }else{
                $pr2 = explode(',', $prefixes);
                return $pr2[0];
                }            
        }
        
        public static function getPrefixes($doc)
        {
              //$user=Yii::$app->user->username;
              $valid_prefixes = Yii::$app->sbccommon->datareader("SELECT distinct pvalue FROM profile where doc='SED' and psection='$doc'");
              if(empty($valid_prefixes) || $valid_prefixes==''){
                  $valid_prefixes='';
              }
              return $valid_prefixes;
              //$pref=array();
              //for ($i=0; $i<count($valid_prefixes); $i++)
              //{
              //$prefixes = $valid_prefixes[$i]['pvalue'];
              //array_push($pref, $prefixes);
             // }
             // return $pref;
        }


      public static function iscreditlimit($client,$oldamt,$newamt,$doc)
        {
          if(Yii::$app->sbccommon->datareader("select isinactive from client where client='$client'")==0){
            
                $crlimit= Yii::$app->sbccommon->datareader("select crlimit from client where client='$client'");
              if(empty($crlimit) || $crlimit==''){
                $crlimit=0;
               }
               if($crlimit!=0){
                   $sql="select ifnull(sum(db-cr),0) as bal from (
                   select detail.db,detail.cr from lahead as head left join ladetail as detail on detail.trno=head.trno left join coa on coa.acno=detail.acno where head.client='$client' and left(coa.alias,2)='AR'
                   union all
                   select detail.db,detail.cr from lbhead as head left join lbdetail as detail on detail.trno=head.trno left join coa on coa.acno=detail.acno where head.client='$client' and left(coa.alias,2)='AR'
                   union all
                   select detail.db,detail.cr from lchead as head left join lcdetail as detail on detail.trno=head.trno left join coa on coa.acno=detail.acno where head.client='$client' and left(coa.alias,2)='AR'
                   union all
                   select case when arledger.db<>0 then arledger.bal else 0 end ,case when arledger.cr<>0 then arledger.bal*-1 else 0 end from arledger left join client on client.clientid=arledger.clientid where client.client='$client' and arledger.bal>0
                   ) as t";
                   $ar = Yii::$app->sbccommon->datareader($sql);               
                   if($crlimit>=($ar+$newamt-$oldamt)){
                       return true;
                   }else{
                       Yii::$app->session['warning'] = Yii::$app->session['warning']."Above Credit limit.<br/>Credit Limit:".$crlimit."  -  Outstanding AR:".($ar+$newamt-$oldamt);
                       //Webproc::showmsg("Warning", "Credit Limit:".$crlimit."  -  Outstanding AR:".($ar+$newamt-$oldamt));
                       //return false;
                   }
               }else{return true;}
           
          }else{
              Yii::$app->session['warning'] = Yii::$app->session['warning']." Customer is on-hold...";
              //Webproc::showmsg("Warning", "Customer is on-hold...");
              //return false;
          }
        }

        
        
      public function isclientHold($client)
        {
            $clientid= Yii::$app->sbccommon->datareader("select isinactive from client where client='$client'");
          if(empty($clientid) || $clientid==''){
            $clientid=0;
           }
           return $clientid;
        }

        
        public static function checkclient($client)
        {
            $clientid= Yii::$app->sbccommon->datareader("select clientid from client where client='$client'");
            
            if(empty($clientid) || $clientid==''){
            $clientid=0;
            }else{
            $clientid = 1;
            }
            return $clientid;
        }
        
        public static function updatecode($newclient,$oldclient,$clientid)
        {
            //$common=new Common();
            //$pref = $common->GetPrefix($client);
            //$seq=substr($client,$common->SearchPosition($client),strlen($client));
            Yii::$app->sbccommon->execqry("Update client set client='$newclient' where clientid='$clientid'");
            Yii::$app->sbccommon->execqry("Update lahead set client='$newclient' where client='$oldclient'");
            Yii::$app->sbccommon->execqry("Update lahead set agent='$newclient' where agent='$oldclient'");
            Yii::$app->sbccommon->execqry("Update pohead set client='$newclient' where client='$oldclient'");
            Yii::$app->sbccommon->execqry("Update hpohead set client='$newclient' where client='$oldclient'");
            Yii::$app->sbccommon->execqry("Update sohead set client='$newclient' where client='$oldclient'");
            Yii::$app->sbccommon->execqry("Update hsohead set client='$newclient' where client='$oldclient'");
            Log::writelog('customer', $clientid, 'CHANGE', $oldclient.'=>'.$newclient);
           // Yii::$app->sbccommon->execqry("Update $lhead set docno='$docno' where trno='$trno'");
        }
        
        public function insertclient($data){
            $data=$this->checkdata($data);
            $user= $data->createby;
            $data->clientname=preg_replace( "/'/", "`", $data->clientname);
            $data->addr=preg_replace( "/'/", "`", $data->addr);
            $data->tel=preg_replace( "/'/", "`", $data->tel);
            $data->contact=preg_replace( "/'/", "`", $data->contact);
            $data->rem=preg_replace( "/'/", "`", $data->rem);
            $data->groupid=preg_replace( "/'/", "`", $data->groupid);
            $data->province=preg_replace( "/'/", "`", $data->province);
            $data->region=preg_replace( "/'/", "`", $data->region);
            $data->ship=preg_replace( "/'/", "`", $data->ship);
            $data->agentpassword=preg_replace( "/'/", "`", $data->agentpassword);

            $iqry = "insert into client
                    (client, clientname ,addr, tel, agent, terms, email, tin,quota,tel2,type,disc,    
                    iscustomer, isagent, issupplier, iswarehouse, isemployee,isinactive,isexempt,createby,
                    contact,tax,rem,crlimit,area,groupid,
                    province,class,status,start,region,ship,fax,center,editdate,viewdate,pword,charge1,
                    charge2,building,floor,islocation,isvendor,category,rtt_categoryid,rtt_distroarea,rtt_collectionarea,
                    scroute,sccityid,scusername,scpassword,rev,
                    isasset, category2, location, acquireddate, warrantexpiry, servicedate, solddisposeddate, year, make, 
                    model, color, motorno, serialno, renewaldate, insurer, insurancepol,grpcode,
                    isbranch, isallitems, isallwh, issyncbranch, acno,uv_ispicker, uv_ischecker,password,bstyle)
                    values  ('$data->client', '$data->clientname', '$data->addr', '$data->tel', '$data->agent',
                    '$data->terms', '$data->email','$data->tin','$data->quota','$data->tel2','$data->type','$data->disc',
                    '$data->IsCustomer', '$data->IsAgent', '$data->IsSupplier', '$data->IsWarehouse', '$data->IsEmployee',
                    '$data->IsInactive', '$data->IsExempt', '$user',
                    '$data->contact','$data->tax','$data->rem','$data->crlimit','$data->area','$data->groupid',
                    '$data->province','$data->pricegroup','$data->status','$data->start','$data->region','$data->ship',
                    '$data->fax','".Yii::$app->session['loggeduser']['center']."',null,null,'$data->pword','$data->charge1',
                    '$data->charge2','$data->building','$data->floor','$data->isLocation','$data->isVendor','$data->category',
                    '$data->category','$data->distributionarea','$data->collectionarea','$data->routeid','$data->sccityid','$data->aguser','$data->agpass',
                    '"."\\\\"."$data->rev',
                    '$data->isasset', '$data->category2', '$data->location', '$data->acquireddate', '$data->warrantexpiry', '$data->servicedate', 
                    '$data->solddisposeddate', '$data->year', '$data->make', '$data->model2', '$data->color', '$data->motorno', '$data->serialno', 
                    '$data->renewaldate', '$data->insurer', '$data->insurancepol','$data->grpcode',
                    '$data->IsBranch', '$data->isallitems', '$data->isallwh', '$data->issyncbranch', '$data->acno',
                    '$data->uv_ispicker', '$data->uv_ischecker','$data->agentpassword','$data->bstyle')";
            
            $insert= Yii::$app->sbccommon->execqry($iqry);
            if($insert==1){ return true; } else { return false; }
        }


        public function updateclient($clientid,$data){
            try {
                $data=$this->checkdata($data);
                $data->crlimit = str_replace(",","",$data->crlimit);
                $data->quota = str_replace(",","",$data->quota);
                $data->clientname=preg_replace( "/'/", "`", $data->clientname);
                $data->addr=preg_replace( "/'/", "`", $data->addr);
                $data->tel=preg_replace( "/'/", "`", $data->tel);
                $data->contact=preg_replace( "/'/", "`", $data->contact);
                $data->rem=preg_replace( "/'/", "`", $data->rem);
                $data->groupid=preg_replace( "/'/", "`", $data->groupid);
                $data->province=preg_replace( "/'/", "`", $data->province);
                $data->region=preg_replace( "/'/", "`", $data->region);
                $data->ship=preg_replace( "/'/", "`", $data->ship);
                
                $data->agentpassword=preg_replace( "/'/", "`", $data->agentpassword);
                $user=Yii::$app->session['loggeduser']['username'];
                
                $qry = "update client
                set clientname='$data->clientname', addr='$data->addr', tel='$data->tel', agent='$data->agent', terms='$data->terms', email='$data->email',
                iscustomer='$data->IsCustomer', isagent='$data->IsAgent', issupplier='$data->IsSupplier', iswarehouse='$data->IsWarehouse', 
                isemployee='$data->IsEmployee', isinactive='$data->IsInactive',isexempt='$data->IsExempt',
                contact='$data->contact',tax='$data->tax',rem='$data->rem',crlimit='$data->crlimit',area='$data->area',
                groupid='$data->groupid',class='$data->pricegroup',status='$data->status',
                start='$data->start',region='$data->region',province='$data->province',tin='$data->tin',
                quota='$data->quota',tel2='$data->tel2',type='$data->type',disc='$data->disc',fax='$data->fax',
                editby='$user',editdate=CURRENT_TIMESTAMP,charge1='$data->charge1',charge2='$data->charge2',islocation='$data->isLocation',
                building='$data->building',floor='$data->floor',category='$data->category',rtt_categoryid='$data->category',
                rtt_distroarea='$data->distributionarea' ,rtt_collectionarea='$data->collectionarea',scroute='$data->routeid',sccityid='$data->sccityid',
                scusername='$data->aguser',scpassword='$data->agpass',rev='"."\\\\".$data->rev."',
                category2 = '$data->category2', location = '$data->location', acquireddate = '$data->acquireddate', warrantexpiry = '$data->warrantexpiry', 
                servicedate = '$data->servicedate', solddisposeddate = '$data->solddisposeddate', year = '$data->year', make = '$data->make', 
                model = '$data->model2', color = '$data->color', motorno = '$data->motorno', serialno = '$data->serialno', 
                renewaldate = '$data->renewaldate', insurer = '$data->insurer', insurancepol = '$data->insurancepol',grpcode='$data->grpcode',
                isallitems = '$data->isallitems', isallwh = '$data->isallwh', issyncbranch = '$data->issyncbranch', acno = '$data->acno',
                uv_ispicker = '$data->uv_ispicker', uv_ischecker= '$data->uv_ischecker',password='$data->agentpassword',bstyle='$data->bstyle'
                where clientid='$clientid'";
                
                return Yii::$app->sbccommon->execqry($qry);
            } catch (ErrorException $e) {
                echo $e;
            }
        }
        //END KEYWORD LOCATION&VENDOR
        

        public function checkdata($data){
            if(strlen($data->pricegroup)==0){
                $data->pricegroup='R';
            }
            if(strlen($data->tax)==0){
                $data->tax=0;
            }
            if(strlen($data->crlimit)==0){
                $data->crlimit=0;
            }
            if(strlen($data->start)==0){
                $data->start=date('0-0-0 00:00:00');
            }
            if(strlen($data->IsCustomer)==0){
                $data->IsCustomer=0;
            }
            if(strlen($data->IsAgent)==0){
                $data->IsAgent=0;
            }
            if(strlen($data->IsSupplier)==0){
                $data->IsSupplier=0;
            }
            if(strlen($data->IsWarehouse)==0){
                $data->IsWarehouse=0;
            }
            if(strlen($data->IsEmployee)==0){
                $data->IsEmployee=0;
            }
            if(strlen($data->IsInactive)==0){
                $data->IsInactive=0;
            }
            if(strlen($data->quota)==0){
                $data->quota=0;
            }
            return $data;
        }//end if


        public function suggestarea($keywords,$limit=20){
            $keyword=explode(",",$keywords);
            $sql ="select distinct area from client where ";
            $criteria="";
            for($i=0;$i<count($keyword);$i++){
                if ($criteria=="")
                    {$criteria = "(area like '%".$keyword[$i]."%')";}
                else
                    {$criteria = $criteria." and "."(area like '%".$keyword[$i]."%')";}
            }
                $models=Yii::$app->sbccommon->opentable($sql." ".$criteria." limit $limit");
		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model['area'],  
				'value'=>$model['area'], 
			);
		}
		return $suggest;
	}
        public function suggestregion($keywords,$limit=20){
            $keyword=explode(",",$keywords);
            $sql ="select distinct region from client where ";
            $criteria="";
            for($i=0;$i<count($keyword);$i++){
                if ($criteria=="")
                    {$criteria = "(region like '%".$keyword[$i]."%')";}
                else
                    {$criteria = $criteria." and "."(region like '%".$keyword[$i]."%')";}
            }
                $models=Yii::$app->sbccommon->opentable($sql." ".$criteria." limit $limit");
		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model['region'],
				'value'=>$model['region'],
			);
		}
		return $suggest;
	}
        public function suggestprovince($keywords,$limit=20){
            $keyword=explode(",",$keywords);
            $sql ="select distinct province from client where ";
            $criteria="";
            for($i=0;$i<count($keyword);$i++){
                if ($criteria=="")
                    {$criteria = "(province like '%".$keyword[$i]."%')";}
                else
                    {$criteria = $criteria." and "."(province like '%".$keyword[$i]."%')";}
            }
                $models=Yii::$app->sbccommon->opentable($sql." ".$criteria." limit $limit");
		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model['province'],
				'value'=>$model['province'],
			);
		}
		return $suggest;
	}
        public function suggestgroup($keywords,$limit=20){
            $keyword=explode(",",$keywords);
            $sql ="select distinct groupid from client where ";
            $criteria="";
            for($i=0;$i<count($keyword);$i++){
                if ($criteria=="")
                    {$criteria = "(groupid like '%".$keyword[$i]."%')";}
                else
                    {$criteria = $criteria." and "."(groupid like '%".$keyword[$i]."%')";}
            }
                $models=Yii::$app->sbccommon->opentable($sql." ".$criteria." limit $limit");
		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model['groupid'],
				'value'=>$model['groupid'],
			);
		}
		return $suggest;
	}
        public function suggesttype($keywords,$limit=20){
            $keyword=explode(",",$keywords);
            $sql ="select distinct type from client where ";
            $criteria="";
            for($i=0;$i<count($keyword);$i++){
                if ($criteria=="")
                    {$criteria = "(type like '%".$keyword[$i]."%')";}
                else
                    {$criteria = $criteria." and "."(type like '%".$keyword[$i]."%')";}
            }
                $models=Yii::$app->sbccommon->opentable($sql." ".$criteria." limit $limit");
		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model['type'],
				'value'=>$model['type'],
			);
		}
		return $suggest;
	}//END FUNCTION SUGGESS TTYPE


    public static function GetCRLimit($client){
            $msg = "";

            $strSQL="select ifnull(sum(a.amtdue),0) as ar,ifnull(client.crlimit,0) as crlimit,ifnull(client.isinactive,0) as isinactive,
                ifnull((select sum(a.amount) from (
                select abs((ladetail.db - ladetail.cr)) as amount from
                ladetail left join lahead on lahead.trno = ladetail.trno left join coa on coa.acno = ladetail.acno
                where lahead.doc='cr' and left(coa.alias,2) = 'cr' and lahead.client='$client'
                union all
                select abs((ladetail.cr - ladetail.db)) as amount from
                ladetail left join lahead on lahead.trno = ladetail.trno left join coa
                on coa.acno = ladetail.acno where lahead.doc='cv' and left(coa.alias,2) = 'cr' and lahead.client ='$client'
                union all
                select abs((ladetail.db - ladetail.cr)) as amount from
                ladetail left join lahead on lahead.trno = ladetail.trno 
                left join coa on coa.acno = ladetail.acno
                where lahead.doc='gj' and ((left(coa.alias,2) = 'cr') 
                and (ifnull((select sum(detail.trno) from (ladetail detail left join coa c on((c.acno = detail.acno)))
                where ((detail.trno = lahead.trno) and (c.alias = 'arb') and (detail.db > 0))),0) = 0)) and lahead.client ='$client'
                union all
                select abs((crledger.db - crledger.cr)) as amount from
                crledger left join glhead on glhead.trno = crledger.trno left join client on client.clientid = glhead.clientid
                where ((ifnull(crledger.depodate,'') = '')  and crledger.checkdate > now() and (ifnull((select sum(detail.trno)
                from (gldetail detail 
                left join coa c on((c.acnoid = detail.acnoid)))
                where ((detail.trno = glhead.trno) and (c.alias = 'arb') and (detail.db > 0))),0) = 0)) 
                and client.client = '$client') as a where a.client=client.client),0) as pdc
                from client left join (
                select client.client, sum(lastock.ext) as amtdue from lastock left join lahead on lahead.trno = lastock.trno
                left join client on client.client = lahead.client where client.client='$client'
                union all
                select client.client, sum(ladetail.db) as amtdue from ladetail left join lahead on lahead.trno = ladetail.trno
                left join coa on coa.acno = ladetail.acno left join client on client.client = lahead.client
                where left(coa.alias,2) = 'ar' and client.client='$client'
                union all
                select client.client, sum(((case when (arledger.db > 0) then 1 else -(1) end) * arledger.bal)) as amtdue
                from gldetail left join glhead on glhead.trno = gldetail.trno
                left join coa on coa.acnoid = gldetail.acnoid left join client on client.clientid = glhead.clientid
                left join arledger on arledger.trno = gldetail.trno and arledger.line = gldetail.line
                where glhead.doc in ('ar','sj','bl','cm','gj','cr') and left(coa.alias,2) = 'ar' and arledger.bal <> 0
                and client.client='$client'
                ) as a on a.client=client.client where client.client='$client'";

                $arrCRlimit = Yii::$app->sbccommon->opentable($strSQL);

                $AR = $arrCRlimit[0]['ar'];
                $crlimit = $arrCRlimit[0]['crlimit'];
                $hold = $arrCRlimit[0]['isinactive'];
                $pdc = $arrCRlimit[0]['pdc'];

                if($hold==0){
                    if($crlimit!=0){
                        if(($AR+$pdc) > $crlimit){
                            $msg = "Above Credit limit.".'</br>Credit limit: '.number_format($crlimit,2).'</br>'.'Outstanding AR: '.number_format($AR+$pdc,2);
                        }else{
                            $msg = "";
                        }
                    }

                }else{
                    $msg="Cannot create transaction! Customer is 'On Hold'";
                }

            return $msg;
        }//end function get cr limit 

}//END MODEL