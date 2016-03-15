<?php

use app\models\Element;
use kartik\builder\Form;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Element $model
 * @var ActiveForm $form
 */
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'options' => ['enctype' => 'multipart/form-data']]);
$attributes = [
    'stretchImages' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 255]],
];
echo Form::widget([
    'model' => $model->elementSlideshow,
    'form' => $form,
    'columns' => 1,
    'attributes' => $attributes
]);

echo TabularForm::widget([
    'form' => $form,
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $model->elementSlideshowImages,
            ]),
    'attributes' => [
        'title' => ['type' => TabularForm::INPUT_TEXT],
    ],
    'serialColumn' => false,
    'checkboxColumn' => false,
    'actionColumn' => false,
    'gridSettings' => [
        'floatHeader' => true,
        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-image"></i> Manage Images</h3>',
            'type' => GridView::TARGET_BLANK,
            'after' => ''
//                        Html::a(
//                                '<i class="glyphicon glyphicon-plus"></i> Add New', $createUrl, ['class' => 'btn btn-success']
//                        ) . '&nbsp;' .
//                        Html::a(
//                                '<i class="glyphicon glyphicon-remove"></i> Delete', $deleteUrl, ['class' => 'btn btn-danger']
//                        ) . '&nbsp;' .
//                        Html::submitButton(
//                                '<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class' => 'btn btn-primary']
//                        )
        ]
    ]
]);

echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
ActiveForm::end();
