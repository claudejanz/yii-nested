<?php

use app\models\Page;
use app\widgets\nested\NestedSortable;
use yii\web\View;

/**
 * @var View $this
 * @var Page $model
 */

$this->title = Yii::t('app', 'Order {modelClass}', [
    'modelClass' => 'Page',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-order">

    <?= NestedSortable::widget([
    'model' => Page::className(),
    'url' => '/pages/save-sortable',
    'expand' => true,
    'pluginOptions' => [
        'maxDepth' => 2
    ]
]) ?>

</div>
