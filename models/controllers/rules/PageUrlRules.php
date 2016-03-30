<?php

namespace app\controllers\rules;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductUrlRules
 *
 * @author Claude Janz <claude.janz@gmail.com>
 */
use Yii;
use yii\caching\DbDependency;
use yii\db\Query;
use yii\web\UrlRule;

class PageUrlRules extends UrlRule {

    public $connectionID = 'db';

    public function init() {
        if ($this->name === null) {
            $this->name = __CLASS__;
        }
    }

    public function createUrl($manager, $route, $params) {
        
        if ($route === 'pages/view') {
            if (isset($params['id'])) {
                //var_dump($params);
                $language = isset($params['language']) ? $params['language'] : Yii::$app->language;
                $query = new Query();
                $query->select('slug')->from('page_lang')->where(['language' => $language, 'page_id' => $params['id']]);
                $slug = $query->createCommand()->queryScalar();
                unset($params['id']);
                unset($params['language']);
                if (!empty($params))
                    return $slug . '?' . http_build_query($params);
                return $slug;
            }
        }else {
            $routeArray = preg_split('/\//', $route, -1, PREG_SPLIT_NO_EMPTY);
            $language = isset($params['language']) ? $params['language'] : Yii::$app->language;
            
            $query = new Query();
            $query->select('page_lang.slug')->from('page')->where(['controller' => $routeArray[0], 'action' => $routeArray[1], 'language' => $language])->leftJoin('page_lang', 'page.id = page_lang.page_id');
            $slug = $query->createCommand()->queryScalar();
            if ($slug) {

                unset($params['language']);
                if (!empty($params))
                    return $slug . '?' . http_build_query($params);
                return $slug;
            }
        }

        return false;  // this rule does not apply
    }

    public function parseRequest($manager, $request) {
        $pathInfo = $request->getPathInfo();
        if (preg_match('%^([\w-]+)(/([\w-]+))?$%', $pathInfo, $matches)) {
            // check $matches[1] and $matches[3] to see
            // if they match a manufacturer and a model in the database
            // If so, set $params['manufacturer'] and/or $params['model']
            // and return ['car/index', $params]
//           
            if (in_array($matches[1], Yii::$app->params['langsNames'])) {
                $res = (new Query())->select(['page.id', 'language', 'controller', 'action'])->from('page')->leftJoin('page_lang', 'page.id = page_lang.page_id')->where(['page_lang.slug' => $matches[0]])->one();
                if ($res) {
                    $params = $request->getQueryParams();
                    if ($res['controller'] == 'pages' && $res['action'] == 'view') {
                        $params['id'] = $res['id'];
                        $request->setQueryParams($params);
                    }
                    if (!isset($params['language'])) {
                        $params['language'] = $res['language'];
                        $request->setQueryParams($params);
                    }
                    return [$res['controller'] . '/' . $res['action'], $params];
                }
            }
        }
        return false;  // this rule does not apply
    }

}
