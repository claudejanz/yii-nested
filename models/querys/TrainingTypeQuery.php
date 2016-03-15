<?php

namespace app\models\querys;

/**
 * This is the ActiveQuery class for [[\app\models\TrainingType]].
 *
 * @see \app\models\TrainingType
 */
class TrainingTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\TrainingType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\TrainingType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
