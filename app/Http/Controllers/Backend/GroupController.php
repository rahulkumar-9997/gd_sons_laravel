<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Groups;
use App\Models\GroupCategories;
use PHPUnit\TextUI\XmlConfiguration\Group;

class GroupController extends Controller
{
    public function groupCategoryList(){
        // $data['groups_category_list'] = GroupCategories::orderBy('id','DESC')->get(); 
        $data['groups_category_list'] = GroupCategories::with('groups')->orderBy('id','DESC')->get(); 
        return view('backend.manage-group-category.group-category-list', compact('data'));
    }

    public function addNewGrupCategoryModal(Request $request){
        $url = $request->input('url'); 
        $form ='
        <div class="modal-body">
            <form method="POST" action="'.route('add-new-group-category.submit').'" accept-charset="UTF-8" enctype="multipart/form-data" id="addNewGroupCategory">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Group Category Name *</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="group_percentage" class="form-label">Group Percentage*</label>
                            <input type="text" id="group_percentage" name="group_percentage" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3 col-md-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" checked>
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
            'message' => 'Group Category Form created successfully',
            'form' => $form,
        ]);
    }

    public function addNewGrupCategoryModalSubmit(Request $request){
        $request->validate([
            'name' => 'required|unique:groups_categories,name',
            'status' => 'nullable|string',
            'group_percentage' => 'required|numeric|min:0|max:100'
        ]);
        $input['name'] = $request->input('name');
        $input['group_category_percentage'] = $request->input('group_percentage');
        if(!empty($request->input('status'))){
            $input['status'] = 1;
        }else{
            $input['status'] = 0;
        }
        $groups_category_create = GroupCategories::create($input);
        $data['groups_category_list'] = GroupCategories::with('groups')->orderBy('id','DESC')->get();
        if($groups_category_create){
            return response()->json([
                'message' => 'Group category created successfully',
                'status' => 'success',
                'groupCategoryContent' => view('backend.manage-group-category.partials.ajax-group-category-list', compact('data'))->render(),
            ]);
        }else{
            return response()->json([
                'message' => 'Somthings wents wrongs',
                'status' => 'fail',
            ]);
        }
    }

    public function editGroupCategoryModal(Request $request, $id){
        $url = $request->input('url');
        $group_category_row = GroupCategories::find($id);
        $status ='';
        if($group_category_row->status==1){
            $status='checked';
        }
        $form ='
        <div class="modal-body">
            <form method="POST" action="'.route('update-group-category.submit', $id).'" accept-charset="UTF-8" enctype="multipart/form-data" id="UpdateGroupCategory">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Group Name *</label>
                            <input type="text" value="'.$group_category_row->name.'" id="name" name="name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="group_percentage" class="form-label">Group Percentage*</label>
                            <input type="text" id="group_percentage" value="'.$group_category_row->group_category_percentage.'" name="group_percentage" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3 col-md-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" '. $status.'>
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
            'message' => 'Group Category Form created successfully',
            'form' => $form,
        ]);
    }

    public function editGroupCategoryModalSubmit(Request $request, $id){
        $request->validate([
            'name' => 'required|unique:groups_categories,name,' . $id,
            'status' => 'nullable|string',
            'group_percentage' => 'required|numeric|min:0|max:100'
        ]);

        $group_category = GroupCategories::findOrFail($id);
        $group_category->name = $request->input('name');
        $group_category->group_category_percentage = $request->input('group_percentage');
        if(!empty($request->input('status'))){
            $group_category->status = 1;
        }else{
            $group_category->status = 0;
        }
        $group_category->save();
        $data['groups_category_list'] = GroupCategories::with('groups')->orderBy('id','DESC')->get();
        return response()->json([
            'status' => 'success',
            'groupCategoryContent' => view('backend.manage-group-category.partials.ajax-group-category-list', compact('data'))->render(),
            'message' => 'Group category updated successfully',
        ]);
    }

    public function groupCategoryDelete($id){
        $groups_category_row = GroupCategories::find($id);
        $groups_category_row->delete();
        return redirect('manage-group-category')->with('success','Group category deleted successfully');
    }

    public function groupList(){
        //$data['groups_list'] = Groups::orderBy('id','DESC')->get();
        $data['groups_list'] = Groups::with('groupCategory')->orderBy('id','DESC')->get();
        //return response()->json( $data['groups_list']); 
        return view('backend.manage-group.group-list', compact('data'));
    }

    public function addNewGrupModal(Request $request){
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        $group_category = GroupCategories::orderBy('id','DESC')->get();
        $form ='
        <div class="modal-body">
            <form method="POST" action="'.route('add-new-group.submit').'" accept-charset="UTF-8" enctype="multipart/form-data" id="addNewGroup">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="group_category_id" class="form-label">Select Group  Category*</label>
                            <select class="form-select" id="group_category_id" name="group_category_id">
                                <option value="">Select Group Category</option>';
                                foreach ($group_category as $group_category_row) {
                                    $form .= '<option value="'.$group_category_row->id.'">'.$group_category_row->name.'</option>';
                                }
                            $form .= ' 
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="group_name" class="form-label">Group Name *</label>
                            <input type="text" id="group_name" name="group_name" class="form-control">
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
            'message' => 'Group Form created successfully',
            'form' => $form,
        ]);
    }

    public function addNewGrupModalSubmit(Request $request){
        $validated = $request->validate([
            'group_category_id' => 'required|exists:groups_categories,id',
            'group_name' => 'required|string|max:255|unique:groups,name',
            // 'group_percentage' => 'required|numeric|min:0|max:100',
        ]);
    
        Groups::create([
            'groups_category_id' => $validated['group_category_id'],
            'name' => $validated['group_name'],
        ]);
        $data['groups_list'] = Groups::with('groupCategory')->orderBy('id','DESC')->get(); 
        return response()->json([
            'status' => 'success',
            'message' => 'Group category added successfully!',
            'groupContent' => view('backend.manage-group.partials.ajax-group-list', compact('data'))->render(),
        ]);
    }

    public function editGroupModal(Request $request, $id){
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        $group_category = GroupCategories::orderBy('id','DESC')->get();
        $group = Groups::find($id); 
        $form ='
        <div class="modal-body">
            <form method="POST" action="'.route('update-group.submit', $group->id).'" accept-charset="UTF-8" enctype="multipart/form-data" id="UpdateNewGroup">
                '.csrf_field().'
                <input type="hidden" name="group_id" value="'. $group->id.'">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="group_category_name" class="form-label">Select Group Category*</label>
                            <select class="form-select" id="group_category_name" name="group_category_name">
                                <option value="">Select Group Category</option>';
                                foreach ($group_category as $group_category_row) {
                                    $selected = ($group_category_row->id == $group->groups_category_id) ? 'selected' : '';
                                    $form .= '<option value="'.$group_category_row->id.'" '.$selected.'>'.$group_category_row->name.'</option>';
                                }
                            $form .= ' 
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="group_name" class="form-label">Group  Name *</label>
                            <input type="text" id="group_name" name="group_name" value="'.$group->name.'" class="form-control">
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
            'message' => 'Group Form created successfully',
            'form' => $form,
        ]);
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'group_category_name' => 'required|exists:groups_categories,id',
            'group_name' => 'required|string|max:255|unique:groups,name,' . $id,
            //'group_percentage' => 'required|numeric|min:0|max:100',
        ]);
        $group = Groups::findOrFail($id);
        $group->update([
            'groups_category_id' => $validated['group_category_name'],
            'name' => $validated['group_name'],
        ]);
        $data['groups_list'] = Groups::with('groupCategory')->orderBy('id','DESC')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Group Category updated successfully!',
            'groupContent' => view('backend.manage-group.partials.ajax-group-list', compact('data'))->render(),
        ]);
    }

    public function groupDelete($id){
        $groups_row = Groups::find($id);
        $groups_row->delete();
        return redirect('manage-group')->with('success','Group deleted successfully');
    }

    

}
