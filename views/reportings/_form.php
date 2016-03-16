<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var app\models\Reporting $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="reporting-form">

    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

//            'training_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Training ID...']],
//
//            'created_by'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Created By...']],
//
//            'updated_by'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated By...']],

            'feedback' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Feedback...', 'rows' => 6]],
            'time' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => DateControl::classname(),
                'options' => [
                    'type' => DateControl::FORMAT_TIME,
                    'options' => [
                        'pluginOptions' => [
                            'defaultTime' => false
                        ]
                    ]
                ]
            ],
//            'created_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],
//
//            'updated_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],
            'feeled_rpe' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\RangeInput',
                'options' => [
                    'html5Options' => ['min' => 1, 'max' => 10],
                    'options' => ['readonly' => true],
                ]
            ],
        ]
    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end();
    ?>

</div>
