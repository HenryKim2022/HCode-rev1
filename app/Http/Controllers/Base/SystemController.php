<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Akaunting\Setting\Facade as Setting;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class SystemController extends Controller
{
    /**
     * Display the system settings page.
     */
    public function index($message = null)
    {
        // Retrieve all routes and map them to their URIs
        $routes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'uri' => $route->uri(),
            ];
        })->filter(function ($route) {
            // Exclude internal/default routes
            $excludedPrefixes = ['/', '_debugbar', 'telescope', 'horizon', 'sanctum/csrf-cookie', '_ignition'];
            foreach ($excludedPrefixes as $prefix) {
                if (Str::startsWith($route['uri'], $prefix)) {
                    return false; // Exclude routes that match any prefix
                }
            }
            return true; // Include all other routes
        })->unique('uri') // Ensure only unique URIs are included
            ->values(); // Reset keys for easier handling
        // Retrieve currently excluded URIs from settings
        $selectedUris = collect(Setting::get('maintenance_excluded_uris', ''))
            ->flatMap(function ($uri) {
                return array_map('trim', explode(';', $uri));
            })
            ->filter()
            ->toArray();
        // Combine routes and selected URIs into a single collection
        $allUris = collect($routes)->pluck('uri')
            ->merge($selectedUris)
            ->unique() // Ensure uniqueness
            ->values(); // Reset keys for easier handling
        $pageData = [
            'excludedIps' => Setting::get('maintenance_excluded_ips', ''),
            'selectedUris' => $selectedUris,
            // 'laravelLogs' => $this->fetchLogs(),
            'messages' => [$message],
            'routes' => $allUris, // Pass the combined URIs to the view
        ];
        return view('pages.userpanels.vp_syssettings', $pageData);
    }


    /**
     * Update maintenance exclusions (IPs and URIs).
     */
    public function update(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'maintenance_excluded_ips' => [
                'nullable',
                'array',
            ],
            'maintenance_excluded_uris' => [
                'nullable',
                'array',
            ],
        ]);

        // Convert the selected IPs array to a semicolon-separated string
        $selectedIps = implode(';', $request->input('maintenance_excluded_ips', []));

        // Convert the selected URIs array to a semicolon-separated string
        $selectedUris = implode(';', $request->input('maintenance_excluded_uris', []));

        // Save the new settings
        Setting::set('maintenance_excluded_ips', $selectedIps);
        Setting::set('maintenance_excluded_uris', $selectedUris);
        Setting::save();

        // Log the update
        if (config('app.logging_enabled')) {
            Log::info('Maintenance exclusions updated.', [
                'excluded_ips' => $selectedIps,
                'excluded_uris' => $selectedUris,
            ]);
        }

        // Return a JSON response
        return $this->jsonResponse(true, "Settings updated successfully.", route('index.syssettings'));
    }




    /**
     * Save a new IP option to the backend.
     */
    public function saveTypedIp(Request $request)
    {
        $validated = $request->validate([
            'newIp' => [
                'required',
                'string',
                'regex:/^([0-9]{1,3}\.){3}[0-9]{1,3}$/',
            ],
        ]);

        $existingIps = collect(Setting::get('maintenance_excluded_ips', ''))
            ->flatMap(function ($ip) {
                return array_map('trim', explode(';', $ip));
            })
            ->filter()
            ->toArray();

        if (in_array($validated['newIp'], $existingIps)) {
            return response()->json([
                'success' => false,
                'message' => 'The IP already exists.',
            ], 409); // 409 Conflict
        }

        $updatedIps = implode(';', array_merge($existingIps, [$validated['newIp']]));
        Setting::set('maintenance_excluded_ips', $updatedIps);
        Setting::save();

        return response()->json([
            'success' => true,
            'message' => 'New IP added successfully.',
        ]);
    }




    /**
     * Save a new URI option to the backend.
     */
    public function saveTypedUri(Request $request)
    {
        $validated = $request->validate([
            'newUri' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9\-_\/]+$/',
            ],
        ]);
        $existingUris = collect(Setting::get('maintenance_excluded_uris', ''))
            ->flatMap(function ($uri) {
                return array_map('trim', explode(';', $uri));
            })
            ->filter()
            ->toArray();
        if (in_array($validated['newUri'], $existingUris)) {
            return response()->json([
                'success' => false,
                'message' => 'The URI already exists.',
            ], 409); // 409 Conflict
        }
        $updatedUris = implode(';', array_merge($existingUris, [$validated['newUri']]));
        Setting::set('maintenance_excluded_uris', $updatedUris);
        Setting::save();
        return response()->json([
            'success' => true,
            'message' => 'New URI added successfully.',
        ]);
    }



    /**
     * Toggle maintenance mode.
     */
    public function toggleMaintenance()
    {
        $isDown = app()->isDownForMaintenance();
        if ($isDown) {
            Artisan::call('up'); // Bring the app back online
        } else {
            Artisan::call('down'); // Put the app in maintenance mode
        }

        // Log the toggle action
        if (config('app.logging_enabled')) {
            Log::info('Maintenance mode toggled.', ['status' => $isDown ? 'online' : 'offline']);
        }

        // Return a JSON response
        return $this->jsonResponse(
            true,
            $isDown ? 'Application is now online.' : 'Application is now in maintenance mode.',
            url()->previous() // Redirect back to the previous page
        );
    }



    /**
     * Toggle debugging mode by updating APP_DEBUG in .env.
     */
    public function toggleDebug()
    {
        // Get the new debug value from the request
        $newDebugValue = request('app_debug') === 'true' ? 'true' : 'false';

        // Update the .env file
        $this->setEnv('APP_DEBUG', $newDebugValue);

        // Clear the config cache to apply changes
        Artisan::call('config:clear');

        // Log the toggle action
        if (config('app.logging_enabled')) {
            Log::info('APP_DEBUG updated.', ['APP_DEBUG' => $newDebugValue]);
        }

        // Return a JSON response
        return $this->jsonResponse(
            true,
            "APP_DEBUG has been set to $newDebugValue.",
            route('index.syssettings') // Redirect back to the settings page
        );
    }




    /**
     * Toggle logging mode by updating APP_DEBUG in .env.
     */
    public function toggleLogging()
    {
        // Get the new debug value from the request
        $newLoggingValue = request('app_logging') === 'true' ? 'true' : 'false';

        // Update the .env file
        $this->setEnv('LOGGING_ENABLED', $newLoggingValue);

        // Clear the config cache to apply changes
        Artisan::call('config:clear');

        // Log the toggle action
        if (config('app.logging_enabled')) {
            Log::info('LOGGING_ENABLED updated.', ['LOGGING_ENABLED' => $newLoggingValue]);
        }

        // Return a JSON response
        return $this->jsonResponse(
            true,
            "LOGGING_ENABLED has been set to $newLoggingValue.",
            route('index.syssettings') // Redirect back to the settings page
        );
    }


    /**
     * Fetch and display logs.
     */
    public function fetchLogs()
    {
        // Path to the logs directory
        $logPath = storage_path('logs');

        // Get all log files (sorted by modification time, newest first)
        $logFiles = collect(File::glob($logPath . '/*.log'))
            ->sortByDesc(fn($file) => File::lastModified($file));

        // Read the latest log file(s)
        $logs = [];
        foreach ($logFiles as $file) {
            $fileName = basename($file);
            $logs[$fileName] = $this->parseLogFile($file);
        }

        return $logs;
    }

    /**
     * Helper method to parse a log file.
     */
    private function parseLogFile($filePath)
    {
        $content = File::get($filePath);
        $lines = explode(PHP_EOL, $content);
        $lines = array_slice($lines, -50);

        $parsedLogs = [];
        foreach ($lines as $line) {
            if (preg_match('/^\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]/', $line)) {
                $parsedLogs[] = htmlspecialchars($line, ENT_QUOTES, 'UTF-8');
            } else {
                if (!empty($parsedLogs)) {
                    $parsedLogs[count($parsedLogs) - 1] .= "\n" . htmlspecialchars($line, ENT_QUOTES, 'UTF-8');
                }
            }
        }
        return $parsedLogs;
    }

    /**
     * Toggle refresh UI logs via AJAX.
     */
    public function toggleRefreshLog()
    {
        // Fetch logs
        $logs = $this->fetchLogs();

        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Logs refreshed successfully.',
            'logs' => $logs,
        ]);
    }



    /**
     * Clear all log files.
     */
    public function toggleClearLog()
    {
        $logPath = storage_path('logs');
        $logFiles = File::glob($logPath . '/*.log');

        foreach ($logFiles as $file) {
            if (!File::delete($file)) {
                return response()->json([
                    'success' => false,
                    'message' => "Failed to delete log file: " . basename($file),
                ], 500);
            }
        }

        if (config('app.logging_enabled')) {
            Log::info('All log files have been cleared.');
        }

        return response()->json([
            'success' => true,
            'message' => 'All logs have been cleared successfully.',
        ]);
    }


    /**
     * Helper method to update the .env file.
     */
    private function setEnv($key, $value)
    {
        $path = base_path('.env');
        if (!File::exists($path)) {
            throw new \Exception("The .env file does not exist at path: {$path}");
        }
        $content = File::get($path);
        if (preg_match("/^{$key}=.*/m", $content)) {
            $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
        } else {
            $content .= "\n{$key}={$value}";
        }
        if (!File::put($path, $content)) {
            throw new \Exception("Failed to update the .env file at path: {$path}");
        }
    }





    /**
     * Clear application cache.
     */
    public function clearAppCache()
    {
        try {
            Artisan::call('cache:clear');
            return $this->jsonResponse(true, 'Application cache cleared successfully.');
        } catch (\Exception $e) {
            return $this->jsonResponse(false, 'Failed to clear application cache.');
        }
    }

    /**
     * Clear configuration cache.
     */
    public function clearConfigCache()
    {
        try {
            Artisan::call('config:clear');
            return $this->jsonResponse(true, 'Configuration cache cleared successfully.');
        } catch (\Exception $e) {
            return $this->jsonResponse(false, 'Failed to clear configuration cache.');
        }
    }

    /**
     * Clear route cache.
     */
    public function clearRouteCache()
    {
        try {
            Artisan::call('route:clear');
            return $this->jsonResponse(true, 'Route cache cleared successfully.');
        } catch (\Exception $e) {
            return $this->jsonResponse(false, 'Failed to clear route cache.');
        }
    }

    /**
     * Clear view cache.
     */
    public function clearViewCache()
    {
        try {
            Artisan::call('view:clear');
            return $this->jsonResponse(true, 'View cache cleared successfully.');
        } catch (\Exception $e) {
            return $this->jsonResponse(false, 'Failed to clear view cache.');
        }
    }






    /**
     * Centralized JSON response helper method.
     */
    private function jsonResponse($success, $message, $redirect = null)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'redirect' => $redirect,
        ]);
    }
}
