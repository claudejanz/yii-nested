<?php

use app\models\search\UserSearch;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var UserSearch $model
 * @var ActiveForm $form
 */
?>

<div class="user-search">

    <?php
    $form = ActiveForm::begin([
//        'action' => ['index'],
                'method' => 'get',
                'options' => [
                    'data-pjax' => '',
                    'class'=>'kneubuhler'
                ]
        
    ]);
    ?>



    <?php
    echo $form->field($model, 'trainer_id')->dropDownList(ArrayHelper::map(User::find()->select(['id', 'title' => 'CONCAT(firstname,\' \',lastname)'])->andWhere(['between', 'role', User::ROLE_COACH, User::ROLE_ADMIN])->asArray()->all(), 'id', 'title'), [
        'prompt' => Yii::t('app', 'All'),
        'class' => 'form-control',
        'onchange' => '$(this).parents("form:first").submit();',
    ])
    ?>



<?php ActiveForm::end(); ?>

</div>
