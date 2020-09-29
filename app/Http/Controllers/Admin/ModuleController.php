<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\TableInstall;
use App\Helper;
use App\MenuSystem;
use App\Module;
use App\PermissionAction;
use App\PermissionActionByGroup;
use Illuminate\Support\Facades\Auth;
use File;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'Module')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        if (Helper::CheckPermissionMenu('Module', '1')) {
            return view('admin.Module.modules', $data);
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
            'modules_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Module = new Module;
                foreach ($input_all as $key => $val) {
                    $Module->{$key} = $val;
                }
                if (!isset($input_all['modules_status'])) {
                    $Module->modules_status = 0;
                }
                $Module->save();
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
            if (isset($failedRules['modules_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Module is required";
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
        $content = Module::find($id);
        $return['status'] = 1;
        $return['title'] = 'Get Module';
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
            'modules_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Module = Module::find($id);
                foreach ($input_all as $key => $val) {
                    $Module->{$key} = $val;
                }
                if (!isset($input_all['modules_status'])) {
                    $Module->modules_status = 0;
                }
                $Module->save();
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
            if (isset($failedRules['modules_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Module is required";
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
        $result = Module::select();
        $modules_name = $request->input('modules_name');
        $modules_detail = $request->input('modules_detail');
        if ($modules_name) {
            $result->where('modules_name', 'like', '%' . $modules_name . '%');
        };
        if ($modules_detail) {
            $result->where('modules_details', 'like', '%' . $modules_detail . '%');
        };
        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->modules_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->modules_id . '"></label>
                    </div>';
                return $str;
            })
            ->addColumn('modules_name', function ($res) {
                $str = '<i class="' . $res->modules_icon . '"></i>  ' . $res->modules_name;
                return $str;
            })
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('Module', '1');
                $insert = Helper::CheckPermissionMenu('Module', '2');
                $update = Helper::CheckPermissionMenu('Module', '3');
                $delete = Helper::CheckPermissionMenu('Module', '4');
                if ($res->modules_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->modules_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->modules_id . '">View</button>';
                $btnInstall = '<button type="button" class="btn btn-success btn-md btn-install" data-id="' . $res->modules_id . '" id="0" ><i class="fas fa-arrow-alt-circle-down"></i>  Install</button>';
                $btnUninstall = '<button type="button" class="btn btn-danger btn-md btn-install" data-id="' . $res->modules_id . '" id="1" ><i class="fas fa-arrow-alt-circle-up"></i>  Uninstall</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->modules_id . '">Edit</button>';
                $str = '';
                if ($update) {
                    $str .= ' ' . $btnStatus;
                }
                if ($view) {
                    $str .= ' ' . $btnView;
                }
                if ($res->modules_install == 0) {
                    $str .= ' ' . $btnInstall;
                } else if ($res->modules_install == 1) {
                    $str .= ' ' . $btnUninstall;
                }

                if ($update) {
                    $str .= ' ' . $btnEdit;
                }
                return $str;
            })
            ->addIndexColumn()
            ->rawColumns(['checkbox', 'modules_name', 'action'])
            ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            $input_all['modules_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            Module::where('modules_id', $id)->update($input_all);
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
    public function Install(Request $request, $id)
    {
        $status = $request->input('status');

        $url_modules = public_path('uploads/Modules');
        $url_resources = resource_path('views/admin');
        $url_app = app_path();
        $url_controller = app_path('Http/Controllers/Admin');


        if ($status == 0) {
            $status = 1;
            $return['title'] = 'Install Module';
        } else if ($status == 1) {
            $status = 0;
            $return['title'] = 'Uninstall Module';
        }
        \DB::beginTransaction();
        try {
            $input_all['modules_install'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            Module::where('modules_id', $id)->update($input_all);
            $Module = Module::where('modules_id', $id)->first();

            $url_modules_app = public_path('uploads/Modules' . '/' . $Module->modules_name . '/' . 'App');
            $url_modules_view = public_path('uploads/Modules' . '/' . $Module->modules_name . '/' . 'View');
            $url_modules_controller = public_path('uploads/Modules' . '/' . $Module->modules_name . '/' . 'Controller');

            $file_module_model_all = $this->readDir($url_modules_app);
            $file_module_view_all = $this->readDir($url_modules_view);
            $file_module_controller_all = $this->readDir($url_modules_controller);
            $permission_action = [
                "1" => "1",
                "2" => "2",
                "3" => "3",
                "4" => "4"
            ];
            $admin = Auth::guard('admin')->user();

            if ($status == 1) {
                // Add Menu
                TableInstall::CreateTable($Module->modules_name);
                $MenuSystem = new MenuSystem;
                $MenuSystem->menu_system_name = $Module->modules_name;
                $MenuSystem->menu_system_part = '';
                $MenuSystem->menu_system_icon = $Module->modules_icon;
                $MenuSystem->menu_system_z_index = 99;
                $MenuSystem->menu_system_status = 1;
                $MenuSystem->save();
                $menu_id = $MenuSystem->getKey();

                $this->app_copy($url_modules . '/' . $Module->modules_name . '/App', $url_app);
                if ($file_module_view_all) {
                    foreach ($file_module_view_all as $val) {
                        $data_view = explode('/', $val);
                        $cout_path = count($data_view);
                        $view_name =  $data_view[$cout_path - 2];
                        $this->recurse_copy($url_modules . '/' . $Module->modules_name . '/View' . '/' . $view_name, $url_resources . '/' . $view_name);

                        // Add SubMenu
                        $MenuSystem = new MenuSystem;
                        $MenuSystem->menu_system_name = $view_name;
                        $MenuSystem->menu_system_part = $view_name;
                        $MenuSystem->menu_system_main_menu = $menu_id;
                        $MenuSystem->menu_system_status = 1;
                        $MenuSystem->save();
                        $sunb_menu_id[] = $MenuSystem->getKey();
                    }
                    // Add Menu Permission
                    foreach ($permission_action as $val2) {
                        $PermissionAction = new PermissionAction;
                        $PermissionAction->menu_system_id = $menu_id;
                        $PermissionAction->admin_id = $admin->admin_id;
                        $PermissionAction->permission_action_code_action = $val2;
                        $PermissionAction->permission_action_status = 1;
                        $PermissionAction->save();
                    }
                    // Add Sub Menu Permission
                    foreach ($sunb_menu_id as $val) {
                        foreach ($permission_action as $val2) {
                            $PermissionAction = new PermissionAction;
                            $PermissionAction->menu_system_id = $val;
                            $PermissionAction->admin_id = $admin->admin_id;
                            $PermissionAction->permission_action_code_action = $val2;
                            $PermissionAction->permission_action_status = 1;
                            $PermissionAction->save();
                        }
                    }
                }
                $this->controller_copy($url_modules . '/' . $Module->modules_name . '/Controller', $url_controller);
            }

            if ($status == 0) {
                TableInstall::DropTable($Module->modules_name);

                $MenuSystemMenu = MenuSystem::where('menu_system_name', $Module->modules_name)
                ->where('menu_system_part', '')
                ->first();
                foreach ($file_module_model_all as $val1) {
                    $data_model = explode('/', $val1);
                    $cout_path = count($data_model);
                    $model_name =  $data_model[$cout_path - 1];
                    unlink($url_app . '/' . $model_name);
                }
                foreach ($file_module_view_all as $val2) {
                    $data_pic = explode('/', $val2);
                    $cout_path = count($data_pic);
                    $view_name =  $data_pic[$cout_path - 2];
                    $MenuSystem = MenuSystem::where('menu_system_part', $view_name)->first();
                    $sunb_menu_id[] = $MenuSystem->menu_system_id;
                    File::deleteDirectory($url_resources . '/' . $view_name);
                }
                foreach ($file_module_controller_all as $val3) {
                    $data_controller = explode('/', $val3);
                    $cout_path = count($data_controller);
                    $controller_name =  $data_controller[$cout_path - 1];
                    unlink($url_controller . '/' . $controller_name);
                }
                PermissionAction::where('menu_system_id',$MenuSystemMenu->menu_system_id)->delete();
                foreach ($sunb_menu_id as $val) {
                    PermissionAction::where('menu_system_id',$val)->delete();
                }
                MenuSystem::where('menu_system_id',$MenuSystemMenu->menu_system_id)->delete();
                foreach ($sunb_menu_id as $val) {
                    MenuSystem::where('menu_system_id',$val)->delete();
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
        return $return;
    }

    public function recurse_copy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    recurse_copy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
    public function app_copy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    app_copy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
    public function controller_copy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    controller_copy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
    public function readDir($dir)
    {
        $dirs = array($dir);
        $files = array();
        for ($i = 0;; $i++) {
            if (isset($dirs[$i]))
                $dir =  $dirs[$i];
            else
                break;

            if ($openDir = @opendir($dir)) {
                while ($readDir = @readdir($openDir)) {
                    if ($readDir != "." && $readDir != "..") {

                        if (is_dir($dir . "/" . $readDir)) {
                            $dirs[] = $dir . "/" . $readDir;
                        } else {
                            $files[] = $dir . "/" . $readDir;
                        }
                    }
                }
            }
        }

        return $files;
    }
    
}
