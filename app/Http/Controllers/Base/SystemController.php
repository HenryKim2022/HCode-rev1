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

    // public function index($message = null)
    // {
    //     // Retrieve all routes and map them to their URIs
    //     $routes = collect(Route::getRoutes())->map(function ($route) {
    //         return [
    //             'uri' => $route->uri(),
    //         ];
    //     })->filter(function ($route) {
    //         // Exclude internal/default routes
    //         $excludedPrefixes = ['/', '_debugbar', 'telescope', 'horizon', 'sanctum/csrf-cookie', '_ignition'];
    //         foreach ($excludedPrefixes as $prefix) {
    //             if (Str::startsWith($route['uri'], $prefix)) {
    //                 return false; // Exclude routes that match any prefix
    //             }
    //         }
    //         return true; // Include all other routes
    //     })->unique('uri') // Ensure only unique URIs are included
    //         ->values(); // Reset keys for easier handling

    //     // Retrieve currently excluded URIs from settings
    //     $selectedUris = collect(Setting::get('maintenance_excluded_uris', ''))
    //         ->flatMap(function ($uri) {
    //             return array_map('trim', explode(';', $uri));
    //         })
    //         ->filter()
    //         ->toArray();

    //     $pageData = [
    //         'excludedIps' => Setting::get('maintenance_excluded_ips', ''),
    //         'selectedUris' => $selectedUris,
    //         'messages' => [$message],
    //         'routes' => $routes,
    //     ];

    //     return view('pages.userpanels.vp_syssettings', $pageData);
    // }



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
                'string',
                'regex:/^([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}(;[ ]*[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})*[ ]*)?$/',
                function ($attribute, $value, $fail) {
                    $ips = explode(';', $value);
                    foreach ($ips as $ip) {
                        if (!filter_var(trim($ip), FILTER_VALIDATE_IP)) {
                            $fail("The {$attribute} field contains an invalid IP address: '{$ip}'.");
                        }
                    }
                },
            ],
            'maintenance_excluded_uris' => [
                'nullable',
                'array',
            ],
        ]);

        // Convert the selected URIs array to a semicolon-separated string
        $selectedUris = implode(';', $request->input('maintenance_excluded_uris', []));

        // Save the new settings
        Setting::set('maintenance_excluded_ips', $request->input('maintenance_excluded_ips'));
        Setting::set('maintenance_excluded_uris', $selectedUris);
        Setting::save();

        // Log the update
        Log::info('Maintenance exclusions updated.', [
            'excluded_ips' => $request->input('maintenance_excluded_ips'),
            'excluded_uris' => $selectedUris,
        ]);

        // Return a JSON response
        return $this->jsonResponse(true, "Settings updated successfully.", route('index.syssettings'));
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
        Log::info('Maintenance mode toggled.', ['status' => $isDown ? 'online' : 'offline']);

        // Return a JSON response
        return $this->jsonResponse(
            true,
            $isDown ? 'Application is now online.' : 'Application is now in maintenance mode.',
            url()->previous()
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
        Log::info('APP_DEBUG updated.', ['APP_DEBUG' => $newDebugValue]);

        // Return a JSON response
        return $this->jsonResponse(
            true,
            "APP_DEBUG has been set to $newDebugValue.",
            route('index.syssettings')
        );
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
