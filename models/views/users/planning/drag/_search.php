<?php

use app\models\Category;
use app\models\search\TrainingTypeSearch;
use app\models\Sport;
use app\models\SubCategory;
use app\models\UserSport;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var TrainingTypeSearch $model
 * @var ActiveForm $form
 */
?>

<div class="training-type-search">

    <?php
    $form = ActiveForm::begin([
//                'action' => ['drag'],
                'method' => 'post',
                'options' => [
                    'data-pjax' => '',
                    'class' => 'kneubuhler'
                ]
    ]);
    ?>

    <?php // $form->field($model, 'id')  ?>

    <?php // $form->field($model, 'title')  ?>

    <?php
    $sub = UserSport::find()->select('sport.id')->where(['user_id'=>$user->id])->joinWith(['sport'=>function($query){return $query->select('id');}])->column();
    echo yii\helpers\Html::tag('h4',Sport::getLabel(2));      
    echo $form->field($model, 'sport_id')->dropDownList(ArrayHelper::map(Sport::find()->select(['id', 'title'])->where(['in','id',$sub])->asArray()->all(), 'id', 'title'), [
        'prompt' => Yii::t('app', 'All'),
        'class' => 'form-control form-kneubuhler',
        'onchange' => '$(this).parents("form:first").submit();',
    ])->label(false)->hint(false);
    ?>

    <?php
    if (!empty($model->sport_id)) {
        $data = Category::find()->select(['id', 'title'])->where(['sport_id' => $model->sport_id])->asArray()->all();
        if ($data) {
            echo $form->field($model, 'category_id')->dropDownList(ArrayHelper::map($data, 'id', 'title'), [
                'prompt' => Yii::t('app', 'All'),
                'class' => 'form-control form-kneubuhler',
                'onchange' => '$(this).parents("form:first").submit();',
            ])->label(false)->hint(false);
        }
    }
    ?>
    <?php
    if (!empty($model->category_id)) {
        $data = SubCategory::find()->select(['id', 'title'])->where(['category_id' => $model->category_id])->asArray()->all();
        if ($data) {

            echo $form->field($model, 'sub_category_id')->dropDownList(ArrayHelper::map($data, 'id', 'title'), [
                'prompt' => Yii::t('app', 'All'),
                'class' => 'form-control form-kneubuhler',
                'onchange' => '$(this).parents("form:first").submit();',
            ])->label(false)->hint(false);
        }
    }
    ?>



    <?php ActiveForm::end(); ?>

</div>
