<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Training $model
 */

Yii::$app->controller->page->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Training',
]) . ' ' . $model->title;
?>
<div class="training-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
