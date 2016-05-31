<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Mail $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Mail',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mails'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mail-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
