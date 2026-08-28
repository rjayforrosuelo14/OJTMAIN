<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as LaravelAuthenticate;
use Illuminate\Http\Request;

class Authenticate extends LaravelAuthenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        $path = $request->path();

        if (str_starts_with($path, 'supervisor/')) {
            return route('supervisor.login');
        }

        if (str_starts_with($path, 'intern/')) {
            return route('intern.login');
        }

        return route('login');
    }
}
