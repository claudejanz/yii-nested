<?php

namespace app\controllers;

use app\controllers\base\MyController;
use app\models\forms\ContactForm;
use app\models\forms\DateForm;
use app\models\forms\LoginForm;
use app\models\forms\PasswordResetRequestForm;
use app\models\forms\ResetPasswordForm;
use app\models\search\SportifSearch;
use claudejanz\contextAccessFilter\filters\ContextFilter;
use claudejanz\toolbox\controllers\behaviors\PageBehavior;
use kartik\widgets\Alert;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;

class SiteController extends MyController
{

    public function behaviors()
    {
        return [
            'context' => [
                'class' => ContextFilter::className(),
                'only' => ['null']
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
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
                    'logout' => ['post'],
                ],
            ],
//            'negociator' => [
//                'class' => 'yii\filters\ContentNegotiator',
//                'only' => ['index'], // in a controller
//                // if in a module, use the following IDs for user actions
//                // 'only' => ['user/view', 'user/index']
//                'formats' => [
//                    'application/json' => Response::FORMAT_JSON,
//                    'text/html' => Response::FORMAT_HTML,
//                ],
//            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
//        $model = Page::find()->select('id')->andWhere(['home_page'=>1])->one(); 
//        return $this->redirect(['pages/view','id'=>$model->id]);
        if (Yii::$app->user->can('coach')) {

            $searchModel = new SportifSearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
            return $this->render('index', [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
            ]);
        } else {
            $this->redirect(['users/planning','id'=>Yii::$app->user->id]);
        }
    }

    public function actionActivity()
    {
        return $this->render('activity');
    }

    public function actionCalandar()
    {
        return $this->render('calandar');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $login = new LoginForm();
        if ($login->load(Yii::$app->request->post()) && $login->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                        'login' => $login,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goBack();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash(Alert::TYPE_SUCCESS, Yii::t('app', 'Check your email for further instructions.'));

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash(Alert::TYPE_DANGER, Yii::t('app', 'Sorry, we are unable to reset password for email provided.'));
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash(Alert::TYPE_SUCCESS, 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    public function actionSelectAs($id)
    {
        
    }

}
