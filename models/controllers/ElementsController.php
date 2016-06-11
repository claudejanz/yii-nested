<?php

namespace app\controllers;

use app\controllers\base\MyController;
use app\models\Element;
use app\models\ElementSlideshowImage;
use app\models\search\ElementSearch;
use claudejanz\contextAccessFilter\filters\ContextFilter;
use claudejanz\toolbox\controllers\behaviors\PageBehavior;
use kartik\widgets\Alert;
use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * ElementsController implements the CRUD actions for Element model.
 */
class ElementsController extends MyController
{

    public function behaviors()
    {
        return [
            'context' => [
                'class' => ContextFilter::className(),
                'modelName' => Element::className(),
                'only' => ['view', 'update']
            ],
            'page' => [
                'class' => PageBehavior::className(),
                'actions' => ['index2']
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'delete', 'view', 'slideshow-order', 'slideshow-sort'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Element models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ElementSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actions()
    {
        return [
            'slideshow-sort' => [
                'class' => 'app\extentions\SortableAction',
                //'scenario'=>'editable',  //optional
                'modelclass' => ElementSlideshowImage::className(),
            ],
        ];
    }

    public function actionSlideshowOrder($id)
    {
        return $this->render('slideshow/order', ['id' => $id]);
    }

    /**
     * Displays a single Element model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->model;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new Element model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Element;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Element model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->model;
        if ($model->load(Yii::$app->request->post())) {
            $isValid = true;
            $errors = [];
            $modelsToSave = [];
            if ($model->validate()) {
                $modelsToSave[] = $model;
            } else {
                $isValid = false;
                $errors = $model->errors;
            }
            switch ($model->type) {
                case Element::TYPE_SPLASH:
                    $model->elementImage->loadWithFiles(Yii::$app->request->post());
                    if ($model->elementImage->validate()) {
                        $modelsToSave[] = $model->elementImage;
                    } else {
                        $isValid = false;
                        $errors = ArrayHelper::merge($errors, $model->elementImage->errors);
                    }
                    $models = $model->elementTexts;
                    if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
                        $modelsToSave = ArrayHelper::merge($modelsToSave, $models);
                    }else{
                        $isValid = false;
                        foreach($models as $m){
                            $errors = ArrayHelper::merge($errors, $m->errors);
                        }
                    }

                    break;
                case Element::TYPE_MULTITEXT:
                    
                    $models = $model->elementTexts;
                    if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
                        $modelsToSave = ArrayHelper::merge($modelsToSave, $models);
                    }else{
                        $isValid = false;
                        foreach($models as $m){
                            $errors = ArrayHelper::merge($errors, $m->errors);
                        }
                    }
                    break;
                default:
                    $this->redirect(Url::previous());
            }
            if ($isValid) {
                foreach ($modelsToSave as $m) {
                    $m->save(false);
                }
                $this->redirect(Url::previous());
            } else {
                Yii::$app->session->setFlash(Alert::TYPE_DANGER, $errors);
            }
        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Element model.
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
     * Finds the Element model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Element the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Element::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
