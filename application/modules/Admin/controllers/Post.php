<?php

class PostController extends Yaf_Controller_Abstract {

    public function createAction(string $name) {
        $this->getView()->appName = "magic-stone-circuit.app";
        $this->getView()->label = " by " . $name;

        $request = $this::getRequest();
        var_dump($request->getMethod());
        var_dump($request->getParams());
        var_dump($request->getBaseUri() . $request->getRequestUri());
    }
}
