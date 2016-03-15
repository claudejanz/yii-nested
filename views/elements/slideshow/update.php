<?php

use claudejanz\toolbox\widgets\inputs\BooleanWidget;
use claudejanz\toolbox\widgets\inputs\CssClassWidget;
use claudejanz\toolbox\widgets\inputs\PublishWidget;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="element-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'title'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Title...', 'maxlength'=>255]], 



'display_title'=>['type'=> Form::INPUT_WIDGET,'widgetClass'=> BooleanWidget::className(),'options'=>[]], 
'published'=>['type'=> Form::INPUT_WIDGET,'widgetClass'=> PublishWidget::className(),'options'=>[]], 
'class_css'=>['type'=> Form::INPUT_WIDGET,'widgetClass'=> CssClassWidget::className(),'options'=>[]], 

//'class_css'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Class Css...']], 

//'weight'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Weight...']], 
//
//
//'created_by'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Created By...']], 
//
//'updated_by'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated By...']], 
//
//'created_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 
//
//'updated_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>

