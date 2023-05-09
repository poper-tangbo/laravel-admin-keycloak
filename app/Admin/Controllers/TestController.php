<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function test(): string
    {
        return '公共访问';
    }

    public function test1(): string
    {
        return 'test1';
    }

    public function test2(): string
    {
        return 'test2';
    }
}
