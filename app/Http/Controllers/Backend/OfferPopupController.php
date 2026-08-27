<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\OfferPopup;
use Illuminate\Http\Request;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OfferPopupController extends Controller
{
    public function index()
    {
        $popups = OfferPopup::latest()->paginate(15);
        return view('backend.offer-popups.index', compact('popups'));
    }

    public function create()
    {
        return view('backend.offer-popups.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         => 'nullable|string|max:255',
            'desktop_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'mobile_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'redirect_url'  => 'nullable|string|max:255',
            'starts_at'     => 'nullable|date',
            'ends_at'       => 'nullable|date|after_or_equal:starts_at',
        ]);

        $fileName = ImageHelper::generateFileName($data['title'] ?? 'offer');
        $desktopImage = null;
        if ($request->hasFile('desktop_image')) {
            $desktopImage = ImageHelper::uploadSingleImageWebpOnly(
                $request->file('desktop_image'), 
                $fileName,
                'offer'
            );
        }
        $mobileImage = null;
        if ($request->hasFile('mobile_image')) {
            $mobileImage = ImageHelper::uploadSingleImageWebpOnly(
                $request->file('mobile_image'),
                $fileName, 
                'offer'
            );
        }

        $data['desktop_image'] = $desktopImage;
        $data['mobile_image']  = $mobileImage;
        $data['is_active']     = $request->boolean('is_active');
        DB::beginTransaction();
        try {
            OfferPopup::create($data);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            ImageHelper::deleteSingleImage($desktopImage, 'offer');
            ImageHelper::deleteSingleImage($mobileImage, 'offer');
            return back()->with('error', 'Something went wrong while saving. Please try again.')->withInput();
        }
        return redirect()->route('offer-popups.index')->with('success', 'Offer popup added.');
    }

    public function edit(OfferPopup $offerPopup)
    {
        return view('backend.offer-popups.edit', compact('offerPopup'));
    }

    public function update(Request $request, OfferPopup $offerPopup)
    {
        $data = $request->validate([
            'title'         => 'nullable|string|max:255',
            'desktop_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'mobile_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'redirect_url'  => 'nullable|string|max:255',
            'starts_at'     => 'nullable|date',
            'ends_at'       => 'nullable|date|after_or_equal:starts_at',
        ]);

        $fileName = ImageHelper::generateFileName($data['title'] ?? 'offer');

        $oldDesktopImage = $offerPopup->desktop_image;
        $oldMobileImage  = $offerPopup->mobile_image;
        $newDesktopImage = null;
        $newMobileImage  = null;

        if ($request->hasFile('desktop_image')) {
            $newDesktopImage = ImageHelper::uploadSingleImageWebpOnly(
                $request->file('desktop_image'), $fileName . '-desktop', 'offer'
            );
            $data['desktop_image'] = $newDesktopImage;
        }

        if ($request->hasFile('mobile_image')) {
            $newMobileImage = ImageHelper::uploadSingleImageWebpOnly(
                $request->file('mobile_image'), $fileName . '-mobile', 'offer'
            );
            $data['mobile_image'] = $newMobileImage;
        }

        $data['is_active'] = $request->boolean('is_active');
        DB::beginTransaction();
        try {
            $offerPopup->update($data);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            if ($newDesktopImage) ImageHelper::deleteSingleImage($newDesktopImage, 'offer');
            if ($newMobileImage)  ImageHelper::deleteSingleImage($newMobileImage, 'offer');
            return back()->with('error', 'Something went wrong while updating. Please try again.')->withInput();
        }
        if ($newDesktopImage && $oldDesktopImage) ImageHelper::deleteSingleImage($oldDesktopImage, 'offer');
        if ($newMobileImage && $oldMobileImage)   ImageHelper::deleteSingleImage($oldMobileImage, 'offer');
        return redirect()->route('offer-popups.index')->with('success', 'Offer popup updated.');
    }

    public function destroy(OfferPopup $offerPopup)
    {
        $desktopImage = $offerPopup->desktop_image;
        $mobileImage  = $offerPopup->mobile_image;
        DB::beginTransaction();
        try {
            $offerPopup->delete();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong while deleting.');
        }
        ImageHelper::deleteSingleImage($desktopImage, 'offer');
        ImageHelper::deleteSingleImage($mobileImage, 'offer');
        return back()->with('success', 'Offer popup deleted.');
    }

    public function toggleStatus(OfferPopup $offerPopup)
    {
        $offerPopup->is_active = ! $offerPopup->is_active;
        $offerPopup->save();
        return response()->json([
            'success'   => true,
            'is_active' => $offerPopup->is_active,
            'message'   => 'Offer popup marked as ' . ($offerPopup->is_active ? 'Active' : 'Inactive') . '.',
        ]);
    }
}