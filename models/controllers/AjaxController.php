<?php

namespace app\controllers;

use app\controllers\base\MyController;
use app\models\Address;
use app\models\Element;
use app\models\ElementImage;
use app\models\ElementText;
use app\models\Page;
use app\models\Project;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Response;

/**
 * AjaxController implements the CRUD actions for Ajax request.
 */
class AjaxController extends MyController
{

    public function behaviors()
    {
        return [
            'contentNegotiator' => [

                'class' => ContentNegotiator::className(),
                'only' => [
                    'element',
                    'element-image',
                    'element-text',
                    'update'
                ],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'element',
                            'element-image',
                            'element-text',
                            'element-text-delete',
                            'update',
                        ],
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'element-text-delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionElement($id)
    {
        // Check if there is an Editable ajax request
        if (isset($_POST['hasEditable'])) {
            $model = Element::findOne($id);

            if ($model == null) {
                return ['output' => '', 'message' => 'The requested model does not exist.'];
            }

            // read your posted model attributes
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                // read or convert your posted information
                $value = $model->title;

                // return JSON encoded output in the below format
                return ['output' => $value, 'message' => ''];

                // alternatively you can return a validation error
                // return ['output'=>'', 'message'=>'Validation error'];
            }
            // else if nothing to do always return an empty JSON encoded output
            else {
                return ['output' => '', 'message' => $model->errors];
            }
        }
        return ['output' => '', 'message' => ''];
    }

    public function actionElementImage($id)
    {
        // Check if there is an Editable ajax request
        if (isset($_POST['hasEditable'])) {
            $model = ElementImage::findOne($id);

            if ($model == null) {
                return ['output' => '', 'message' => 'The requested model does not exist.'];
            }

            // read your posted model attributes
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                // read or convert your posted information
                $value = Html::img($model->url, ['class' => 'img-responsive']);

                // return JSON encoded output in the below format
                return ['output' => $value, 'message' => ''];

                // alternatively you can return a validation error
                // return ['output'=>'', 'message'=>'Validation error'];
            }
            // else if nothing to do always return an empty JSON encoded output
            else {
                return ['output' => '', 'message' => $model->errors];
            }
        }
        return ['output' => '', 'message' => ''];
    }

    public function actionElementText($id)
    {
        // Check if there is an Editable ajax request
        if (isset($_POST['hasEditable'])) {
            $model = ElementText::findOne($id);

            if ($model == null) {
                return ['output' => '', 'message' => 'The requested model does not exist.'];
            }

            // read your posted model attributes
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                // read or convert your posted information
                $value = $model->content;

                // return JSON encoded output in the below format
                return ['output' => $value, 'message' => ''];

                // alternatively you can return a validation error
                // return ['output'=>'', 'message'=>'Validation error'];
            }
            // else if nothing to do always return an empty JSON encoded output
            else {
                return ['output' => '', 'message' => $model->errors];
            }
        }
        return ['output' => '', 'message' => ''];
    }

    public function actionElementTextDelete($id)
    {
        // Check if there is an Editable ajax request

        $model = ElementText::findOne($id);


        if ($model == null) {
            return ['output' => '', 'message' => 'The requested model does not exist.'];
        }
        $parent_id = $model->element->id;

        // read your posted model attributes
        $model->delete();
        return $this->redirect(Url::to(['elements/update', 'id' => $parent_id]));
    }

    public function actionUpdate($id)
    {
        // Check if there is an Editable ajax request
        $posts = Yii::$app->request->post();
        if (key_exists('hasEditable', $posts)) {
            if (key_exists('Page', $posts)) {
                $model = Page::findOne($id);
                $modelPosts = $posts['Page'];
            }
            if (key_exists('Address', $posts)) {
                $model = Address::findOne($id);
                $modelPosts = $posts['Address'];
            }
            if (key_exists('Project', $posts)) {
                $model = Project::findOne($id);
                $modelPosts = $posts['Project'];
            }
            if (key_exists('Element', $posts)) {
                $model = Element::findOne($id);
                $modelPosts = $posts['Element'];
            }

            if ($model == null) {
                return ['output' => '', 'message' => 'The requested model does not exist.'];
            }

            // read your posted model attributes
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                // read or convert your posted information
                    $value = null;
                if (key_exists('title', $modelPosts)) {
                    $value = $model->title;
                } elseif (key_exists('street', $modelPosts)) {
                    $value = $model->street;
                } elseif (key_exists('city', $modelPosts)) {
                    $value = $model->city;
                }

                // return JSON encoded output in the below format
                return ['output' => $value, 'message' => ''];

                // alternatively you can return a validation error
                // return ['output'=>'', 'message'=>'Validation error'];
            }
            // else if nothing to do always return an empty JSON encoded output
            else {
                return ['output' => '', 'message' => $model->errors];
            }
        }
        return ['output' => '', 'message' => ''];
    }

}
