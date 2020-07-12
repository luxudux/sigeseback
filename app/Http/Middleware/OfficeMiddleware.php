<?php

namespace App\Http\Middleware;
use App\OfficeUser;

use Closure;

class OfficeMiddleware
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
        if($request->year && $request->header('user-id') && $request->header('office-id')){
            
            $year=$request->year;
            $user_id=$request->header('user-id');
            $office_id=$request->header('office-id');
            //Validando que el usuario tenga acceso a la officina de la petición
            $office_user = new OfficeUser;
            $validate=$office_user->validateOffice($year,$user_id, $office_id);
            if ($validate) {
                  return $next($request);
            } 
        }
       return response()->json(['error'=>'Unauthorized'],401,[]);  
    }
}
