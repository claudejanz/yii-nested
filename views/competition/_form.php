<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var app\models\Competition $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="competition-form">

    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);
    echo Form::widget([
        'model'      => $model,
        'form'       => $form,
        'columns'    => 1,
        'attributes' => [
            'title' => [
                'type'    => Form::INPUT_TEXT,
                'options' => ['placeholder' => 'Enter Titre...', 'maxlength' => 1024],
            ],
        ]
    ]);
    echo Form::widget([
        'model'      => $model,
        'form'       => $form,
        'columns'    => 2,
        'attributes' => [
            'date_begin' => [
                'type'        => Form::INPUT_WIDGET,
                'widgetClass' => DateControl::classname(),
                'options'     => ['type' => DateControl::FORMAT_DATE]
            ],
            'date_end'   => [
                'type'        => Form::INPUT_WIDGET,
                'widgetClass' => DateControl::classname(),
                'options'     => ['type' => DateControl::FORMAT_DATE]
            ],
//            'published'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Publication...']],
//
//            'created_by'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Created By...']],
//
//            'updated_by'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated By...']],
//
//            'created_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],
//
//            'updated_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],
        ]
    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end();
    ?>

</div>
