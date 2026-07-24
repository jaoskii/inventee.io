<?php

namespace app\models;
use Yii;
use yii\base\Model;
class Employee extends Model
{
    public $empid;
    public $empcode;
    public $emplast;
    public $empfirst;
    public $empmiddle;
    public $city;
    public $country;
    public $telno;
    public $mobileno;
    public $email;
    public $citizenship;
    public $religion;
    public $status;
    public $gender;
    public $alias;
    public $bday;
    public $idbarcode;
    public $tin;
    public $sss;
    public $hdmf;
    public $phic;
    public $bankacct;
    public $atm;
    public $paymode;
    public $jobtitle;
    public $jobcode;
    public $jobdesc;
    public $hired;
    public $regular;
    public $level;
    public $resigned;
    public $division;
    public $dept;
    public $orgsection;
    public $supervisor;
    public $teu;
    public $nodeps;
    public $isactive;
    public $classrate;
    public $maidname;
    public $isconfidential;
    public $shiftcode;
    public $ecola;
    public $spclallow;
    public $mealallow;
    public $sssdef;
    public $philhdef;
    public $pibigdef;
    public $wtaxdef;
    public $dyear;
    public $chktin;
    public $chksss;
    public $chkphealth;
    public $chkpibig;
    public $lastbatch;
    public $fullname;
    public $provaddress;
    public $address;
    public $age;
    public $remarks;
    public $contact1; 
    public $relation1;
    public $addr1;
    public $homeno1;
    public $mobileno1;
    public $officeno1;
    public $ext1;
    public $notes1;
    public $contact2;
    public $relation2;
    public $addr2;
    public $homeno2;
    public $mobileno2;
    public $officeno2;
    public $ext2;
    public $notes2;
    public $emprate;
    public $iscba;
    public $trans;
    public $trans1;
    public $zipcode;
    public $picture;

    public static function tableName()
    {
        return 'Employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
       

        return array(
            array('empcode', 'required', 'except' => 'level'),
            array('idbarcode,atm,yrsattend,yrsexp,nodeps,isactive,isconfidential,mustclkin,mustclkout,chkmon,chktue,chkwed,chkthu,chkfri,chksat,chksun,chkpaidrd,chkpaidsp,chkpaidlh,cntm,chktin,chksss,chkphealth,chkpibig,age,iscba,ecola,spclallow,transpo,mealallow,sssdef,philhdef,pibigdef,wtaxdef,dyear,Cola,trans,trans1', 'numerical'),
            array('zipcode,gender,country,city,mobileno,level,alias,telno,bankacct,status,hdmf', 'length', 'max' => 30),
            array('empcode,citizenship,tin,sss,phic,shiftcode,custcode', 'length', 'max' => 20),
            array('paymode,teu,classrate,yrgrad,gpa,height,weight', 'length', 'max' => 40),
            array('jobtitle,supervisor,Emprate', 'length', 'max' => 500),
                array('finger1,finger2,finger3,Finger4,Finger5,Finger6,Finger7,Finger8,Finger9,FingerLast,address,provaddress,remarks,emplast,empfirst,empmiddle,religion,maidname,email,division,dept,orgsection,school,course,prevcomp,prevjob,lastbatch,fullname,interviewby,picpath,jobdesc,q1,q2,q3,q4,picture', 'length', 'max' => 5000),
            // array('line', 'length', 'max' => 50),
            // array('picture', 'file', 'allowEmpty' => true, 'types' => 'jpg,gif,png'),
            array('bday,hired,regular,resigned,prevjstart,prevjend,appdate,contact1,relation1,addr1,homeno1,mobileno1,officeno1,ext1,notes1,contact2,relation2,addr2,homeno2,mobileno2,officeno2,ext2,notes2', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return [
            'empid' => 'Empid',
            'empcode' => 'Empcode',
            'emplast' => 'Emplast',
            'empfirst' => 'Empfirst',
            'empmiddle' => 'Empmiddle',
            'address' => 'Address',
            'city' => 'City',
            'country' => 'Country',
            'zipcode' => 'Zipcode',
            'telno' => 'Telno',
            'mobileno' => 'Mobileno',
            'email' => 'Email',
            'citizenship' => 'Citizenship',
            'religion' => 'Religion',
            'status' => 'Status',
            'gender' => 'Gender',
            'alias' => 'Alias',
            'picpath' => 'Picpath',
            'bday' => 'Bday',
            'idbarcode' => 'Idbarcode',
            'tin' => 'Tin',
            'sss' => 'Sss',
            'hdmf' => 'Hdmf',
            'phic' => 'Phic',
            'bankacct' => 'Bankacct',
            'atm' => 'Atm',
            'paymode' => 'Paymode',
            'jobtitle' => 'Jobtitle',
            'jobcode' => 'Jobcode',
            'jobdesc' => 'Jobdesc',
            'hired' => 'Hired',
            'regular' => 'Regular',
            'resigned' => 'Resigned',
            'division' => 'Division',
            'dept' => 'Dept',
            'orgsection' => 'Orgsection',
            'supervisor' => 'Supervisor',
            'school' => 'School',
            'course' => 'Course',
            'yrgrad' => 'Yrgrad',
            'yrsattend' => 'Yrsattend',
            'gpa' => 'Gpa',
            'prevcomp' => 'Prevcomp',
            'prevjob' => 'Prevjob',
            'prevjstart' => 'Prevjstart',
            'prevjend' => 'Prevjend',
            'yrsexp' => 'Yrsexp',
            'teu' => 'Teu',
            'nodeps' => 'Nodeps',
            'isactive' => 'Isactive',
            'classrate' => 'Classrate',
            'maidname' => 'Maidname',
            'isconfidential' => 'Isconfidential',
            'shiftcode' => 'Shiftcode',
            'mustclkin' => 'Mustclkin',
            'mustclkout' => 'Mustclkout',
            'chkmon' => 'Chkmon',
            'chktue' => 'Chktue',
            'chkwed' => 'Chkwed',
            'chkthu' => 'Chkthu',
            'chkfri' => 'Chkfri',
            'chksat' => 'Chksat',
            'chksun' => 'Chksun',
            'ecola' => 'Ecola',
            'spclallow' => 'Spclallow',
            'transpo' => 'Transpo',
            'mealallow' => 'Mealallow',
            'sssdef' => 'Sssdef',
            'philhdef' => 'Philhdef',
            'pibigdef' => 'Pibigdef',
            'wtaxdef' => 'Wtaxdef',
            'dyear' => 'Dyear',
            'chkpaidrd' => 'Chkpaidrd',
            'chkpaidsp' => 'Chkpaidsp',
            'chkpaidlh' => 'Chkpaidlh',
            'cntm' => 'Cntm',
            'custcode' => 'Custcode',
            'chktin' => 'Chktin',
            'chksss' => 'Chksss',
            'chkphealth' => 'Chkphealth',
            'chkpibig' => 'Chkpibig',
            'finger1' => 'Finger1',
            'finger2' => 'Finger2',
            'finger3' => 'Finger3',
            'lastbatch' => 'Lastbatch',
            'fullname' => 'Fullname',
            'provaddress' => 'Provaddress',
            'age' => 'Age',
            'height' => 'Height',
            'weight' => 'Weight',
            'appdate' => 'Appdate',
            'remarks' => 'Remarks',
            'interviewby' => 'Interviewby',
            'q1' => 'Q1',
            'q2' => 'Q2',
            'q3' => 'Q3',
            'q4' => 'Q4',
            'Finger4' => 'Finger4',
            'Finger5' => 'Finger5',
            'Finger6' => 'Finger6',
            'Finger7' => 'Finger7',
            'Finger8' => 'Finger8',
            'Finger9' => 'Finger9',
            'FingerLast' => 'Finger Last',
            'Cola' => 'Cola',
            'Emprate' => 'Emprate',
            'level' => 'Level',
            'iscba' => 'Iscba',
            'trans' => 'Trans',
            'trans1' => 'Trans1',
        ];
    }


    public static function openemployee($clientid){

        $data= Yii::$app->sbccommon->opentable("select empimg.picture,emp.zipcode,emp.empid,emp.empcode,emp.emplast,emp.empfirst,emp.empmiddle,emp.address,emp.city,emp.country,emp.telno,emp.mobileno,
        emp.email,emp.citizenship,emp.religion,emp.status,emp.gender,emp.alias,emp.bday,emp.idbarcode,emp.tin,emp.sss,emp.hdmf,emp.phic,
        emp.bankacct,emp.atm,emp.paymode,emp.jobtitle,emp.jobcode,emp.jobdesc,date(emp.hired) as hired,date(emp.regular) as regular ,date(emp.resigned) as resigned,emp.division,emp.dept,
        emp.orgsection,emp.supervisor,emp.teu,emp.nodeps,emp.isactive,emp.classrate,emp.maidname,emp.isconfidential,emp.shiftcode,
        emp.ecola,emp.spclallow,emp.transpo,emp.mealallow,emp.sssdef,emp.philhdef,emp.pibigdef,emp.wtaxdef,emp.dyear,
        emp.chktin,emp.chksss,emp.chkphealth,emp.chkpibig,emp.lastbatch,emp.fullname,emp.provaddress,emp.age,emp.remarks,emp.emprate,
        emp.level,emp.iscba,emp.trans,emp.trans1,cont.contact1,cont.relation1,cont.addr1,cont.homeno1,cont.mobileno1,cont.officeno1,cont.ext1,
        cont.notes1,cont.contact2,cont.relation2,cont.addr2,cont.homeno2,cont.mobileno2,cont.officeno2,cont.ext2,cont.notes2
        from employee as emp left join contacts as cont on cont.empcode=emp.empcode
        left join empimages as empimg on empimg.codeid=emp.empid where emp.empid='$clientid'");
        
        if(!empty($data)){
            return $data;
        }
    }//END OPENCLIENT

    public static function checkempcode($client){
            $clientid= Yii::$app->sbccommon->datareader("select empid from employee where empcode='$client'");
            
            if(empty($clientid) || $clientid==''){
            $clientid=0;
            }else{
            $clientid = 1;
            }
            return $clientid;
        }
    public function requestEmpid($client){
        return $clientid = Yii::$app->sbccommon->datareader("select empid from employee where empcode = '".$client."'");
        }//END REQUEST ITEMID    


    public function checkdata($data){
            if(strlen($data->teu)=='S'){
                $data->teu='S';
            }
            if(strlen($data->paymode)=='D'){
                $data->paymode='D';
            }
            if(strlen($data->iscba)==0){
                $data->iscba=0;
            }
            if(strlen($data->isactive)==0){
                $data->isactive=0;
            }

            if(strlen($data->age)==0){
                $data->age=0;
            }

            if(strlen($data->idbarcode)==0){
                $data->idbarcode=0;
            }

            if(strlen($data->nodeps)==0){
                $data->nodeps=0;
            }

            if(strlen($data->ecola)==0){
                $data->ecola=0;
            }

            if(strlen($data->sssdef)==0){
                $data->sssdef=0;
            }

            if(strlen($data->philhdef)==0){
                $data->philhdef=0;
            }

            if(strlen($data->pibigdef)==0){
                $data->pibigdef=0;
            }

            if(strlen($data->wtaxdef)==0){
                $data->wtaxdef=0;
            }

            if(strlen($data->hired)==0){
                $data->hired=date('0-0-0 00:00:00');
            }

            if(strlen($data->regular)==0){
                $data->regular=date('0-0-0 00:00:00');
            }

            if(strlen($data->resigned)==0){
                $data->resigned=date('0-0-0 00:00:00');
            }

            if(strlen($data->bday)==0){
                $data->bday=date('0-0-0 00:00:00');
            }

            return $data;
        }

    public function insertemployee($data){
           $data=$this->checkdata($data);
            //$user= $data->createby; //JAO CHANGED THIS SO IT CAN BE MODIFIED PER INSERTION DEPENDING FROM AIMS TO ECOMMERCE
            $data->empfirst=preg_replace( "/'/", "`", $data->empfirst);
            $data->address=preg_replace( "/'/", "`", $data->address);
            $data->telno=preg_replace( "/'/", "`", $data->telno);
            // $data->contact=preg_replace( "/'/", "`", $data->contact);
            // $data->rem=preg_replace( "/'/", "`", $data->rem);
            // $data->groupid=preg_replace( "/'/", "`", $data->groupid);
            // $data->province=preg_replace( "/'/", "`", $data->province);
            // $data->region=preg_replace( "/'/", "`", $data->region);
            // $data->ship=preg_replace( "/'/", "`", $data->ship);
            //$start=$data->start;
            //$center=$data->center;


             $insert= Yii::$app->sbccommon->execqry("insert into employee
                (empcode,emplast,empfirst,empmiddle,jobtitle,jobdesc,
        iscba,isactive,address,hired,regular,resigned,age,bday,idbarcode,tin,sss,hdmf,phic,
        chktin,chksss,chkphealth,chkpibig,bankacct,atm,paymode,division,dept,orgsection,supervisor,
        teu,nodeps,classrate,ecola,sssdef,philhdef,pibigdef,wtaxdef,
        city,country,citizenship,maidname,
        religion,status,email,gender,alias,
        shiftcode,telno,mobileno,zipcode)
        values  ('$data->empcode','$data->emplast','$data->empfirst','$data->empmiddle','$data->jobtitle','$data->jobdesc',
        '$data->iscba','$data->isactive','$data->address','$data->hired','$data->regular','$data->resigned','$data->age','$data->bday','$data->idbarcode','$data->tin','$data->sss','$data->hdmf','$data->phic','$data->chktin','$data->chksss','$data->chkphealth','$data->chkpibig','$data->bankacct','$data->atm','$data->paymode','$data->division','$data->dept','$data->orgsection','$data->supervisor',
        '$data->teu','$data->nodeps','$data->classrate','$data->ecola','$data->sssdef','$data->philhdef','$data->pibigdef','$data->wtaxdef',
        '$data->city','$data->country','$data->citizenship','$data->maidname',
        '$data->religion','$data->status','$data->email','$data->gender','$data->alias','$data->shiftcode','$data->telno','$data->mobileno','$data->zipcode')");


          $insert= Yii::$app->sbccommon->execqry("insert into contacts
        (empcode,contact1,relation1,addr1,homeno1,mobileno1,officeno1,ext1,notes1,
        contact2,relation2,addr2,homeno2,mobileno2,officeno2,ext2,notes2)
        values  ('$data->empcode','$data->contact1','$data->relation1','$data->addr1','$data->homeno1','$data->mobileno1','$data->officeno1','$data->ext1','$data->notes1',
        '$data->contact2','$data->relation2','$data->addr2','$data->homeno2','$data->mobileno2','$data->officeno2','$data->ext2','$data->notes2')");

          
          

            if($insert==1){
                return true;
            }else{
                return $data;
            }
        }//end

        public  function updateEmployee($clientid,$data){
            $data=$this->checkdata($data);   //var_dump($data);
             $data->empfirst=preg_replace( "/'/", "`", $data->empfirst);
            $data->address=preg_replace( "/'/", "`", $data->address);
            $data->telno=preg_replace( "/'/", "`", $data->telno);


            $aa = Yii::$app->sbccommon->execqry("update employee
            set empcode='$data->empcode',emplast='$data->emplast',empfirst='$data->empfirst',empmiddle='$data->empmiddle',
            jobtitle='$data->jobtitle',jobdesc='$data->jobdesc',iscba='$data->iscba',isactive='$data->isactive',
            address='$data->address',hired='$data->hired',regular='$data->regular',resigned='$data->resigned',
            age='$data->age',bday='$data->bday',idbarcode='$data->idbarcode',
            tin='$data->tin',sss='$data->sss',hdmf='$data->hdmf',phic='$data->phic',
            chktin='$data->chktin',chksss='$data->chksss',chkphealth='$data->chkphealth',
            chkpibig='$data->chkpibig',bankacct='$data->bankacct',atm='$data->atm',paymode='$data->paymode',
            division='$data->division',dept='$data->dept',orgsection='$data->orgsection',supervisor='$data->supervisor',
            teu='$data->teu',nodeps='$data->nodeps',classrate='$data->classrate',ecola='$data->ecola',
            sssdef='$data->sssdef',philhdef='$data->philhdef',pibigdef='$data->pibigdef',wtaxdef='$data->wtaxdef',
            city='$data->city',country='$data->country',citizenship='$data->citizenship',maidname='$data->maidname',
            religion='$data->religion',status='$data->status',email='$data->email',gender='$data->gender',alias='$data->alias',
            shiftcode='$data->shiftcode',telno='$data->telno',mobileno='$data->mobileno',zipcode='$data->zipcode'
            where empid='$clientid'");

            $aa2 = Yii::$app->sbccommon->execqry("update contacts
                set contact1='$data->contact1',
            relation1='$data->relation1',addr1='$data->addr1',homeno1='$data->homeno1',mobileno1='$data->mobileno1',
            officeno1='$data->officeno1',ext1='$data->ext1',notes1='$data->notes1',
            contact2='$data->contact2',
            relation2='$data->relation2',addr2='$data->addr2',homeno2='$data->homeno2',mobileno2='$data->mobileno2',
            officeno2='$data->officeno2',ext2='$data->ext2',notes2='$data->notes2'
            where empcode='$data->empcode'");
         
            return $ar = array('ar' => $aa,'ar2'=>$aa2 );
        }
}
