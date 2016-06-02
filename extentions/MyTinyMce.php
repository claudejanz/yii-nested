<?php


namespace app\extentions;

use dosamigos\tinymce\TinyMce;

/**
 * Description of MyTinyMce
 *
 * @author Claude
 */
class MyTinyMce extends TinyMce
{

    public function init()
        {

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        }

    public $_id;

    public function getId($autoGenerate = true) {
        if ($autoGenerate && $this->_id === null) {
            $this->_id = static::$autoIdPrefix . time() . static::$counter++;
        }

        return $this->_id;
}

}
