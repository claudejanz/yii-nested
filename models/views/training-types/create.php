<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\TrainingType $model
 */

Yii::$app->controller->page->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Training Type',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Training Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-type-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
