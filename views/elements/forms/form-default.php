<?php

use app\models\Element;
use claudejanz\toolbox\widgets\inputs\BooleanWidget;
use claudejanz\toolbox\widgets\inputs\CssClassWidget;
use claudejanz\toolbox\widgets\inputs\PublishWidget;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Element $model
 * @var ActiveForm $form
 */
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);


echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

        'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 255]],
        'display_title' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => BooleanWidget::className(), 'options' => []],
        'published' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => PublishWidget::className(), 'options' => []],
        'class_css' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => CssClassWidget::className(), 'options' => []],
//            'weight' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Weight...']],
//            'display_title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Display Title...']],
//            'created_by' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Created By...']],
//            'updated_by' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Updated By...']],
//            'created_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(), 'options' => ['type' => DateControl::FORMAT_DATETIME]],
//            'updated_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(), 'options' => ['type' => DateControl::FORMAT_DATETIME]],
    ]
]);
echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
ActiveForm::end();
