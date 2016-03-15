<?php

namespace app\controllers;

use app\controllers\base\MyController;
use app\models\Category;
use app\models\search\TrainingTypeSearch;
use app\models\SubCategory;
use app\models\TrainingType;
use claudejanz\contextAccessFilter\filters\AccessControl;
use claudejanz\contextAccessFilter\filters\ContextFilter;
use claudejanz\toolbox\controllers\behaviors\PageBehavior;
use kartik\depdrop\DepDropAction;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * TrainingTypeController implements the CRUD actions for TrainingType model.
 */
class TrainingTypesController extends MyController
{

    public function behaviors()
    {
        return [
            'context' => [
                'class'     => ContextFilter::className(),
                'modelName' => TrainingType::className(),
                'only'      => ['null']
            ],
            'access'  => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow'   => true,
                        'roles'   => ['coaching'],
                    ],
                    [
                        'actions' => ['create','update', 'categories', 'sub-categories'],
                        'allow'   => true,
                        'roles'   => ['coaching'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow'   => true,
                        'roles'   => ['coaching'],
                    ],
                ],
            ],
            'page'    => [
                'class'   => PageBehavior::className(),
                'actions' => ['index2', 'contact']
            ],
            'verbs'   => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all TrainingType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TrainingTypeSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel'  => $searchModel,
        ]);
    }

    /**
     * Displays a single TrainingType model.
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
     * Creates a new TrainingType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrainingType;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TrainingType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TrainingType model.
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
     * Finds the TrainingType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TrainingType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrainingType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
                    'categories' => [
                        'class'          => DepDropAction::className(),
                        'outputCallback' => function ($selectedId, $params) {
                            return Category::find()->select(['id', 'name' => 'title'])->where(['sport_id' => $selectedId])->asArray()->all();
                        }
                            ],
                            'sub-categories' => [
                                'class'          => DepDropAction::className(),
                                'outputCallback' => function ($selectedId, $params) {
                                    return SubCategory::find()->select(['id', 'name' => 'title'])->where(['category_id' => $selectedId])->asArray()->all();
                                }
                                    ]
                        ]);
                    }

                }
                