<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Akaunting\Setting\Facade as Setting;

class SystemController extends Controller
{
    /**
     * Display the system settings page.
     */
    public function index($message = null)
    {
        $excludedIps = Setting::get('maintenance_excluded_ips', '');
        $excludedUris = Setting::get('maintenance_excluded_uris', '');

        $pageData = [
            'excludedIps' => $excludedIps,
            'excludedUris' => $excludedUris,
            'messages' => [$message],
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
                'string',
                'regex:/^([a-zA-Z0-9\/\-_&=?]+(;[ ]*[a-zA-Z0-9\/\-_&=?]+)*[ ]*)?$/',
                function ($attribute, $value, $fail) {
                    $uris = explode(';', $value);
                    foreach ($uris as $uri) {
                        $trimmedUri = trim($uri);
                        if (!preg_match('/^\/[a-zA-Z0-9\/\-_&=?]*$/', $trimmedUri)) {
                            $fail("The {$attribute} field contains an invalid URI: '{$uri}'.");
                        }
                    }
                },
            ],
        ]);

        // Save the new settings
        Setting::set('maintenance_excluded_ips', $request->input('maintenance_excluded_ips'));
        Setting::set('maintenance_excluded_uris', $request->input('maintenance_excluded_uris'));
        Setting::save();

        // Log the update
        Log::info('Maintenance exclusions updated.', [
            'excluded_ips' => $request->input('maintenance_excluded_ips'),
            'excluded_uris' => $request->input('maintenance_excluded_uris'),
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
