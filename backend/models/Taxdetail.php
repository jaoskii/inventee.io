<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Apledger;
use app\models\Common;


class Taxdetail extends Model
{
        public $alias;
        public $trno;
        public $line;
        public $docno;
        public $dateid;
        public $acno;
        public $acnoid;
        public $acnoname;
        public $client;
        public $ref;
        public $rem;
        public $refx;
        public $linex;
        public $clientname;
        public $db;
        public $cr;
        public $runningdb;
        public $runningcr;
        public $fdb;
        public $grandtotal;
        public $itemcount;
        public $fcr;

        public $depodate;
        public $checkdate;
        public $checkno;
        public $postdate;
        public $field_focus;
        public $action;
        
        public $editacno;
        public $editacnoname;
        public $editref;
        public $editrem;
        public $editdb;
        public $editcr;
        public $editfdb;
        public $editpostdate;
        public $editfcr;
        public $editcheckno;
        public $editrefx;
        public $editlinex;
        public $pdcline;
        public $templine;
        public $rate;
        public $income;
        public $wheld;
        //WTODO: JLY 2019.1.22 RTT TW ADD MONTH FIELD add new month field
        public $month;


    public function rules()
    {
        return array(
                        array('line','numerical', 'integerOnly'=>true),
                        array('acno', 'required'),
                        array('field_focus', 'length', 'max'=>15),
                        array('itemcount,grandtotal,rate,income,wheld,acnoname,postdate,rem,ref', 'safe'),
        );
    }


        public static function deletedetail($doc,$trno)         //delete all details   used before inserting newly computed details
        {   
            $table=Common::localdetail($doc);
            return Yii::$app->sbccommon->execqry("delete from taxdetail where trno=$trno");
        }



        public static function getLastLine($trno,$doc)
        {
            $table=Common::localdetail($doc);
            $stocks=Yii::$app->sbccommon->opentable("SELECT ifnull(line,0) as line FROM $table where trno ='$trno' order by line 
                desc limit 1");
            if(count($stocks)==0)
            {
                return 0;
            }
            else
            {
                return $stocks[0]['line'];
            }
        }

        public static function getstockMI($doc,$trno,$tax)
        {
            $table=Common::localstock($doc);
            $head=Common::localhead($doc);

            $tax1=1 + ($tax/100);
            $tax_=$tax/100;
            switch($doc)
            {
                case 'RR':{
                    $inventory=Yii::$app->sbccommon->opentable("
                    select head.client,item.asset,stock.wh,0 as discount,
                    (sum(stock.ext)) 
                    * case when ifnull(head.forex,0)=0 then 1 else head.forex end as inventory,
                    (((sum(stock.ext))/$tax1)*$tax_ *case when 
                    ifnull(head.forex,0)=0 then 1 else head.forex end) as vat
                    from $head as head left join $table as stock on stock.trno=head.trno
                    left join item on item.barcode=stock.barcode where stock.trno=$trno 
                    group by head.client,item.asset,stock.wh
                    ");


/*                    $inventory=Yii::$app->sbccommon->opentable("
                    select head.client,item.asset,stock.wh,0 as discount,
                    (sum(stock.rrcost*stock.rrqty) - ((sum((stock.rrcost*stock.rrqty)-stock.ext)))) 
                    * case when ifnull(head.forex,0)=0 then 1 else head.forex end as inventory,
                    (((sum(stock.rrcost*stock.rrqty) - ((sum((stock.rrcost*stock.rrqty)-stock.ext))))/$tax1)*$tax_ *case when 
                    ifnull(head.forex,0)=0 then 1 else head.forex end) as vat
                    from $head as head left join $table as stock on stock.trno=head.trno
                    left join item on item.barcode=stock.barcode where stock.trno=$trno 
                    group by head.client,item.asset,stock.wh
                    ");
*/
                    break;
                }
                
                case 'AJ':case 'IS':{
                    $inventory=Yii::$app->sbccommon->opentable("
                    select head.client,item.asset,stock.wh,sum(stock.ext) as inventory
                    from $head as head left join $table as stock on stock.trno=head.trno
                    left join item on item.barcode=stock.barcode where stock.trno=$trno
                    group by head.client,item.asset,stock.wh
                    ");
                    break;
                }
                
                case 'SJ': case 'DM': case 'CH': {
                    $inventory=Yii::$app->sbccommon->opentable("
                    select head.client,item.asset,stock.wh,sum((stock.isamt*stock.isqty)-stock.ext) as discount,sum(stock.ext) as sales,
                    sum(stock.cost*stock.iss)  as inventory ,sum(stock.cost*stock.iss)  as costofgood
                    from $head as head left join $table as stock on stock.trno=head.trno
                    left join item on item.barcode=stock.barcode where stock.trno=$trno
                    group by head.client,item.asset,stock.wh
                    ");


/*                    $inventory=Yii::$app->sbccommon->opentable("
                    select head.client,item.asset,stock.wh,sum((stock.isamt*stock.isqty)-stock.ext) as discount,(sum(stock.isamt*stock.isqty) - ((sum(stock.isamt*stock.isqty)-sum((stock.isamt*stock.isqty)-stock.ext))/1)*0) as sales,
                    sum(stock.cost*stock.iss)  as inventory ,sum(stock.cost*stock.iss)  as costofgood
                    from $head as head left join $table as stock on stock.trno=head.trno
                    left join item on item.barcode=stock.barcode where stock.trno=$trno
                    group by head.client,item.asset,stock.wh
                    ");
*/                    
                    break;
                }

                case 'SJ2':
                {
                    $inventory=Yii::$app->sbccommon->opentable("
                    select head.client,item.asset,stock.wh,sum((stock.isamt*stock.isqty2)-stock.ext) as discount,sum(stock.ext) as sales,
                    sum(stock.cost*stock.iss)  as inventory ,sum(stock.cost*stock.iss)  as costofgood
                    from $head as head left join $table as stock on stock.trno=head.trno
                    left join item on item.barcode=stock.barcode where stock.trno=$trno
                    group by head.client,item.asset,stock.wh
                    ");
                    break;

                }
                case 'CM': {
                     $inventory=Yii::$app->sbccommon->opentable("
                    select head.client,item.asset,stock.wh,sum((stock.isamt*stock.rrqty)-stock.ext) as discount,sum(stock.ext) as sales,
                    sum(stock.cost*stock.qty)  as inventory ,sum(stock.cost*stock.qty)  as costofgood
                    from $head as head left join $table as stock on stock.trno=head.trno
                    left join item on item.barcode=stock.barcode where stock.trno=$trno
                    group by head.client,item.asset,stock.wh
                    ");
                    break;
                }

                default:{
                     $inventory=Yii::$app->sbccommon->opentable("
                    select head.client,item.asset,stock.wh,sum((stock.rrcost*stock.rrqty)-stock.ext) as discount,(sum(stock.ext)/$tax1)*$tax_) as inventory
                    from $head as head left join $table as stock on stock.trno=head.trno
                    left join item on item.barcode=stock.barcode where stock.trno=$trno
                    group by head.client,item.asset,stock.wh
                    ");
                    break;
                }
            }

            return $inventory;
        }




        public static function computeDistributions($doc,$trno,$tax)       //return  Purchase discount, accounts payable, vat
        {
            $table=Common::localstock($doc);
            $head=Common::localhead($doc);

            $tax1=1 + ($tax/100);
            $tax_=$tax/100;
             switch($doc){
                
                case 'RR':{
                $inventory=Yii::$app->sbccommon->opentable("
                select
                sum(stock.rrcost*stock.rrqty) as total,
                0 as pd,
                (sum(stock.ext)) *case when ifnull(head.forex,0)=0 then 1 else head.forex end as ap,
                ((sum(stock.ext))/$tax1)*$tax_  *case when ifnull(head.forex,0)=0 then 1 else head.forex end as vat 
                from $head as head left join $table as stock on stock.trno=head.trno 
                left join item on item.barcode=stock.barcode where stock.trno=$trno
                ");
                break;
                }

                case 'SJ': case 'DM': case 'CH':{
                   $inventory=Yii::$app->sbccommon->opentable("
                    select
                    ifnull(sum(stock.isamt*stock.isqty),0) as total,
                    ifnull(sum((stock.isamt*stock.isqty)-stock.ext),0) as pd,
                    ifnull(sum(stock.ext),0) as ar,
                    ifnull(((sum(stock.ext))/$tax1)*$tax_,0) as vat
                    from $table as stock
                    left join item on item.barcode=stock.barcode where stock.trno=$trno
                    ");
                    break;
                }

                case 'SJ2':
                {
                   $inventory=Yii::$app->sbccommon->opentable("
                    select
                    ifnull(sum(stock.isamt*stock.isqty2),0) as total,
                    ifnull(sum((stock.isamt*stock.isqty2)-stock.ext),0) as pd,
                    ifnull(sum(stock.ext),0) as ar,
                    ifnull(((sum(stock.ext))/$tax1)*$tax_,0) as vat
                    from $table as stock
                    left join item on item.barcode=stock.barcode where stock.trno=$trno
                    ");
                    break;

                }
                case 'CM':{
                    $inventory=Yii::$app->sbccommon->opentable("
                    select
                    sum(stock.isamt*stock.rrqty) as total,
                    sum((stock.isamt*stock.rrqty)-stock.ext) as pd,
                    sum(stock.ext) as ar,
                    ((sum(stock.ext))/$tax1)*$tax_ as vat
                    from $table as stock
                    left join item on item.barcode=stock.barcode where stock.trno=$trno
                    ");
                    break;
                }

                default:{
                    $inventory=Yii::$app->sbccommon->opentable("
                    select
                    sum(stock.rrcost*stock.rrqty) as total,
                    sum((stock.rrcost*stock.rrqty)-stock.ext) as pd,
                    sum(stock.ext) as ap,
                    ((sum(stock.ext))/$tax1)*$tax_ as vat
                    from $table as stock
                    left join item on item.barcode=stock.barcode where stock.trno=$trno
                    ");
                    break;
                }
                
            }//end swtich case
            return $inventory[0];
        }//end function



        public static function getacnoname($acno)
        {
            $acnoname= Yii::$app->sbccommon->datareader("select acnoname from coa where acno='$acno'");
            return $acnoname;
        }
        public static function getacnoid($acno)
        {
            $acnoid= Yii::$app->sbccommon->datareader("select acnoid from coa where acno='$acno'");
            return $acnoid;
        }

        public static function getacno($alias)
        {
            $acno= Yii::$app->sbccommon->datareader("select acno from coa where alias='$alias' limit 1");
            return $acno;
        }
        public static function getacno_($acnoid)
        {
            $acno= Yii::$app->sbccommon->datareader("select acno from coa where acnoid='$acnoid'");
            return $acno;
        }





        public static function deletedetail_($doc,$trno,$line){
           
            Yii::$app->sbccommon->execqry("delete from taxdetail where trno=$trno and line=$line");
            //Yii::$app->sbccommon->execqry("delete from costing where trno=$trno and line=$line");
            //return 1;
            $gettotal = Ladetail::getgrandtotal($trno,$doc);
               if (!empty($gettotal)){                
                $runningdb = $gettotal[0]['totaldb'];
                $runningcr = $gettotal[0]['totalcr'];
               }else{
                $runningdb = 0;
                $runningcr = 0;
               }

            $isbalance = 0;
            $passjson = array('grandtotal'=>$runningcr,'itemcount'=>$runningdb,'isbalance'=>$isbalance,'messages'=>'');
            echo json_encode($passjson);
            
        }
        
        
        public static function insertgl($doc,$trno,$client,$acno,$db,$cr,$date){
            $table=Common::localdetail($doc);
            $user=Yii::$app->session['loggeduser']['username'];
            $line=Ladetail::getLastLine($trno) + 1;
            $acnoname=Ladetail::getacnoname($acno);
                   return  Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                     values ('$trno','$line','$acno','$acnoname','$client',round('$db',2),round('$cr',2),0,0,0,0,'$date','$user')
                     ");
        }
  


       public static function distributeRR($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions){
            //for inventory merchandise - debit side
               $supplier='';
               $acno='';
               for ($i=0; $i<count($inventory);$i++)
               {
                   $acno=$inventory[$i]['asset'];
                   if(strlen($acno)==0)
                       {
                       $acno='\\\\'. Ladetail::getacno('IN1');
                       }
                   else
                       {
                       $acno='\\\\'.$acno;
                       }
                   $acnoname=Ladetail::getacnoname($acno);
                   $whid=$inventory[$i]['wh'];
                   $supplier=$inventory[$i]['client'];
                   $merchandise_inventory=$inventory[$i]['inventory']-$inventory[$i]['vat'];
                   if($merchandise_inventory!=0){
                     Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                     values ('$trno','$line','$acno','$acnoname','$whid',round('$merchandise_inventory',2),0,0,0,0,0,'$dateid',
                     '$user')
                     ");
                   $line++;
                   }
               }//end for inventory merchandise - debit side

               //for vat - debit side
               if ($tax>0)
                   {
                   //$line=Ladetail::getLastLine($trno,$doc)+1;
                   $taxcontra='\\\\'.Ladetail::getacno('TX1');
                   $acnoname=Ladetail::getacnoname($taxcontra);
                   $vat=$distributions['vat'];
                   Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                     values ('$trno','$line','$taxcontra','$acnoname','$supplier',round('$vat',2),0,'$vat',0,0,0,'$dateid','$user')
                    ");
                   $line++;
                   }// end for vat - debit side

                  //for vat - credit side
                $discount=0;
               /* if ($distributions['pd']>0)
                    {
                    $discount=$distributions['pd'];
                    //$line=Ladetail::getLastLine($trno,$doc) + 1;
                    $pdcontra='\\\\'.Ladetail::getacno('PD1'); 
                    $acnoname=Ladetail::getacnoname($pdcontra);
                    $pd=$distributions['pd'];
                   Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                         values ('$trno','$line','$pdcontra','$acnoname','$supplier',0,round('$pd',2),0,0,0,0,'$dateid','$user')
                        ");
                     $line++;
                    } //end for vat - credit side*/

                 //for AP - credit side                
                $ap=$distributions['ap'];
                if($ap>0){
                    //$line=Ladetail::getLastLine($trno,$doc) + 1;
                    if(strlen($contra)==0)
                        {
                        $contra='\\\\'.Ladetail::getacno('AP1');
                        }
                    else
                        {
                        $contra="\\\\".$contra;
                        }
                    $acnoname=Ladetail::getacnoname($contra);
                   Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                         values ('$trno','$line','$contra','$acnoname','$supplier',0,round('$ap',2),0,0,0,0,'$dateid','$user')
                        ");
                }// end for AP - credit side                
               return 'ok';            
        }




      public static function distributeDM($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions){
            //for inventory merchandise - credit side
            $pd=0;
            $merchandise_inventory=0;
            $tax=0;

           for ($i=0; $i<count($inventory);$i++)
           {
               $acno=$inventory[$i]['asset'];
               if(strlen($acno)==0)
                   {
                   $acno='\\\\'.Ladetail::getacno('IN1');
                   }
               else
                   {
                   $acno='\\\\'.$acno;
                   }
               $acnoname=Ladetail::getacnoname($acno);
               $whid=$inventory[$i]['wh'];
               $supplier=$inventory[$i]['client'];               
               $merchandise_inventory=$inventory[$i]['inventory']; // - $inventory[$i]['discount']
               if($merchandise_inventory!=0){
                   Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                     values ('$trno','$line','$acno','$acnoname','$whid',0,round('$merchandise_inventory',2),0,0,0,0,'$dateid','$user')
                     ");
             $line++;
               }
           }//end for inventory merchandise - credit side

           //for vat - debit side
           if ($tax>0)
               {
               //$line=Ladetail::getLastLine($trno,$doc) + 1;
               $taxcontra='\\\\'.Ladetail::getacno('TX1');
               $acnoname=Ladetail::getacnoname($taxcontra);
               $vat=$distributions['vat'];
               Yii::$app->sbccommon->execqry("insert into $table
                (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                 values ('$trno','$line','$taxcontra','$acnoname','$supplier',$vat,0,0,0,0,0,'$dateid','$user')
                ");
                $line++;
               }//end for vat - debit side

             //for vat - credit side
               $discount=0;
            if ($distributions['pd']>0)
                {
                $discount=$distributions['pd'];
                //$line=Ladetail::getLastLine($trno,$doc) + 1;
                $pdcontra='\\\\'.Ladetail::getacno('PD1');
                $acnoname=Ladetail::getacnoname($pdcontra);
                $pd=$distributions['pd'];
               Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                     values ('$trno','$line','$pdcontra','$acnoname','$whid',$pd,0,0,0,0,0,'$dateid','$user')
                    ");
                 $line++;
                }//end for vat - credit side

               //for AP - debit side
                $ap=$distributions['ar']; // - $discount
                if($ap>0){
                    if(strlen($contra)==0)
                        {
                        $contra='\\\\'.Ladetail::getacno('AP1');
                        }
                    else
                        {
                        $contra="\\\\".$contra;
                        }
                    $acnoname=Ladetail::getacnoname($contra);
                   Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                         values ('$trno','$line','$contra','$acnoname','$supplier',$ap,0,0,0,0,0,'$dateid','$user')
                        ");
                   $line++;
                } //end for AP - debit side

                //Balancing account only
                $balance_total = ($ap+$pd)-$merchandise_inventory;
                $pdcontra='\\\\'.Ladetail::getacno('GLC');
                $acnoname=Ladetail::getacnoname($pdcontra);

                if($balance_total>0){                    
                   Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                         values ('$trno','$line','$pdcontra','$acnoname','$whid',0,'$balance_total',0,0,0,0,'$dateid','$user')
                        ");
                }elseif($balance_total<0){
                   Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,cr,db,fdb,fcr,refx,linex,postdate,encodedby)
                         values ('$trno','$line','$pdcontra','$acnoname','$whid',0,'".abs($balance_total)."',0,0,0,0,'$dateid','$user')
                        ");                    
                }
                //Balancing account only
                return 'ok';

      }



          public static function distributeSJ($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions){
            //for inventory merchandise - credit side
                $vat=0;
                if ($distributions['vat']>0)
                    {
                    $vat=$distributions['vat'];
                    }
                
               for ($i=0; $i<count($inventory);$i++){
                   $acno=$inventory[$i]['asset'];
                    if(strlen($acno)==0){
                        $acno='\\\\'.Ladetail::getacno('IN1');
                    }else{
                        $acno='\\\\'.$acno;
                    }
                       
                   $whid=$inventory[$i]['wh'];
                   $merchandise_inventory=$inventory[$i]['inventory'];
                   $supplier=$inventory[$i]['client'];                   
                   $merchandise_cost=$inventory[$i]['costofgood'];
                   if($merchandise_cost!=0){
                            $acnoname=Ladetail::getacnoname($acno);
                            Yii::$app->sbccommon->execqry("insert into $table
                            (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                            values ('$trno','$line','$acno','$acnoname','$whid',0,$merchandise_cost,0,0,0,0,'$dateid','$user')
                            ");
                            $line++;
                   }
                    //for sales
                    $merchandise_sales=$inventory[$i]['sales'] - $vat ;
                  if($merchandise_sales!=0){
                        $acno='\\\\'.Ladetail::getacno('SA1');
                        $acnoname=Ladetail::getacnoname($acno);                    
                        Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                        values ('$trno','$line','$acno','$acnoname','$supplier',0,$merchandise_sales,0,0,0,0,'$dateid','$user')
                        ");
                        $line++;
                  }   //end for sales
                    
                    //for cost of good sold 
                   if($merchandise_cost!=0){
                        $acno='\\\\'.Ladetail::getacno('CG1');
                        $acnoname=Ladetail::getacnoname($acno);                    
                        Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                        values ('$trno','$line','$acno','$acnoname','$whid',$merchandise_cost,0,0,0,0,0,'$dateid','$user')
                        ");
                        $line++;
                    }// end for cost of good sold
               }//end for inventory merchandise - credit side
              
               //for vat - debit side
               if ($tax>0)
                   {
                   $taxcontra='\\\\'.Ladetail::getacno('TX2');
                   $acnoname=Ladetail::getacnoname($taxcontra);
                   $vat=$distributions['vat'];
                   Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                     values ('$trno','$line','$taxcontra','$acnoname','$supplier',0,$vat,0,0,0,0,'$dateid','$user')
                    ");
                    $line++;
                   }//end for vat - debit side

                 //for discount - credit side
                $discount=0;
                /*if ($distributions['pd']>0)
                    {
                    $discount=$distributions['pd'];
                    $pdcontra='\\\\'.Ladetail::getacno('SD1');
                    $acnoname=Ladetail::getacnoname($pdcontra);
                    $pd=$distributions['pd'];
                   Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                         values ('$trno','$line','$pdcontra','$acnoname','$supplier',$pd,0,0,0,0,0,'$dateid','$user')
                        ");
                   $line++;
                    }*/

               //for AR - debit side
                $ar=$distributions['ar'];
                if($ar>0){
                    if(strlen($contra)==0){
                        $contra='\\\\'.Ladetail::getacno('AR1');
                    }else{
                        $contra="\\\\".$contra;
                    }
                      $acnoname=Ladetail::getacnoname($contra); 
                      Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                         values ('$trno','$line','$contra','$acnoname','$supplier',$ar,0,0,0,0,0,'$dateid','$user')
                        ");
                      $line++;
                      Yii::$app->sbccommon->execqry("update ladetail left join lahead on lahead.trno=ladetail.trno left join coa on coa.acno=ladetail.acno set ladetail.checkno=lahead.Checked where ladetail.trno=".$trno." and left(coa.alias,2)='CR'");
                } //end for AR - debit side
                return 'ok';
      }




      public static function distributeCM($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions){
            //for inventory merchandise - debit side
            $vat=0;
            if ($distributions['vat']>0)
                {
                $vat=$distributions['vat'];
                }

               for ($i=0; $i<count($inventory);$i++)
               {
                   $acno=$inventory[$i]['asset'];
                   if(strlen($acno)==0)
                       {
                       $acno='\\\\'.Ladetail::getacno('IN1');
                       }
                   else
                       {
                       $acno='\\\\'.$acno;
                       }

                   $whid=$inventory[$i]['wh'];
                   $merchandise_inventory=$inventory[$i]['inventory'];
                   $supplier=$inventory[$i]['client'];                   
                   $merchandise_cost=$inventory[$i]['costofgood'];
                   if ($merchandise_inventory>0){
                      $acnoname=Ladetail::getacnoname($acno);
                      Yii::$app->sbccommon->execqry("insert into $table
                       (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                        values ('$trno','$line','$acno','$acnoname','$whid',$merchandise_inventory,0,0,0,0,0,'$dateid','$user')
                       ");
                      $line++;
                    }
                    
                    if ($merchandise_cost>0){
                            $acno='\\\\'.Ladetail::getacno('CG1');
                            $acnoname=Ladetail::getacnoname($acno);
                            Yii::$app->sbccommon->execqry("insert into $table
                            (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                            values ('$trno','$line','$acno','$acnoname','$whid',0,$merchandise_cost,0,0,0,0,'$dateid','$user')
                            ");
                            $line++;
                   }

                    //for Accounts receivables
                            $merchandise_sales=$inventory[$i]['sales'] - $vat ;
                            if($merchandise_sales!=0){
                                $acno='\\\\'.Ladetail::getacno('SR1');
                                $acnoname=Ladetail::getacnoname($acno);                                
                                Yii::$app->sbccommon->execqry("insert into $table
                                (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                                values ('$trno','$line','$acno','$acnoname','$supplier',$merchandise_sales,0,0,0,0,0,'$dateid','$user')
                                ");
                                $line++;
                            }
                           
               }

               //for vat - debit side
               if ($tax>0)
                {
                   $taxcontra='\\\\'.Ladetail::getacno('TX2');
                   $acnoname=Ladetail::getacnoname($taxcontra);
                   $vat=$distributions['vat'];
                   Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,cr,db,fdb,fcr,refx,linex,postdate,encodedby)
                     values ('$trno','$line','$taxcontra','$acnoname','$supplier',0,$vat,0,0,0,0,'$dateid','$user')
                    ");
                   $line++;
                }

                //for vat - credit side
                $discount=0;
                $pd=$distributions['pd'];                
                if ($pd>0)
                  {
                    $discount=$distributions['pd'];
                    $pdcontra='\\\\'.Ladetail::getacno('SD1');
                    $acnoname=Ladetail::getacnoname($pdcontra);
                    Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                         values ('$trno','$line','$pdcontra','$acnoname','$supplier',0,$pd,0,0,0,0,'$dateid','$user')
                        ");
                    $line++;
                  }//end for vat - credit side

               //for AR - credit side
                $ar=$distributions['ar'];
                if($ar>0){
                    if(strlen($contra)==0)
                        {
                        $contra='\\\\'.Ladetail::getacno('AR1');
                        }
                    else
                        {
                        $contra="\\\\".$contra;
                        }
                   $acnoname=Ladetail::getacnoname($contra);
                  Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                     values ('$trno','$line','$contra','$acnoname','$supplier',0,$ar,0,0,0,0,'$dateid','$user')
                    ");
                   $line++;
                } //end for AR - credit side
                return 'ok';
      }



      public static function distributeAJ($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions){
            //for inventory merchandise - debit side
               for ($i=0; $i<count($inventory);$i++)
               {
                   $acno=$inventory[$i]['asset'];
                   if(strlen($acno)==0)
                       {
                       $acno='\\\\'. Ladetail::getacno('IN1');
                       }
                   else
                       {
                       $acno='\\\\'.$acno;
                       }
                   $whid=$inventory[$i]['wh'];
                   $merchandise_inventory=$inventory[$i]['inventory']; // - $inventory[$i]['discount']
                    if($merchandise_inventory>0){                        
                       $acnoname=Ladetail::getacnoname($acno);                       
                       Yii::$app->sbccommon->execqry("insert into $table
                        (trno,line,acno,acnoname,client,cr,db,fdb,fcr,refx,linex,postdate,encodedby)
                         values ('$trno','$line','$acno','$acnoname','$whid','0',$merchandise_inventory,0,0,0,0,'$dateid','$user')
                         ");
                        $line++;

                       $contraacno='\\\\'.Ladetail::getacno('IS1');
                       $acnoname=Ladetail::getacnoname($contraacno);
                       Yii::$app->sbccommon->execqry("insert into $table
                            (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                             values ('$trno','$line','$contraacno','$acnoname','$whid','0',$merchandise_inventory,0,0,0,0,'$dateid',
                             '$user')");
                       $line++;
                    } //if($merchandise_inventory>0)
                    elseif($merchandise_inventory<0)
                    {
                        $acnoname=Ladetail::getacnoname($acno);                       
                        $qry="
                          insert into ".$table."
                         (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                         values ('".$trno."','".$line."','".$acno."','".$acnoname."','".$whid."','0',abs(".$merchandise_inventory."),0,0,0,0,'".$dateid."',
                         '".$user."')";
                        Yii::$app->sbccommon->execqry($qry);                        
                        //Yii::$app->sbccommon->execqry("insert into $table
                        // (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,encodedby)
                        // values ('$trno','$line','$acno','$acnoname','$whid','0',abs($merchandise_inventory),0,0,0,0,'$dateid',
                        // '$user')
                     //");
                    $line++;
                       $contraacno='\\\\'.Ladetail::getacno('IS1');
                       $acnoname=Ladetail::getacnoname($contraacno);
                        Yii::$app->sbccommon->execqry("insert into ".$table."
                             (trno,line,acno,acnoname,client,cr,db,fdb,fcr,refx,linex,postdate,encodedby)
                              values ('".$trno."','".$line."','".$contraacno."','".$acnoname."','".$whid."','0',abs(".$merchandise_inventory."),0,0,0,0,
                              '".$dateid."','".$user."')
                              ");
                        $line++;
                    }//elseif($merchandise_inventory<0)
               }
               return 'ok';
      }




        public static function autoinsertdetail($doc,$trno,$contra,$tax,$dateid){
            $table=Common::localdetail($doc);
            $user=Yii::$app->session['loggeduser']['username'];
            $line=Ladetail::getLastLine($trno,$doc) + 1;
            $inventory=Ladetail::getstockMI($doc,$trno, $tax);
            $distributions=Ladetail::computeDistributions($doc,$trno,$tax);
            $whid='';

            switch($doc){
              case 'RR':{
                 return Ladetail::distributeRR($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions);
                 break;
                }
               case 'DM':{
                  return Ladetail::distributeDM($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions);
                  break;
                }              
               case 'SJ':
               case 'SJ2':
                {
                  return Ladetail::distributeSJ($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions);
                  break;                 
               }
               case 'CH':{
                  return Ladetail::distributeSJ($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions);
                  break;                                  
               }
               case 'CM':{
                  return Ladetail::distributeCM($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions);
                  break;
               }
               case 'AJ':case 'IS':{
                  return Ladetail::distributeAJ($trno,$doc,$contra,$tax,$table,$user,$line,$dateid,$inventory,$distributions);
                  break;
                 }
            }
        }//end function autoinsert detial





        //manage details
        public static function insertdetail($trno,$data,$table,$module){
            $line=Taxdetail::getLastLine($trno,$module) + 1;
            $supplier=$data->client;

            $postdate=isset($data->postdate) && ($data->postdate!=null) && strlen($data->postdate)!=0 ? "'".date('Y-m-d H:i:s',strtotime($data->postdate))."'" : 'null';
            $user=Yii::$app->session['loggeduser']['username'];
            $acno=$data->acno;
            
            // $acnoname=Ladetail::getacnoname($acno);//use this if editing of account title is NOT ALLOWED
            $acnoname=$data->acnoname;//use this if editing of account title is ALLOWED

            $insert = Yii::$app->sbccommon->execqry("insert into taxdetail
            (trno,line,acno,acnoname,rate,income,wheld,month)
            values ('$trno','$line','$acno','$acnoname',
            round('$data->rate',".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
            round('$data->income',".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
            round('$data->wheld',".Yii::$app->systemsettings->setDecimaldisplay('currency')."),'$data->month')");
            
            $gettotal = Ladetail::getgrandtotal($trno,$module);
            $detail = Taxdetail::opendetailline($trno,$line,$module);
            $month = $detail[0]['month'];
            $acno = $detail[0]['acno'];
            $acnoname = $detail[0]['acnoname'];
            $rate = $detail[0]['rate'];
            $income= $detail[0]['income'];
            $wheld= $detail[0]['wheld'];
            $trno= $detail[0]['trno'];
            $line= $detail[0]['line'];
     
            $runningdb = $gettotal[0]['totaldb'];
            $runningcr = $gettotal[0]['totalcr'];

            return $insert;
        }//end function   

        public static function insert($trno,$data,$module)
        {
            $table=Common::localdetail($module);
            $line=Ladetail::getLastLine($trno,$module) + 1;
            switch($module){
                case 'PV':
                case 'CV':
                case 'CR':
                case 'GJ':
                case 'DS':{
                    $supplier=$data->client;
                    if(strlen($supplier)==0 || $supplier==null){
                        $supplier=Yii::$app->session['supplier'.$module];
                    }
                    break;
                }
                default:{
                        $supplier=Yii::$app->session['supplier'.$module];
                    break;
                }
            }

            $postdate=isset($data->postdate) && ($data->postdate!=null) && strlen($data->postdate)!=0 ? "'".date('Y-m-d H:i:s',strtotime($data->postdate))."'" : 'null';
            $user=Yii::$app->session['loggeduser']['username'];
            $acno="\\".$data->acno;
            $acnoname=$data->acnoname;                                          
            if (($data->db+$data->cr)!=0){
                $query="insert into $table (trno,line,acno,acnoname,client,db,cr,fdb,fcr,ref,refx,linex,postdate,encodedby,checkno)
                values ('$trno','$line','$acno','$acnoname','$supplier',round('$data->db',2),round('$data->cr',2),'0.00','0.00',
                '$data->ref','$data->refx','$data->linex',$postdate,'$user','$data->checkno')";

                $insert=Yii::$app->sbccommon->execqry($query);
            
                if($insert==1){ //update success
                    if(Apledger::updatebal($data->refx, $data->linex, $data, $module,0)==1){
                        return true;
                    }else{//update failed
                        Apledger::resetdb($trno, $line, $module);//set CV db to 0
                        Apledger::updatebal($data->refx, $data->linex, $data, $module,1); //update the bal in ap/arledger
                        return false;
                    }//end if
                }else{//insert failed
                    return false;//$trno."-".$line."-".$acno."-".$acnoname."-".$supplier."-".$postdate."-".$user;
                }//end if
            }else{
                return false;
            }//end if
        }//end fn

        public static function getdetailbank($trno,$acno){
            $acno = "\\".$acno;
           return $data =  Yii::$app->sbccommon->opentable("select trno,line from ladetail where trno = $trno and acno = '$acno'");           
           
       }

        public static function getapdetail($trno,$module)                                       //this can be used to get ap detail upon posting
        {
            $table=Common::localdetail($module);
            $ap=Yii::$app->sbccommon->opentable("
                    select trno,d.acno,d.acnoname,alias,client,round(db,2) as db,round(cr,2) as cr from $table as d
                    left join coa on coa.acno=d.acno
                    where alias='AP1' and trno=$trno
                    ");
            if ($ap!=null)
                {
                return $ap;
                }
            else
                {
                return false;
                }
        }

        public static function getapLastLine($trno,$table)
        {
            $stocks=Yii::$app->sbccommon->opentable("SELECT line FROM $table where trno ='$trno' order by line desc limit 1");
            if ($stocks==null)
            {
                return 0;
            }
            else
            {
                return $stocks[0]['line'];
            }
        }

        public static function insertapdetail($trno,$line,$data,$table)
        {
            
            $supplier=Yii::$app->session['supplier'.Yii::$app->session['RR']];
            $user=Yii::$app->session['loggeduser']['username'];
            $clientid=Client::checkclient($supplier);
            $date=date("Y-m-d H:i:s");
            Yii::$app->sbccommon->execqry("insert into $table
                    (trno,line,acnoid,clientid,db,cr,docno,dateid)
                     values ('$trno','$line','$data->acnoid','$clientid',round('$data->db',2),round('$data->cr',2),'$data->docno','$date')
                     ");
        if(Ladetail::validatecheckno($acno,$data->checkno,$module)==1){    
                //IF VALIDATION OF CHECK IS TRUE
                $detail = Ladetail::opendetailline($trno,$line,$module);
                $gettotal = Ladetail::getgrandtotal($trno,$module);
                $isbalance = Common::isBalanced($trno,$table);
                $acno = $detail[0]['acno'];
                $acnoname = $detail[0]['acnoname'];
                $db = $detail[0]['db'];
                $cr= $detail[0]['cr'];
                $postdate = $detail[0]['postdate'];
                $checkno = $detail[0]['checkno'];
                $rem = $detail[0]['rem'];
                $ref = $detail[0]['ref'];
                $client = $detail[0]['client'];
                $refx = $detail[0]['refx'];
                $linex = $detail[0]['linex'];
                
                $runningdb = $gettotal[0]['totaldb'];
                $runningcr = $gettotal[0]['totalcr'];

                $passjson = array('status'=>true,'savingtype'=>'add','trno'=>$trno,'line'=>$line,'acno'=>$acno,'acnoname'=>$acnoname,'db'=>number_format($db,Yii::$app->systemsettings->setDecimaldisplay('currency')),'cr'=>number_format($cr,Yii::$app->systemsettings->setDecimaldisplay('currency')),'postdate'=>$postdate,'checkno'=>$checkno,'rem'=>$rem,'ref'=>$ref,'runningdb'=>$runningdb,'runningcr'=>$runningcr,'results'=>'1','isbalance'=>$isbalance,'client'=>$client,'refx'=>$refx,'linex'=>$linex,'msg'=>$msg,'templine'=> $data->templine);
                    return $passjson;
            }else{
                //validation of check no is false
                Yii::$app->sbccommon->execqry("delete from $table where trno = $trno and line = $line");                
                $passjson = array('msg'=>"Bank Entries should have check numbers! Please kindly check your entries!",'status'=>false,'line'=>$line);
                return $passjson;
            }//end if check no validation
        }//end function   
        //WTODO: JLY 2019.1.22 RTT TW ADD MONTH FIELD
        public static function updatedetail($trno,$line,$data,$doc){
            $date=date("Y-m-d H:i:s");
            $msg = "";
            
            $user=Yii::$app->session['loggeduser']['username'];
            $acno=$data->acno;

            updating: 
            $sql="update taxdetail set rate=round('$data->rate',2), income=round('$data->income',2) , wheld=round('$data->wheld',2), 
            month='$data->month',editby='$user',editdate=CURRENT_TIMESTAMP
                   where trno='$trno' and line='$line'";
             Yii::$app->sbccommon->execqry($sql);
             

            view:    
            $gettotal = Ladetail::getgrandtotal($trno,$doc);
            $detail = Taxdetail::opendetailline($trno, $line,$doc);
               if (!empty($detail)){
                $month = $detail[0]['month'];
               $acno = $detail[0]['acno'];
                $acnoname = $detail[0]['acnoname'];
                $rate = $detail[0]['rate'];
                $income= $detail[0]['income'];
                $wheld= $detail[0]['wheld'];
                $trno= $detail[0]['trno'];
                $line= $detail[0]['line'];
                $runningdb = $gettotal[0]['totaldb'];
                $runningcr = $gettotal[0]['totalcr'];
                
               $passjson = array('status'=>true,'savingtype'=>'edit','trno'=>$trno,'line'=>$line,'month'=>$month,'acno'=>$acno,'acnoname'=>$acnoname,'rate'=>number_format($rate,Yii::$app->systemsettings->setDecimaldisplay('currency')),'income'=>number_format($income,Yii::$app->systemsettings->setDecimaldisplay('currency')),'wheld'=>number_format($wheld,Yii::$app->systemsettings->setDecimaldisplay('currency')),'results'=>'1','templine'=> $data->templine,'runningdb'=>$runningdb,'runningcr'=>$runningcr);
                return $passjson;
          }
        }
        //WTODO: JLY 2019.1.22 RTT TW ADD MONTH FIELD
     public static function opendetailline($trno,$line,$doc){

            $detail=Yii::$app->sbccommon->opentable("
                select head.trno,line,d.acno,d.acnoname,round(d.rate,2) as rate,round(income,2) as income,round(wheld,2) as wheld,d.month
                from taxdetail as d
                left join taxhead as head on head.trno=d.trno
                left join client on d.client=client.client
                left join coa on d.acno=coa.acno
                where d.trno=$trno and d.line=$line
                union all
                select head.trno,line,coa.acno,coa.acnoname,round(d.rate,2) as rate,round(income,2) as income,round(wheld,2) as wheld,d.month
                from htaxdetail as d
                left join taxhead as head on head.trno=d.trno
                left join client on d.clientid=client.clientid
                left join coa on d.acnoid=coa.acnoid
                where d.trno=$trno and d.line=$line
                
                ");
            return $detail;
        }

        //WTODO: JLY 2019.1.22 RTT TW ADD MONTH FIELD add in opendetail
        public static function opendetail($trno,$doc){
            return "select d.trno,d.line,d.acno,d.acnoname,round(d.rate,2) as rate,
            round(income,2) as income,round(wheld,2) as wheld,d.month 
            from taxdetail as d
            left join taxhead as head on head.trno=d.trno
            left join client on d.client=client.client
            left join taxmenu on d.acno=taxmenu.atc
            where d.trno=$trno
            UNION ALL
            select d.trno,d.line,taxmenu.atc,taxmenu.name,round(d.rate,2) as rate,
            round(income,2) as income,round(wheld,2) as wheld,d.month 
            from htaxdetail as d
            left join taxhead as head on head.trno=d.trno
            left join client on d.clientid=client.clientid
            left join taxmenu on d.acno=taxmenu.atc where d.trno=$trno";
        }//end fn
        
        
        public static function openkrdetail($trno){
            $detail=Yii::$app->sbccommon->opentable("
                select 'AR' as alias_,ar.trno,ar.line,left(dateid,10) as dateid,ar.acnoid,coa.alias,coa.acno,coa.acnoname,client.clientname,ar.db,ar.cr,ar.bal,ar.docno,ar.kr,detail.rem,client.client

                from arledger as ar
                left join gldetail as detail on detail.trno = ar.trno and detail.line = ar.line
                left join coa on coa.acnoid=ar.acnoid
                left join client on client.clientid=ar.clientid
                where ar.kr='$trno'");
            return $detail;
        }
        
        public static function getdstotal($trno){            
            return Yii::$app->sbccommon->opentable("
            SELECT round(sum(ladetail.db),2) as totaldb,round(sum(ladetail.cr),2) as totalcr
            FROM ladetail left join coa on coa.acno = ladetail.acno  where left(coa.alias,2)<>'CB' and  ladetail.trno
             ='$trno'");
        }
        
        public static function getgrandtotal($trno,$doc){
            $table=Common::localdetail($doc);
            
                    return Yii::$app->sbccommon->opentable("
                    select count(trno) as itemcount,
                    round(sum(wheld),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as grandtotal
                    FROM taxdetail where trno ='$trno' group by trno
                    UNION ALL
                    SELECT count(trno) as itemcount,
                    round(sum(wheld),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as grandtotal
                    FROM htaxdetail where trno ='$trno' group by trno
                    ");
                
        }
        public static function getContralist($doc) {

            switch($doc){
                case'AP':{ $condition=" left(alias,2)='IS' "; break; }
                case'AR':{ $condition=" left(alias,2)='IS' "; break; }
                case'CV':{ $condition=" left(alias,2)='CB' "; break; }
                case'CR':{ $condition=" left(alias,2)='CR' or left(alias,2)='CA' "; break; }
                case'DS':{ $condition=" left(alias,2)='CB' "; break; }
                case'PV':{ $condition=" alias='AP2' "; break; }
                default:{ $condition =" left(alias,2)='AP' or left(alias,2)='AR' or left(alias,2)='CB' or left(alias,2)='CR' "; break; }
            }
        $data = Yii::$app->sbccommon->opentable("SELECT  acnoid, acno, acnoname from coa where $condition ");
        if (!empty($data)) {
            if ($data[0]['acno'] != null) {
                $acno = array();
                foreach ($data as $key => $data_) {

                   $acno1 = array('acnoid' => strtoupper($data_['acnoid']), 'acno' => strtoupper($data_['acno']), 'acnoname' => $data_['acnoname']);
                    array_push($acno, $acno1);
                }
                return $acno;
            } 
        } else {
            return $data;
        }
    }
    
    public static function validatecheckno($acno,$checkno,$module) {
       $validate = 1;
       switch ($module) {
           case 'GJ': case 'DS':               
               break;           
           default:
               if(!empty($acno)){
                       $alias = Yii::$app->sbccommon->datareader("select alias from coa where acno = '".$acno."'");
                        if (substr($alias,0,2)=='CB' || substr($alias,0,2)=='CR'){ 
                            if ($checkno==""){
                                $validate =0;
                            }else{
                                $validate =1;                        
                            }
                        }           
               }               
               break;
       }//end switch
       return $validate;
    }




}