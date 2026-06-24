<?php

namespace App\Http\Middleware;

use App\Services\SeoMetaService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplySeoMeta
{
    public function __construct(protected SeoMetaService $seo) {}

    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()?->getName();

        if ($routeName) {
            $this->seo->applyForRoute($routeName);
        }

        return $next($request);
    }
}
