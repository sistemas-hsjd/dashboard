<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $directives = [
            'default-src' => ["'self'"],
            // Existing Blade event handlers still require inline scripts.
            'script-src' => ["'self'", "'unsafe-inline'"],
            'style-src' => ["'self'", "'unsafe-inline'", 'https://fonts.googleapis.com'],
            'img-src' => ["'self'", 'data:', 'blob:'],
            'font-src' => ["'self'", 'data:', 'https://fonts.gstatic.com'],
            'connect-src' => ["'self'"],
            'object-src' => ["'none'"],
            'base-uri' => ["'self'"],
            'form-action' => ["'self'"],
            'frame-ancestors' => ["'self'"],
        ];

        // Allow only the configured Vite development server, and only locally.
        if (app()->environment('local') && is_file(public_path('hot'))) {
            $url = parse_url(trim(file_get_contents(public_path('hot'))));
            if ($url && isset($url['scheme'], $url['host']) && in_array($url['scheme'], ['http', 'https'], true)) {
                $host = $url['host'].(isset($url['port']) ? ':'.$url['port'] : '');
                $origin = $url['scheme'].'://'.$host;
                $directives['script-src'][] = $origin;
                $directives['style-src'][] = $origin;
                $directives['connect-src'][] = $origin;
                $directives['connect-src'][] = ($url['scheme'] === 'https' ? 'wss' : 'ws').'://'.$host;
            }
        }

        $policy = collect($directives)->map(fn ($sources, $directive) => $directive.' '.implode(' ', $sources))->implode('; ');
        $response->headers->set('Content-Security-Policy', $policy);
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        return $response;
    }
}
