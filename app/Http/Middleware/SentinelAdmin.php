<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( !Sentinel::check() )
        {
            return redirect( '/' );
        }

        if ( Sentinel::inRole( 'administrators' ) )
            return $next( $request );
        else
            return redirect( '/' );
    }
}
