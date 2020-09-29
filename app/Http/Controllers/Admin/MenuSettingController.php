<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;

class MenuSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'MenuSetting')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['MenuSystems'] = MenuSystem::where('menu_system_status', 1)
            ->where('menu_system_main_menu', Null)
            ->get();
        if (Helper::CheckPermissionMenu('MenuSetting', '1')) {
            return view('admin.MenuSetting.menu_setting', $data);
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
            'menu_system_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $MenuSystem = new MenuSystem;
                foreach ($input_all as $key => $val) {
                    $MenuSystem->{$key} = $val;
                }
                if (!isset($input_all['menu_system_status'])) {
                    $MenuSystem->menu_system_status = 0;
                }
                $MenuSystem->save();
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
            if (isset($failedRules['menu_system_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Menu System is required";
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
        $content = MenuSystem::find($id);
        $return['status'] = 1;
        $return['title'] = 'Get Menu System';
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
            'menu_system_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $MenuSystem = MenuSystem::find($id);
                foreach ($input_all as $key => $val) {
                    $MenuSystem->{$key} = $val;
                }
                if (!isset($input_all['menu_system_status'])) {
                    $MenuSystem->menu_system_status = 0;
                }
                $MenuSystem->save();
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
            if (isset($failedRules['menu_system_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Menu System is required";
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
        $result = MenuSystem::select()->with('MainMenu');
        $menu_system_name = $request->input('menu_system_name');
        $menu_system_main_menu = $request->input('menu_system_main_menu');
        $menu_system_sub_menu = $request->input('menu_system_sub_menu');
        if ($menu_system_name) {
            $result->where('menu_system_name', 'like', '%' . $menu_system_name . '%');
        };
        if($menu_system_main_menu){
            $result->where('menu_system_id',$menu_system_main_menu);
        }
        if ($menu_system_sub_menu) {
            $result->where('menu_system_main_menu',$menu_system_sub_menu);
        };
        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->menu_system_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->menu_system_id . '"></label>
                    </div>';
                return $str;
            })
            ->addColumn('menu_system_type', function ($res) {
                if ($res->menu_system_main_menu == Null) {
                    $str = 'Main Menu';
                } else if ($res->menu_system_main_menu != Null) {
                    $str = 'Sub Menu ';
                }
                return $str;
            })

            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('MenuSetting', '1');
                $insert = Helper::CheckPermissionMenu('MenuSetting', '2');
                $update = Helper::CheckPermissionMenu('MenuSetting', '3');
                $delete = Helper::CheckPermissionMenu('MenuSetting', '4');
                if ($res->menu_system_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->menu_system_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->menu_system_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->menu_system_id . '">Edit</button>';
                $btnDelete = '<button type="button" class="btn btn-danger btn-md btn-delete" data-id="' . $res->menu_system_id . '">Delete</button>';
                $str = '';
                if ($update) {
                    $str .= ' ' . $btnStatus;
                }
                // if ($view) {
                //     $str .= ' ' . $btnView;
                // }
                if ($update) {
                    $str .= ' ' . $btnEdit;
                }
                if ($delete) {
                    $str .= ' ' . $btnDelete;
                }

                return $str;
            })
            ->addIndexColumn()
            ->rawColumns(['checkbox', 'menu_system_type', 'action'])
            ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            $input_all['menu_system_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            MenuSystem::where('menu_system_id', $id)->update($input_all);
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
            
            MenuSystem::where('menu_system_id', $id)->delete();
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
