<?php

namespace app\models\search;

use app\models\Sport;
use app\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{

    public function rules()
    {
        return [
            [['id', 'role', 'trainer_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['firstname', 'lastname', 'address', 'city', 'npa', 'tel', 'username', 'email', 'auth_key', 'password_hash', 'password_reset_token', 'language', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find();

        $query->andWhere(['<=', 'role', Yii::$app->user->identity->role]);

        if (!Yii::$app->user->can('admin')) {
            $query->andWhere(['trainer_id' => Yii::$app->user->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'role' => $this->role,
            'trainer_id' => $this->trainer_id,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
                ->andFilterWhere(['like', 'lastname', $this->lastname])
                ->andFilterWhere(['like', 'address', $this->address])
                ->andFilterWhere(['like', 'npa', $this->npa])
                ->andFilterWhere(['like', 'city', $this->city])
                ->andFilterWhere(['like', 'tel', $this->tel])
                ->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'auth_key', $this->auth_key])
                ->andFilterWhere(['like', 'password_hash', $this->password_hash])
                ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
                ->andFilterWhere(['like', 'language', $this->language]);

        return $dataProvider;
    }

    public function getColumns()
    {
        $cols = [
//            ['class' => 'yii\grid\SerialColumn'],
//        'id',
//        'username',
            [
                'attribute' => 'firstname',
                'value' => function($model) {
                    return Html::a($model->firstname,['users/planning','id'=>$model->id],['data'=>['pjax'=>0]]);
                },
                'format'=>'raw'
            ],
            [
                'attribute' => 'lastname',
                'value' => function($model) {
                    return Html::a($model->lastname,['users/planning','id'=>$model->id],['data'=>['pjax'=>0]]);
                },
                'format'=>'raw'
            ],
            [
                'label' => Sport::getLabel(2),
                'value' => function($model) {
                    $sportName = [];
                    foreach ($model->sports as $sport) {
                        $sportName[] = $sport->title;
                    }
                    return (!empty($sportName)) ? join(', ', $sportName) : null;
                }
                    ],
//            'address',
//            'city_npa',
//            'tel', 
//                    'email:email',
//            'auth_key', 
//            'password_hash', 
//            'password_reset_token', 
//            'language', 
                    [
                        'filter' => Html::activeDropDownList($this, 'language', Yii::$app->params['translatedLanguages'], ['prompt' => Yii::t('app', 'All'), 'class' => 'form-control']),
                        'attribute' => 'language',
                        'value' =>
                        function($model) {
                    $languages = Yii::$app->params['translatedLanguages'];
                    return $languages[$model->language];
                },
                    ]
                ];
                if (Yii::$app->user->can('super admin')) {
                    $cols[] = [
                        'label' => Yii::t('app', 'Trainer'),
                        'filter' => false,
                        'attribute' => 'trainer_id',
                        'value' => function($model) {
                            return ($model->trainer) ? $model->trainer->firstname . ' ' . $model->trainer->lastname : null;
                        },
                    ];
                }
                if (Yii::$app->user->can('super admin')) {
                    $cols[] = [
                        'filter' => Html::activeDropDownList($this, 'role', User::getRoleOptions(), ['prompt' => Yii::t('app', 'All'), 'class' => 'form-control']),
                        'attribute' => 'role',
                        'value' =>
                        function($model) {
                    return $model->getRoleLabel();
                },
                    ];
                }
//            'created_by', 
//            ['attribute'=>'created_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            'updated_by', 
//            ['attribute'=>'updated_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
                $cols[] = [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {planning} {delete}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Yii::$app->urlManager->createUrl(['users/view', 'id' => $model->id]), [
                                        'data-pjax' => '0',
                                        'title' => Yii::t('yii', 'Edit'),
                            ]);
                        },
                                'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['users/update', 'id' => $model->id]), [
                                        'data-pjax' => '0',
                                        'title' => Yii::t('yii', 'Edit'),
                            ]);
                        },
                                'planning' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-list"></span>', Yii::$app->urlManager->createUrl(['users/planning', 'id' => $model->id]), [
                                        'data-pjax' => '0',
                                        'title' => Yii::t('yii', 'Planning'),
                            ]);
                        },
                                'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', Yii::$app->urlManager->createUrl(['users/delete', 'id' => $model->id]), [
                                        'title' => Yii::t('yii', 'Delete'),
                                        'aria-label' => Yii::t('yii', 'Delete'),
                                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                        'data-method' => 'post',
                                        'data-pjax' => '0',
                            ]);
                        }
                            ],
                        ];
                        return $cols;
                    }

                }
                