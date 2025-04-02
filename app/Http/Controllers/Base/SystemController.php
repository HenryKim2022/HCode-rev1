<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;


class SystemController extends Controller
{
    public function maintenance()
    {
        return view('pages.userpanels.vp_syssettings');
    }


    public function toggleMaintenance()
    {
        $isDown = app()->isDownForMaintenance();
        if ($isDown) {
            Artisan::call('up'); // Bring the app back online
        } else {
            Artisan::call('down'); // Put the app in maintenance mode
        }
        return Redirect::back()->with('message', $isDown ? 'Application is now online.' : 'Application is now in maintenance mode.');
    }


    public function updateAppDebug()
    {
        $newDebugValue = request('app_debug') === 'true' ? 'true' : 'false';
        $envPath = base_path('.env');
        $envContent = File::get($envPath);
        // Replace the APP_DEBUG value
        $envContent = preg_replace('/APP_DEBUG=(.*)/', "APP_DEBUG=$newDebugValue", $envContent);
        // Save the updated content back to the .env file
        File::put($envPath, $envContent);
        // Clear the config cache to apply changes
        Artisan::call('config:clear');
        return Redirect::back()->with('message', "APP_DEBUG has been set to $newDebugValue.");
    }
}
