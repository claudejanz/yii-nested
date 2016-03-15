<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Element;

/**
 * ElementSearch represents the model behind the search form about `app\models\Element`.
 */
class ElementSearch extends Element
{
    public function rules()
    {
        return [
            [['id', 'class_css', 'weight', 'display_title', 'type', 'published', 'created_by', 'updated_by'], 'integer'],
            [['title', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Element::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'class_css' => $this->class_css,
            'weight' => $this->weight,
            'display_title' => $this->display_title,
            'type' => $this->type,
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
