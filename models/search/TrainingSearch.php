<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Training;

/**
 * TrainingSearch represents the model behind the search form about `app\models\Training`.
 */
class TrainingSearch extends Training
{
    public function rules()
    {
        return [
            [['id', 'sport_id', 'category_id', 'sub_category_id', 'sportif_id', 'graph_type', 'published', 'created_by', 'updated_by'], 'integer'],
            [['title', 'time', 'explanation', 'extra_comment', 'graph', 'date', 'created_at', 'updated_at'], 'safe'],
            [['rpe'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Training::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sport_id' => $this->sport_id,
            'category_id' => $this->category_id,
            'sub_category_id' => $this->sub_category_id,
            'sportif_id' => $this->sportif_id,
            'time' => $this->time,
            'rpe' => $this->rpe,
            'graph_type' => $this->graph_type,
            'date' => $this->date,
            'published' => $this->published,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'explanation', $this->explanation])
            ->andFilterWhere(['like', 'extra_comment', $this->extra_comment])
            ->andFilterWhere(['like', 'graph', $this->graph]);

        return $dataProvider;
    }
}
