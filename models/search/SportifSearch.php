<?php

namespace app\models\search;

use app\extentions\helpers\EuroDateTime;
use app\models\Day;
use app\models\User;
use app\models\Week;
use DateInterval;
use DatePeriod;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class SportifSearch extends User
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

        if (!Yii::$app->user->can('admin')) {

            $query->andWhere(['trainer_id' => Yii::$app->user->id]);
        } else {
            $query->andWhere(['not', ['trainer_id' => null]]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id'         => $this->id,
            'role'       => $this->role,
            'trainer_id' => $this->trainer_id,
            'status'     => $this->status,
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

    /**
     * 
     * @param View $view
     * @return string
     */
    public function getColumns($view)
    {
        $cols = [];
        $cols[] = [
                    'attribute' => 'firstname',
                    'format'    => 'raw',
                    'value'     => function($model) {
                        return Html::a($model->firstname, ['users/update', 'id' => $model->id], ['data' => ['pjax' => 0]]);
                    },
                ];

                $cols[] = [
                    'attribute' => 'lastname',
                    'format'    => 'raw',
                    'value'     => function($model) {
                        return Html::a($model->lastname, ['users/update', 'id' => $model->id], ['data' => ['pjax' => 0]]);
                    },
                        ];

                        $date = new EuroDateTime('now');
                        $date->modify('Monday this week');
                        $endDate = clone $date;
                        $endDate->modify('+1 month');
                        $interval = DateInterval::createFromDateString('1 day');
                        $period = new DatePeriod($date, $interval, $endDate);
                        foreach ($period as $dateTime) {
                            /* @var $week Week */
                            $index = $dateTime->format('Y-m-d');
                            $cols[] = [
//                                'encodeLabel'=>false,
                                'dateTime' => $dateTime,
                                'format'   => 'raw',
                                'value'    => function($model)use($index, $view) {
                                    $days = $model->daysByDate;
                                    $day = isset($days[$index]) ? $days[$index] : null;
                                    return $view->render('/days/_miniview', ['model' => $day, 'id' => $model->id, 'date' => $index]);
                                }
                                    ];
                                }


                                if (Yii::$app->user->can('super admin')) {
                                    $cols[] = [
                                        'label'     => Yii::t('app', 'Trainer'),
                                        'filter'    => false,
                                        'attribute' => 'trainer_id',
                                        'value'     => function($model) {
                                            return ($model->trainer) ? $model->trainer->firstname . ' ' . $model->trainer->lastname : null;
                                        },
                                    ];
                                }
                                if (Yii::$app->user->can('super admin')) {
                                    $cols[] = [
                                        'filter'    => Html::activeDropDownList($this, 'role', User::getRoleOptions(), ['prompt' => Yii::t('app', 'All'), 'class' => 'form-control']),
                                        'attribute' => 'role',
                                        'value'     =>
                                        function($model) {
                                    return $model->getRoleLabel();
                                },
                                    ];
                                }
                                return $cols;
                            }

                        }
                        