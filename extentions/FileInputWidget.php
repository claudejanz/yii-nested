<?php

namespace app\extentions;

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/*
 * Copyright (C) 2014 Claude Janz <claude.janz@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Description of FileInputWidget
 *
 * @author Claude Janz <claude.janz@gmail.com>
 */
class FileInputWidget extends InputWidget {

    /**
     * @var array the HTML attributes for the input tag.
     */
    public $options ;

    public function init() {
        parent::init();
        $this->options['pluginOptions']['showUpload']=false;
        if(isset($this->model->imagePreviewHtml)){
            $this->options['pluginOptions']['initialPreview']=[$this->model->imagePreviewHtml];
        }
        if(isset($this->model->imageName)){
            $this->options['pluginOptions']['initialCaption']=[$this->model->imageName];
        }
        $this->options['model']=$this->model;
        $this->options['attribute']=$this->attribute;
        
    }
    
    

    public function run() {
//    
        echo FileInput::widget($this->options);
        echo Html::activeHiddenInput($this->model, $this->attribute . '_delete');

        $js = "$('#".$this->options['id']."').each(function(){
            $(this).closest('.input-group-btn').find('.fileinput-remove-button').on('click',function(event){
            $('#".$this->options['id']."_delete').val(1);
              
            });
               
        })";
        $this->view->registerJs($js . '');
    }

}
