<?php

namespace app\models\querys;

/**
 * This is the ActiveQuery class for [[\app\models\Day]].
 *
 * @see \app\models\Day
 */
class DayQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\Day[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Day|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
