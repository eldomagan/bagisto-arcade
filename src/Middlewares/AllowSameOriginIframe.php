<?php

namespace EldoMagan\BagistoArcade\Middlewares;

use Closure;

class AllowSameOriginIframe
{
    public function handle($request, Closure $next)
    {
        if ($request->inDesignMode() || $request->inPreviewMode()) {
            $response = $next($request);

            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

            return $response;
        }

        return $next($request);
    }
}
