<?php

$config = 'alpha'; // or 'beta'

switch ($config) {
    case 'alpha':
        $model = new SeriousHuman();
    case 'beta':
        $model = new FunnyHuman();
}

/** @var $model Human */
$model->tellMeStory();




/** code... */




interface Story {
    public function getContent();
}

class FunnyStory implements Story {

    public function getContent() {
        return ';)';
    }
}

class SeriousStory implements Story {

    public function getContent() {
        return ':-]';
    }
}




abstract class Human {

    abstract public function getStory() : Story;

    public function tellMeStory() {
        $this->getStory()->getContent();
    }
}

class FunnyHuman extends Human {

    // FACTORY METHOD is addition to other class functions
    public function getStory() : Story {
        return new FunnyStory();

        // or
        // return new SeriousStory(['level_of_serious' => 0]);
    }
}

class SeriousHuman extends Human {

    public function getStory() : Story {
        return new SeriousStory();
    }
}