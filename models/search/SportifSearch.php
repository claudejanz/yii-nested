<?php

namespace app\models\search;

use app\extentions\helpers\EuroDateTime;
use app\models\Sport;
use app\models\User;
use app\models\Week;
use DateInterval;
use DatePeriod;
use kartik\icons\Icon;
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
/**
 * 
 * @param View $view
 * @return string
 */
    public function getColumns($view)
    {
        $cols = [
//            ['class' => 'yii\grid\SerialColumn'],
//        'id',
//        'username',
             [
                'attribute' => 'firstname',
                'value' => function($model) {
                    return Html::a($model->firstname,['users/update','id'=>$model->id],['data'=>['pjax'=>0]]);
                },
                'format'=>'raw'
            ],
            [
                'attribute' => 'lastname',
                'value' => function($model) {
                    return Html::a($model->lastname,['users/update','id'=>$model->id],['data'=>['pjax'=>0]]);
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
                    [
                        'label' => Yii::t('app', 'Next Weeks'),
                        'format'=>'raw',
                        'value' => function($model)use ($view){
                            $date = new EuroDateTime('now');
                            $date->modify('Monday this week');
                            $endDate = clone $date;
                            $endDate->modify('+4 weeks');
                            $interval = DateInterval::createFromDateString('1 week');
                            $period = new DatePeriod($date, $interval, $endDate);
                            $weeks = Week::find()->select(['published','date_begin'])->indexBy('date_begin')->where(['between','date_begin',$date->format('Y-m-d'),$endDate->format('Y-m-d')])->andWhere(['sportif_id'=>$model->id])->all();
                            $str ='';
                            foreach ($period as $dateTime){
                                /* @var $week Week */
                                $index = $dateTime->format('Y-m-d');
                                $week = isset($weeks[$index])?$weeks[$index]:null;
                                $str .= $view->render('/weeks/_miniview',['model'=>$week,'dateTime'=>$dateTime,'id'=>$model->id]).' '; 
                            }
                            return $str;
                        }
                    ],
//            'address',
//            'tel', 
//                    'email:email',
//            'auth_key', 
//            'password_hash', 
//            'password_reset_token', 
//            'role', 
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
//                $cols[] = [
//                    'class' => 'yii\grid\ActionColumn',
////                    'template'=>'{view} {update} {planning} {delete}',
//                    'template' => '{planning}',
//                    'buttons' => [
////                        'view' => function ($url, $model) {
////                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Yii::$app->urlManager->createUrl(['users/view', 'id' => $model->id]), [
////                                        'title' => Yii::t('yii', 'Edit'),
////                            ]);
////                        },
////                                'update' => function ($url, $model) {
////                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['users/update', 'id' => $model->id]), [
////                                        'title' => Yii::t('yii', 'Edit'),
////                            ]);
////                        },
//                        'planning' => function ($url, $model) {
//                            return Html::a(Icon::show('list'), Yii::$app->urlManager->createUrl(['users/planning', 'id' => $model->id]), [
//                                        'title' => Yii::t('yii', 'Planning'),
//                                        'data-pjax' => '0',
//                            ]);
//                        },
////                                'delete' => function ($url, $model) {
////                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', Yii::$app->urlManager->createUrl(['users/delete', 'id' => $model->id]), [
////                                        'title' => Yii::t('yii', 'Delete'),
////                                        'aria-label' => Yii::t('yii', 'Delete'),
////                                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
////                                        'data-method' => 'post',
////                                        'data-pjax' => '0',
////                            ]);
////                        },
//                            ],
//                        ];
                        return $cols;
                    }

                }
                