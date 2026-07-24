<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
                <?php $form = ActiveForm::begin(['id' => 'login-form'],['class' => 'form-signin']); ?>
                
                <?= $form->field($model, 'username') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <label style="color:red;"><?php echo $errmsg; ?></label>
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-lg btn-default btn-block', 'name' => 'login-button']) ?>

<?php ActiveForm::end(); ?>

