<?php

use app\models\User;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $user User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>

Hello <?= Html::encode($user->username) ?>,

Cliquez le lien ci-dessous pour ré-initialiser votre mot de passe:

<?= Html::a(Html::encode($resetLink), $resetLink) ?>
