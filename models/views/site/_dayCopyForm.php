<?php

use app\models\Training;
use app\models\User;
use claudejanz\toolbox\widgets\ajax\AjaxSubmit;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
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

<div class="day-copy-form">

    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);
    

    if (Yii::$app->user->can('coach')) {
        echo Form::widget([
            'model'         => $model,
            'form'          => $form,
            'contentBefore' => Html::tag('legend', Yii::t('app', 'Only for coaches')),
            'columns'       => 2,
            'attributes'    => [
                'sportif_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => ArrayHelper::map(User::find()->all(), 'id', 'fullname'), 'options' => ['placeholder' => 'Enter Sportif ID...']],
                'date'       => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(), 'options' => ['type' => DateControl::FORMAT_DATE]],
            ]
        ]);
    }
     if (Yii::$app->request->isAjax) {
        echo AjaxSubmit::widget(['label'   => Yii::t('app', 'Create'),
            'options' => [
                'class' =>  'btn btn-success' 
        ]]);
    } else {
        echo Html::submitButton( Yii::t('app', 'Create'), ['class' =>  'btn btn-success' ]);
    }
    ActiveForm::end();
    ?>

</div>
