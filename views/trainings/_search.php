<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\search\TrainingSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="training-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'sport_id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'sub_category_id') ?>

    <?php // echo $form->field($model, 'sportif_id') ?>

    <?php // echo $form->field($model, 'time') ?>

    <?php // echo $form->field($model, 'rpe') ?>

    <?php // echo $form->field($model, 'explanation') ?>

    <?php // echo $form->field($model, 'extra_comment') ?>

    <?php // echo $form->field($model, 'graph') ?>

    <?php // echo $form->field($model, 'graph_type') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'published') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
