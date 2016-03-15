<?php

namespace app\models\querys;

use app\models\Project;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Project]].
 *
 * @see Project
 */
class ProjectQuery extends ActiveQuery
{

    public function withRights()
    {
        if (Yii::$app->user->isGuest) {
            $this->andWhere(['=', '[[published]]', 3]);
        }
        return $this;
    }

    /**
     * @inheritdoc
     * @return Project[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Project|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
