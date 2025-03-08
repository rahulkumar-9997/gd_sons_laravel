<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Label;
use Intervention\Image\Facades\Image;
use App\Models\Product;
class LabelController extends Controller
{
    public function index(){
        $data['label_list'] = Label::orderBy('id','DESC')->get(); 
        return view('backend.label.index', compact('data'));
    }

    public function create(Request $request){
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        $add_brand_form ='
        <div class="modal-body">
            <form method="POST" action="'.route('label.store').'" accept-charset="UTF-8" enctype="multipart/form-data" id="uploadForm">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required="">
                        </div>
                    </div>
                    
                    <div class="mb-3 col-md-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status">
                            <label class="form-check-label" for="status">Status</label>
                        </div>
                    </div>
                    
                    <div class="modal-footer pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
        ';
        return response()->json([
            'message' => 'Label Form created successfully',
            'form' => $add_brand_form,
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $input['title'] = $request->input('name');
        if(!empty($request->input('status'))){
            $input['status'] = $request->input('status');
        }else{
            $input['status'] = 'on';
        }

        $label_create = Label::create($input);
        if($label_create){
            return redirect('label')->with('success','Label created successfully');
        }else{
             return redirect()->back()->with('error','Somthings went wrong please try again !.');
        }
    }

    public function edit(Request $request){
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        $label_id = $request->input('label_id'); 
        $label_row = Label::find($label_id);
        $label_status ='';
        if($label_row->status=='on'){
            $label_status ='checked';
        }
        $form = '
        <div class="modal-body">
            <form method="POST" action="'.route('label.update', $label_row->id).'" accept-charset="UTF-8" enctype="multipart/form-data" id="uploadForm">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required="" value="'.$label_row->title.'">
                        </div>
                    </div>
                    
                    <div class="mb-3 col-md-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" '.$label_status.'>
                            <label class="form-check-label" for="status">Status</label>
                        </div>
                    </div>
                    
                    <div class="modal-footer pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>';
        return response()->json([
            'message' => 'Label Form created successfully',
            'form' => $form,
        ]);
    }

    public function updateLabel(Request $request, $id){
        $label_row = Label::find($id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $input['title'] = $request->input('name');
        if(!empty($request->input('status'))){
            $input['status'] = $request->input('status');
        }else{
            $input['status'] = 'on';
        }
        
        $label_row_update = $label_row->update($input);
        if($label_row_update){
            return redirect('label')->with('success','Label updated successfully');
        }else{
             return redirect()->back()->with('error','Somthings went wrong please try again !.');
        }
    }
    
    public function deleteLabel(Request $request, $id){
        $label_row = Label::find($id);
        $label_row->delete();
        return redirect('label')->with('success','Label deleted successfully');
    }

    public function labelProduct(Request $request, $id){
        $label_row = Label::find($id);
        $categories = Category::orderBy('id', 'DESC')->get(); 
        
        $productsWithLabel = Product::with('label')
            ->where(function ($query) use ($id) {
                $query->where('label_id', $id)
                ->orWhereNull('label_id');
            });
        if ($request->has('category_id') && !empty($request->category_id)) {
            $productsWithLabel = $productsWithLabel->where('category_id', $request->category_id);
        }
        
        if ($request->has('search') && !empty($request->search)) {
            $searchTerms = explode(' ', $request->search); 
            $booleanQuery = '+' . implode(' +', $searchTerms);
        
            $productsWithLabel->whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
            $productsWithLabel->orWhere(function ($productsWithLabel) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $productsWithLabel->where('title', 'like', '%' . $term . '%');
                }
            });
        }
        $productsWithLabel = $productsWithLabel->orderByRaw("CASE 
                WHEN label_id = ? THEN 0 
                ELSE 1 
            END", [$id])
            ->paginate(20);
        if ($request->ajax()) {
            return view('backend.label.partials.product-label-partials', compact('productsWithLabel', 'label_row'));
        }
        return view('backend.label.label-product', compact('label_row', 'productsWithLabel', 'categories'));
    }

    public function labelProductFormSubmit(Request $request, $labelId){
        try {
            $productUpdates = json_decode($request->input('product_updates', []));
            if (empty($productUpdates)) {
                return response()->json(['success' => false, 'message' => 'No products selected.']);
            }
            foreach ($productUpdates as $update) {
                $product = Product::find($update->product_id);
                if ($product) {
                    $product->label_id = $update->label_id ? $labelId : null;
                    $product->save();
                }
            }
    
            return response()->json(['success' => true, 'message' => 'Products labels updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating products', 'error' => $e->getMessage()], 500);
        }
    }


}
