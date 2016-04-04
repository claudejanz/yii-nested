<?php

namespace app\models\querys;

use app\models\AuthItem;
use Yii;
use yii\caching\DbDependency;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\AuthItem]].
 *
 * @see AuthItem
 */
class AuthItemQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return AuthItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AuthItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
}
