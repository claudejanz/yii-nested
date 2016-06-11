<?php

use app\models\Element;
use kartik\widgets\ActiveForm;
use yii\web\View;

/**
 * @var View $this
 * @var Element $model
 * @var ActiveForm $form
 */
?>
<div class="element-form">
    <?php
    switch ($model->type) {
        case Element::TYPE_SLIDESHOW:
        case Element::TYPE_SPLASH:
        case Element::TYPE_MULTITEXT:
            echo $this->render('forms/form-' . $model->getTypeValue(), ['model' => $model]);
            break;
        default:
            echo $this->render('forms/form-default', ['model' => $model]);
    }
    ?>

</div>
