<?php

use app\models\TrainingType;
use yii\web\View;

/**
 * @var View $this
 * @var TrainingType $model
 */

Yii::$app->controller->page->title = Yii::t('app', 'Duplicate {modelClass}: ', [
    'modelClass' => 'Training Type',
]) . ' ' . $model->title;

?>
<div class="training-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
