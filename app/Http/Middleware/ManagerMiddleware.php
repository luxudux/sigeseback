<?php

namespace App\Http\Middleware;
use App\User;

use Closure;

class ManagerMiddleware
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
         //$request->route()[2]['year']
        if($request->year && $request->header('x-api-key')){
            
            $year=$request->year;
            $api_key=$request->header('x-api-key');
            //Validate level
            $user = new User;
            $validate=$user->validateUser($year,$api_key,['Manager']);
            if ($validate) {
               return $next($request);
            } 
        }
       return response()->json(['error'=>'Unauthorized'],401,[]);  
    }
}
