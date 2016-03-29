<?php

namespace app\models\search;

use app\extentions\MulaffGraphWidget;
use app\models\Category;
use app\models\Sport;
use app\models\SubCategory;
use app\models\TrainingType;
use kartik\icons\Icon;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * TrainingTypeSearch represents the model behind the search form about `app\models\TrainingType`.
 */
class TrainingTypeSearch extends TrainingType
{

    public function rules()
    {
        return [
            [['id', 'sport_id', 'category_id', 'sub_category_id', 'graph_type', 'published', 'created_by', 'updated_by'], 'integer'],
            [['title', 'time', 'explanation', 'extra_comment', 'graph', 'created_at', 'updated_at'], 'safe'],
            [['rpe'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params, $user = null,$pageSize=20)
    {
        $query = TrainingType::find();

        if ($user) {
            $sub = \app\models\UserSport::find()->select('sport.id')->where(['user_id' => $user->id])->joinWith(['sport' => function($query) {
                            return $query->select('id');
                        }])->column();
            $query->andWhere(['in', 'training_type.sport_id', $sub]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>['pageSize'=>$pageSize]
        ]);

        $dataProvider->setSort([
            'attributes' => array_merge($dataProvider->getSort()->attributes, [
                'sport.title' => [
                    'asc' => ['sport.title' => SORT_ASC],
                    'desc' => ['sport.title' => SORT_DESC],
                ],
                'category.title' => [
                    'asc' => ['category.title' => SORT_ASC],
                    'desc' => ['category.title' => SORT_DESC],
                ],
                'subCategory.title' => [
                    'asc' => ['subCategory.title' => SORT_ASC],
                    'desc' => ['subCategory.title' => SORT_DESC],
                ],
            ])
        ]);

        $query->joinWith([
            'sport',
            'category',
            'subCategory',
        ]);


        if (!($this->load($params) && $this->validate())) {
            // no filters
            return $dataProvider;
        }

        // with filters
        if (!empty($this->sport_id)) {
            $query->andWhere([static::tableName() . '.sport_id' => $this->sport_id]);
        }
        if (!empty($this->category_id)) {
            $query->andWhere([static::tableName() . '.category_id' => $this->category_id]);
        }
        if (!empty($this->sub_category_id)) {
            $query->andWhere([static::tableName() . '.sub_category_id' => $this->sub_category_id]);
        }
//        

        $query->andFilterWhere([
            'id' => $this->id,
//            'sport_id' => $this->sport_id,
//            'category_id' => $this->category_id,
//            'sub_category_id' => $this->sub_category_id,
            'time' => $this->time,
            'rpe' => $this->rpe,
            'graph_type' => $this->graph_type,
            $this->tableName().'.published' => $this->published,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', static::tableName() . '.title', $this->title])
                ->andFilterWhere(['like', 'explanation', $this->explanation])
                ->andFilterWhere(['like', 'extra_comment', $this->extra_comment])
                ->andFilterWhere(['like', 'graph', $this->graph]);

        return $dataProvider;
    }

    public function getColumns()
    {
        return [
//            ['class' => 'yii\grid\SerialColumn'],
//
//            'id',
            'title',
            [
                'label' => Sport::getLabel(),
                'attribute' => 'sport.title',
                'filter' => Html::activeDropDownList($this, 'sport_id', ArrayHelper::map(Sport::find()->select(['id', 'title'])->asArray()->all(), 'id', 'title'), ['prompt' => Yii::t('app', 'All'), 'class' => 'form-control']),
                'group' => true,
//                'groupedRow'=>true, 
            ],
            [
                'label' => Category::getLabel(),
                'attribute' => 'category.title',
                'filter' => (!empty($this->sport_id)) ? Html::activeDropDownList($this, 'category_id', ArrayHelper::map(Category::find()->select(['id', 'title'])->where(['sport_id' => $this->sport_id])->asArray()->all(), 'id', 'title'), ['prompt' => Yii::t('app', 'All'), 'class' => 'form-control']) : '',
                'group' => true,
//                'subGroupOf'=>2
            ],
            [
                'label' => SubCategory::getLabel(),
                'attribute' => 'subCategory.title',
                'filter' => (!empty($this->category_id)) ? Html::activeDropDownList($this, 'sub_category_id', ArrayHelper::map(SubCategory::find()->select(['id', 'title'])->where(['category_id' => $this->category_id])->asArray()->all(), 'id', 'title'), ['prompt' => Yii::t('app', 'All'), 'class' => 'form-control']) : '',
            ],
            [
//                'label'=> SubCategory::getLabel(),
                'attribute' => 'graph',
                'format' => 'raw',
                'value' => function($model) {
                    return MulaffGraphWidget::widget(['model' => $model, 'attribute' => 'graph', 'width' => 200, 'height' => 80, 'withLegends' => true, 'withLines' => true, 'type' => $model->graph_type]);
                },
                    ],
                    ['attribute' => 'time'],
                    'rpe',
//            'explanation:ntext', 
//            'extra_comment:ntext', 
//            'graph:ntext', 
//            'graph_type', 
//            'published', 
//            'created_by', 
//            ['attribute'=>'created_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            'updated_by', 
//            ['attribute'=>'updated_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a(Icon::show('pencil'), Yii::$app->urlManager->createUrl(['training-types/update', 'id' => $model->id]), [
                                            'title' => Yii::t('yii', 'Edit'),
                                            'data' => [
                                                'pjax' => 0
                                            ]
                                ]);
                            },
                                    'delete' => function ($url, $model) {
                                return Html::a(Icon::show('trash'), Yii::$app->urlManager->createUrl(['training-types/delete', 'id' => $model->id]), [
                                            'title' => Yii::t('yii', 'Delete'),
                                            'data-confirm' => Yii::t('kvgrid', 'Are you sure to delete this item?'),
                                            'data-method' => 'post',
                                            'data-pjax' => '0'
                                ]);
                            }
                                ],
                            ],
                        ];
                    }

                }
                