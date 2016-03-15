<?php

namespace app\models;

use app\models\base\LayoutBase;
use claudejanz\toolbox\models\behaviors\AutoPlaceBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Layout extends LayoutBase {

    public function behaviors() {
        return array(
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
            'autoLayout' => array(
                'class' => AutoPlaceBehavior::className(),
            )
        );
    }

    const PATH_FULL = 'full';
    const PATH_COLUMN1 = 'column1';
    const PATH_COLUMN2 = 'column2';
    const PATH_COLUMN3 = 'column3';

    /**
     * @return array path names indexed by path IDs
     */
    public static function getPathOptions() {
        return array(
            self::PATH_FULL => Yii::t('core', 'Full page'),
            self::PATH_COLUMN1 => Yii::t('core', '1 Columns'),
            self::PATH_COLUMN2 => Yii::t('core', '2 Columns'),
            self::PATH_COLUMN3 => Yii::t('core', '3 Columns'),
        );
    }

    /**
     * @return string display text for the current Path
     */
    public function getPathLabel() {
        $options = self::getPathOptions();
        return isset($options[$this->path]) ? $options[$this->path] : "unknown path ($this->path)";
    }
    
   
    
    public function getPlacesByName(){
        return $this->getPlaces()->indexBy('title');
    }

}
