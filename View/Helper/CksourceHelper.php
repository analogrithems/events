<?php 
class CksourceHelper extends FormHelper {

    var $helpers = array('Html');

    function ckeditor($fieldName, $options = array()) {
        //CakePHP 1.2.4.8284
        $options = $this->_initInputField($fieldName, $options);
        //If you have probelms, try adding a second underscore to _initInputField.  I haven't tested this, but some commenters say it works.
        //$options = $this->__initInputField($fieldName, $options);
        $value = null;
        $config = null;
        $events = null;

        if (array_key_exists('value', $options)) {
            $value = $options['value'];
            if (!array_key_exists('escape', $options) || $options['escape'] !== false) {
                $value = $value;
            }
            unset($options['value']);
        }
        if (array_key_exists('config', $options)) {
            $config = $options['config'];
            unset($options['config']);
        }
        if (array_key_exists('events', $options)) {
            $events = $options['events'];
            unset($options['events']);
        }

        require_once WWW_ROOT.DS.'js'.DS.'ckeditor'.DS.'ckeditor.php';
        $CKEditor = new CKEditor();
        $CKEditor->basePath = $this->request->webroot.'js/ckeditor/';

        return $CKEditor->editor($options['name'], $value, $config, $events);
    }
}
?> 
