<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Training $model
 */

Yii::$app->controller->page->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Training',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Trainings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
