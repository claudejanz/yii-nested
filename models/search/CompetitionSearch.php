<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Competition;

/**
 * CompetitionSearch represents the model behind the search form about `app\models\Competition`.
 */
class CompetitionSearch extends Competition
{
    public function rules()
    {
        return [
            [['id', 'sportif_id', 'published', 'created_by', 'updated_by'], 'integer'],
            [['title', 'date_begin', 'date_end', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Competition::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sportif_id' => $this->sportif_id,
            'date_begin' => $this->date_begin,
            'date_end' => $this->date_end,
            'published' => $this->published,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
