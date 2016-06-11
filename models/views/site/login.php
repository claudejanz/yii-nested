<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\forms\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <?php 

    
    $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-md-3 col-lg-2 animated fadeInUp\">{input}</div>\n<div class=\"col-md-6 col-lg-2 col-lg-offset-5 animated fadeInDown\">{error}</div>",
            'labelOptions' => ['class' => 'col-md-3  col-lg-2 col-lg-offset-3 control-label animated fadeInUp'],
        ],
    ]); 

    echo $this->render('_login',['login'=>$login,'form'=>$form]);

    ?>

    <div class="form-group animated flipInX">
            <div class="col-md-offset-3 col-md-9 col-lg-2 col-lg-offset-5">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
