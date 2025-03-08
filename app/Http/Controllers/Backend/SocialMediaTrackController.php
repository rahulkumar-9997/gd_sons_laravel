<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SocialMediaTracking;

class SocialMediaTrackController extends Controller
{
    public function socialMediaTrackList(){
        $data['social_media_track_list'] = SocialMediaTracking::orderBy('id', 'desc')->get();
        return view('backend.manage-whatsapp.social-media-track.index', compact('data'));
    }
}
