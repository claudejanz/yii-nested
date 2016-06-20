<?php

use app\extentions\helpers\MyPjax;
use app\models\User;
use app\models\Week;
use app\models\WeekComment;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var WeekComment $model
 * @var Week $week
 * @var User $user
 */
MyPjax::begin(['id' => 'comment' . $model->id]);
?>
<div class="week-comment-view">
    <?php
    /* @var $model WeekComment */
    $creator = User::findOne($model->created_by);
    echo Html::tag('p', Yii::t('app', 'by: {name}', ['name' => $creator->firstname]), ['class' => 'pull-right']);
    echo Html::tag('p', Yii::t('app', 'date: {date}', ['date' => Yii::$app->formatter->asDatetime($model->created_at)]));
    echo Html::tag('h4', $model->title);
    echo Html::tag('p', Yii::$app->formatter->asNtext($model->content));
    echo $this->render('view/actions', [
        'model'   => $model,
        'user'    => $user,
        'creator' => $creator
    ]);
    ?>
</div>
<?php
MyPjax::end();
