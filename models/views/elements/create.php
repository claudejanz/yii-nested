<?php

use app\models\Element;
use yii\web\View;

/* @var $this View */
/* @var $model Element */
?>
<div class="widget-create">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
