<?php

use app\extentions\WebUser;
use app\models\forms\ViewStyleForm;
use kartik\builder\Form;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* 
 * Copyright (C) 2016 Claude
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
/* @var $user User */
/* @var $startDate DateTime */
$linkDate = clone $startDate;
$linkDate->modify('-7 days');
$optionsLeft=['class' => 'col-xs-6'];
$optionsRight=['class' => 'col-xs-6'];
$optionsBottom=['class' => 'col-xs-12'];

if (!Yii::$app->request->isAjax) {
    Html::addCssClass($optionsLeft, 'animated fadeInLeft');
    Html::addCssClass($optionsRight, 'animated fadeInRight');
}
echo Html::beginTag('div', ['class' => 'row weekNav']);

echo Html::beginTag('div', $optionsLeft);
echo Html::a(Yii::t('app', 'Previous Week'), Url::current(['date' => $linkDate->format('Y-m-d')]), ['class' => 'kneubuhler', 'data' => ['pjax' => '0']]);
echo Html::endTag('div');
$linkDate = clone $startDate;
$linkDate->modify('+7 days');
echo Html::beginTag('div', $optionsRight);
echo Html::a(Yii::t('app', 'Next Week'), Url::current(['date' => $linkDate->format('Y-m-d')]), ['class' => 'kneubuhler', 'data' => ['pjax' => '0']]);
echo Html::endTag('div');

echo Html::beginTag('div', $optionsBottom);
 $form = ActiveForm::begin([
                'action'  => ['planning','id'=>$user->id,'date'=>$startDate->format('Y-m-d')],
                'method'  => 'get',
                'options' => [
                    'data-pjax' => '',
                    'class'     => 'kneubuhler'
                ]
    ]);
 $fields = [];
    $fields['viewStyle'] = [
        'type'    => Form::INPUT_DROPDOWN_LIST,
        'items'   => WebUser::getViewStyleOptions(),
        'options' => [
//            'prompt'   => ucfirst($model->viewStyle),
            'class'    => 'form-control',
            'onchange' => '$(this).parents("form:first").submit();',
        ]
    ];
 echo Form::widget([
        'model'      => new ViewStyleForm(),
        'form'       => $form,
//        'contentBefore' => Html::tag('legend', Yii::t('app', 'Profile data')),
        'columns'    => 2,
        'attributes' => $fields,
    ]);


    ActiveForm::end();
echo Html::endTag('div');//col

echo Html::endTag('div');//row