<?php

use app\extentions\FileInputWidget;
use app\models\Element;
use kartik\builder\Form;
use kartik\builder\TabularForm;
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
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 2,
    'attributes' => [
        'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 255]],
    ]
]);
echo Form::widget([

    'model' => $model->elementImage,
    'form' => $form,
    'columns' => 2,
    'attributes' => [

        'url' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => FileInputWidget::className(), 'widgetOptions' => ['accept' => 'image/*']],
    ]
]);
echo TabularForm::widget([
    'form' => $form,
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $model->elementTexts,
            ]),
    'attributes' => [
        'content' => ['type' => TabularForm::INPUT_TEXTAREA],
    ],
    'serialColumn' => false,
    'checkboxColumn' => false,
    'actionColumn' => false,
//                'gridSettings' => [
//                    'floatHeader' => true,
//                    'panel' => [
//                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-image"></i> Manage Texte</h3>',
//                        'type' => GridView::TYPE_PRIMARY,
//                        'after' => ''
////                        Html::a(
////                                '<i class="glyphicon glyphicon-plus"></i> Add New', $createUrl, ['class' => 'btn btn-success']
////                        ) . '&nbsp;' .
////                        Html::a(
////                                '<i class="glyphicon glyphicon-remove"></i> Delete', $deleteUrl, ['class' => 'btn btn-danger']
////                        ) . '&nbsp;' .
////                        Html::submitButton(
////                                '<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class' => 'btn btn-primary']
////                        )
//                    ]
//                ]
]);
echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
ActiveForm::end();
