<?php

use app\extentions\MulaffIconListWidget;
use app\models\Sport;
use claudejanz\toolbox\widgets\ajax\AjaxSubmit;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Sportel
 * @var ActiveForm2 $form
 */
/* @var $model Sport */
?>


<?php
$fields = [

    'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Titre...', 'maxlength' => 255]],
//            'published'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Publication...']],
//
//            'weight'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Poids...']],
//
//            'created_by'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Created By...']],
//
//            'updated_by'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated By...']],
//
//            'created_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],
//
//            'updated_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],
];
if ($model->hasAttribute('icon'))
    $fields['icon'] = ['type' => Form::INPUT_WIDGET,'widgetClass'=>MulaffIconListWidget::classname(), 'options' => [
        'items'=>  Sport::getIconOptions()]];
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);
echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => $fields,
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
$this->registerJs('$("form input:text").first().select();');
?>

</div>
