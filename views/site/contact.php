<?php

use app\extentions\maps\Bounds;
use app\models\Address;
use app\models\forms\ContactForm;
use app\widgets\AddressWidget;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model ContactForm */
?>

<div class="row">
    <div class="col-sm-12">


        <div class="row">
            <div class="col-md-5">
                <?php
                $addresses = Address::find()->all();
                ?>
                <?= $this->render('/all/pageElements'); ?>
                <?= $this->render('/all/addresses', ['models' => $addresses]); ?>
                <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

                    <div class="alert alert-success">
                        <?= Yii::t('app', 'Thanks for contacting us. We will respond shortly.'); ?>
                    </div>



                <?php else: ?>
                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                    <?= $form->field($model, 'name') ?>
                    <?= $form->field($model, 'email') ?>
                    <?php
//                   echo $form->field($model, 'from_date')->widget(DatePicker::className(), [
//                        'type' => DatePicker::TYPE_RANGE,
//                        'attribute2' => 'to_date',
//                        'pluginOptions' => [
//                            'autoclose' => true,
//                            'format' => 'dd-M-yyyy'
//                ]])
                    ?>
                    <?= $form->field($model, 'subject') ?>
                    <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>
                    <?=
                    $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-md-6">{image}</div><div class="col-md-6">{input}</div></div>',
                    ])
                    ?>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app','Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                <?php endif; ?>
            </div>
            <div class="col-md-7">
                <?php
                $coord = new LatLng(['lat' => 46.3572019, 'lng' => 6.2038004]);
                $bounds = new Bounds();
               
                $markers = [];
               
                foreach ($addresses as $address) {
                    /* @var $address Address */
// Lets add a marker now
                    $coord = new LatLng(['lat' => $address->lat, 'lng' => $address->lng]);
                    $marker = new Marker([
                        'position' => $coord,
                        'title' => $address->title,
                    ]);

// Provide a shared InfoWindow to the marker
                    $marker->attachInfoWindow(
                            new InfoWindow([
                        'content' => AddressWidget::widget(['model'=>$address,'editable'=>false])
                            ])
                    );
                    $markers[]=$marker;
                    $bounds->add($coord);

// Add marker to the map
                    
                }
                
                 $map = new Map([
                    'center' => $bounds->getCenterCoordinates(),
                    'zoom' => $bounds->getZoom(300),
                    'width' => '100%',
                    'height' => 550,
                ]);
                
                foreach ($markers as $marker) {
                   $map->addOverlay($marker); 
                }



                echo $map->display();
                ?>
            </div>

        </div>
    </div>
</div>

