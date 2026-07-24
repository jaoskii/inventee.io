<?php

namespace app\components;
 
use Yii;
use yii\base\Component;
use yii\db\Query;

use yii\db\Exception;
use yii\base\ErrorException;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class commonfunc extends Component
{

    public function opentable($query){
        //Array Return $rawdata[0]  
        /* print_r(Yii::app()->db);
        return 0; */
        try{
            //var_dump(Yii::app()->db);
            $rawdata = Yii::$app->db->createCommand($query)->queryAll();
            return $rawdata;            
        }catch (Exception $e){
          //echo $e;
        }
    }//end function opentable
    


    public function execqry($query){
        try{
            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'KINGGEORGE':
                    switch (Yii::$app->session['king_db_set']){
                        case md5(1):
                            Yii::$app->g1->createCommand($query)->query();
                        break;
                        
                        case md5(2):
                            Yii::$app->g2->createCommand($query)->query();
                        break;

                        case md5(3):
                            Yii::$app->g3->createCommand($query)->query();
                        break;

                        case md5(4):
                            Yii::$app->g4->createCommand($query)->query();
                        break;

                        case md5(5):
                            Yii::$app->g5->createCommand($query)->query();
                        break;

                        case md5(6):
                            Yii::$app->g6->createCommand($query)->query();
                        break;

                        case md5(7):
                            Yii::$app->g7->createCommand($query)->query();
                        break;

                        case md5(8):
                            Yii::$app->g8->createCommand($query)->query();
                        break;

                        case md5(9):
                            Yii::$app->g9->createCommand($query)->query();
                        break;

                        case md5(10):
                            Yii::$app->g10->createCommand($query)->query();
                        break;
                    }//end switch
                break;

                default:
                    Yii::$app->db->createCommand($query)->query();
                break;
            }//end switch

           return 1;
        }catch(Exception $e){
            Yii::$app->backend->create_Elog($query);
            return 0;
        }//end function
    }


    public function exec_stored_procedure($query,$field){
        try{
            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'KINGGEORGE':
                    switch (Yii::$app->session['king_db_set']){
                        case md5(1):
                            Yii::$app->g1->createCommand($query)->query();
                            $rawdata = Yii::$app->g1->createCommand('select '.$field)->queryScalar();
                        break;
                        
                        case md5(2):
                            Yii::$app->g2->createCommand($query)->query();
                            $rawdata = Yii::$app->g2->createCommand('select '.$field)->queryScalar();
                        break;

                        case md5(3):
                            Yii::$app->g3->createCommand($query)->query();
                            $rawdata = Yii::$app->g3->createCommand('select '.$field)->queryScalar();
                        break;

                        case md5(4):
                            Yii::$app->g4->createCommand($query)->query();
                            $rawdata = Yii::$app->g4->createCommand('select '.$field)->queryScalar();
                        break;

                        case md5(5):
                            Yii::$app->g5->createCommand($query)->query();
                            $rawdata = Yii::$app->g5->createCommand('select '.$field)->queryScalar();
                        break;

                        case md5(6):
                            Yii::$app->g6->createCommand($query)->query();
                            $rawdata = Yii::$app->g6->createCommand('select '.$field)->queryScalar();
                        break;

                        case md5(7):
                            Yii::$app->g7->createCommand($query)->query();
                            $rawdata = Yii::$app->g7->createCommand('select '.$field)->queryScalar();
                        break;

                        case md5(8):
                            Yii::$app->g8->createCommand($query)->query();
                            $rawdata = Yii::$app->g8->createCommand('select '.$field)->queryScalar();
                        break;

                        case md5(9):
                            Yii::$app->g9->createCommand($query)->query();
                            $rawdata = Yii::$app->g9->createCommand('select '.$field)->queryScalar();
                        break;

                        case md5(10):
                            Yii::$app->g10->createCommand($query)->query();
                            $rawdata = Yii::$app->g10->createCommand('select '.$field)->queryScalar();
                        break;
                    }//end switch
                break;

                default:
                    Yii::$app->db->createCommand($query)->query();
                    $rawdata = Yii::$app->db->createCommand('select '.$field)->queryScalar();
                break;
            }//end switch
           
           $rawdata = Yii::$app->db->createCommand('select '.$field)->queryScalar();
           return $rawdata;
        }

        catch(Exception $e){
            Yii::$app->backend->create_Elog($query);
            return 0;
        }
    }


    public function datareader($query){
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'KINGGEORGE':
                switch (Yii::$app->session['king_db_set']){
                    case md5(1):
                        $data = Yii::$app->g1->createCommand($query)->queryScalar();
                    break;
                    
                    case md5(2):
                        $data = Yii::$app->g2->createCommand($query)->queryScalar();
                    break;

                    case md5(3):
                        $data = Yii::$app->g3->createCommand($query)->queryScalar();
                    break;

                    case md5(4):
                        $data = Yii::$app->g4->createCommand($query)->queryScalar();
                    break;

                    case md5(5):
                        $data = Yii::$app->g5->createCommand($query)->queryScalar();
                    break;

                    case md5(6):
                        $data = Yii::$app->g6->createCommand($query)->queryScalar();
                    break;

                    case md5(7):
                        $data = Yii::$app->g7->createCommand($query)->queryScalar();
                    break;

                    case md5(8):
                        $data = Yii::$app->g8->createCommand($query)->queryScalar();
                    break;

                    case md5(9):
                        $data = Yii::$app->g9->createCommand($query)->queryScalar();
                    break;

                    case md5(10):
                        $data = Yii::$app->g10->createCommand($query)->queryScalar();
                    break;
                }//end switch
            break;

            default:
                $data = Yii::$app->db->createCommand($query)->queryScalar();
            break;
        }//end switch
     return $data;
    }//end if

    public function opencsql($sql,$keyField,$sort,$pagesize)
        {
                   //return new CSqlDataProvider($sql,array(
                   //    'keyField'=>$keyField,'sort'=>array('attributes'=>array($sort,),),'pagination'=>array('pageSize'=>$pagesize,),));
                          return new CSqlDataProvider($sql,array(
                       'keyField'=>$keyField,'sort'=>array('attributes'=>array($sort,),),'pagination'=>array('pageSize'=>$pagesize,),));

            
        }



    public function openhead2($trno=0){
            $query ='select 0 as id,sohead.trno, sohead.docno, sohead.client from sohead where sohead.trno='.$trno ;
            return new CActiveDataProvider(new CSqlDataProvider($query));                      
        }

        
    public  function SearchPosition($Search){
      for ($i=0;$i<=strlen($Search);$i++)
       {
          if (strspn(substr($Search, $i, 1),'1234567890' ))
            {
              return $i;
            }
       }
    }// end SearchPosition


  public function padj($PadString,$Len)
     {
       $Prefix =strtoupper(substr($PadString,0,$this->SearchPosition($PadString)));
       if ($Prefix=='')
         {
           $Prefix=$PadString;
         }
         $Number =floatval(substr($PadString,$this->SearchPosition($PadString),strlen($PadString)));
         if($Number==0)
           {
             $Number=1;
         }
         if ((strlen($Prefix)+strlen($Number))<$Len)
             {
                $Return =$Prefix .  str_pad($Number, $Len-(strlen($Prefix)), '0', STR_PAD_LEFT);
             }else{
                $Return = $PadString;
             }
         return $Return;
     } //PadJ

   public function GetPrefix($PadString)
     {
       $Prefix =strtoupper(substr($PadString,0,$this->SearchPosition($PadString)));
         return $Prefix;
     } //GetPrefix

   public function GetNumber($PadString){
         $Number =floatval(substr($PadString,$this->SearchPosition($PadString),strlen($PadString)));
         return $Number;
     } //GetNumber


public function right($value, $count){
    return substr($value, ($count*-1));
}

public function left($string, $count){
    return substr($string, 0, $count);
}


public function Getfloat($str) { 
  if(strstr($str, ",")) { 
    $str = str_replace(".", "", $str); // replace dots (thousand seps) with blancs 
    $str = str_replace(",", ".", $str); // replace ',' with '.' 
  } 
  
  if(preg_match("#([0-9\.]+)#", $str, $match)) { // search for number that may contain '.' 
    return floatval($match[0]); 
  } else { 
    return floatval($str); // take some last chances with floatval 
  } 
} 


 public function Discount($Amt,$Discount){
     if($Discount != ''){
        $Disc = explode('/',$Discount);
     }else{
        $Disc = 0;
     }//end if

     $DiscV='';
     
     for ($a=0;(count($Disc)-1)>=$a;$a++){
           $m=-1;
           $DiscV=$Disc[$a];
           if ($this->left($Disc[$a],1)=='+'){
               $DiscV=substr($Disc[$a],1);
               $m=1;
           }//end if

           if ($this->right($DiscV,1)=='%'){
               $AmountDisc = $Amt * floatval(($this->left($DiscV,strlen($DiscV)-1))/100);
           }else{
               $AmountDisc=$DiscV;
           }//end if
           
           $Amt = $Amt + ($AmountDisc * $m);
     }//emd each

    return $Amt;
}//end function discount

public function changeQuantity($quantity,$discount,$baseprice)
     {
     
     }


private function sqlData($filterParams) {
    //build the SQL query with :params
    $sql = "EXECUTE storedProcedure @Param1=:paramValue1, @Param2=:paramValue2";
     
    //set database connection and start the yii query builder to be executed.
    $connection = Yii::app()->db;
    $command = $connection->createCommand($sql);
 
    //Check to see if arguments have values and set the params in the $sql
    //query to the corrisponding arguments.
    if(array_key_exists('paramValue1Key', $filterParams)){
  $command->bindValue(":paramValue1", $filterParams['paramValue1Key ']);
 } else{
  $command->bindValue(":paramValue", Null);
 }
 
    if(array_key_exists('paramValue2Key', $filterParams)){
  $command->bindValue(":paramValue2", $filterParams['paramValue2Key ']);
    }else{
        $command->bindValue(":paramValue2", Null);
    }  
    $results = $command->queryAll();
    $sqlDataProvider = new CArrayDataProvider($results, array(
 'keyField'=>'wID',
 'pagination'=>false,
 )
    );
  
    //return the $dataProvider
    return $sqlDataProvider;
}



public function actionAjaxStoredProcedure() {
    //Declare an array to store the params that the user has set using a form
    $filterParams = Array();
 
    //Check to see if the value has been set by the user and store it into the array.
    if (isset($_POST['paramValue1 '])) {
        $filterParams['paramValue1Key '] = $_POST['paramValue1'];
    }
    if (isset($_POST['paramValue2'])) {
        $filterParams['paramValue2Key'] = $_POST['paramValue2 '];
    }
    //Call the method that generates the CArrayDataProvider by executing the stored procedure.
    $dataProvider = $this->sqlData($filterParams);
    //Return with the webpage that contains the data grid using the $dataProvider
    //generated earlier.
    return $this->renderPartial('_dataGrid', array(
        'dataProvider' => $dataProvider,
    ));
}
    

public function pagination($query, $per_page = 10,$page = 1, $url = '?'){        
    	$query = "SELECT COUNT(*) as `num` FROM ($query) as tbl";
    	//$row = mysql_fetch_array(mysql_query($query));
        $total = Yii::$app->sbccommon->datareader($query);
        $adjacents = "2"; 
    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	$pagedetail = "<li class='details'>Page $page of $lastpage</li>";
    	$pagination = "";
    	if($lastpage > 1)
    	{	
    		$pagination .= "<ul class='pagination'>";
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li><a class='current'>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    				
    				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>...</li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>..</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>..</li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='{$url}page=$next'>Next</a></li>";
                $pagination.= "<li><a href='{$url}page=$lastpage'>Last</a></li>";
    		}else{
    			$pagination.= "<li><a class='current'>Next</a></li>";
                $pagination.= "<li><a class='current'>Last</a></li>";
            }
    		$pagination.= "</ul>\n";		
    	}
    
    
        return $pagination;
    }
}
?>
