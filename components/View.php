<?php

namespace components;

class View
{
    private $_default;
    private $_authorization;

    function __construct($default) {
        $this->_default = $default;
        $this->_authorization = new Authorization();
    }

    public function render($template = null, $disable_layout = false) {

        $includes = array($template);

        if (!$disable_layout) {
            array_unshift($includes, 'layout/header');
            array_push($includes, 'layout/footer');
        }

        foreach ($includes as $include) {
            $file_path = ROOT . $this->_getTemplatePath($include);
            if (file_exists($file_path)) {
                include ($file_path);
            }
        }
    }

    public function getAuth() {
        return $this->_authorization;
    }

    private function _getTemplatePath($template = null) {
        if (!$template) {
            return sprintf("/views/{$this->_default}.phtml");
        } else {
            return "/views/$template.phtml";
        }
    }
}