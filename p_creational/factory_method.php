<?php

$config = 'alpha';

switch ($config) {
    case 'alpha':
        $model = new SeriousHuman();
    case 'beta':
        $model = new FunnyHuman();
}

/** @var $model Human */
$model->tellMeStory(); // client code based on factory method




/** code... */

abstract class Human {

    abstract public function getStory(): Story;

    public function tellMeStory() {
        $this->getStory()->getContent();
    }
}

class FunnyHuman extends Human {

    // FACTORY METHOD is addition to some class methods
    public function getStory() : Story {
        return new FunnyStory();

        // or
        // return new SeriousStory(['level_of_serious' => 0]);
    }
}

class SeriousHuman extends Human {

    // FACTORY METHOD
    public function getStory(): Story {
        return new SeriousStory();
    }
}




interface Story {
    public function getContent();
}

class FunnyStory implements Story {

    public function getContent(): string {
        return ';)';
    }
}

class SeriousStory implements Story {

    public function getContent(): string {
        return ':-]';
    }
}
