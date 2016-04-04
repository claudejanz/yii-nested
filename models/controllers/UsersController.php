<?php

namespace app\controllers;

use app\controllers\base\MyController;
use app\extentions\helpers\EuroDateTime;
use app\models\Day;
use app\models\Reporting;
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
                    'reporting-update',
                    'day-update',
                    'week-ready',
                    'week-fill',
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
                            'reporting-update',
                            'week-ready',
                            'week-fill',
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
                    'week-ready',
                    'week-fill',
                    'day-update',
                    'reporting-update',
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
        $searchModel = new TrainingTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->model, 10);
        return $this->render('planning', [
                    'model' => $this->model,
                    'isCoach' => $isCoach,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
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
                    throw new NotAcceptableHttpException($this->render('/trainings/update', [
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
                    throw new NotAcceptableHttpException($this->render('/days/_form', ['model' => $model]));
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
     * Updates Reporting datas
     * 
     * @param int $id
     * @param string $date
     * @return string
     * @throws NotAcceptableHttpException
     */
    public function actionReportingUpdate($id, $training_id)
    {
        $model = Reporting::findOne(['training_id' => $training_id]);
        if (!$model) {
            $model = new Reporting();
            $training = Training::findOne($training_id);
            $model->training_id = $training->id;
            $model->date = $training->day->date;
            $model->week_id = $training->day->week_id;
            $model->sport_id = $training->sport_id;
        }
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                if ($model->validate()) {
                    return $model->save();
                } else {
                    throw new NotAcceptableHttpException($this->render('/reportings/_form', ['model' => $model]));
                }
            } else {
                if ($model->validate()) {
                    $model->save();
                    return $this->redirect(Url::previous());
                } else {
                    var_dump($model->errors, $training_id);
                }
            }
        }

        return $this->render('/reportings/_form', ['model' => $model]);
    }

    /**
     * Publishes a week and send an email to the sportif
     * 
     * @param int $id
     * @param string $date_begin
     * @return string
     */
    public function actionWeekPublish($id, $week_id)
    {
        $model = Week::findOne($week_id);
        /* @var $$user User */
        $user = $this->model;

        if ($model) {

            if ($model->load(Yii::$app->request->post())) {
                if (Yii::$app->request->isAjax) {
                    if ($model->publish()) {


                        if ($model->sendWeekMail($user))
                            return ['message' => Yii::t('app', 'Week has been sent to {user}', ['user' => $user->fullname]), 'error' => '0'];
                    } else {
                        throw new NotAcceptableHttpException($this->render('/weeks/_form', [
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
     * Coach sends an email to ask sportif to fill his week
     * 
     * @param int $id
     * @param string $date_begin
     * @return string
     */
    public function actionWeekFill($id, $date_begin)
    {
        /* @var $model User */
        $model = $this->model;
        if ($model->sendCityMail($date_begin)) {
            return ['message' => Yii::t('app', 'Mail has been sent.'), 'error' => 0];
        }
        return ['message' => Yii::t('app', 'Week must have something in it to be sent.'), 'error' => 1];
    }

    /**
     * Sportif confirms the week places are ok
     * 
     * @param int $id
     * @param string $date_begin
     * @return string
     */
    public function actionWeekReady($id, $date_begin)
    {
        /* @var $model User */
        $model = Week::find(['sportif_id' => $id, 'date_begin' => $date_begin]);
        if (!$model) {
            $date = new EuroDateTime($date_begin);
            $date->modify('+6jours');
            $model = new Week();
            $model->sportif_id = $id;
            $model->date_begin = $date_begin;
            $model->date_end = $date->format('Y-m-d');
            if (!$model->save()) {
                return ['message' => Yii::t('app', 'Week could not be created.'), 'error' => 1];
            }
        }
        return ['message' => Yii::t('app', 'Week has been validated.'), 'error' => 0];
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