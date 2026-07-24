  <img style="margin-top:-8px;width:300px;margin-left:50px;" alt="SBCommerce" src="http://buymore.com.ph/frontendassets/steamlayout/header-logo.png">
  
  <h5>We have received your orders. Kindly wait for our feedback</h5>
  <h5>Thank you very much! Have a nice day!</h5>
  <h5>These are the items you have orders</h5>
    <table class="table" border="1">
        <thead>
          <tr>
            <th>Item Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $totalamt = 0;
        foreach (Yii::$app->params['data'] as $barcode => $iteminfo) {
          $toti = $iteminfo['totprice'];
          $price = str_replace(',', '', $iteminfo['price']);
          $totprice = str_replace(',', '', $iteminfo['totprice']);
          echo '<tr>
            <td>'.$iteminfo['itemname'].'</td>
            <td>'.number_format($price,Yii::$app->systemsettings->setDecimaldisplay('fcurrency'),'.',',').'</td>
            <td>'.number_format($iteminfo['qty']).'</td>
            <td>'.number_format($totprice,Yii::$app->systemsettings->setDecimaldisplay('fcurrency'),'.',',').'</td>
          </tr>';
        $totalamt = $totalamt + $toti;
        }
        ?>
        </tbody>
    </table>
    <h5>Grand total: <?php echo number_format($totalamt,Yii::$app->systemsettings->setDecimaldisplay('fcurrency'),'.',','); ?></h5>
    <h5>If you have any questions / reactions regarding your order , please don't hesitate to contact us.</h5>
    <h5>Below are our are contacts where you could reach us:</h5>

    <h5>support@buymore.com.ph</h5>
    <h5>Telephone #: 413-3414 loc. 214</h5>

