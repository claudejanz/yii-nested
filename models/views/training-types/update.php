<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\TrainingType $model
 */

Yii::$app->controller->page->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Training Type',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Training Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="training-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
