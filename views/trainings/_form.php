<?php

use app\models\Training;
use claudejanz\toolbox\widgets\ajax\AjaxSubmit;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
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
    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Titre...', 'maxlength' => 1024]],
//            'sport_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Sport ID...']],
//            'sportif_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Sportif ID...']],
//            'date'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATE]],
//            'published'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Publication...']],
//            'category_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Category ID...']],
//            'sub_category_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Sub Category ID...']],
//            'graph_type'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Graph Type...']],
//            'created_by'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Created By...']],
//            'updated_by'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated By...']],
            'time'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_TIME]],
//            'created_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],
//            'updated_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],
//            'rpe'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Rpe...']],
            'explanation'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Explanation...','rows'=> 6]],
            'extra_comment' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Extra Comment...', 'rows' => 6]],
            'graph'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Graph...','rows'=> 6]],
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
