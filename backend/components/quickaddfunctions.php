<?php

namespace app\components;
 
use Yii;
use yii\base\Component;
use yii\db\Query;
use yii\Web\Session;
use yii\web\Request;
use yii\base\ErrorException;

use app\models\Common;
use app\models\Client;

class quickaddfunctions extends Component{
    public function generateQuickAddClientCode($typecode){
        $common=new Common();
        switch ($typecode) {
            case 'customer':
                $client = 'CL';
            break;

            case 'supplier':
                $client = 'SL';
            break;

            case 'warehouse':
                $client = 'WH';
            break;

            case 'agent':
                $client = 'AG';
            break;

            default:
                $client = 'DF';
            break;
        }//end functin

        $length=$common->clientlength();//RETURNS ZERO
        $pref=strtoupper($client); 
        $last_client = Client::getlast_client($pref);
        $start=$common->SearchPosition($last_client);
        $seq=substr($last_client, $start) + 1;
        $clseq=$client.$seq; 
        $new_client=$common->PadJ($clseq, $length); //HARDCODED
        return $new_client;
    }//end functin


    public function quickaddClient($clientdata){
    //CREATES NEWLY REGISTERED CUSTOMERS
        $customerinfo = new Client;
        $ccode = $this->generateQuickAddClientCode($clientdata['quickaddtype']);
        $clientexist = Client::checkclient($ccode);
        
        switch ($clientdata['quickaddtype']) {
            case 'customer':
                $customerinfo->IsCustomer = 1;
            break;
            
            case 'supplier':
                $customerinfo->IsSupplier = 1;
            break;

            case 'warehouse':
                $customerinfo->IsWarehouse = 1;
            break;

            case 'agent':
                $customerinfo->IsAgent = 1;
            break;
        }//end switch
        
        $customerinfo->client = $ccode;
        $customerinfo->IsExempt = 0;
        $customerinfo->charge1 = 0;
        $customerinfo->charge2 = 0;
        $customerinfo->isLocation = 0;
        $customerinfo->isVendor = 0;
        $customerinfo->isasset = 0;
        $customerinfo->clientname = $clientdata['quickname'];
        $customerinfo->addr = $clientdata['quickaddress'];
        $customerinfo->tel2 = $clientdata['quickmobile'];
        $customerinfo->email = $clientdata['quickemail'];
        $customerinfo->pword = '';
        $customerinfo->createby = Yii::$app->session['loggeduser']['username'];
        $customerinfo->center = Yii::$app->session['loggeduser']['center'];
        $customerinfo->category = 0;
        $customerinfo->distributionarea = 0;
        $customerinfo->collectionarea = 0;
        $customerinfo->routeid = 0;
        $customerinfo->sccityid = 0;
        $status = $customerinfo->insertclient($customerinfo);
        $searchid = Yii::$app->backend->requestClientid($ccode);
        return ['status'=>$status,'quickaddid'=>$searchid];
    }//END CREATE CUSTOMER
}//END COMPONENTS
?>

