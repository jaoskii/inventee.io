<?php

namespace backend\modules\frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\ErrorException;

class DefaultController extends Controller{
//NOTES:
//Yii::$app->session['placeorderstatusmsg'] = 1; will show msg on dashboard landing page of the user

//FUNCTIONS FOR FRONTEND PAGE RENDERING######################################################################
    public $customershipto = "";
    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }//end action before action

    public function actionIndex(){
        
        //return $this->redirect(Url::to(['/']));
    }//end aciton index

    ######################## ACTIONS WITH RENDER
    public function actionSignin(){
        switch (Yii::$app->systemsettings->companyfrontendConfig()) {
            case 'HOTELDEMO':
                $this->layout = "@app/views/layouts/frontend/hoteldemo/contentpages3";
                return $this->render('hoteldemo/login');
                break;
            
            case 'BUYMORE':
                if(Yii::$app->frontend->verifyCustomerCredentials()){
                    return $this->redirect(Url::to(['/']));
                }else{
                    $this->layout = "@app/views/layouts/frontend/steamlayout/wholerow";
                    return $this->render('steamlayout/login');
                }//end function
                break;
        }//END SWITCH
    }//end action sign in

    public function actionProducts(){
        try {
            //this is for grouping lanes and category items
            if(!isset(Yii::$app->session['lanes'])){
                Yii::$app->session['lanes'] = Yii::$app->backend->retrieveLanes(1);
            }//end ssession

            $params = Yii::$app->backend->sanitize($_GET,'ARRAY');

                switch (strtoupper($params['type'])) {
                    case 'LANE':
                        $bannerheaderqry = "select headerpic from frontend_lanes where navid = ".$params['v']."";
                        $bannerheader = Yii::$app->sbccommon->datareader($bannerheaderqry);
                        $slider = Yii::$app->frontend->getLaneSliderPerLane($params['v']);
                        Yii::$app->view->params['breadcrumbs'] = Yii::$app->frontend->generateBreadcrumbs('LANE',$params);
                        $catdata = Yii::$app->frontend->ListAvailableProductsFor($params['v'],strtoupper($params['type']));
                        $this->layout = "@app/views/layouts/frontend/steamlayout/productlist";
                        return $this->render('steamlayout/products',array('productlisting'=>$catdata,'slider'=>$slider));
                        break;
                    
                    case 'CATEGORY':
                        $slider = Yii::$app->frontend->retrieveCategoryBanners($params['v']);
                        Yii::$app->view->params['breadcrumbs'] = Yii::$app->frontend->generateBreadcrumbs('CATEGORY',$params);
                        $catdata = Yii::$app->frontend->ListAvailableProductsFor($params['v'],strtoupper($params['type']));
                        $this->layout = "@app/views/layouts/frontend/steamlayout/productlist";
                        return $this->render('steamlayout/products',array('productlisting'=>$catdata,'slider'=>$slider));
                        break;

                    case 'BRAND':
                        try {
                        $slider = Yii::$app->frontend->retrieveBrandBanners($params['v']);
                        $catdata = Yii::$app->frontend->ListAvailableProductsFor($params['v'],strtoupper($params['type']));
                        $this->layout = "@app/views/layouts/frontend/steamlayout/productlist";
                        return $this->render('steamlayout/products',array('productlisting'=>$catdata,'slider'=>$slider));   
                        } catch (ErrorException $e) {
                            echo $e;
                        }
                        break;

                    case 'SEARCH':
                        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
                        $this->layout = "@app/views/layouts/frontend/steamlayout/searchinglist";
                        $productsdata = Yii::$app->frontend->generalSearch($params['q'],$params['lane']);
                        return $this->render('steamlayout/searchproducts',array('productlisting'=>$productsdata));                
                    break;

                    case 'HIGHLIGHT':
                    $this->layout = "@app/views/layouts/frontend/steamlayout/productlist";
                    $slider = Yii::$app->frontend->retrieveHighlightBanners($params['v']);
                    $catdata = Yii::$app->frontend->ListAvailableProductsFor($params['v'],strtoupper($params['type']));
                    return $this->render('steamlayout/products',array('productlisting'=>$catdata,'slider'=>$slider));

                    case 'DOD':
                    $this->layout = "@app/views/layouts/frontend/steamlayout/wholerow";
                    $slider = Yii::$app->frontend->retrieveDODBanner($params['v']);
                    $catdata = Yii::$app->frontend->ListAvailableProductsFor('',strtoupper($params['type']));
                    return $this->render('steamlayout/dealsfortoday',array('productlisting'=>$catdata,'slider'=>$slider));                    
                    break;

                }//END SWITCH CASE
        } catch (ErrorException $e) {
         echo $e;   
        }//end try catch
    }//end action product detail 

    public function actionProductdetail(){
        try {
            if(!isset($_GET['sku']) || $_GET['sku'] == ''){
                return $this->redirect(Url::to(['/frontend/error']));
            }else{
                switch (Yii::$app->systemsettings->companyfrontendConfig()) {
                    case 'SBC':
                        $barcode = Yii::$app->backend->sanitize($_GET['sku'],'DEFAULT');
                        $itemid = Yii::$app->backend->requestItemid($barcode);
                        $itemdetail = Yii::$app->frontend->retrieveItemFrontendDetails($itemid);

                        $this->layout = "@app/views/layouts/frontend/sbc/product_detail_layout";
                        return $this->render('sbc/product_detail',array('details'=>$itemdetail));
                    break;
                    
                    default:
                        if(!isset(Yii::$app->session['lanes'])){
                            Yii::$app->session['lanes'] = Yii::$app->backend->retrieveLanes(1);
                        }//end ssession

                        $barcode = Yii::$app->backend->sanitize($_GET['sku'],'DEFAULT');
                        $itemid = Yii::$app->backend->requestItemid($barcode);
                        $itemdetail = Yii::$app->frontend->retrieveItemFrontendDetails($itemid);

                        if(!empty($itemdetail)){
                            if(Yii::$app->frontend->checkIfStockisAvailable($itemid)){
                                $instock = "In stock";
                            }else{
                                $instock = "Out of stock";
                            }//end function
                            $itemdetail[0]['instock'] = $instock;
                            $params = array('itemid'=>$itemid);
                            Yii::$app->view->params['breadcrumbs'] = Yii::$app->frontend->generateBreadcrumbs('ITEM',$params);

                            $this->layout = "@app/views/layouts/frontend/steamlayout/productdetail";
                            Yii::$app->frontend->addItemViewingCount($barcode);
                            Yii::$app->frontend->recordFrontendLogs('VIEW_ITM_DETAIL',$_GET['sku']);
                            return $this->render('steamlayout/product_detail',array('details'=>$itemdetail));
                        }else{
                            return $this->redirect(Url::to(['/frontend/error']));
                        }//end if
                    break;
                }//END SWITCH
            }//end if isset
        } catch (ErrorException $e) {
            
        }//end try catch
    }//end action product detail

    public function actionMycart(){
        $this->layout = "@app/views/layouts/frontend/steamlayout/wholerow";
        return $this->render('steamlayout/mycart');
    }//end function action my cart

    public function actionCustomerdashboard(){
    try {
        if(!Yii::$app->frontend->verifyCustomerCredentials()){
            return $this->redirect(Url::to(['/frontend/signin']));
        }else{
            if(isset($_GET['q'])){
            $parameter = strtoupper(Yii::$app->backend->sanitize($_GET['q'],'DEFAULT'));
                switch ($parameter) {
                    case 'UNFINISHED':
                        $myorder = Yii::$app->frontend->retrieveUnfinishedOrders();
                        if(!empty($myorder)){
                            $orderdetail = Yii::$app->frontend->retrieveOrderDetails($myorder[0]['trno']);
                        }else{
                            $orderdetail = array();
                        }//end if
                        $this->layout = "@app/views/layouts/frontend/steamlayout/wholerow";
                        return $this->render('steamlayout/unfinishedorders',array('orderhistory'=>$myorder,'orderdetail'=>$orderdetail));
                    break;


                    case 'ORDERHISTORY':
                        $myorder = Yii::$app->frontend->retrieveOrderHistory();
                        if(!empty($myorder)){
                            if(isset($_GET['ord'])){
                                $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
                                $ord = $params['ord'];
                                $orderdetail = Yii::$app->frontend->retrieveOrderDetails($ord);
                                $pendingitems = Yii::$app->frontend->checkForPendingOrderItem($ord);
                            }else{
                                $orderdetail = Yii::$app->frontend->retrieveOrderDetails($myorder[0]['trno']);
                                $pendingitems = Yii::$app->frontend->checkForPendingOrderItem($myorder[0]['trno']);
                            }//end if

                            if(!empty($pendingitems)){
                                $openstatus = true;
                            }else{
                                $openstatus = false;
                            }//end if empty pending
                            
                            $orderdetail[0]['status'] = $openstatus;
                        }else{
                            $orderdetail = array();
                        }//end if

                        $this->layout = "@app/views/layouts/frontend/steamlayout/wholerow";
                        return $this->render('steamlayout/orderhistory',array('orderhistory'=>$myorder,'orderdetail'=>$orderdetail));
                    break;
                    
                    case 'ADDRESSBOOK':

                    break;

                    case 'ACCOUNTINFO':
                        $this->layout = "@app/views/layouts/frontend/steamlayout/dashboardlayout";
                        $lanes = Yii::$app->backend->retrieveLanes(1);
                        return $this->render('steamlayout/accountinformation',array('lanes'=>$lanes));
                    break;

                    case 'PCHANGE':
                        $this->layout = "@app/views/layouts/frontend/steamlayout/dashboardlayout";
                        return $this->render('steamlayout/changepassword');
                    break;

                    case 'REVIEWS':

                    break;

                    case 'WISHLIST':
                        $this->layout = "@app/views/layouts/frontend/steamlayout/dashboardlayout";
                        return $this->render('steamlayout/customerwishlist');
                    break;
                }//END SWITCH CASE

            }else{
                if(isset(Yii::$app->session['placeorderstatusmsg'])){
                    unset(Yii::$app->session['placeorderstatusmsg']);
                    $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
                      
                    //THIS MESSSAGE IN FOR PLACING ORDER STATUS (CANCELLED PAYMENT OR SUCCESSFULY PLACEMENT)
                    if(isset($params['p'])){
                        $params['p'] = strtoupper($params['p']);
                        switch ($params['p']) {
                            case 'CANCELLED':
                                $msg = '<div class="alert alert-danger fade in" style="margin-top:18px;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                <strong>'.$params['ref'].' payment has been cancelled. Order will be added to your list of pending orders!</strong>
                                </div>';
                                break;
                            
                            default:
                                $msg = '<div class="alert alert-success fade in" style="margin-top:18px;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                <strong>'.$params['ref'].' has been placed Successfull!</strong>
                                </div>';
                                break;
                        }//END SWITCH CASE
                    }//END IF
                }else{
                    $params = '';
                    $msg = '';
                }///end if


                $recentorders = Yii::$app->frontend->retrieveTopRecentOrders(Yii::$app->session['customerdata']['clientcode']);
                $this->layout = "@app/views/layouts/frontend/steamlayout/dashboardlayout";
                return $this->render('steamlayout/customerdashboard',array('recentorders'=>$recentorders,'params'=>$params,'msg'=>$msg));
            }//end if q
        }//end if customer creds
    } catch (ErrorException $e) {
        echo $e;   
    }
    }//end function action my cart

    public function actionContact(){   
        $this->layout = "@app/views/layouts/frontend/steamlayout/others";
        return $this->render('steamlayout/contact_us');
    }//end action contact us

    public function actionSiteinfo(){   
        try {
        $field = Yii::$app->backend->sanitize($_GET['q'],'DEFAULT');
        $this->layout = "@app/views/layouts/frontend/steamlayout/others";
        
        $qry = "select ".$field." from fsitedetails";
        $data = Yii::$app->sbccommon->datareader($qry);

        switch ($field) {
            case 'aboutus':
                $title = 'About Us';
            break;

            case 'helpcenter':
                $title = 'Help Center';
            break;

            case 'other1':
                $title = 'Order and Payment';
            break;

            case 'other2':
                $title = 'Shopping and Delivery';
            break;

            case 'other3':
                $title = 'Return and Refund';
            break;

            case 'other4':
                $title = 'Terms and Conditions';
            break;

            case 'other5':
                $title = 'Return Policy';
            break;

            case 'other6':
                $title = 'Privacy and Order Policy';
            break;

            case 'other7':
                $title = 'Payment Methods';
            break;

            case 'other8':
                $title = 'How to Buy';
            break;

            case 'other9':
                $title = 'How to Return';
            break;

            case 'other10':
                $title = 'Contact Us';
            break;
        }//end switch

        return $this->render('steamlayout/sitedetail',['data'=>$data,'title'=>$title]);
        
            
        } catch (ErrorException $e) {
            echo $e;
        }
    }//end action contact us

    public function actionCheckout(){
    try {
        if(!Yii::$app->frontend->verifyCustomerCredentials()){
            return $this->redirect(Url::to(['/frontend/signin']));
        }else{
            if(!Yii::$app->frontend->isAllowedCheckoutperStep($_GET['step'])){
                return $this->redirect(Url::to(['/frontend/error']));
            }else{
                $step = Yii::$app->backend->sanitize($_GET['step'],'DEFAULT');
                switch ($step) {
                    case 'unfcontinue':
                        Yii::$app->frontend->transferPendingtoCart($_POST['ordercode']);
                        $this->redirect(Url::to(['/frontend/checkout','step'=>'1']));
                    break;

                    case '1':
                        $this->layout = "@app/views/layouts/frontend/steamlayout/wholerow";
                        $cartcount = Yii::$app->frontend->countCart();
                        $cart_total = Yii::$app->frontend->computeCart();
                        $addressbook = Yii::$app->frontend->generateAddressBook(Yii::$app->session['customerdata']['clid']);
                        return $this->render('steamlayout/setdeliveryinfo',array('gtotalqty'=>$cartcount,'gtotalamt'=>$cart_total,'addressbook'=>$addressbook));
                    break;

                    case '2':
                        if(isset($_POST) && !empty($_POST)){
                            $this->layout = "@app/views/layouts/frontend/steamlayout/wholerow";
                            $cartcount = Yii::$app->frontend->countCart();
                            $cart_total = Yii::$app->frontend->computeCart();
                            $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
                            $addbookdetail = Yii::$app->frontend->retrieveAddressdetail($params['addbook'],$params);
                            Yii::$app->session['customershiptosave'] = $addbookdetail[0]['name'].'\n'.$addbookdetail[0]['address'].'\n'.$addbookdetail[0]['contact'];
                            Yii::$app->session['customershipto'] = $addbookdetail[0]['name'].'<br>'.$addbookdetail[0]['address'].'<br>'.$addbookdetail[0]['contact'];
                            return $this->render('steamlayout/setpaymentmethod',array('gtotalqty'=>$cartcount,'gtotalamt'=>$cart_total,'addbookdetail'=>$addbookdetail));
                        }else{
                            return $this->redirect(Url::to(['/']));    
                        }//end if
                    break;

                    case '3':
                        $params = array('shipto'=>Yii::$app->session['customershiptosave']);
                        //$ongoingcheckout = Yii::$app->session['ongoingcheckout'];
                        //$ongoingcheckout['ptype'] = $_POST['paymentmethod'];
                        //Yii::$app->session['ongoingcheckout'] = $ongoingcheckout;
                        $cart = Yii::$app->session['cart'];
                        Yii::$app->frontend->placeOrder($params);
                        Yii::$app->session['cartcatcher'] = $cart;
                        Yii::$app->session['needtoless'] = $cart;
                        unset(Yii::$app->session['cart']);
                        $ongoingcheckout = Yii::$app->session['ongoingcheckout'];
                        $ongoingcheckout['ptype'] = $_POST['paymentmethod'];
                        Yii::$app->session['ongoingcheckout'] = $ongoingcheckout;
                        $this->layout = "@app/views/layouts/frontend/steamlayout/wholerow";
                        return $this->render('steamlayout/finalizeorder',array('cart'=>$cart,'params'=>$params,'docreference'=>Yii::$app->session['ongoingcheckout']));
                    break;

                    case '4':
                        $this->layout = "@app/views/layouts/frontend/steamlayout/wholerow";
                        $p="success";
                        //THIS UPDATES REFERENCES FOR PAYMENT EITHER COD OR ONLINE
                        //BETA : UPDATES YOURREF OF SOHEAD
                        switch (Yii::$app->session['ongoingcheckout']['ptype']) {
                            case 'COD':
                                $ref = Yii::$app->session['ongoingcheckout']['docno'];
                            break;

                            case 'ONLINE':
                                $ref = Yii::$app->backend->sanitize($_GET['Ref'],'DEFAULT');
                            break;
                        }//end switch case

                        $qry = "update sohead as head set head.ourref = '".Yii::$app->session['ongoingcheckout']['ptype']."' where trno = ".Yii::$app->session['ongoingcheckout']['trno']."";
                        $qryfinish = "update transnum set fppayment = 1 where trno = ".Yii::$app->session['ongoingcheckout']['trno']."";
                        
                        //SETS EMAIL FOR ORDER INFORMATION
                        $sendto = Yii::$app->session['customerdata']['email'];
                        $subject = 'ORDER INFORMATION';
                        $mailtype = 'ECOMMORDERS';
                        $cart = Yii::$app->session['cartcatcher'];
                        unset(Yii::$app->session['cartcatcher']);
                        Yii::$app->session['mailstatus'] = Yii::$app->frontend->sendMail($sendto,$subject,$cart,$mailtype);    
                        
                        //UPDATES SO HEAD
                        Yii::$app->sbccommon->execqry($qry);
                        //UPDATES TRANSNUM FPAYMENT TAGGING (TAGGING FOR SUCCESSFULL PAYMENT)
                        Yii::$app->sbccommon->execqry($qryfinish);
                        
                        $trno = Yii::$app->session['ongoingcheckout']['trno'];
                        unset(Yii::$app->session['ongoingcheckout']);
                        Yii::$app->session['placeorderstatusmsg'] = 1;
                        $searchingbarcode = '';
                        foreach (Yii::$app->session['needtoless'] as $key => $value) {
                            //Yii::$app->frontend->recordFrontendLogs('PLACE_ORDER',$key);
                            if($searchingbarcode == ''){
                                $searchingbarcode = '"'.$key.'"';
                            }else{
                                $searchingbarcode = $searchingbarcode .  ',' . '"' . $key . '"';
                            }//end if
                        }//end for each
                        unset(Yii::$app->session['needtoless']);
                        $qryselectitems = "select itemid,fqty from item where barcode in (".$searchingbarcode.")";
                        $itemstoupdate = Yii::$app->sbccommon->opentable($qryselectitems);
                        
                        foreach ($itemstoupdate as $itemstoupdatekey => $itemstoupdatevalue) {
                            $fqty = floatval($itemstoupdatevalue['fqty']) - 1;
                            $qryupdate = "update item set fqty = '".$fqty."' where itemid = ".$itemstoupdatevalue['itemid']."";
                            Yii::$app->sbccommon->execqry($qryupdate);
                        }//end if

                        Yii::$app->frontend->postCheckedOutComplete($trno);
                        return $this->redirect(Url::to(['/frontend/customerdashboard/','ref'=>$ref,'p'=>$p]));                        
                    break;

                    case 'olcancelled':
                        unset(Yii::$app->session['needtoless']);
                        $ref = Yii::$app->backend->sanitize($_GET['Ref'],'DEFAULT');
                        $this->layout = "@app/views/layouts/frontend/steamlayout/wholerow";
                        $p = 'cancelled';
                        unset(Yii::$app->session['ongoingcheckout']);
                        Yii::$app->frontend->recordFrontendLogs('CANCEL_PAYMENT',$barcode);
                        Yii::$app->session['placeorderstatusmsg'] = 1;
                        return $this->redirect(Url::to(['/frontend/customerdashboard/','ref'=>$ref,'p'=>$p]));
                    break;
                    
                    default:
                        return $this->redirect(Url::to(['/']));
                    break;
                }//end switch case
            }//end if
        }//end if isset or empty cart
    } catch (ErrorException $e) {
        echo $e;
    }//end try catch
    }//end function

    public function actionFlogout(){
        if(!Yii::$app->frontend->verifyCustomerCredentials()){
            return $this->redirect(Url::to(['/']));
        }else{
             Yii::$app->frontend->clearClientSession();
             return $this->redirect(Url::to(['/']));
        }
    }

    public function actionError(){
        $this->layout = "@app/views/layouts/frontend/steamlayout/wholerow";
        return $this->render('steamlayout/error');
    }//end function


    public function actionHighlights(){
        $this->layout = "@app/views/layouts/frontend/steamlayout/wholerow";
        $featured = Yii::$app->frontend->retrieveHighlights('featured');
        $highlights = Yii::$app->frontend->retrieveHighlights();
        return $this->render('steamlayout/highlights',array('featured'=>$featured,'highlights'=>$highlights));
    }//end function
    ######################## END ACTIONS WITH RENDER


    ####################### AJAX ACTIONS
    public function actionManagecart(){
        try {
        Yii::$app->backend->AjaxVerification($this);
        //ACCESSING GET REQUEST VALUE
        $itmtotal = 0;
        $barcode = $_GET['barcode'];
        $qty = $_GET['qty'];
        $triggerhappy = $_GET['tri'];
        
        if(isset($_GET['type'])){
            $type = $_GET['type'];
            $grpid = $_GET['md5id'];
        }else{
            $type = '';
            $grpid = '';
        }//end if
        

        switch ($triggerhappy) {
            case '1':
                Yii::$app->frontend->cart($barcode,$qty,$triggerhappy,$type,$grpid);
                $cartcount = Yii::$app->frontend->countCart();
                $cart_total = Yii::$app->frontend->computeCart();
                //ENCDING TO JSON TO ENABLE JQUERY TO READ PARSED DATA
                Yii::$app->frontend->recordFrontendLogs('ADD_TO_CART',$barcode);
                echo json_encode(array("cartcount" => $cartcount, "carttotal" => $cart_total , "itmtotal" => $itmtotal));
                break;
            
            case '2':
                $return = Yii::$app->frontend->cart($barcode,$qty,$triggerhappy,$type,$grpid);
                $itmtotal = Yii::$app->session['cart'][$_GET['barcode'].'_'.$return['type']]['totprice'];        
                $cartcount = Yii::$app->frontend->countCart();
                $cart_total = Yii::$app->frontend->computeCart();
                //ENCDING TO JSON TO ENABLE JQUERY TO READ PARSED DATA
                echo json_encode(array("cartcount" => $cartcount, "carttotal" => $cart_total ,
                "itmtotal" => $itmtotal,'utotprice'=>$return['utotprice'],'uqty'=>$return['uqty']));
                break;
        }//end switch case

        } catch (ErrorException $e) {
            echo $e;
        }
    }//end action manage cart

    public function actionVerifycustomersignin(){
        Yii::$app->backend->AjaxVerification($this);
        try{
            $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
            $return = Yii::$app->frontend->verifyCustomerSignin($params);
            echo json_encode(array('status'=>$return['status'],'msg'=>$return['msg']));
        } catch (ErrorException $e) {
            echo $e;
        }//end try catch
    }//end action verifycustomer signin

    public function actionCregistration(){
        Yii::$app->backend->AjaxVerification($this);
        try {
            $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
            $qry = "select email from client where iscustomer = 1 and registeredfrom ='DEFAULT'";
            $emails = Yii::$app->sbccommon->opentable($qry);
            
            if(!empty($emails)){
                $return['status'] = false;
            }else{
                $return = Yii::$app->frontend->createCustomer($params);  
            }   //end if       
        }catch(ErrorException $e) {
            echo $e;
        }
    }//end function action c registration

    public function actionResetcart(){
        Yii::$app->backend->AjaxVerification($this);
        Yii::$app->frontend->resetCart();    
        $clrmsg = '<tr><td colspan="6" align="center" >There is no item on your cart, <a href="'.Url::to(['/']).'"> Shop now</a></td></tr>';
        
        echo json_encode(array("clrmsg" => $clrmsg));
    }

    
    public function actionRemovecartitem(){
        Yii::$app->backend->AjaxVerification($this);
        $barcode = $_GET['barcode'];
        Yii::$app->frontend->removeCartitem($barcode);
        $cartcount = Yii::$app->frontend->countCart();
        $cart_total = Yii::$app->frontend->computeCart();
        echo json_encode(array("cart" => Yii::$app->session['cart'],"cartcount" => $cartcount,'gtotalcart'=>$cart_total));
    }

    public function actionRefreshcart(){
        Yii::$app->backend->AjaxVerification($this);
        if(isset(Yii::$app->session['cart'])){
            $cartcount = Yii::$app->frontend->countCart();
            $cart_total = Yii::$app->frontend->computeCart();
            echo json_encode(array("cart" => Yii::$app->session['cart'],"cartcount" => $cartcount,'gtotalcart'=>$cart_total));   
        }else{
            echo json_encode(array("cart" => '',"cartcount" => 0,'gtotalcart'=>0.00));       
        }//end if
    }//end refresh cart

    public function actionUpdatecustomerinfo(){
        try {
            Yii::$app->backend->AjaxVerification($this);
            $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
            $status = Yii::$app->frontend->UpdateCustomerInfo($params);
            if($status){
                $msg = "Updating profile successfull!";
            }else{
                $msg = "Updating profile failed!";
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg));
        } catch (ErrorException $e) {
            echo $e;
        }//end try
    }//end action updatecustomerinfo

    public function actionRetrieveorderdetail(){
        try {
            Yii::$app->backend->AjaxVerification($this);
            $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
            $details = Yii::$app->frontend->retrieveOrderDetails($params['q']);
            $pendingitems = Yii::$app->frontend->checkForPendingOrderItem($params['q']);

            if(!empty($pendingitems)){
                $openstatus = true;
            }else{
                $openstatus = false;
            }//end if empty pending

            echo json_encode(array('details'=>$details,'openstatus'=>$openstatus));
        } catch (ErrorException $e) {
            echo $e;
        }//end try
    }//end action retrieve order detail
    ###################### END AJAX ACTIONS

    public function actionChangepassword(){
        $params = $_POST;
        if(md5($params['pchangeold']) != Yii::$app->session['customerdata']['customerpword']){
            $status = false;
            Yii::$app->session['pchangemsg'] = '<div class="alert alert-danger fade in" style="margin-top:18px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <strong>Password doesn`t match. Please try again.</strong>
            </div>';
        }else{
            if(md5($params['pchangenew']) != md5($params['pchangeconfirm'])){
                $status = false;
                Yii::$app->session['pchangemsg'] = '<div class="alert alert-danger fade in" style="margin-top:18px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                <strong>New passwords doesn`t match. Please check your passwords.</strong>
                </div>';
            }else{
                $qrychange = 'update client set pword = "'.$params['pchangenew'].'" where clientid = '.Yii::$app->session['customerdata']['clid'];
                $status = Yii::$app->sbccommon->execqry($qrychange);
                if(!$status){
                    $status = false;
                    Yii::$app->session['pchangemsg'] = '<div class="alert alert-danger fade in" style="margin-top:18px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>An error occured while updating your password. Please try again.</strong>
                    </div>';
                }else{
                    $status = true;
                    $customerdata = Yii::$app->session['customerdata'];
                    $customerdata['customerpword'] = $params['pchangenew'];
                    Yii::$app->session['customerdata'] = $customerdata;
                    Yii::$app->session['pchangemsg'] = '<div class="alert alert-success fade in" style="margin-top:18px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>Changing password Successfull!</strong>
                    </div>';
                }//end if
            }//end if
        }//end if
        return $this->redirect(Url::to(['/frontend/customerdashboard/','q'=>'pchange']));
    }//end account change

    public function actionDatafeed(){
        //THIS IS THE DATA FEED PAGE
        //FOR THE MEANTIME THIS PAGE COULD BE ACCESSED ON PUBLIC THROUGH
        //http://eshop.solutionbasecorp.com/frontend/datafeed/
        //i had set this link as successURL and failURL on CLIENT POST method
        echo 'OK';
        $isfailed = true;
        $isfailed = $_REQUEST['successcode']; //=> sucesscode if the payment is success or not
        $payref = $_REQUEST['PayRef']; //=>payment reference given by pesopay
        $ref = $_REQUEST['Ref']; //=> reference code from the merchant (our reference SO#)
        $ord = $_REQUEST['Ord']; //=> bank reference #
        $amt = $_REQUEST['Amt']; //=> amt from pesopay
        $hamt  = $_REQUEST['accountHash']; //=>hash key amt from pesopay
        $sourceip = $_REQUEST['sourceIp']; //IP Address of payer
        $paymethod = $_REQUEST['payMethod']; //Payment method used by payer
        $transtime = $_REQUEST['TxTime']; //Transaction time of the payment

        if(!$isfailed){
            $params = ['docno'=>$ref,'payref'=>$payref,'ord'=>$ord,'sourceip'=>$sourceip,'paymethod'=>$paymethod,'transtime'=>$transtime];
            //HAVE SOME FUNCTION HERE WHERE TO STORE PAYMENT DETAILS
            //NOTE: MAKE A FUNCTION FOR IT. updateOnlinePaymentCredentials();
            Yii::$app->backend->updateOnlinePaymentCredentials($params);    
        }//end is successcode = true
        
    }//end action datafeed


    public function actionCountdownsample(){
        try {
        $this->layout = "@app/views/layouts/frontend/steamlayout/wholerow";
        $returndata = Yii::$app->frontend->getAvailableFlashDeal();
        $flashitems = Yii::$app->frontend->ListAvailableProductsFor($returndata['flashid'],strtoupper('FLASHDEAL'));
        return $this->render('steamlayout/countdown',array('flashitems'=>$flashitems));
        } catch (ErrorException $e) {
            echo $e;
        }
    }//end action count down 

    public function actionRetrieveflashdeal(){
        $return = Yii::$app->frontend->getAvailableFlashDeal();
        echo json_encode(array('flashavail'=>$return['flashavailable'],'flashend'=>$return['flashend']));
    }//end if













   

    
 

//FUNCTIONS FOR FRONTEND PROCESSES###########################################################################
    public function actionSendconcern(){
        $errors = 0;
        $finalstatus = 0;
        $mailtype = 'RECEIVE_CONCERN';
        $receivingemail = Yii::$app->systemsettings->requestDefaultReceivingEmail();
        $subject = $_POST['subject'];
        $params = array('name'=>$_POST['name'],'email'=>$_POST['email'],'msg'=>$_POST['message'],'subject'=>$subject);
        $receivestatus = Yii::$app->frontend->sendMail($receivingemail,$subject,$params,$mailtype);

        if($receivestatus){
            $mailtype = 'SEND_CONCERN_CONFIRM';
            $finalstatus = Yii::$app->frontend->sendMail($params['email'],'RE: '.$subject,'',$mailtype);
            if($finalstatus){
            $msg = "Sending Succeed , Thank you very much!";
            }else{
            $msg = "Error sending email, please check your internet connection and try again.";
            $errors = 1;
            }//end if final status
        }else{
            $msg = "Error sending email, please check your internet connection and try again.";
            $errors = 1;
        }//end if

        if(Yii::$app->systemsettings->setfrontendOnly()){
            return $this->redirect(Url::to(['/','q'=>'success']));
        }else{
            echo json_encode(array('errors'=>$errors,'msg'=>$msg));
        }//end if
    }//end send concern


    public function actionGetorderlist(){
        Yii::$app->backend->AjaxVerification($this);
        $params['search'] = $_GET['q'];
        $myorder = Yii::$app->frontend->retrieveOrderHistory($params);
        echo json_encode(['myorders'=>$myorder]);
    }//end action



    
    ############## HOTEL EXCLUSIVE ACTIONS ####################
    public function actionRoomdetails(){
        $this->layout = "@app/views/layouts/frontend/hoteldemo/roomdetail";
        $roomid = $_GET['q'];
        $roomdetails = Yii::$app->frontend->getRoomdetails($roomid);
        Yii::$app->view->params['keyid'] = $roomid;
        return $this->render('hoteldemo/roomdetail',['roomdetails'=>$roomdetails]);
    }//end function

    public function actionRoomtypes(){
        $this->layout = "@app/views/layouts/frontend/hoteldemo/contentpages";
        $roomtypes = Yii::$app->frontend->getActiveRoomTypes();
        return $this->render('hoteldemo/roomtypes',['roomtypes'=>$roomtypes]);
    }//end function

    public function actionBooking(){
        $this->layout = "@app/views/layouts/frontend/hoteldemo/bookinglayout";
        return $this->render('hoteldemo/booking');
    }//end function


    public function actionSearchavailablerooms(){
        $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
        $startdate = $params['searchstart'];
        $enddate = $params['searchend'];
        $numadults = $params['adults'];
        $numchildren = $params['children'];
        $qty = $params['numrooms'];
        $rooms = Yii::$app->frontend->getRoomAvailabilities($startdate,$enddate,$qty,$numadults);
        
        Yii::$app->view->params['featroomtypes'] = Yii::$app->frontend->getFeaturedRoomtypes();
        $this->layout = "@app/views/layouts/frontend/hoteldemo/contentpages2";
        return $this->render('hoteldemo/bookingresults',['rooms'=>$rooms,'startdate'=>$startdate,'enddate'=>$enddate]);
    }//end function

    public function actionBookingsetup(){
        $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
        $keyid = $params['keyid'];
        $roomname = '';
        $startdate = $params['checkin'];
        $enddate = $params['checkout'];
        $numadults = $params['adults'];
        $numchildren = $params['children'];
        $qty = $params['numrooms'];
        $roomdetails = Yii::$app->frontend->getRoomdetails($keyid);
        if(!empty($roomdetails)){
            $roomname = $roomdetails[0]['roomtype'];
        }//end if
        Yii::$app->view->params['keyid'] = $keyid;
        Yii::$app->view->params['startdate'] = $startdate;
        Yii::$app->view->params['enddate'] = $enddate;
        Yii::$app->view->params['roomqty'] = $qty;
        Yii::$app->view->params['adults'] = $qty;
        Yii::$app->view->params['children'] = $numchildren;
        $roomsdetails = Yii::$app->frontend->getRoomDetailedAvailability($keyid,$startdate,$enddate,$qty,$numadults);
        $this->layout = "@app/views/layouts/frontend/hoteldemo/contentpages3";
        return $this->render('hoteldemo/bookingsetup',['roomname'=>$roomname,'roomsdetails'=>$roomsdetails,'startdate'=>$startdate,'enddate'=>$enddate]);
    }//end aciton
}//end frontend controller
