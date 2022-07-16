<?php

class PostAction extends Yaf_Action_Abstract {

    public function execute() {
        $this->getView()->appName = "magic-stone-circuit.app";
    }
}