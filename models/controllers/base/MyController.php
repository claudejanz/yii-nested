<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers\base;

use Yii;
use yii\web\Controller;

/**
 * Description of MyController
 *
 * @author Claude Janz <claude.janz@gmail.com>
 */
class MyController extends Controller
{

    public function init()
    {
        parent::init();
        $this->setMyAppLanguage();
    }

    private function setMyAppLanguage()
    {
        $app = Yii::$app;
        $lang = $app->params['defaultLanguage'];
        //var_dump($app->request->getQueryParams());die();
        if (!empty($app->request->getQueryParams()['language']) && array_key_exists($app->request->getQueryParams()['language'], $app->params['langsNames'])) {
            $lang = $app->params['langsNames'][$app->request->getQueryParams()['language']];
        } elseif (isset($app->session['language'])) {
            $lang = $app->session['language'];
        } elseif (isset($app->request)) {
            $preferLang = $app->request->getPreferredLanguage();
            //echo array_key_exists($prefLang, $app->params['langsNames'])."<br>";
            if (!empty($preferLang) && array_key_exists($preferLang, $app->params['langsNames'])) {
                $lang = $app->params['langsNames'][$preferLang];
            }
        } else {
            $lang = $app->params['defaultLanguage'];
        }

        //echo $lang;


        $app->session['language'] = $lang;
        $app->language = $lang;
    }

    public function render($view, $params = [])
    {
        if (Yii::$app->request->isAjax) {
            return parent::renderAjax($view, $params);
        } else {
            return parent::render($view, $params);
        }
    }

}
