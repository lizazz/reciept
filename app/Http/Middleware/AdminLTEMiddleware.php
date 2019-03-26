<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class AdminLTEMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $requestmenu)
    {
        $adminLTEMenu = Config::get('adminlte.menu');
        $activemenus = [];

        foreach ($adminLTEMenu as $menu) {
            if(isset($menu['submenu']) && is_array($menu['submenu'])) {
                foreach ($menu['submenu'] as $submenu) {
                    if(isset($submenu['text'])) {
                        $activemenus[] = strtolower($submenu['text']);
                    }
                }
            } elseif(isset($menu['text'])) {
                $activemenus[] = strtolower($menu['text']);
            }
        }

        if(!in_array(strtolower($requestmenu), $activemenus)) {
            return redirect(route('adminLogin'));
        }

        return $next($request);
    }
}
