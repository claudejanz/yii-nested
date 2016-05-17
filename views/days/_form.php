<?php

use app\models\Day;
use claudejanz\toolbox\widgets\ajax\AjaxSubmit;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

/**
 * @var View $this
 * @var Day $model
 * @var ActiveForm2 $form
 */
?>

<div class="day-form">

    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);
    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

//            'published' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Publication...']],
//            'week_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Week ID...']],
            'training_city' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Training City...', 'maxlength' => 1024]],
//            'sportif_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Sportif ID...']],
           'time'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options' => [
            'type' => DateControl::FORMAT_TIME,
            'options' => [
                'pluginOptions' => [
                    'defaultTime' => false
                ]
            ]
        ]],
             'comment' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Extra Comment...', 'rows' => 6]],
            
//            'created_by' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Created By...']],
//            'updated_by' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Updated By...']],
//            'created_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(), 'options' => ['type' => DateControl::FORMAT_DATETIME]],
//            'updated_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(), 'options' => ['type' => DateControl::FORMAT_DATETIME]],
        ]
    ]);

    if (Yii::$app->request->isAjax) {
        echo AjaxSubmit::widget(['label' => $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            'options' => [
                'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
        ]]);
    } else {
        echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    }
    ActiveForm::end();
    $this->registerJs('$("form input:text, form textarea").first().select();');
    ?>

</div>
