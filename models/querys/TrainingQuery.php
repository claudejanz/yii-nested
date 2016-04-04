<?php

namespace app\models\querys;

use app\models\Training;
use Yii;
use yii\caching\DbDependency;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Training]].
 *
 * @see Training
 */
class TrainingQuery extends ActiveQuery
{
    /* public function active()
      {
      $this->andWhere('[[status]]=1');
      return $this;
      } */

    /**
     * @inheritdoc
     * @return Training[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Training|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    

}
