<?php

use app\models\behaviors\GraphTypeBehavior;
use app\models\Category;
use app\models\Sport;
use app\models\SubCategory;
use app\models\TrainingType;
use claudejanz\toolbox\widgets\ajax\AjaxSubmit;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var TrainingType $model
 * @var ActiveForm $form
 */
?>

<div class="training-type-form">

    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);

    $fields = [
        'title' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Titre...', 'maxlength' => 1024]],
    ];
    echo Form::widget([

        'model'      => $model,
        'form'       => $form,
        'columns'    => 1,
        'attributes' => $fields,
    ]);

    $fields = [
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
    ];

    $data = Category::find()->select(['id', 'name' => 'title'])->where(['sport_id' => $model->sport_id])->asArray()->all();
    $fields['category_id'] = [
        'type'        => Form::INPUT_WIDGET,
        'widgetClass' => DepDrop::className(),
        'options'     => [
            'type'          => Select2::className(),
            'data'          => ArrayHelper::map($data, 'id', 'name'),
            'pluginOptions' => [
                'depends' => ['trainingtype-sport_id'],
                'url'     => Url::to(['categories']),
            ]
        ]
//                'options' => [
//                    'prompt' => 'Enter Category ID...'
//                ]
    ];
    $data = SubCategory::find()->select(['id', 'name' => 'title'])->where(['category_id' => $model->category_id])->asArray()->all();

    $fields['sub_category_id'] = [
        'type'        => Form::INPUT_WIDGET,
        'widgetClass' => DepDrop::className(),
//            'multiple'      => FALSE,
        'options'     => [
            'type'          => Select2::className(),
            'data'          => ArrayHelper::map($data, 'id', 'name'),
            'pluginOptions' => [
                'url'     => Url::to(['sub-categories']),
                'depends' => ['trainingtype-category_id'],
            ]
        ]
//                'options' => [
//                    'prompt' => 'Enter Sub Category ID...'
//                ]
    ];
    echo Form::widget([
        'model'      => $model,
        'form'       => $form,
        'columns'    => 3,
        'attributes' => $fields,
    ]);
    $fields = [];
//    $fields['published'] = ['type' => Form::INPUT_WIDGET,'widgetClass'=>  PublishWidget::className()];
    $fields['time'] = ['type'        => Form::INPUT_WIDGET,
        'widgetClass' => DateControl::classname(),
        'options'     => [
            'type'    => DateControl::FORMAT_TIME,
            'options' => [
                'pluginOptions' => [
                    'defaultTime' => false,
                    'minuteStep'  => 1,
                ]
            ]
        ]
    ];
    $fields['rpe'] = ['type'    => Form::INPUT_DROPDOWN_LIST,
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
    ];
    echo Form::widget([

        'model'      => $model,
        'form'       => $form,
        'columns'    => 2,
        'attributes' => $fields,
    ]);
    echo Form::widget([

        'model'      => $model,
        'form'       => $form,
        'columns'    => 2,
        'attributes' => [


            'explanation'   => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Explanation...', 'rows' => 6]],
            'extra_comment' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Extra Comment...', 'rows' => 6]],
            'graph'         => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Graph...', 'rows' => 6]],
//            'graph_type'    => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Graph Type...']],
            'graph_type'    => [
                'type'    => Form::INPUT_DROPDOWN_LIST,
                'items'   => GraphTypeBehavior::getTypeOptions(),
                'options' => ['prompt' => 'Enter Graph Type...']],
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
