<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Sport $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Sport',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sport-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
