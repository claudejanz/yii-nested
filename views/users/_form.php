<?php

use app\models\Sport;
use app\models\User;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

/**
 * @var View $this
 * @var User $model
 * @var ActiveForm2 $form
 */
?>

<div class="user-form">

    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);
    $sportsOptions = ArrayHelper::map(Sport::find()->select(['id', 'title'])->asArray()->all(), 'id', 'title');
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'contentBefore' => Html::tag('legend', Yii::t('app', 'Profile data')),
        'columns' => 4,
        'attributes' => [
            'username' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['placeholder' => Yii::t('app', 'Enter Nom d\'utilisateur...'), 'maxlength' => 255]
            ],
            'language' => [
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => Yii::$app->params['translatedLanguages'],
                'options' => ['prompt' => Yii::t('app', 'Enter Language...')],
                'hint' => Yii::t('app', 'Will be used for application to user mail communication.'),
            ],
            'editableSports' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => Select2::className(),
                'options' => [
                    'maintainOrder' => true,
                    'theme' => Select2::THEME_DEFAULT,
                    'data' => $sportsOptions,
                    'options' => ['multiple' => true, 'placeholder' => Yii::t('app', 'Enter Sports...')]
                ],
                'columnOptions' => ['colspan' => 2]
            ],
        ]
    ]);
    if (Yii::$app->user->can('admin')) {
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'contentBefore' => Html::tag('legend', Yii::t('app', 'Only for administrators')),
            'columns' => 2,
            'attributes' => [
                'trainer_id' => [
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'items' => ArrayHelper::map(User::find()->select(['id', 'title' => 'CONCAT(firstname,\' \',lastname)'])->andWhere(['between', 'role', User::ROLE_COACH, User::ROLE_ADMIN])->asArray()->all(), 'id', 'title'),
                    'options' => [ 'prompt' => Yii::t('app', 'Enter Trainer ID...')]
                ],
                'role' => [
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'items' => User::getRoleOptions(Yii::$app->user),
                    'options' => ['placeholder' => Yii::t('app', 'Enter Role...')]
                ],
            ]
        ]);
    }
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'contentBefore' => Html::tag('legend', Yii::t('app', 'Personal data')),
        'columns' => 2,
        'attributes' => [
            'lastname' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => Yii::t('app', 'Enter Nom...'), 'maxlength' => 255]],
            'firstname' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => Yii::t('app', 'Enter Prénom...'), 'maxlength' => 255]],
            'address' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => Yii::t('app', 'Enter Adresse...'), 'maxlength' => 255]],
            'npa' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => Yii::t('app', 'Enter CCP...'), 'maxlength' => 255]],
            'city' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['placeholder' => Yii::t('app', 'Enter Ville...'), 'maxlength' => 255],
                'hint' => Yii::t('app', 'Will also be used as default training city.'),
            ],
            'tel' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => Yii::t('app', 'Enter Tél...'), 'maxlength' => 255]],
            'email' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => Yii::t('app', 'Enter Email...'), 'maxlength' => 255]],
            'comments' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => Yii::t('app', 'Enter Comments...')]],
        ]
    ]);


    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end();
    $this->registerJs("$('form input:text').first().select();");
    ?>

</div>
