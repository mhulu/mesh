<?php

namespace Star\Permission;

use App\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/database' => database_path('migrations')
            ], 'migrations');
        /**
         * When new user registering, if not 'admin' (default seeder generated),automatic assign 'user' role.
         */
        // User::created(function($user){
        //     if($user->roles->count() == 0 && $user->name !== 'admin')
        //     {
        //         $user->assignRole('user');
        //     }
        // });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPack();
    }


    private function registerPack()
    {
        $this->app->bind('Permission',function($app){
            return new Permission($app);
        });

        $this->app->alias('Permission', 'Star\Permission');
    }

}