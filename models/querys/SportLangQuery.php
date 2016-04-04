<?php

namespace app\models\querys;

use app\models\SportLang;
use Yii;
use yii\caching\DbDependency;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\SportLang]].
 *
 * @see SportLang
 */
class SportLangQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SportLang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SportLang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
   
}
