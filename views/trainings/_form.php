<?php

use app\models\Sport;
use app\models\Training;
use app\models\User;
use claudejanz\toolbox\widgets\ajax\AjaxSubmit;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

/**
 * @var View $this
 * @var Training $model
 * @var ActiveForm2 $form
 */
?>

<div class="training-form">

    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);

    $fields = [
        'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Titre...', 'maxlength' => 1024]],
    ];

    $fields2 = [
        'sport_id' => [
            'type'        => Form::INPUT_WIDGET,
            'widgetClass' => Select2::className(),
            'options'     => [
                'data'    => ArrayHelper::map(Sport::find()->select(['id', 'name' => 'title'])->asArray()->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => 'Enter Sport ID...'
                ]
            ]
        ],
        'time'     => ['type'        => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(), 'options'     => ['type'    => DateControl::FORMAT_TIME, 'options' => [
                    'pluginOptions' => [
                        'defaultTime' => false,
                        'minuteStep'  => 1,
                    ]
                ]]],
        'rpe'      => [
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
    ];
    $fields3 = [

        'explanation'   => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Explanation...', 'rows' => 6]],
        'extra_comment' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Extra Comment...', 'rows' => 6]],
        'graph'         => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Graph...', 'rows' => 6]],
    ];



    echo Form::widget([
        'model'      => $model,
        'form'       => $form,
        'columns'    => 1,
        'attributes' => $fields,
    ]);
    echo Form::widget([
        'model'      => $model,
        'form'       => $form,
        'columns'    => 3,
        'attributes' => $fields2,
    ]);
    echo Form::widget([
        'model'      => $model,
        'form'       => $form,
        'columns'    => 1,
        'attributes' => $fields3,
    ]);

    if (Yii::$app->user->can('coach')) {
        $fields4 = [
            'sportif_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => ArrayHelper::map(User::find()->all(), 'id', 'fullname'), 'options' => ['placeholder' => 'Enter Sportif ID...']],
            'date'       => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(), 'options' => ['type' => DateControl::FORMAT_DATE]],
        ];
        echo Form::widget([
            'model'         => $model,
            'form'          => $form,
            'contentBefore' => Html::tag('legend', Yii::t('app', 'Only for coaches')),
            'columns'       => 2,
            'attributes'    => $fields4,
        ]);
    }
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
