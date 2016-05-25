<?php

namespace app\controllers;

use app\controllers\base\MyController;
use app\extentions\behaviors\WeekPublishBehavior;
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
use kartik\mpdf\Pdf;
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
            'context'    => [
                'class'     => ContextFilter::className(),
                'modelName' => User::className(),
                'only'      => [
                    'day-update',
                    'day-validate-city',
                    'delete',
                    'planning',
                    'planning-pdf',
                    'training-create',
                    'training-delete',
                    'training-update',
                    'reporting-update',
                    'update',
                    'view',
                    'week-publish',
                    'week-fill',
                    'week-ready',
                ]
            ],
            'access'     => [
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
                        'allow'   => true,
                        'roles'   => ['coaching'],
                    ],
                    [
                        'actions' => [
                            'create',
                        ],
                        'allow'   => true,
                        'roles'   => ['coach'],
                    ],
                    [
                        'actions' => [
                            
                            'day-update',
                            'day-validate-city',
                            'planning',
                            'planning-pdf',
                            'reporting-update',
                            'update',
                            'week-ready',
                            'week-fill',
                        ],
                        'allow'   => true,
                        'roles'   => ['update user'],
                    ],
                ],
            ],
            'page'       => [
                'class'   => PageBehavior::className(),
                'actions' => ['index']
            ],
            'verbs'      => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'negociator' => [
                'class'   => 'yii\filters\ContentNegotiator',
                'only'    => [
                    'day-update',
                    'day-validate-city',
                    'training-update',
                    'reporting-update',
                    'week-fill',
                    'week-publish',
                    'week-ready',
                ], // in a controller
                // if in a module, use the following IDs for user actions
                // 'only' => ['user/view', 'user/index']
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'text/html'        => Response::FORMAT_HTML,
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
                    'searchModel'  => $searchModel,
        ]);
    }

    /**
     * Shows all plannings from a specific sportif.
     * @return mixed
     */
    public function actionPlanning($id, $date = 'now')
    {
        $startDate = new EuroDateTime($date);
        $startDate->modify('Monday this week');
        $endDate = clone $startDate;
        $isCoach = Yii::$app->user->can('coach');
        if ($isCoach) {
            $endDate->modify(Yii::$app->user->planningLength);
        } else {
            $endDate->modify('+6days');
        }
        $searchModel = new TrainingTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->model, 10);

        Url::remember();
        return $this->render('planning', [
                    'model'        => $this->model,
                    'startDate'    => $startDate,
                    'endDate'      => $endDate,
                    'dataProvider' => $dataProvider,
                    'searchModel'  => $searchModel,
                    'isCoach'      => $isCoach,
        ]);
    }

    /**
     * Shows all plannings from a specific sportif in PDF Format.
     * @return mixed
     */
    public function actionPlanningPdf($id, $date = 'now')
    {
        $startDate = new EuroDateTime($date);
        $startDate->modify('Monday this week');
        $endDate = clone $startDate;
        $isCoach = Yii::$app->user->can('coach');
        $endDate->modify(Yii::$app->user->planningLength);
        $searchModel = new TrainingTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), $this->model, 10);

        $content = $this->renderPartial('planningPdf', [
            'model'        => $this->model,
            'isCoach'      => $isCoach,
            'startDate'    => $startDate,
            'endDate'      => $endDate,
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
//        return $content;
        // setup kartik\mpdf\Pdf component
        $label = Yii::t('app', 'Planning for {name} from {date_begin} to {date_end}', [
                    'name'       => $this->model->fullname,
                    'date_begin' => Yii::$app->formatter->asDate($startDate),
                    'date_end'   => Yii::$app->formatter->asDate($endDate)
        ]);

        $pdf = new Pdf([
            // set to use core fonts only
            'mode'        => Pdf::MODE_CORE,
            // A4 paper format
            'format'      => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content'     => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile'     => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline'   => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options'     => ['title' => $label],
            // call mPDF methods on the fly
            'methods'     => [
                'SetHeader' => [$label],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
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
            return '';
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
        if (Yii::$app->request->isAjax) {
            return true;
        } else {
            return $this->redirect(Url::previous());
        }
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
     * Updates Day datas
     * 
     * @param int $id
     * @param string $date
     * @return string
     */
    public function actionDayValidateCity($id, $date)
    {
        $model = Day::findOne(['sportif_id' => $id, 'date' => $date]);
        if (!$model) {
            $model = new Day();
            $model->date = $date;
            $model->sportif_id = $id;
            $model->training_city = $this->model->city;
        }
        if ($model->save()) {

            return $model->save();
        } else {
            return;
        }
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
            $model->day_id = $training->day_id;
            $model->sport_id = $training->sport_id;
            $model->time = $training->time;
        } else {
            $training = $model->training;
        }
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                if ($model->validate()) {
                    return $model->save();
                } else {
                    throw new NotAcceptableHttpException($this->render('/reportings/_form', ['model' => $model, 'training' => $training]));
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

        return $this->render('/reportings/_form', ['model' => $model, 'training' => $training]);
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
                    if ($model->publish(WeekPublishBehavior::PUBLISHED_PLANING_DONE)) {
                        if ($model->sendWeekMail($user)) {
                            return ['message' => Yii::t('app', 'Week has been sent to {user}', ['user' => $user->fullname]), 'error' => '0'];
                        }
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
        $model = Week::findOne(['sportif_id' => $id, 'date_begin' => $date_begin]);
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
        $model->publish(WeekPublishBehavior::PUBLISHED_CITY_DONE);
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
