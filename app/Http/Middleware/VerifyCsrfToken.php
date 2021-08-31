<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Closure;
use Auth;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];


    public function handle($request, Closure $next)
    {
        if($request->route()->named('logout')) {
        
            $this->except[] = route('logout');
            
        }
        if($request->route()->named('login')) {
        
            $this->except[] = route('login');
            
        }
        
        return parent::handle($request, $next);
    }
}
