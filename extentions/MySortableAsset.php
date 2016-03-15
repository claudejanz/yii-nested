<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\extentions;

use yii\web\AssetBundle;

/**
 * Description of MySortableAsset
 *
 * @author Claude
 */
class MySortableAsset extends AssetBundle
{
     public $sourcePath = '@bower/jqueryui-touch-punch';
    public $js = [
        'jquery.ui.touch-punch.min.js',
    ];
    
    public $depends = [
        'yii\jui\JuiAsset',
    ];
}
