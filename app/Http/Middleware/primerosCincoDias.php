<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class primerosCincoDias
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
        /*
        $hoy = Carbon::now()->format('d');

        if($hoy == '01' || $hoy == '02' || $hoy == '03' || $hoy == '04' || $hoy == '05'){
            return $next($request);
        }else{
            return back()->with('danger', 'solo se pueden solicitar retiros los primeros 5 dias de cada mes.');
        }
        */
    }
}
