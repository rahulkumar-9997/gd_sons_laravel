<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
class CacheController extends Controller
{
    public function clearCache(){
        try {
            Artisan::call('optimize:clear');
            return back()->with('success', 'All caches have been cleared successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to clear caches. Please try again.');
        }
    }
}
