<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\AdminUserGroup;
use App\PermissionActionByGroup;

class AdminUserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'AdminUserGroup')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['PermisstionMenus'] = MenuSystem::whereNull('menu_system_main_menu')->with('SubMenu')->orderBy('menu_system_z_index')->get();
        if (Helper::CheckPermissionMenu('AdminUserGroup', 1)) {
            return view('admin.AdminUserGroup.admin_user_group', $data);
        } else {
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
            'admin_user_group_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $AdminUserGroup = new AdminUserGroup;
                foreach ($input_all as $key => $val) {
                    $AdminUserGroup->{$key} = $val;
                }
                if (!isset($input_all['admin_user_group_status'])) {
                    $AdminUserGroup->admin_user_group_status = 0;
                }
                $AdminUserGroup->save();
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'Success';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'Unsuccess';
            }
        } else {
            $failedRules = $validator->failed();
            $return['content'] = 'Unsuccess';
            if (isset($failedRules['admin_user_group_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "AdminUserGroup Name is required";
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
        $content = AdminUserGroup::with('PermissionActionByGroup')->find($id);
        $return['status'] = 1;
        $return['title'] = 'Get AdminUserGroup';
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
            'admin_user_group_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $AdminUserGroup = AdminUserGroup::find($id);
                foreach ($input_all as $key => $val) {
                    $AdminUserGroup->{$key} = $val;
                }
                if (!isset($input_all['admin_user_group_status'])) {
                    $AdminUserGroup->admin_user_group_status = 0;
                }
                $AdminUserGroup->save();
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'Sucess';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'Unsuccess';
            }
        } else {
            $failedRules = $validator->failed();
            $return['content'] = 'Unsuccess';
            if (isset($failedRules['admin_user_group_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "AdminUserGroup Name is required";
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
        $result = AdminUserGroup::select();
        return Datatables::of($result)
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('AdminUserGroup', 1);
                $insert = Helper::CheckPermissionMenu('AdminUserGroup', 2);
                $update = Helper::CheckPermissionMenu('AdminUserGroup', 3);
                $delete = Helper::CheckPermissionMenu('AdminUserGroup', 4);
                if ($res->admin_user_group_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->admin_user_group_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->admin_user_group_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->admin_user_group_id . '">Edit</button>';
                $btnPremission = '<button type="button" class="btn btn-warning btn-md btn-permission text-white" data-id="' . $res->admin_user_group_id . '">Permission</button>';
                $str = '';
                if ($update) {
                    $str .= ' ' . $btnStatus;
                }
                if ($view) {
                    $str .= ' ' . $btnView;
                }
                $str .= ' ' . $btnPremission;
                if ($update) {
                    $str .= ' ' . $btnEdit;
                }
                return $str;
                
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            $AdminUserGroup = AdminUserGroup::find($id);
            $AdminUserGroup->status = $request->input('status');
            $AdminUserGroup->save();
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
        if (isset($input_all['menu'])) {
            $menus = $input_all['menu'];
            unset($input_all['menu']);
        }
        \DB::beginTransaction();
        try {
            if (isset($menus) && $menus) {
                PermissionActionByGroup::where('admin_user_group_id', $id)->update(['permission_action_by_group_status' => 0]);
                foreach ($menus as $menu_id => $menu) {
                    foreach ($menu as $val) {
                        $check = PermissionActionByGroup::where('admin_user_group_id', $id)->where('menu_system_id', $menu_id)->where('permission_action_by_group_code_action', $val)->first();
                        if ($check) {
                            PermissionActionByGroup::where('admin_user_group_id', $id)->where('menu_system_id', $menu_id)->where('permission_action_by_group_code_action', $val)->update(['permission_action_by_group_status' => 1]);
                        } else {
                            $PermissionActionByGroup = new PermissionActionByGroup;
                            $PermissionActionByGroup->admin_user_group_id = $id;
                            $PermissionActionByGroup->menu_system_id = $menu_id;
                            $PermissionActionByGroup->permission_action_by_group_code_action = $val;
                            $PermissionActionByGroup->permission_action_by_group_status = 1;
                            $PermissionActionByGroup->save();
                        }
                    }
                }
            } else {
                PermissionActionByGroup::where('admin_user_group_id', $id)->update(['permission_action_by_group_status' => 0]);
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
