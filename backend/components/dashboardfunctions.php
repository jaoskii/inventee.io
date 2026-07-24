<?php

namespace app\components;
 
use Yii;
use yii\base\Component;
use yii\db\Query;
use yii\web\sessions;


class dashboardfunctions extends Component
{
    public function getItemCategories(){
    $availablecategories = Yii::$app->sbccommon->OpenTable("select distinct category from item");
    return $availablecategories;
    }
}//END COMPONENTS
?>
