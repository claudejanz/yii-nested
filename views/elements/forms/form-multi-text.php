<?php

use app\models\Element;
use kartik\builder\Form;
use kartik\builder\TabularForm;
use kartik\widgets\ActiveForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\redactor\widgets\Redactor;
use yii\web\View;

/**
 * @var View $this
 * @var Element $model
 * @var ActiveForm $form
 */
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'options' => ['enctype' => 'multipart/form-data']]);
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 2,
    'attributes' => [
        'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 255]],
    ]
]);

echo TabularForm::widget([
    'form' => $form,
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $model->elementTexts,
            ]),
    'attributes' => [
        'content' => ['type' => TabularForm::INPUT_WIDGET, 'widgetClass' => Redactor::className()],
    ],
    'gridSettings' => [
        'pjax' => true,
//        'pjaxSettings' => [
//            'neverTimeout' => true,
//            'beforeGrid'=>'My fancy content before.',
//        'afterGrid'=>'My fancy content after.',
//        ]
    ],
    'actionColumn' => [
        'template' => '{delete}',
        'urlCreator' => function($action, $model, $key, $index) {
//            var_dump($action, $model, $key, $index);
            return ['ajax/element-text-' . $action, 'id' => $model->id];
        },
//        'buttons'=>[
//            'delete'=>function ($url, $model, $key) {
//                $options = [
//                    'title' => Yii::t('yii', 'Delete'),
//                    'aria-label' => Yii::t('yii', 'Delete'),
//                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
//                    'data-method' => 'post',
//                    'data-pjax' => '0',
//                ];
//                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
//            }
//            ],
            ],
            'serialColumn' => false,
            'checkboxColumn' => false,
//    'actionColumn' => false,
//                'gridSettings' => [
//                    'floatHeader' => true,
//                    'panel' => [
//                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-image"></i> Manage Texte</h3>',
//                        'type' => GridView::TYPE_PRIMARY,
//                        'after' => ''
////                        Html::a(
////                                '<i class="glyphicon glyphicon-plus"></i> Add New', $createUrl, ['class' => 'btn btn-success']
////                        ) . '&nbsp;' .
////                        Html::a(
////                                '<i class="glyphicon glyphicon-remove"></i> Delete', $deleteUrl, ['class' => 'btn btn-danger']
////                        ) . '&nbsp;' .
////                        Html::submitButton(
////                                '<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class' => 'btn btn-primary']
////                        )
//                    ]
//                ]
        ]);

        echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
        ActiveForm::end();
        