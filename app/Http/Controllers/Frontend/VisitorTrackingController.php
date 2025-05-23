<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisitorTracking;
use Jenssegers\Agent\Agent;
use Torann\GeoIP\Facades\GeoIP;
use Illuminate\Support\Facades\Log;


class VisitorTrackingController extends Controller
{
    public function trackTime(Request $request)
    {   
        $ipAddress = $request->ip();
        $browser = (new Agent())->browser();
        $pageName = $request->input('page_name');
        $location = GeoIP::getLocation($ipAddress)->city;
        $timeSpent = $request->input('time_spent');
        // Log::info('Tracking Data Received:', [
        //     'ip_address' => $ipAddress,
        //     'browser' => $browser,
        //     'page_name' => $pageName,
        //     'location' => $location,
        //     'time_spent' => $timeSpent
        // ]);
        if (!$timeSpent || !is_numeric($timeSpent)) {
            return response()->json(['error' => 'Invalid time_spent value'], 400);
        }

        // Save the tracking data
        VisitorTracking::create([
            'ip_address' => $ipAddress,
            'browser' => $browser,
            'page_name' => $pageName,
            'location' => $location,
            'time_spent' => $timeSpent,
            'visited_at' => now(),
        ]);

        return response()->json(['status' => 'success']);
    }
}
