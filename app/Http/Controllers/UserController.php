<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Star\Repositories\Eloquent\UserRepo;

class UserController extends Controller
{
    public function __construct(UserRepo $user)
    {
        $this->user = new UserRepo(\Auth::user());
    }
    public function index()
    {
        $result = $this->user->all();
        return $result;
    }
}
