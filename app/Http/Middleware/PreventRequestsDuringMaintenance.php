<?php

namespace App\Http\Middleware;

use Akaunting\Setting\Facade as Setting;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PreventRequestsDuringMaintenance extends \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance
{
    /**
     * Custom Allowed IP's
     * @var array
     */
    protected $excluded_ips = [];

    /**
     * Create a new middleware instance.
     *
     * @param Application $app
     * @return void
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);

        // Default URI exclusions
        $default_excluded_uris = [
            '/reset', // Reset password
            'public/temp', // Public temp files
            'public/template/*', // Public templates
            'lang/*', // Language routes
            'logout', // Logout route
            '/system/*', // System settings

        ];

        // Retrieve excluded URIs from settings and split by semicolons
        $urls_allowed = collect(Setting::get('maintenance_excluded_uris', ''))
            ->flatMap(function ($uri) {
                return array_map('trim', explode(';', $uri));
            })
            ->filter()
            ->toArray();

        // Merge default exclusions with user-defined exclusions
        $urls_allowed = array_merge($default_excluded_uris, $urls_allowed);

        // Automatically exclude backend prefix (if configured in config file)
        if (config('mycustomconfig.backend_prefix')) {
            $urls_allowed[] = '/' . trim(config('mycustomconfig.backend_prefix'), '/') . '*';
        }

        // Merge excluded URIs into the $except array
        $this->except = array_merge($this->except, $urls_allowed);

        // Store excluded IPs in a separate property
        $this->excluded_ips = collect(Setting::get('maintenance_excluded_ips', ''))
            ->flatMap(function ($ip) {
                return array_map('trim', explode(';', $ip));
            })
            ->filter()
            ->toArray();

        // Log exclusions for debugging
        if (config('app.logging_enabled')) {
            Log::info('Maintenance Mode Exclusions', [
                'except' => $this->except,
                'excluded_ips' => $this->excluded_ips,
            ]);
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Log request details for debugging
        if (config('app.logging_enabled')) {
            Log::info('Request Details', [
                'uri' => $request->getPathInfo(),
                'ip' => $request->ip(),
                'isDownForMaintenance' => $this->app->isDownForMaintenance(),
                'isExcludedUri' => $this->inExceptArray($request),
                'isExcludedIp' => $this->inExceptIpArray($request),
            ]);
        }

        // If maintenance mode is off, proceed normally
        if (!$this->app->isDownForMaintenance()) {
            return $next($request);
        }

        // Allow requests if they match excluded URIs or IPs
        if ($this->inExceptArray($request) || $this->inExceptIpArray($request)) {
            return $next($request);
        }

        // Throw a 503 error for all other requests
        throw new HttpException(503);
    }

    /**
     * Check if the request IP is in the excluded IPs array.
     *
     * @param Request $request
     * @return bool
     */
    private function inExceptIpArray($request)
    {
        if (empty($this->excluded_ips)) {
            return false;
        }

        foreach ($this->excluded_ips as $ip) {
            // Validate the IP and check if it matches the request IP
            if (filter_var($ip, FILTER_VALIDATE_IP) && IpUtils::checkIp($request->ip(), $ip)) {
                return true;
            }
        }

        return false;
    }
}
