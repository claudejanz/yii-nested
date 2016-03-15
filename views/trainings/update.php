<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Training $model
 */

Yii::$app->controller->page->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Training',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Trainings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="training-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
