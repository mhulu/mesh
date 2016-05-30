<?php

namespace App\Http\Controllers\God;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    public function index()
    {
        return view('god.app');
    }
}
