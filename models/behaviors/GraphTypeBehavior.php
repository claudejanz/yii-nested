<?php

namespace app\models\behaviors;

use Yii;
use yii\base\Behavior;

/**
 * @author Janz
 *
 */
class GraphTypeBehavior extends Behavior {

    const GRAPH_TYPE_HISTOGRAMME = 1;
    const GRAPH_TYPE_BEZIER = 2;

    /**
     * @return array published names indexed by published IDs
     */
    public static function getTypeOptions() {
        return array(
            self::GRAPH_TYPE_HISTOGRAMME => Yii::t('mulaff', 'Colonne histogramme'),
            self::GRAPH_TYPE_BEZIER => Yii::t('mulaff', 'Courbe de Bézier'),
        );
    }
    

   


    

}
