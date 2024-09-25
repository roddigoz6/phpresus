<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Proyecto;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShareProyectoNum
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $proyectos = Proyecto::count();
        $proyectoNum = $proyectos + 1;
        View::share('proyectoNum', $proyectoNum);

        return $next($request);
    }
}
