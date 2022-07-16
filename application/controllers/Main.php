<?php

class MainController extends Yaf_Controller_Abstract {

    protected $_view = 'index';

    public $actions = array(
        "post" => "actions/main/PostAction.php",
    );

    public function getAction() {
        $this->getView()->appName = "magic-stone-circuit.app";
    }

}
