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
    if ($week->weekComments) {
        echo Html::tag('h2', Yii::t('app', 'Comments'));
        foreach ($week->weekComments as $weekComment) {
            echo $this->render('/week-comments/view', ['model' => $weekComment]);
        }
    }
}
if ($week) {
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
}