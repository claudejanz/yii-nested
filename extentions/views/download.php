<?php

use yii\helpers\Html;


?>
<!-- The template to display files available for download -->



<script id="template-download" type="text/x-tmpl">
    
{% 
    var index = $("#projectimage-url-fileupload .template-download:not('.state-error')").length;
    
    for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
                  {% console.log();%}  
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            {% if (file.error) { %}
                <div><span class="label label-danger state-error"><?= Yii::t('app', 'Error:') ?></span> {%=file.error%}</div>
            {% }else{ %}
                 <input id="projectimage-title" class="form-control" type="text" value="{%=file.name%}" name="ProjectImage[{%=(index+i)%}][title]"></input>
                <?php 
                echo Html::beginTag('div',['class'=>'form-group']);
                echo Html::tag('label',Yii::t('app', 'Homepage'));?>
                 <input type='hidden' value='0' name='ProjectImage[{%=(index+i)%}][homepage]'>
                 <input id="projectimage-homepage" type="checkbox" value="1" name="ProjectImage[{%=(index+i)%}][homepage]"{% if (file.homepage) { %} checked{% } %}></input>
                <?php
                echo Html::endTag('div');
                echo Html::beginTag('div',['class'=>'form-group']);
                echo Html::tag('label',Yii::t('app', 'Represent'));?>
                 <input type='hidden' value='0' name='ProjectImage[{%=(index+i)%}][represent]'>
                 <input id="projectimage-represent" type="checkbox" value="1" name="ProjectImage[{%=(index+i)%}][represent]"{% if (file.represent) { %} checked{% } %}></input>
                      <?= Html::endTag('div'); ?>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span><?= Yii::t('app', 'Delete') ?></span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span><?= Yii::t('app', 'Cancel') ?></span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}

</script>
