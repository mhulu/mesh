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
    public function home()
    {
        return view('home');
    }
    public function index()
    {
        return view('mplist');
    }
}
