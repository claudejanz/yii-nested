<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\PageSearch $searchModel
 */
?>
<div class="page-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?=
        Html::a(Yii::t('app', 'Create {modelClass}', [
                    'modelClass' => 'Page',
                ]), ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>

<?php echo $this->render('_grid', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]); ?>
</div>
