<?php

use app\models\Sport;
use app\models\User;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
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
        'model'         => $model,
        'form'          => $form,
        'contentBefore' => Html::tag('legend', Yii::t('app', 'Profile data')),
        'columns'       => 4,
        'attributes'    => [
            'gender'         => [
                'type'    => Form::INPUT_RADIO_LIST,
                'items'   => User::getGenderOptions(),
                'options' => []
            ],
            'username'       => [
                'type'    => Form::INPUT_TEXT,
                'options' => ['placeholder' => Yii::t('app', 'Enter Nom d\'utilisateur...'), 'maxlength' => 255]
            ],
            'birthday'       => [
                'type'        => Form::INPUT_WIDGET,
                'widgetClass' => DateControl::classname(),
                'options'     => [
                    'type'    => DateControl::FORMAT_DATE,
                    'options' => [
                        'pluginOptions' => [
                            'defaultTime' => false
                        ]
                    ]
                ]
            ],
            'language'       => [
                'type'    => Form::INPUT_DROPDOWN_LIST,
                'items'   => Yii::$app->params['translatedLanguages'],
                'options' => ['prompt' => Yii::t('app', 'Enter Language...')],
                'hint'    => Yii::t('app', 'Will be used for application to user mail communication.'),
            ],
            'editableSports' => [
                'type'          => Form::INPUT_WIDGET,
                'widgetClass'   => Select2::className(),
                'options'       => [
                    'maintainOrder' => true,
                    'theme'         => Select2::THEME_DEFAULT,
                    'data'          => $sportsOptions,
                    'options'       => ['multiple' => true, 'placeholder' => Yii::t('app', 'Enter Sports...')]
                ],
                'columnOptions' => ['colspan' => 2]
            ],
        ]
    ]);
     echo Form::widget([
        'model'         => $model,
        'form'          => $form,
        'contentBefore' => Html::tag('legend', Yii::t('app', 'Personal data')),
        'columns'       => 2,
        'attributes'    => [
            'lastname'  => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => Yii::t('app', 'Enter Nom...'), 'maxlength' => 255]],
            'firstname' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => Yii::t('app', 'Enter Prénom...'), 'maxlength' => 255]],
            'society' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => Yii::t('app', 'Enter Socété...'), 'maxlength' => 255]],
            'address'   => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => Yii::t('app', 'Enter Adresse...'), 'maxlength' => 255]],
            'npa'       => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => Yii::t('app', 'Enter CCP...'), 'maxlength' => 255]],
            'city'      => [
                'type'    => Form::INPUT_TEXT,
                'options' => ['placeholder' => Yii::t('app', 'Enter Ville...'), 'maxlength' => 255],
                'hint'    => Yii::t('app', 'Will also be used as default training city.'),
            ],
             'country'    => [
                    'type'    => Form::INPUT_DROPDOWN_LIST,
                    'items'   => [
                        'CH'=>  Yii::t('app', 'Suisse'),
                        'FR'=>  Yii::t('app', 'France'),
                        ],
                    'options' => [ 'prompt' => Yii::t('app', 'Enter Country...')]
                ],
            'tel'       => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => Yii::t('app', 'Enter Tél...'), 'maxlength' => 255]],
            'email'     => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => Yii::t('app', 'Enter Email...'), 'maxlength' => 255]],
            'comments'  => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => Yii::t('app', 'Enter Comments...')]],
        ]
    ]);
    if (Yii::$app->user->can('admin')) {
        echo Form::widget([
            'model'         => $model,
            'form'          => $form,
            'contentBefore' => Html::tag('legend', Yii::t('app', 'Contract')),
            'columns'       => 2,
            'attributes'    => [
                'contrat_start' => [
                    'type'        => Form::INPUT_WIDGET,
                    'widgetClass' => DateControl::classname(),
                    'options'     => [
                        'type'    => DateControl::FORMAT_DATE,
                        'options' => [
                            'pluginOptions' => [
                                'defaultTime' => false,
                            ]
                        ]
                    ]
                ],
                'contrat_end'   => [
                    'type'        => Form::INPUT_WIDGET,
                    'widgetClass' => DateControl::classname(),
                    'options'     => [
                        'type'    => DateControl::FORMAT_DATE,
                        'options' => [
                            'pluginOptions' => [
                                'defaultTime' => false,
                            ]
                        ]
                    ]
                ],
               
            ]
        ]);
        echo Form::widget([
            'model'         => $model,
            'form'          => $form,
            'contentBefore' => Html::tag('legend', Yii::t('app', 'Only for administrators')),
            'columns'       => 2,
            'attributes'    => [
                'trainer_id'    => [
                    'type'    => Form::INPUT_DROPDOWN_LIST,
                    'items'   => ArrayHelper::map(User::find()->select(['id', 'title' => 'CONCAT(firstname,\' \',lastname)'])->andWhere(['between', 'role', User::ROLE_COACH, User::ROLE_ADMIN])->asArray()->all(), 'id', 'title'),
                    'options' => [ 'prompt' => Yii::t('app', 'Enter Trainer ID...')]
                ],
                'role'          => [
                    'type'    => Form::INPUT_DROPDOWN_LIST,
                    'items'   => User::getRoleOptions(Yii::$app->user),
                    'options' => ['placeholder' => Yii::t('app', 'Enter Role...')]
                ],
            ]
        ]);
    }

   
    if (Yii::$app->user->can('admin') && Yii::$app->user->id == $model->id && $model->role > User::ROLE_SPORTIF) {
        echo Form::widget([
            'model'         => $model,
            'form'          => $form,
            'contentBefore' => Html::tag('legend', Yii::t('app', 'Mail settings for Coaches')),
            'columns'       => 3,
            'attributes'    => [

                'mail_password' => [
                    'type' => Form::INPUT_TEXT,
                    'hint' => Yii::t('app', 'The password the email account you provided before.'),
                ],
                'mail_host' => [
                    'type' => Form::INPUT_TEXT,
                    'hint' => Yii::t('app', 'The smtp mail host. ex: mail.infomaniak.com'),
                ],
                'mail_port' => [
                    'type' => Form::INPUT_TEXT,
                    'hint' => Yii::t('app', 'The smtp mail port. ex: 587'),
                ],
            ]
        ]);
    }


    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end();
    $this->registerJs("$('form input:text').first().select();");
    ?>

</div>
