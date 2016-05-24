<?php

use app\models\Competition;
use yii\web\View;

/**
 * @var View $this
 * @var Competition $model
 */

Yii::$app->controller->page->title = Yii::t('app', 'Create competition');
?>
<div class="competition-create">
   
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
