<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class AuthenticateAccess
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
        $validSecrets = explode(',',env('ADMIN_ACCEPTED_SECRETS'));
        if(in_array($request->header('Authorization'),$validSecrets)){
            return $next($request);
        }
        // $response = [
        //     'error' => 'Unauthorized',
        //     'message' => 'Administrator Only',
        //     'database' => DB::getDatabaseName(),
        //     'code' => Response::HTTP_UNAUTHORIZED
        // ];
    
        // return response()->json($response);
        abort(Response::HTTP_UNAUTHORIZED);
    }
}
