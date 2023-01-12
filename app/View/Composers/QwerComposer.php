<?php

namespace App\View\Composers;

use Illuminate\View\View;

class QwerComposer
{
    public function compose(View $view) {
        $view->with('qwerComposer', 'the End');
    }
}
