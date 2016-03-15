<?php

namespace app\extentions;

use dosamigos\fileupload\FileUploadUI;
/**
 * 
 */
class MyFileUploadUI extends FileUploadUI
{
   public $master;
    public function run()
    {
        echo $this->render($this->uploadTemplateView);
        echo $this->render($this->downloadTemplateView);
        echo $this->render($this->formView,['model'=>$this->master]);

        if ($this->gallery) {
            echo $this->render($this->galleryTemplateView);
        }

        $this->registerClientScript();
    }

    
} 
