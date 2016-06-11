<?php

use app\models\Element;
use yii\web\View;

/**
 * @var View $this
 * @var Element $model
 */
?>
<div class="element-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
