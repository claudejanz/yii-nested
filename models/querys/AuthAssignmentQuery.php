<?php

namespace app\models\querys;

use app\models\AuthAssignment;
use Yii;
use yii\caching\DbDependency;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\AuthAssignment]].
 *
 * @see AuthAssignment
 */
class AuthAssignmentQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return AuthAssignment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AuthAssignment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
}
