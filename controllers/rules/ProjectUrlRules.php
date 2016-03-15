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

use yii\db\Query;
use yii\web\UrlRule;

class ProjectUrlRules extends UrlRule
{

    public $connectionID = 'db';

    public function init()
    {
        if ($this->name === null) {
            $this->name = __CLASS__;
        }
    }

    public function createUrl($manager, $route, $params)
    {

        if ($route === 'projects/view') {
            if (isset($params['id'])) {
                //var_dump($params);
                $query = new Query();
                $query->select('slug')->from('project')->where(['id' => $params['id']]);
                $slug = $query->createCommand()->queryScalar();
                unset($params['id']);
                if (!empty($params))
                    return 'projet/'.$slug . '?' . http_build_query($params);
                return 'projet/'.$slug;
            }
        }

        return false;  // this rule does not apply
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        if (preg_match('%^projet/([\w-]+)?$%', $pathInfo, $matches)) {
            // check $matches[1] and $matches[3] to see
            // if they match a manufacturer and a model in the database
            // If so, set $params['manufacturer'] and/or $params['model']
            // and return ['car/index', $params]
//           
            $res = (new Query())->select(['id'])->from('project')->where(['slug' => $matches[1]])->one();
            if ($res) {
                $params = $request->getQueryParams();
                $params['id'] = $res['id'];
                $request->setQueryParams($params);

                return ['projects/view', $params];
            }
        }
        return false;  // this rule does not apply
    }

}
