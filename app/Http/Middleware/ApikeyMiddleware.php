<?php

namespace App\Http\Middleware;
use App\User;

use Closure;

class ApikeyMiddleware
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
         // $request->route()[2]['year']
        if($request->year && $request->header('user-id') && $request->header('x-api-key')){
            
            $year=$request->year;
            $user_id=$request->header('user-id');
            $api_key=$request->header('x-api-key');
            //Validando que el token corresponda a su id de usuario
            $user = new User;
            $validate=$user->validateApikey($year,$user_id,$api_key);

            if ($validate) {
                  return $next($request);
            } 
        }
       return response()->json(['error'=>'Unauthorized'],401,[]);  
    }
}
