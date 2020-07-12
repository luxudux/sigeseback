<?php

namespace App\Http\Middleware;
use App\User;
use Carbon\Carbon;
use Closure;

class YearMiddleware
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
        
        //Este Middleware debe ponerse donde esté el prefix
        if($request->year && strlen($request->year)==4 && 
            $request->year>2018 && $request->year<=Carbon::now()->year){
            
                return $next($request);
        }
       return response()->json(['error'=>'Unauthorized'],401,[]);  
    }
}
