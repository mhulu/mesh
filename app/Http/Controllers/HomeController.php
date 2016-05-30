<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Star\Repositories\Eloquent\UserRepo;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(empty($parmes)){
            dd('error');
        }
        return view('home');
    }
    public function mplist()
    {
        return view('mplist');
    }
}
