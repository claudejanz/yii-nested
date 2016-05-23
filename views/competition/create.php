<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Competition $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Competition',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Competitions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="competition-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
