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
    $fields =  [
            'done'       => [
                'type'        => Form::INPUT_WIDGET,
                'widgetClass' => BooleanWidget::className(),
            ],
            'feeled_rpe' => [
                'type'    => Form::INPUT_DROPDOWN_LIST,
                'items'   => [
                    0  => Yii::t('app', 'RPE_0'),
                    1  => Yii::t('app', 'RPE_1'),
                    2  => Yii::t('app', 'RPE_2'),
                    3  => Yii::t('app', 'RPE_3'),
                    4  => Yii::t('app', 'RPE_4'),
                    5  => Yii::t('app', 'RPE_5'),
                    6  => Yii::t('app', 'RPE_6'),
                    7  => Yii::t('app', 'RPE_7'),
                    8  => Yii::t('app', 'RPE_8'),
                    9  => Yii::t('app', 'RPE_9'),
                    10 => Yii::t('app', 'RPE_10')
                ],
                'options' => [
                    'prompt' => Yii::t('app', 'Enter Rpe...'),
                ],
                'hint'    => Yii::t('app', 'RPE_HINT')
            ],
            'km'         => [
                'type' => Form::INPUT_TEXT,
            ],
//            'time_done' => [
//                'type' => Form::INPUT_WIDGET,
//                'widgetClass' => BooleanWidget::className(),
//            ],
            'time'       => [
                'type'        => Form::INPUT_WIDGET,
                'widgetClass' => DateControl::classname(),
                'options'     => [
                    'type'    => DateControl::FORMAT_TIME,
                    'options' => [
                        'pluginOptions' => [
                            'defaultTime' => false,
                            'minuteStep'  => 1,
                        ]
                    ]
                ],
//                'hint'=>  Yii::t('app', 'Default value is <b>{value}</b>',['value'=>$training->time]),
//                'columnOptions'=>[
//                  'colspan'=>2  
//                ]
            ],
        ];
    echo Form::widget([
        'model'      => $model,
        'form'       => $form,
        'columns'    => 4,
        'attributes' =>$fields
    ]);
    echo Form::widget([
        'model'      => $model,
        'form'       => $form,
        'columns'    => 1,
        'attributes' => [
            'feedback' => [
                'type'    => Form::INPUT_TEXTAREA,
                'options' => [
                    'placeholder' => 'Enter Feedback...',
                    'rows'        => 6,
                    'maxlength'   => 255,
                ],
                'hint'    => Yii::t('app', 'Max 255 chars'),
            ],
        ]
    ]);


    if (Yii::$app->request->isAjax) {
        echo AjaxSubmit::widget(['label'   => $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            'options' => [
                'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
        ]]);
    } else {
        echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    }
    ActiveForm::end();
    ?>

</div>
