<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider{

    public function register(){}

    public function boot(){
        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->header('api_token')) {
                return User::where('api_token', $request->header('api_token'))->first();
            }
        });
    }
}
