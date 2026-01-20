<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisit
{
    private const TRACKABLE_ROUTES = [
        'home',
        'page.show',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->method() !== 'GET') {
            return $response;
        }

        $routeName = $request->route()?->getName();
        if (!$routeName || !in_array($routeName, self::TRACKABLE_ROUTES, true)) {
            return $response;
        }

        if ($request->user()) {
            return $response;
        }

        $userAgent = (string) $request->userAgent();
        if ($userAgent && preg_match('/bot|crawl|spider|slurp/i', $userAgent)) {
            return $response;
        }

        $sessionKey = 'visit_logged_' . md5($request->path());
        $lastLogged = $request->session()->get($sessionKey);
        if ($lastLogged) {
            $lastLoggedAt = Carbon::parse($lastLogged);
            if ($lastLoggedAt->diffInMinutes(now()) < 30) {
                return $response;
            }
        }

        $referer = $request->headers->get('referer');
        $refererHost = null;
        if ($referer) {
            $refererHost = parse_url($referer, PHP_URL_HOST);
        }

        Visit::create([
            'visited_at' => now(),
            'path' => '/' . ltrim($request->path(), '/'),
            'referrer_host' => $refererHost,
            'referrer_url' => $referer,
            'utm_source' => $request->query('utm_source'),
            'utm_medium' => $request->query('utm_medium'),
            'utm_campaign' => $request->query('utm_campaign'),
            'user_agent' => $userAgent ?: null,
        ]);

        $request->session()->put($sessionKey, now()->toIso8601String());

        return $response;
    }
}
