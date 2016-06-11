<?php

use app\models\Page;
use claudejanz\toolbox\widgets\ajax\AjaxSubmit;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Page $model
 * @var ActiveForm $form
 */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin([
//        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'id'=>'page-form'
        ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'published')->textInput() ?>

    <?= $form->field($model, 'controller')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'action')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'parent_id')->textInput() ?>

    <?= $form->field($model, 'layout_id')->textInput() ?>

    <?= $form->field($model, 'breadcrumb_text')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'params')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?php
        $label = ($model->isNewRecord) ? Yii::t('app', 'Create') : Yii::t('app', 'Update');
        $class = ($model->isNewRecord) ? 'btn btn-success' : 'btn btn-primary';
        if (Yii::$app->request->isAjax) {
            echo AjaxSubmit::widget(['label'=>$label,'options'=>['class'=>$class]]);
        } else {
            echo Html::submitButton($label, ['class' => $class]);
        }
        ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
