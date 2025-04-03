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
        parent::__construct($app); // Call the parent constructor

        // Default URI exclusions
        $default_excluded_uris = [
            'lang/*',
            '/system/settings',
            '/system/update-maintenance-exclusion',
            '/system/toggle-maintenance',
            '/system/toggle-debug',
        ];

        // Retrieve excluded URIs from settings and split by semicolons
        $urls_allowed = collect(Setting::get('maintenance_excluded_uris', ''))
            ->flatMap(function ($uri) {
                return array_map('trim', explode(';', $uri)); // Split by semicolon and trim each value
            })
            ->filter() // Remove empty values
            ->toArray();

        // Merge default exclusions with user-defined exclusions
        $urls_allowed = array_merge($default_excluded_uris, $urls_allowed);

        // Retrieve excluded IPs from settings and split by semicolons
        $ips_allowed = collect(Setting::get('maintenance_excluded_ips', ''))
            ->flatMap(function ($ip) {
                return array_map('trim', explode(';', $ip)); // Split by semicolon and trim each value
            })
            ->filter() // Remove empty values
            ->toArray();

        // Automatically exclude backend prefix (if configured in config file)
        if (config('mycustomconfig.backend_prefix')) {
            $this->except[] = '/' . trim(config('mycustomconfig.backend_prefix'), '/') . '*';
        }

        // Merge excluded URIs into the $except array
        $this->except = array_merge($this->except, $urls_allowed);

        // Store excluded IPs in a separate property
        $this->excluded_ips = $ips_allowed;

        // Log exclusions for debugging
        Log::info('Maintenance Mode Exclusions', [
            'except' => $this->except,
            'excluded_ips' => $this->excluded_ips,
        ]);
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
        // Log request IP and exclusion status
        Log::info('Request IP Check', [
            'request_ip' => $request->ip(),
            'excluded_ips' => $this->excluded_ips,
            'is_excluded' => $this->inExceptIpArray($request),
        ]);

        // Check if the application is in maintenance mode
        if ($this->app->isDownForMaintenance()) {
            // Allow requests if they match excluded URIs or IPs
            if ($this->inExceptArray($request) || $this->inExceptIpArray($request)) {
                return $next($request);
            }

            // Throw a 503 error for all other requests
            throw new HttpException(503);
        }

        // If not in maintenance mode, proceed normally
        return $next($request);
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
