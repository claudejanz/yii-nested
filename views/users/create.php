<?php

use app\models\User;
use yii\web\View;

/**
 * @var View $this
 * @var User $model
 */

Yii::$app->controller->page->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => User::getLabel(),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
