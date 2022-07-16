<?php

class MainController extends Yaf_Controller_Abstract {

    public $actions = array(
        "post" => "actions/main/PostAction.php",
    );

    public function getAction() {
        $this->getView()->appName = "magic-stone-circuit.app";
    }

}
