<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var app\models\WeekComment $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="week-comment-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'title'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Titre...', 'maxlength'=>1024]],



            'content'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Contenu...','rows'=> 6]],


        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
