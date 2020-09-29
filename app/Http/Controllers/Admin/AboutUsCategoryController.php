<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\AboutUsCategory;

class AboutUsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $data['MainMenus'] = MenuSystem::where('menu_system_part','AboutUsCategory')->with('MainMenu')->first();
          $data['Menus'] = MenuSystem::ActiveMenu()->get();
          if(Helper::CheckPermissionMenu('AboutUsCategory' , '1')){
              return view('admin.AboutUsCategory.about_us_category', $data);
          }else{
              return redirect('admin/');
          }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input_all = $request->all();
        $validator = Validator::make($request->all(), [
            'aboutus_category_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $AboutUsCategory = new AboutUsCategory;
                foreach($input_all as $key=>$val){
                    $AboutUsCategory->{$key} = $val;
                }
                if(!isset($input_all['aboutus_category_status'])){
                    $AboutUsCategory->aboutus_category_status = 0;
                }
                $AboutUsCategory->save();
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'Success';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'Unsuccess';
            }
        }else{
            $failedRules = $validator->failed();
            $return['content'] = 'Unsuccess';
            if(isset($failedRules['aboutus_category_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "About Us Category is required";
            }
        }
        $return['title'] = 'Insert';
        return $return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $content = AboutUsCategory::find($id);
        $return['status'] = 1;
        $return['title'] = 'Get AboutUsCategory';
        $return['content'] = $content;
        return $return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input_all = $request->all();
        $validator = Validator::make($request->all(), [
            'aboutus_category_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $AboutUsCategory = AboutUsCategory::find($id);
                foreach($input_all as $key=>$val){
                    $AboutUsCategory->{$key} = $val;
                }
                if(!isset($input_all['aboutus_category_status'])){
                    $AboutUsCategory->aboutus_category_status = 0;
                }
                $AboutUsCategory->save();
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'Success';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'Unsuccess';
            }
        }else{
            $failedRules = $validator->failed();
            $return['content'] = 'Unsuccess';
            if(isset($failedRules['aboutus_category_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "About Us Category is required";
            }
        }
        $return['title'] = 'Update';
        return $return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function lists(Request  $request)
    {
      $result = AboutUsCategory::select();
      $aboutus_category_name = $request->input('aboutus_category_name');
      $aboutus_category_detail = $request->input('aboutus_category_detail');
      if($aboutus_category_name){
          $result->where('aboutus_category_name', 'like', '%'.$aboutus_category_name.'%');
      };
      if($aboutus_category_detail){
          $result->where('aboutus_category_details', 'like', '%'.$aboutus_category_detail.'%');
      };
      return Datatables::of($result)
        ->addColumn('checkbox' , function($res){
            $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-'.$res->aboutus_category_id.'">
                        <label class="custom-control-label" for="checkbox-item-'.$res->aboutus_category_id.'"></label>
                    </div>';
            return $str;
        })
        ->addColumn('action' , function($res){
            $view = Helper::CheckPermissionMenu('AboutUsCategory' , '1');
            $insert = Helper::CheckPermissionMenu('AboutUsCategory' , '2');
            $update = Helper::CheckPermissionMenu('AboutUsCategory' , '3');
            $delete = Helper::CheckPermissionMenu('AboutUsCategory' , '4');
            if($res->aboutus_category_status == 1){
                $checked = 'checked';
            }else{
                $checked = '';
            }
            $btnStatus = '<input type="checkbox" class="toggle change-status" '.$checked.' data-id="'.$res->aboutus_category_id.'" data-style="ios" data-on="On" data-off="Off">';
            $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="'.$res->aboutus_category_id.'">View</button>';
            $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="'.$res->aboutus_category_id.'">Edit</button>';
            $btnDelete = '<button type="button" class="btn btn-danger btn-md btn-delete" data-id="' . $res->aboutus_category_id . '">Delete</button>';
            $str = '';
            if($update){
                $str.=' '.$btnStatus;
            }
            if($view){
                $str.=' '.$btnView;
            }
            if($update){
                $str.=' '.$btnEdit;
            }
            if ($delete) {
                $str .= ' ' . $btnDelete;
            }
            return $str;
        })
        ->addIndexColumn()
        ->rawColumns(['checkbox', 'action'])
        ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            $input_all['aboutus_category_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            AboutUsCategory::where('aboutus_category_id', $id)->update($input_all);
            \DB::commit();
            $return['status'] = 1;
            $return['content'] = 'Success';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['status'] = 0;
            $return['content'] = 'Unsuccess';
        }
        $return['title'] = 'Update Status';
        return $return;
    }
    public function Delete(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            
            AboutUsCategory::where('aboutus_category_id', $id)->delete();
            \DB::commit();
            $return['status'] = 1;
            $return['content'] = 'Success';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['content'] = 'Unsuccess';
        }
        $return['title'] = 'Update Status';
        return $return;
    }
}
