<?php 
echo '18064485|1280204670187|608|3000.0|N|Z8AweiAuT2UwfGighKNTxsxDhMnSmqge';
echo '</br>';
echo $hashtag = sha1('18064485|1280204670190|608|3000.0|N|Z8AweiAuT2UwfGighKNTxsxDhMnSmqge');?>

<!-- <form name="payForm" method="post" action="https://test.pesopay.com/b2cDemo/eng/dPayment/payComp.jsp">
<input type="hidden" name="merchantId" value="18064485"> 
<input type="hidden" name="amount" value="3000.0">
<input type="hidden" name="orderRef" value="1280204670187"> 
<input type="hidden" name="currCode" value="608"> 
<input type="hidden" name="pMethod" value="VISA"> 
<input type="hidden" name="cardNo" value="4918914107195005"> 
<input type="hidden" name="securityCode" value="123"> 
<input type="hidden" name="cardHolder" value="Testing"> 
<input type="hidden" name="epMonth" value="09"> 
<input type="hidden" name="epYear" value="2016"> 
<input type="hidden" name="payType" value="N"> 
<input type="hidden" name="successUrl" value="http://www.yourwebsite.com/pSuccess.jsp"> 
<input type="hidden" name="failUrl" value="http://www.yourwebsite.com/pFail.jsp"> 
<input type="hidden" name="errorUrl" value="http://www.yourwebsite.com/pError.jsp"> 
<input type="hidden" name="lang" value="E"> 
<input type="hidden" name="secureHash" value="Z8AweiAuT2UwfGighKNTxsxDhMnSmqge"> 
<input type="submit" value="Pay Now"> 
</form>
 -->

<!-- PRODUCTION URL [WILL BE USED FOR PRODUCTION] -->
<!-- https://www.pesopay.com/b2c2/eng/payment/payForm.jsp -->

<!-- DEMO URL [WILL BE USED FOR TESTING AND DEMO PURPOSES] -->
<!-- https://test.pesopay.com/b2cDemo/eng/payment/payForm.jsp -->

<form name="payFormCcard" method="post" action=" https://test.pesopay.com/b2cDemo/eng/payment/payForm.jsp"> 
<input type="hidden" name="merchantId" value="18064485">  
<input type="hidden" name="amount" value="3000.0" >
<input type="hidden" name="orderRef" value="1280204670190"> 
<input type="hidden" name="currCode" value="608" > 
<input type="hidden" name="mpsMode" value="NIL" > 
<input type="hidden" name="successUrl" value="http://localhost/ultimatesource/frontend/samplesuccess"> 
<input type="hidden" name="failUrl" value="http://www.yourdomain.com/Fail.html"> 
<input type="hidden" name="cancelUrl" value="http://www.yourdomain.com/Cancel.html"> 
<input type="hidden" name="payType" value="N"> 
<input type="hidden" name="lang" value="E"> 
<input type="hidden" name="payMethod" value="CC"> 
<input type="hidden" name="secureHash" value="<?php echo $hashtag; ?>">	
<button type = "submit">PAY</button>
</form> 