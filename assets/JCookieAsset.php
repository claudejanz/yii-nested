<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Description of JCookie
 *
 * @author Claude Janz <claude.janz@gmail.com>
 */
class JCookieAsset extends AssetBundle
{
    public $language;
    public $sourcePath = '@app/assets/jquery-cookie';
    public $js = [
        'jquery.cookie.js'
    ];

    
}