<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\Department;
use App\GroupLevel;
use App\PermissionActionByGroup;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $data['MainMenu'] = MenuSystem::where('menu_system_part','Department')->with('MainMenu')->first();
          $data['Menus'] = MenuSystem::ActiveMenu()->get();
          $data['PermisstionMenus'] = MenuSystem::whereNull('menu_system_main_menu')->with('SubMenu')->orderBy('menu_system_z_index')->get();
          $data['GroupLevels'] = GroupLevel::where('admin_user_group_status', 1)->get();
          if(Helper::CheckPermissionMenu('Department' , '1')){
              return view('admin.Department.department', $data);
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
            'department_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Department = new Department;
                foreach($input_all as $key=>$val){
                    $Department->{$key} = $val;
                }
                if(!isset($input_all['department_status'])){
                    $Department->department_status = 0;
                }
                $Department->save();
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
            if(isset($failedRules['department_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Department Name is required";
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
        $content = Department::with('PermissionActionByGroup')->find($id);
        $return['status'] = 1;
        $return['title'] = 'Get Department';
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
            'department_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Department = Department::find($id);
                foreach($input_all as $key=>$val){
                    $Department->{$key} = $val;
                }
                if(!isset($input_all['department_status'])){
                    $Department->department_status = 0;
                }
                $Department->save();
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'Sucess';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'Unsuccess';
            }
        }else{
            $failedRules = $validator->failed();
            $return['content'] = 'Unsuccess';
            if(isset($failedRules['department_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Department Name is required";
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
      $result = Department::select();
      return Datatables::of($result)
        ->addColumn('checkbox' , function($res){
            $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-'.$res->department_id.'">
                        <label class="custom-control-label" for="checkbox-item-'.$res->department_id.'"></label>
                    </div>';
            return $str;
        })
        ->addColumn('action' , function($res){
            $view = Helper::CheckPermissionMenu('Department' , '1');
            $insert = Helper::CheckPermissionMenu('Department' , '2');
            $update = Helper::CheckPermissionMenu('Department' , '3');
            $delete = Helper::CheckPermissionMenu('Department' , '4');
            if($res->department_status == 1){
                $checked = 'checked';
            }else{
                $checked = '';
            }
            $btnStatus = '<input type="checkbox" class="toggle change-status" '.$checked.' data-id="'.$res->department_id.'" data-style="ios" data-on="On" data-off="Off">';
            $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="'.$res->department_id.'">View</button>';
            $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="'.$res->department_id.'">Edit</button>';
            $btnPremission = '<button type="button" class="btn btn-warning btn-md btn-permission text-white" data-id="'.$res->department_id.'">Permission</button>';
            $str = '';
            if($update){
                $str.=' '.$btnStatus;
            }
            if($view){
                $str.=' '.$btnView;
            }
            $str.=' '.$btnPremission;
            if($update){
                $str.=' '.$btnEdit;
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
            $input_all['department_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            Department::where('department_id', $id)->update($input_all);
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

    public function SetPremission(Request $request, $id)
    {
        $input_all = $request->all();
        $group_levels = $input_all['group_level'];
        \DB::beginTransaction();
        try {
            foreach($group_levels as $group_level_id=>$group_level){
                if($group_level){
                    PermissionActionByGroup::where([
                        'department_id' => $id, 'admin_user_group_id' => $group_level_id
                    ])->update(['permission_action_by_group_status' => 0]);
                    foreach($group_level as $menu_id=>$menu){
                        foreach($menu as $val){
                            $check = PermissionActionByGroup::where([
                                'department_id' => $id,
                                'admin_user_group_id'=> $group_level_id,
                                'menu_system_id'=> $menu_id,
                                'permission_action_by_group_code_action'=> $val,
                                ])->first();
                            if($check){
                                PermissionActionByGroup::where([
                                    'department_id' => $id,
                                    'admin_user_group_id'=> $group_level_id,
                                    'menu_system_id'=> $menu_id,
                                    'permission_action_by_group_code_action'=> $val,
                                    ])->update(['permission_action_by_group_status' => 1]);
                            }else{
                                $PermissionActionByGroup = new PermissionActionByGroup;
                                $PermissionActionByGroup->department_id = $id;
                                $PermissionActionByGroup->admin_user_group_id = $group_level_id;
                                $PermissionActionByGroup->menu_system_id = $menu_id;
                                $PermissionActionByGroup->permission_action_by_group_code_action = $val;
                                $PermissionActionByGroup->permission_action_by_group_status = 1;
                                $PermissionActionByGroup->save();
                            }
                        }
                    }
                }else{
                  PermissionActionByGroup::where([
                      'department_id' => $id, 'admin_user_group_id' => $group_level_id
                  ])->update(['permission_action_by_group_status' => 0]);
                }
            }
            \DB::commit();
            $return['status'] = 1;
            $return['content'] = 'Success';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['status'] = 0;
            $return['content'] = 'Unsuccess';
        }
        $return['title'] = 'Update Permission';
        return $return;
    }
}
