<?php

use app\extentions\helpers\EuroDateTime;
use app\models\search\SportifSearch;
use app\models\User;
use kartik\builder\Form;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;

/**
 * @var View $this
 * @var SportifSearch $model
 * @var ActiveForm $form
 */
?>

<div class="sportif-search">

    <?php
    $form = ActiveForm::begin([
                'action'  => ['index'],
                'method'  => 'get',
                'options' => [
                    'data-pjax' => '',
                    'class'     => 'kneubuhler'
                ]
    ]);


    $fields = [];


    if (Yii::$app->user->can('admin')) {
        $fields['trainer_id'] = [
            'type'    => Form::INPUT_DROPDOWN_LIST,
            'items'   => ArrayHelper::map(User::find()->select(['id', 'title' => 'CONCAT(firstname,\' \',lastname)'])->andWhere(['between', 'role', User::ROLE_COACH, User::ROLE_ADMIN])->asArray()->all(), 'id', 'title'),
            'options' => [
                'prompt'   => Yii::t('app', 'All'),
                'class'    => 'form-control',
                'onchange' => '$(this).parents("form:first").submit();',
            ]
        ];
    }

    $startDate = new EuroDateTime('first day of last month');
    $endDate = clone $startDate;
    $endDate->modify('+1year');
    $interval = DateInterval::createFromDateString('1 month');
    $period = new DatePeriod($startDate, $interval, $endDate);
    $items = [];
    foreach ($period as $dateTime) {
        $items[$dateTime->format('Y-m-d')] = Yii::$app->formatter->asDate($dateTime, 'LLLL');
    }

    $fields['date'] = [
        'type'    => Form::INPUT_DROPDOWN_LIST,
        'items'   => $items,
        'options' => [
            'prompt'   => Yii::t('app', 'Now'),
            'class'    => 'form-control',
            'onchange' => '$(this).parents("form:first").submit();',
        ]
    ];


    echo Form::widget([
        'model'      => $model,
        'form'       => $form,
//        'contentBefore' => Html::tag('legend', Yii::t('app', 'Profile data')),
        'columns'    => 2,
        'attributes' => $fields,
    ]);


    ActiveForm::end();
    ?>

</div>
