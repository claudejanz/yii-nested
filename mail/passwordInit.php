<?php

use app\models\User;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $user User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>

<h1>Hello <?= Html::encode($user->fullname) ?>,</h1>

<p>Votre nom d'utilisateur est: <b><?= $user->username ?></b></p>
<p>Cliquez le lien ci-dessous pour initialiser votre mot de passe:</p>

<?= Html::a('cliquez pour enregister votre mot de passe', $resetLink) ?>
