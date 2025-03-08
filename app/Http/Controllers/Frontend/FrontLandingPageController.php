<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\LandingPage;

use Illuminate\Http\Request;

class FrontLandingPageController extends Controller
{
    public function landingPage(){
        $landingPage = LandingPage::orderBy('id', 'desc')->get();
        return view('frontend.pages.landing-page.index', compact('landingPage'));
    }
    
}
