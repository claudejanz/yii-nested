<?php

namespace app\controllers;

use app\controllers\base\MyController;
use app\models\Category;
use app\models\Sport;
use app\models\SubCategory;
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
 * SportsController implements the CRUD actions for Sport model.
 */
class SportsController extends MyController
{

    public function behaviors()
    {
        return [
            'context' => [
                'class' => ContextFilter::className(),
                'modelName' => Sport::className(),
                'only' => ['null']
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'item-add',
                            'item-update',
                            'item-delete',
                        ],
                        'allow' => true,
                        'roles' => ['coach'],
                    ],
                ],
            ],
            'page' => [
                'class' => PageBehavior::className(),
                'actions' => ['index2', 'contact']
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'item-delete' => ['post'],
                ],
            ],
            'negociator' => [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => [
                    'item-add',
                    'item-update',
                    'item-delete',
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
     * Lists all Sport models.
     * @return mixed
     */
    public function actionIndex()
    {
        $models = Sport::find()->all();

        return $this->render('index', [
                    'models' => $models,
        ]);
    }

    /**
     * Displays a single Sport model.
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
     * Creates a new Sport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sport;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Sport model.
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
     * Deletes an existing Sport model.
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
     * Finds the Sport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sport::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionItemAdd($type = NULL, $parent_id = null)
    {
        switch ($type) {
            case 'cat':
                $model = new Category ();
                $model->sport_id = $parent_id;
                break;
            case 'subcat':
                $model = new SubCategory();
                $model->category_id = $parent_id;
                break;
            default:
                $model = new Sport();
                break;
        }
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                if ($model->validate()) {
                    return $model->save();
                } else {
                    throw new NotAcceptableHttpException($model->errors);
                }
            } else {
                if ($model->save()) {
                    return $this->redirect(Url::previous());
                }
            }
        }

        return $this->render('_form', [
                    'model' => $model,
        ]);
    }

    public function actionItemUpdate($id, $type = NULL)
    {
        switch ($type) {
            case 'cat':
                $model = Category::findOne($id);
                break;
            case 'subcat':
                $model = SubCategory::findOne($id);
                break;
            default:
                $model = Sport::findOne($id);
                break;
        }
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                if ($model->validate()) {
                    return $model->save();
                } else {
                    throw new NotAcceptableHttpException($this->render('_form', [
                        'model' => $model,
                    ]));
                }
            } else {
                if ($model->save()) {
                    return $this->redirect(Url::previous());
                }
            }
        }

        return $this->render('_form', [
                    'model' => $model,
        ]);
    }

    public function actionItemDelete($id, $type = NULL)
    {
        switch ($type) {
            case 'cat':
                $model = Category::findOne($id);
                break;
            case 'subcat':
                $model = SubCategory::findOne($id);
                break;
            default:
                $model = Sport::findOne($id);
                break;
        }
        if (Yii::$app->request->isAjax) {
            return $model->delete();
        } else {
            if ($model->delete()) {
                return $this->redirect(Url::previous());
            }
        }
    }

}
