<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;

class Test2Controller extends AdminController
{
    public function index(Content $content)
    {
        return $content->title('test2');
    }
}
