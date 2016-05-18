<?php

use app\models\Sport;
use app\models\User;
use yii\web\View;
use yii\widgets\DetailView;

/**
 * @var View $this
 * @var User $model
 */
Yii::$app->controller->page->title = $model->firstname . ' ' . $model->lastname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">



    <?php
    $sportName = [];
    foreach ($model->sports as $sport) {
        $sportName[] = $sport->title;
    }
    $sports = (!empty($sportName)) ? join(', ', $sportName) : null;
    echo DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'username',
            [
                'attribute' => 'gender',
                'value'     => $model->getGenderLabel(),
            ],
            'firstname',
            'lastname',
            'address',
            'npa',
            'city',
            'tel',
            'birthday:date',
            'email:email',
            [
                'label'  => Sport::getLabel(2),
                'value'  => $sports,
                'format' => 'raw'
            ],
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
//            'role',
            ['attribute' => 'trainer.trainername',
//                'value' => '',
            ],
            [
                'attribute' => 'comments',
                'format'    => 'ntext',
            ]
//            'status',
//            'created_by',
//            [
//                'attribute'=>'created_at',
//                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
//                'type'=>DetailView::INPUT_WIDGET,
//                'widgetOptions'=> [
//                    'class'=>DateControl::classname(),
//                    'type'=>DateControl::FORMAT_DATETIME
//                ]
//            ],
//            'updated_by',
//            [
//                'attribute'=>'updated_at',
//                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
//                'type'=>DetailView::INPUT_WIDGET,
//                'widgetOptions'=> [
//                    'class'=>DateControl::classname(),
//                    'type'=>DateControl::FORMAT_DATETIME
//                ]
//            ],
        ],
//        'deleteOptions'=>[
//            'url'=>['delete', 'id' => $model->id],
//            'data'=>[
//                'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
//                'method'=>'post',
//            ],
//        ],
//        'enableEditMode'=>true,
    ])
    ?>

</div>
