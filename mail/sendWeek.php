<?php

use app\models\User;
use app\models\Week;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $user User */
/* @var $date DateTime */
/* @var $date_begin DateTime */
/* @var $model Week */

$dateEnd= clone $date;
$dateEnd->modify('+6 days');
$planningLink = Yii::$app->urlManager->createAbsoluteUrl(['users/planning','id'=>$user->id,'date'=>$date_begin]);
?>

<h1>Salut <?= Html::encode($user->fullname) ?>,</h1>


<p>Ton nouveau planinng du <b><?= Yii::$app->formatter->asDate($date); ?></b> au <b><?= Yii::$app->formatter->asDate($dateEnd); ?></b></p>
<?php
if(isset($model)&&isset($model->words_of_the_week))echo \kartik\helpers\Html::tag('p','Ton objectif: '.$model->words_of_the_week);
?><p>Clique le lien ci-dessous pour le consulter:</p>


<?= Html::a(Yii::t('app', 'See planning.'), $planningLink) ?>

