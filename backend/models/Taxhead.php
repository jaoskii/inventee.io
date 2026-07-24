<?php

namespace app\models;

use Yii;
use yii\base\Model;


class Taxhead extends Model
{
        public $newdocno;
        public $trno;
        public $docno;
        public $client;
        public $clientname;
        public $address;
        public $shipto;
        public $terms;
        public $rem;
        public $forex;
        public $yourref;
        public $ourref;
        public $dateid;
        public $dateid2;
        public $grandtotal;
        public $itemcount;
        public $totalkilo;
        public $createdate;
        public $tax;
        public $contra;
        public $wh;
        public $whid;
        public $wh_address;
        public $agent;
        public $agentcode;
        public $isdeclared;
        public $modeofpayment;
        public $acctname;
        public $acctno;
        public $cardtype;
        public $due;
        public $waybilldate;
        public $billlading;
        public $voyage;
        public $islocked;
        public $isposted;
        public $totaldb;
        public $totalcr;
        public $cur;
        public $vattype;
        public $salestype;
        public $checkno;
        public $confitrans;
        //WTODO: JLY 2019.1.22 RTT APV ADD NOTES IN SEARCH DOC
        public $quarter;

    public function rules(){

        return array(
                    //array('whid','required','except'=>'accounting'),
                    array('whid,client,clientname','required','except'=>'ds'),
                    array('docno','required'),
                    array('trno, docno', 'length', 'max'=>15),
                    array('client', 'length', 'max'=>15),
                    array('clientname, address, shipto', 'length', 'max'=>150),
                    array('terms', 'length', 'max'=>30),                    
                    array('rem', 'length', 'max'=>500),
                    array('forex', 'length', 'max'=>18),
                    array('isdeclared', 'length', 'max'=>1),
                    array('yourref, ourref', 'length', 'max'=>25),
                    array('dateid,dateid2,due,contra,wh,agent,agentcode,whid,modeofpayment,acctname,acctno,cardtype,waybilldate,billlading,voyage', 'safe'),
                    array('tax,trno', 'numerical', 'integerOnly'=>true),
             );
    }
        public function suggest($keywords,$limit=20,$module='')
    {
            $center=Yii::$app->user->center;
            $keyword=explode(",",$keywords);
            $table=Common::localhead($module);
            $glhead=Common::glhead();
            $sql ="select c.docno, c.trno ,cl.client,cl.clientname,cl.addr as address, p.yourref, p.ourref, p.shipto,
                    left(p.dateid,10) as dateid, p.terms, p.rem
                    from $table as p
                    left join  cntnum as c on c.trno=p.trno left join client as cl on cl.client=p.client where c.doc='$module' and";
            $criteria="";
            for($i=0;$i<count($keyword);$i++)
            {
                if ($criteria=="")
                    {
                    $criteria = "(c.docno LIKE '%".$keyword[$i]."%' OR cl.client LIKE '%".$keyword[$i]."%' OR cl.clientname LIKE '%".$keyword[$i]."%')";
                    }
                else
                    {
                    $criteria = $criteria." and "."(c.docno LIKE '%".$keyword[$i]."%' OR cl.client LIKE '%".$keyword[$i]."%' OR cl.clientname LIKE '%".$keyword[$i]."%')";
                    }
                    $criteria= $criteria ." and  c.center='$center'";
            }
            $query1=$sql." ".$criteria;

            $sql2 ="select c.docno, c.trno ,cl.client,cl.clientname,cl.addr as address, p.yourref, p.ourref, p.shipto,
                    left(p.dateid,10) as dateid, p.terms, p.rem
                    from $glhead as p
                    left join cntnum as c on c.trno=p.trno left join client as cl on cl.clientid=p.clientid where c.doc='$module' and";
            
//            $criteria2="";
//            for($i=0;$i<count($keyword);$i++)
//            {
//                if ($criteria2=="")
//                    {
//                    $criteria2 = "(c.docno LIKE '%".$keyword[$i]."%' OR clientid LIKE '%".$keyword[$i]."%' OR clientname LIKE '%".$keyword[$i]."%')";
//                    }
//                else
//                    {
//                    $criteria2 = $criteria2." and "."(c.docno LIKE '%".$keyword[$i]."%' OR clientid LIKE '%".$keyword[$i]."%' OR clientname LIKE '%".$keyword[$i]."%')";
//                    }
//                    $criteria2= $criteria2 ." and  center='$center'";
//            }
            $query2=$sql2." ".$criteria;

            
                $models=Yii::$app->sbccommon->opentable($query1." union all ".$query2." order by trno desc limit $limit");

        $suggest=array();
        foreach($models as $model) {
            $suggest[] = array(
                'label'=> $model['docno'] .' - '. $model['client']  .' - '. $model['clientname'] . ' - '. $model['yourref'].' - '.$model['ourref'], // label for dropdown list
                'value'=>"",  // value for input field
                                'trno'=>$model['trno'],



            );

        }
        return $suggest;

    }




        public static function updatehead($trno, $docno, $data,$doc){

               
                $update=Taxhead::update($trno, $docno, $data,$doc);

                return $update;
               
           
        }//end updatehead
        //WTODO: JLY 2019.1.22 RTT TW ADD QUARTER IN HEAD update quarter
        public static function update($trno, $docno, $data,$doc){
           
            $data->client=preg_replace( "/'/", "`", $data->client );
            $data->clientname=preg_replace( "/'/", "`", $data->clientname );
            $data->address=preg_replace( "/'/", "`", $data->address );
            $data->yourref=preg_replace( "/'/", "`", $data->yourref );
            $data->ourref=preg_replace( "/'/", "`", $data->ourref );
            $data->rem=preg_replace( "/'/", "`", $data->rem );
            $data->shipto=preg_replace( "/'/", "`", $data->shipto );
            $data->terms=preg_replace( "/'/", "`", $data->terms );
            $data->whid=preg_replace( "/'/", "`", $data->whid );
            $data->agent=preg_replace( "/'/", "`", $data->agent );

                     Yii::$app->sbccommon->execqry("UPDATE taxhead
                        SET client='$data->client', clientname='$data->clientname',
                        address='$data->address', dateid2='$data->dateid2',dateid='$data->dateid',
                        editdate=CURRENT_TIMESTAMP, quarter='$data->quarter'
                        where trno='$trno'");
            
            return true;
        }//end function update

        public static function inserthead($docno, $doc, $trno,$data){
            return Taxhead::insert($docno, $doc, $trno,$data);
        }

        public static function insert($docno, $doc, $trno,$data){
           
           $data->client=preg_replace( "/'/", "`", $data->client);
           $data->clientname=preg_replace( "/'/", "`", $data->clientname);
           $data->address=preg_replace( "/'/", "`", $data->address);
           $data->yourref=preg_replace( "/'/", "`", $data->yourref);
           $data->ourref=preg_replace( "/'/", "`", $data->ourref);
           $data->rem=preg_replace( "/'/", "`", $data->rem);
           $data->shipto=preg_replace( "/'/", "`", $data->shipto);
           $data->terms=preg_replace( "/'/", "`", $data->terms);
           $data->whid=preg_replace( "/'/", "`", $data->whid);
            
       
           //WTODO: JLY 2019.1.22 RTT TW ADD QUARTER IN HEAD insert quarter
            $insert= Yii::$app->sbccommon->execqry("INSERT into taxhead (docno, doc, client, clientname, address, dateid, dateid2,quarter,trno)
            values('$docno','$doc', '$data->client', '$data->clientname',
            '$data->address','$data->dateid', '$data->dateid2', $data->quarter, $trno)");
                   
            return $insert;
        }//END FUNCTION INSERT

        public static function openhead($trno,$doc){
            $table=Common::localhead($doc);
            $head=Taxhead::head($trno,$table);
            //return array('trno'=>$trno,'table'=>$head);
            return $head;
        }//END OPEN HEAD
        //WTODO: JLY 2019.1.22 RTT TW ADD QUARTER IN HEAD added head.quarter in local and h table
        public static function head($trno,$lahead){
            $center=Yii::$app->session['loggeduser']['center'];
            
            $qry = "select taxnum.center,head.trno, head.docno,head.client,client.clientname,
            left(head.dateid,10) as dateid,left(head.dateid2,10) as dateid2, head.clientname,
            address,DATE_FORMAT(head.createdate, '%Y-%m-%d') as createdate,head.quarter
            FROM taxhead as head
            left join taxnum on taxnum.trno=head.trno
            left join client  on head.client=client.client
            where head.trno=$trno and taxnum.center='$center'
            union all
            select taxnum.center,head.trno, head.docno,client.client,client.clientname,
            left(head.dateid,10) as dateid,left(head.dateid2,10) as dateid2, head.clientname,
            address,DATE_FORMAT(head.createdate, '%Y-%m-%d') as createdate,head.quarter
            FROM htaxhead as head
            left join taxnum on taxnum.trno=head.trno
            left join client on client.client=head.client
            where head.trno=$trno and taxnum.center='$center'";
            $head = Yii::$app->sbccommon->opentable($qry);
            
            return $head;
        }//end function


        public static function lock($trno,$doc)
        {
            $date=date("Y-m-d H:i:s");
            $user=Yii::$app->session['loggeduser']['username'];
            $docno=Cntnum::getdocno($trno,$doc);
            //Webproc::showmsg('1', "Update $table SET lockdate='$date', lockuser='$user' where trno='$trno'");
            Yii::$app->sbccommon->execqry("Update taxhead SET lockdate='$date', lockuser='$user' where trno='$trno'");
            Log::writelog($doc,$trno,'LOCK',$docno,$user);
        }
        public static function unlock($trno,$doc)
        {
            $docno=Cntnum::getdocno($trno,$doc);
            $user=Yii::$app->session['loggeduser']['username'];
            Yii::$app->sbccommon->execqry("Update taxhead SET lockdate=null, lockuser='' where trno='$trno'");
            Log::writelog($doc,$trno,'UNLOCK',$docno,$user);
        }
        public static function islocked($trno,$doc)
        {
            $table=Common::localhead($doc);
            $islocked= Yii::$app->sbccommon->datareader("SELECT lockdate from taxhead where trno='$trno' union all SELECT lockdate from glhead where trno='$trno' union all SELECT lockdate from hglhead where trno='$trno'");
                   
            
            
            if ($islocked!=null)
                {
                return true;
                }
            else
                {
                return false;
                }

        }
                
                
                
        public static function rrwarehouse($doc,$trno)           //returns the warehouse of the transaction's head
        {
            $table=Common::localhead($doc);
            $warehouse= Yii::$app->sbccommon->datareader("SELECT wh from $table where trno='$trno'");
                return $warehouse;
        }

        public static function getunpostedtrans()           //returns the warehouse of the transaction's head
        {
        //ON LOAD
        $gotdata = Yii::$app->sbccommon->opentable('select head.trno,head.clientname as customername,head.client,head.doc as doc , head.dateid, head.docno as docno from prhead as head
                                                    UNION ALL
                                                    select head.trno,head.clientname as customername,head.client,head.doc as doc , head.dateid, head.docno as docno from pohead as head
                                                    UNION ALL
                                                    select head.trno,head.clientname as customername,head.client,head.doc as doc , head.dateid, head.docno as docno from sohead as head
                                                    UNION ALL
                                                    select head.trno,head.clientname as customername,head.client,head.doc as doc , head.dateid , head.docno as docno from pchead as head
                                                    UNION ALL
                                                    select head.trno,head.clientname as customername,head.client,head.doc as doc , head.dateid, head.docno as docno from lahead as head
                                                    ');
        return $gotdata;
        }

                // JEAR UPDATE

        public function getmodulecounts($controller,$access){

        if (Yii::$app->session['loggeduser']['access'][$access] != 1) {
           $data = "not allowed";
            return $data;
        } else {
            $data= Yii::$app->sbccommon->opentable("
            select distinct doc, count(trno) as counts from(
            select head.trno,head.clientname as customername,head.client,head.doc as doc ,
            head.dateid as datex , head.docno as docno from prhead as head
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
            head.dateid as datex , head.docno as docno from lahead as head)
            as countx group by doc
            order by doc");
            return $data;
        }
        return $data;

        }

        public static function getunpostedtransaction($doc){
            
            $data= Yii::$app->sbccommon->opentable("
            select head.trno,head.clientname as clientname,head.client,head.doc as doc ,
            head.dateid as dateid , head.docno as docno  , 'UNPOSTED' as status from prhead as head
            where head.doc='$doc'
            UNION ALL
            select head.trno,head.clientname as clientname,head.client,head.doc as doc ,
            head.dateid as dateid , head.docno as docno  , 'UNPOSTED' as status from pohead as head
            where head.doc='$doc'
            UNION ALL
            select head.trno,head.clientname as clientname,head.client,head.doc as doc ,
            head.dateid as dateid , head.docno as docno  , 'UNPOSTED' as status from sohead as head
            where head.doc='$doc'
            UNION ALL
            select head.trno,head.clientname as clientname,head.client,head.doc as doc ,
            head.dateid as dateid , head.docno as docno  , 'UNPOSTED' as status from pchead as head
            where head.doc='$doc'
            UNION ALL
            select head.trno,head.clientname as clientname,head.client,head.doc as doc ,
            head.dateid as dateid , head.docno as docno  , 'UNPOSTED' as status from lahead as head
            where head.doc='$doc'
            order by dateid asc");
            return $data;
        }
        
        public function hhh(){
            return '3333';
        }


}