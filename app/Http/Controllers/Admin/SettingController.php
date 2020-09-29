<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\Setting;
use App\Language;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'Setting')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['Language'] = Language::where('languages_status', '1')->get();

        if (Helper::CheckPermissionMenu('Setting', '1')) {
            return view('admin.Setting.setting', $data);
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
        // $input_all = $request->all();
        $Setting_input = $request->input('lang');

        $url_temp = public_path('uploads/SettingOgImageTemp');
        $url_upload = public_path('uploads/SettingOgImage');
        $file_name_all = $this->readDir($url_temp);

        $validator = Validator::make($request->all(), [
            // 'setting_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                // return $Setting;
                if ($Setting_input) {
                    foreach ($Setting_input as $key1 => $val1) {
                        $Setting = Setting::where('setting_id', $val1['setting_id'])->first();
                        foreach ($val1 as $key => $val) {
                            $old_image = $Setting->setting_og_image;
                            $Setting->{$key} = $val;
                            if (isset($val1['setting_og_image'])) {
                                if($old_image){
                                    unlink($url_upload . '/' . $old_image);
                                }
                                $image_cut = str_replace("SettingOgImageTemp/", "", $val1['setting_og_image']);
                                $Setting->setting_og_image = $image_cut;
                                copy($url_temp . '/' . $image_cut, $url_upload . '/' . $image_cut);
                               
                            }
                            $Setting->save();
                        }
                    }
                }
                if ($file_name_all) {
                    foreach ($file_name_all as $val) {
                        $data_pic = explode('/', $val);
                        $cout_path = count($data_pic);
                        $pic_name =  $data_pic[$cout_path - 1];
 
                        unlink($url_temp . '/' . $pic_name);
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
        } else {
            $failedRules = $validator->failed();
            $return['content'] = 'Unsuccess';
            if (isset($failedRules['setting_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Setting Us is required";
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
    public function show()
    {
        $content = Setting::select();
        $return['status'] = 1;
        $return['title'] = 'Get Setting Us';
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
            'setting_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Setting = Setting::find($id);
                foreach ($input_all as $key => $val) {
                    $Setting->{$key} = $val;
                }
                if (!isset($input_all['setting_status'])) {
                    $Setting->setting_status = 0;
                }
                $Setting->save();
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
            if (isset($failedRules['setting_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Setting Us is required";
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
        $result = Setting::select();
        $setting_seo_title = $request->input('setting_seo_title');
        $setting_detail = $request->input('setting_detail');
        if ($setting_seo_title) {
            $result->where('setting_seo_title', 'like', '%' . $setting_seo_title . '%');
        };
        if ($setting_detail) {
            $result->where('setting_details', 'like', '%' . $setting_detail . '%');
        };
        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->setting_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->setting_id . '"></label>
                    </div>';
                return $str;
            })
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('Setting', '1');
                $insert = Helper::CheckPermissionMenu('Setting', '2');
                $update = Helper::CheckPermissionMenu('Setting', '3');
                $delete = Helper::CheckPermissionMenu('Setting', '4');
                if ($res->setting_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->setting_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->setting_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->setting_id . '">Edit</button>';
                $btnDelete = '<button type="button" class="btn btn-danger btn-md btn-delete" data-id="' . $res->setting_id . '">Delete</button>';
                $str = '';
                if ($update) {
                    $str .= ' ' . $btnStatus;
                }
                if ($view) {
                    $str .= ' ' . $btnView;
                }
                if ($update) {
                    $str .= ' ' . $btnEdit;
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
            $input_all['setting_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            Setting::where('setting_id', $id)->update($input_all);
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

    public function GetSetting(Request  $request)
    {
        $content = Setting::select()->get();
        $content['SettingImagePath'] = asset('uploads/SettingOgImage');
        $return['status'] = 1;
        $return['title'] = 'Get Setting Us';
        $return['content'] = $content;
        return $return;
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
