<?php

namespace app\models;

use app\models\base\PlaceBase;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Place extends PlaceBase {
    
     public function behaviors() {
        return array(
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
           
        );
    }


    const PLACE_CONTENT_AFTER = 'PLACE_CONTENT_AFTER';
    const PLACE_CONTENT_BEFORE = 'PLACE_CONTENT_BEFORE';
    const PLACE_LEFT = 'PLACE_LEFT';
    const PLACE_RIGHT = 'PLACE_RIGHT';

    /**
     * @return array title names indexed by title IDs
     */
    public function getTitleOptions() {
        return array(
            self::PLACE_CONTENT_AFTER => Yii::t('core', 'PLACE_CONTENT_AFTER'),
            self::PLACE_CONTENT_BEFORE => Yii::t('core', 'PLACE_CONTENT_BEFORE'),
            self::PLACE_LEFT => Yii::t('core', 'PLACE_LEFT'),
            self::PLACE_RIGHT => Yii::t('core', 'PLACE_RIGHT'),
        );
    }

    /**
     * @return string display text for the current Title
     */
    public function getTitleLabel($id) {
        $titleOptions = $this->getTitleOptions();
        return isset($titleOptions[$id]) ? $titleOptions[$id] : "unknown title ($id)";
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElements()
    {
        return $this->hasMany(Element::className(), ['id' => 'element_id'])->via('placeElements');
    }

}
