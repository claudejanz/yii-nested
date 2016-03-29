<?php

use app\models\User;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model User */
/* @var $date DateTime */
/* @var $date_begin DateTime */

$dateEnd = clone $date;
$dateEnd->modify('+6 days');
$planningLink = Yii::$app->urlManager->createAbsoluteUrl(['users/planning', 'id' => $model->id, 'date' => $date_begin]);
?>

<h1>Salut <?= Html::encode($model->fullname) ?>,</h1>


<p>Pourrais-tu enregistrer tes dates pour la semaine du <b><?= Yii::$app->formatter->asDate($date); ?></b> au <b><?= Yii::$app->formatter->asDate($dateEnd); ?></b> afin que je puisse faire ton planning.</p>
<?php
?><p>Clique le lien ci-dessous pour l'editer:</p>


<?= Html::a(Yii::t('app', 'Edit planning.'), $planningLink) ?>

<p>
    Ton coach:<br>
    <?php
    if ($model->trainer) {
        echo $model->trainer->fullname;
        echo '<br>';
        echo $model->trainer->email;
    }
    ?>
</p>

