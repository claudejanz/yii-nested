<?php

namespace app\controllers;

use app\controllers\base\MyController;
use app\models\Page;
use app\models\search\PageSearch;
use claudejanz\contextAccessFilter\filters\AccessControl;
use claudejanz\contextAccessFilter\filters\ContextFilter;
use claudejanz\toolbox\controllers\behaviors\PageBehavior;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotAcceptableHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * PagesController implements the CRUD actions for Page model.
 */
class PagesController extends MyController
{

    public function behaviors()
    {
        return [
            'context' => [
                'class' => ContextFilter::className(),
                'modelName' => Page::className(),
                'only' => ['view', 'update', 'delete']
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['hidden'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'page' => [
                'class' => PageBehavior::className(),
                'actions' => ['none']
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'negociator' => [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['create'], // in a controller
                // if in a module, use the following IDs for user actions
                // 'only' => ['user/view', 'user/index']
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'text/html' => Response::FORMAT_HTML,
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'save-sortable' => [
                'class' => 'app\widgets\nested\NestedSortableAction',
                //'scenario'=>'editable',  //optional
                'modelclass' => Page::className(),
            ],
        ];
    }

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PageSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Page model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        Url::remember();
        return $this->render('/all/pageElements');
    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Page;



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
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Page model.
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
     * Deletes an existing Page model.
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
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionOrder()
    {
        return $this->render('order');
    }
    public function actionHidden()
    {
        return $this->render('hidden');
    }

}
