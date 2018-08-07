<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ClearanceMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {        
        if (Auth::user()->hasPermissionTo('Administer roles & permissions')) {
            return $next($request);
        }

        if($request->is('usersian') || $request->is('usersiangrava')){
            if (!Auth::user()->hasPermissionTo('sian-senha')) {
                abort('401');
            } else {
                return $next($request);
            }
        }

        if ($request->is('posts/create')) {
            if (!Auth::user()->hasPermissionTo('Create Post')) {
                abort('401');
            } else {
                return $next($request);
            }
        }
            
        if ($request->is('posts/*/edit')) {
            if (!Auth::user()->hasPermissionTo('Edit Post')) {
                abort('401');
            } else {
                return $next($request);
            }
        }

        if($request->is('sian') or $request->is('sian/*'))
        {
            if(!Auth::user()->hasPermissionTo('Analisar'))
            {
                abort('401');
            }
            else
            {
                return $next($request);
            }
        }

        if($request->is('comparativo')){
            if(!Auth::user()->hasPermissionTo('Comparativo')){
                abort('401');
            }else{
                return $next($request);
            }
        }

        if($request->is('boleto')){
            if(!Auth::user()->hasPermissionTo('boleto')){
                abort('401');
            }else{
                return $next($request);
            }
        }

        if($request->is('apagar')){
            if(!Auth::user()->hasPermissionTo('apagar')){
                abort('401');
            }else{
                return $next($request);
            }
        }
        if($request->is('sugestao')){
            if(!Auth::user()->hasPermissionTo('sugestao')){
                abort('401');
            }else{
                return $next($request);
            }
        }

        if ($request->isMethod('Delete')) {
            if (!Auth::user()->hasPermissionTo('Delete Post')) {
                abort('401');
            } else {
                return $next($request);
            }
        }

        return $next($request);
    }
}