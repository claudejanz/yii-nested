<?php

namespace app\models\querys;

/**
 * This is the ActiveQuery class for [[\app\models\Training]].
 *
 * @see \app\models\Training
 */
class TrainingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\Training[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Training|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
