<?php

use app\models\Reporting;
use claudejanz\toolbox\widgets\ajax\AjaxSubmit;
use claudejanz\toolbox\widgets\inputs\BooleanWidget;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Reporting $model
 * @var ActiveForm2 $form
 */
?>

<div class="reporting-form">

    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);
     echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 4,
        'attributes' => [
            'done' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => BooleanWidget::className(),
            ],
            'feeled_rpe' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\RangeInput',
                'options' => [
                    'html5Options' => ['min' => 1, 'max' => 10],
                    'options' => ['readonly' => true],
                ],
//                'columnOptions'=>[
//                  'colspan'=>2  
//                ]
            ],
            'time_done' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => BooleanWidget::className(),
            ],
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
                ],
//                'columnOptions'=>[
//                  'colspan'=>2  
//                ]
            ],
        ]
    ]);
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'feedback' => [
                'type' => Form::INPUT_TEXTAREA,
                'options' => [
                    'placeholder' => 'Enter Feedback...',
                    'rows' => 6
                ],
            ],
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
    ?>

</div>
