<?php

namespace app\controllers;

use app\controllers\base\MyController;
use app\extentions\helpers\EuroDateTime;
use app\models\Day;
use app\models\search\TrainingTypeSearch;
use app\models\search\UserSearch;
use app\models\Training;
use app\models\TrainingType;
use app\models\User;
use app\models\Week;
use claudejanz\contextAccessFilter\filters\AccessControl;
use claudejanz\contextAccessFilter\filters\ContextFilter;
use claudejanz\toolbox\controllers\behaviors\PageBehavior;
use claudejanz\toolbox\models\behaviors\PublishBehavior;
use kartik\alert\Alert;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotAcceptableHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * UsersController implements the CRUD actions for User model.
 */
class UsersController extends MyController
{

    public function behaviors()
    {
        return [
            'context' => [
                'class' => ContextFilter::className(),
                'modelName' => User::className(),
                'only' => [
                    'view',
                    'planning',
                    'training-create',
                    'update',
                    'delete',
                    'training-delete',
                    'training-update',
                    'week-publish',
                    'day-update',
                ]
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'view',
                            'training-create',
                            'training-delete',
                            'training-update',
                            'week-publish',
                        ],
                        'allow' => true,
                        'roles' => ['coaching'],
                    ],
                    [
                        'actions' => [
                            'create',
                        ],
                        'allow' => true,
                        'roles' => ['coach'],
                    ],
                    [
                        'actions' => [
                            'planning',
                            'update',
                            'day-update',
                        ],
                        'allow' => true,
                        'roles' => ['update user'],
                    ],
                ],
            ],
            'page' => [
                'class' => PageBehavior::className(),
                'actions' => ['index']
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'negociator' => [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => [
                    'training-update',
                    'week-publish',
                    'day-update',
                ], // in a controller
                // if in a module, use the following IDs for user actions
                // 'only' => ['user/view', 'user/index']
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'text/html' => Response::FORMAT_HTML,
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    /**
     * Shows all plannings from a specific sportif.
     * @return mixed
     */
    public function actionPlanning($id, $date = 'now')
    {
        Url::remember();
        $startDate = new EuroDateTime($date);
        $startDate->modify('Monday this week');
        $endDate = clone $startDate;
        $isCoach = Yii::$app->user->can('coach');
        if ($isCoach) {

            $endDate->modify('+13days');
        } else {
            $endDate->modify('+6days');
        }
//        var_dump($startDate->format('Y-m-d'),$endDate->format('Y-m-d'));
//        var_dump($startDate->format('Y-m-d'),$endDate->format('Y-m-d'));
        $models = Training::find()->where(['and', ['between', 'date', $startDate->format('Y-m-d'), $endDate->format('Y-m-d')], ['sportif_id' => $id]])->orderBy('date')->all();
        $models = ArrayHelper::index($models, 'id', ['date']);
        $searchModel = new TrainingTypeSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->model);
        return $this->render('planning', [
                    'model' => $this->model,
                    'isCoach' => $isCoach,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'models' => $models,
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User;
        $model->setScenario('create');
        if (!Yii::$app->user->can('admin')) {
            $model->trainer_id = Yii::$app->user->id;
            $model->role = User::ROLE_SPORTIF;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $auth = Yii::$app->authManager;
            $role = $auth->getRole($model->getRoleName());
            $auth->assign($role, $model->getId());

            if ($model->sendPasswordInit()) {
                Yii::$app->getSession()->setFlash(Alert::TYPE_SUCCESS, Yii::t('app', 'Email sended to {name}', ['name' => $model->getFullname()]));
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Adds a training for a sportif. Needs a date and a training-type id.
     * @return mixed
     */
    public function actionTrainingCreate($id, $date, $training_type_id)
    {
        $modelType = TrainingType::findOne($training_type_id);
        $model = new Training();
        $model->sportif_id = $this->model->id;
        $model->date = $date;
        $model->setAttributes($modelType->getAttributes());
        $model->published = PublishBehavior::PUBLISHED_DRAFT; 
//        \yii\helpers\VarDumper::dump($model->getActiveValidators());
//        die();
        if ($model->save()) {
            return $this->render('planning/receive/training', [
                        'model' => $model,
                        'user' => $this->model,
                        'isCoach' => true,
            ]);
        } else {
            return print_r($model->errors, true);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionTrainingUpdate($id, $training_id)
    {
        $model = Training::findOne($training_id);
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                if ($model->validate()) {
                    return $model->save();
                } else {
                    throw new NotAcceptableHttpException($this->render('create', [
                        'model' => $model,
                    ]));
                }
            } else {
                if ($model->save()) {
                    return $this->redirect(Url::previous());
                }
            }
        }

        return $this->render('/trainings/update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionTrainingDelete($id, $training_id)
    {
        Training::findOne($training_id)->delete();

        return $this->redirect(Url::previous());
    }

    /**
     * Updates Day datas
     * 
     * @param int $id
     * @param string $date
     * @return string
     * @throws NotAcceptableHttpException
     */
    public function actionDayUpdate($id, $date)
    {
        $model = Day::findOne(['sportif_id' => $id, 'date' => $date]);
        if (!$model) {
            $model = new Day();
            $model->date = $date;
            $model->sportif_id = $id;
            $model->training_city = $this->model->city;
        }
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                if ($model->validate()) {
                    return $model->save();
                } else {
                    throw new NotAcceptableHttpException();
                }
            } else {
                if ($model->save()) {
                    return $this->redirect(Url::previous());
                }
            }
        }

        return $this->render('/days/_form', ['model' => $model]);
    }

    /**
     * Publishes a week and send an email to the sportif
     * 
     * @param int $id
     * @param string $date_begin
     * @return string
     */
    public function actionWeekPublish($id, $date_begin)
    {
        $model = Week::findOne(['sportif_id' => $id, 'date_begin' => $date_begin]);
        /* @var $$user User */
        $user = $this->model;

        if ($model) {

            if ($model->load(Yii::$app->request->post())) {
                if (Yii::$app->request->isAjax) {
                    if ($model->publish()) {


                        if ($model->sendWeekMail($user))
                            return ['message' => Yii::t('app', 'Week has been sent to {user}', ['user' => $user->fullname]), 'error' => '0'];
                    } else {
                        throw new NotAcceptableHttpException($this->render('create', [
                            'model' => $model,
                        ]));
                    }
                } else {
                    if ($model->save()) {
                        if ($model->sendWeekMail($user))
                            return $this->redirect(Url::previous());
                    }
                }
            }

            return $this->render('/weeks/_form', [
                        'model' => $model,
            ]);
        }
        return ['message' => Yii::t('app', 'Week must have something in it to be sent.'), 'error' => 1];
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
