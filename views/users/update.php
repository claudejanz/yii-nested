<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\User $model
 */

Yii::$app->controller->page->title = Yii::t('app', 'Update User {name}', [
    'name' =>$model->fullname,
]);

?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
