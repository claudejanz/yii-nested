<?php

use app\models\Week;
use claudejanz\toolbox\widgets\ajax\AjaxSubmit;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

/**
 * @var View $this
 * @var Week $model
 * @var ActiveForm2 $form
 */
?>

<div class="week-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

           // 'published'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Publication...']],

            //'title'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Titre...', 'maxlength'=>1024]],

            //'sportif_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Sportif ID...']],

            //'date_begin'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATE]],

//            'date_end'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATE]],
//
//            'created_by'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Created By...']],
//
//            'updated_by'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated By...']],
//
//            'created_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],
//
//            'updated_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

            'words_of_the_week'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Words Of The Week...', 'maxlength'=>1024]],

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
    $this->registerJs('$("form input:text, form textarea").first().select();');
    ?>

</div>
