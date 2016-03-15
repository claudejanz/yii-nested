<?php

namespace app\models\querys;

/**
 * This is the ActiveQuery class for [[\app\models\ProjectImage]].
 *
 * @see \app\models\ProjectImage
 */
class ProjectImageQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }
    public function representFirst(){
        $this->orderBy(['represent'=>SORT_DESC]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return \app\models\ProjectImage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\ProjectImage|array|null
     */
    public function one($db = null)
    {
        
        return parent::one($db);
    }
}
