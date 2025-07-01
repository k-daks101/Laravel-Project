<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\RedirectIfAuthenticated as Middleware;
use App\Providers\RouteServiceProvider;

class RedirectIfAuthenticated extends Middleware
{
    protected $redirectTo = RouteServiceProvider::HOME;
}
