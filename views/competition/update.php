<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Competition $model
 */

Yii::$app->controller->page->title = Yii::t('app', 'Update Competition: {name}', [
    'name' => $model->title,
]) ;
?>
<div class="competition-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
