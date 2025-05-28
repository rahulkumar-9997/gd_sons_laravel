<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductEnquiry;

class EnquiryController extends Controller
{
    public function requestProductList()
    {
        $data['product_enquiry'] = ProductEnquiry::orderBy('id', 'desc')->get();
        return view('backend.manage-enquiry.request-product-list', compact('data'));
    }

    public function requestProductListDestroy($id)
    {
        $enquiry = ProductEnquiry::findOrFail($id);
        $enquiry->delete();
        return redirect()->route('manage-enquiry.request.product.list')->with('success', 'Product enquiry deleted successfully.');
    }
}
