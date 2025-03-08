<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vendors;

class VendorController extends Controller
{
    public function index(Request $request){
        $data['vendor_list'] = Vendors::orderBy('id','DESC')->paginate(20);
        if ($request->ajax()) {
            return view('backend.manage-purchase.manage-vendor.partials.vendor_list_table', compact('data'))->render();
        } 
        //return response()->json($data['vendor_list']);
        return view('backend.manage-purchase.manage-vendor.index', compact('data'));
    }

    public function create(Request $request){
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        
        $form ='
        <div class="modal-body">
            <form method="POST" accept-charset="UTF-8" enctype="multipart/form-data" id="vendorForm"  data-url="'.route('manage-vendor.store').'">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="vendor_name" class="form-label">Vendor Name *</label>
                            <input type="text" id="vendor_name" name="vendor_name" class="form-control">
                            <span class="text-danger error-text vendor_name_error"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="location" class="form-label">Location *</label>
                            <textarea class="form-control" id="location" rows="2" name="location"></textarea>
                            <span class="text-danger error-text location_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="gst_no" class="form-label">GST No.</label>
                            <input type="text" id="gst_no" name="gst_no" class="form-control" >
                            <span class="text-danger error-text gst_no_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone_no" class="form-label">Pnone No.</label>
                            <input type="text" id="phone_no" name="phone_no" class="form-control" >
                             <span class="text-danger error-text phone_no_error"></span>
                        </div>
                    </div>
                    
                    
                    <div class="modal-footer pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="spinner-border spinner-border-sm d-none" id="loadingSpinner" role="status" aria-hidden="true"></span>
                            Save changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
        ';
        return response()->json([
            'message' => 'Vendor Form created successfully',
            'form' => $form,
        ]);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'vendor_name' => 'required|string|max:255',
            'location' => 'required|string',
            'gst_no' => 'nullable|digits:15',
            'phone_no' => 'nullable|digits:10',
        ]);
        try {
            Vendors::create([
                'vendor_name' => $validatedData['vendor_name'],
                'location' => $validatedData['location'],
                'gst_no' => $validatedData['gst_no'],
                'contact_no' => $validatedData['phone_no'],
            ]);
            return response()->json([
                'message' => 'Vendor saved successfully!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while saving the vendor.',
            ], 500);
        }
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'vendor_name' => 'required|string|max:255',
            'vendor_location' => 'required|string',
            'vendor_gst_no' => 'nullable|digits:15',
            'vendor_contact_no' => 'nullable|digits:10',
        ]);
        try {
            $vendor = Vendors::findOrFail($id);
            $vendor->update([
                'vendor_name' => $validatedData['vendor_name'],
                'location' => $validatedData['vendor_location'],
                'gst_no' => $validatedData['vendor_gst_no'],
                'contact_no' => $validatedData['vendor_contact_no'],
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Vendor updated successfully!',
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the vendor.',
            ], 500);
        }
    }

    public function destroy($id){
        try {
            $vendor = Vendors::findOrFail($id);
            $vendor->delete(); 
            return response()->json([
                'success' => true,
                'message' => 'Vendor deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the vendor.'
            ], 500);
        }
    }

    public function autocomplete(Request $request){
        $query = $request->get('query');
        $vendors = Vendors::where('vendor_name', 'LIKE', "%{$query}%")->get(['id', 'vendor_name']);
        return response()->json($vendors);
    }
}
