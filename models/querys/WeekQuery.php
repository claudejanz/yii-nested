<?php

namespace app\models\querys;

/**
 * This is the ActiveQuery class for [[\app\models\Week]].
 *
 * @see \app\models\Week
 */
class WeekQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\Week[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Week|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}