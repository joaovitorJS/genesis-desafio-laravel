<?php

namespace App\Http\Middleware;

use Closure;

class ApiAutenticacao
{
    public function handle($request, Closure $next, $api)
    {
        $api_token = $request->query('api_token');
        //veirifica se api é do tipo tutorial para entrar no laço
        if ($api == 'tutorial' && $api_token == env('API_KEY')){
            return $next($request);
        }
        return response()->json('Sem autorização.', 401);
    }
}
