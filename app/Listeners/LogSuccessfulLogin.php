<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * Handle the event.
     *
     * @param  UserLoggedInEvent  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $this->user->last_login = Carbon::now();
        $this->user->last_ip = \Request::getClientIp();
        $this->user->save();
    }
}
