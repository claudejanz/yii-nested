<?php

use app\extentions\StyleIcon;
use app\models\User;
use app\models\Week;
use claudejanz\toolbox\widgets\ajax\AjaxModalButton;
use kartik\helpers\Html;

/* @var $model User */
/* @var $isCoach booleen */
/* @var $isLight booleen */
/* @var $weekId string */
/* @var $week Week */

if ($week) {
    echo Html::beginTag('fieldset', ['class' => 'comments']);
    echo Html::tag('label', Yii::t('app', 'Comments'));
    $options = [];
    Html::addCssClass($options, 'collapsable collapsed');
    Html::addCssStyle($options, 'display: none;');
    echo Html::beginTag('div', $options);

    if ($week->weekComments) {
        foreach ($week->weekComments as $weekComment) {
            echo $this->render('/week-comments/view', [
                'model' => $weekComment,
                'week'  => $week,
                'user'  => $model,
                'forDashBoard'=>false
            ]);
        }
    }
    echo Html::endTag('div');

    $label = Yii::t('app', 'Add comment');
    echo ' ' . AjaxModalButton::widget([
        'label'       => StyleIcon::showStyled('commenting') . ' ' . $label,
        'encodeLabel' => false,
        'url'         => [
            'week-add-comment',
            'id'      => $model->id,
            'week_id' => $week->id,
        ],
        'title'       => $label,
        'success'     => '#week' . $weekId,
        'options'     => [
            'title' => $label,
            'class' => 'red',
        ],
    ]);
    echo Html::endTag('fieldset');
}