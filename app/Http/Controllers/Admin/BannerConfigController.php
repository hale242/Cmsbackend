<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\BannerConfig;
use App\Language;

class BannerConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'BannerConfig')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['Language'] = Language::where('languages_status', '1')->get();

        if (Helper::CheckPermissionMenu('BannerConfig', '1')) {
            return view('admin.BannerConfig.banner_config', $data);
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

       $BannerConfig_input = $request->input('lang');

        $validator = Validator::make($request->all(), [
            // 'banner_config_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                // return $BannerConfig;
                if ($BannerConfig_input) {
                    foreach ($BannerConfig_input as $key => $val1) {
                        $BannerConfig = BannerConfig::where('banner_config_id', $val1['banner_config_id'])->first();
                        foreach ($val1 as $key => $val) {
                            $BannerConfig->{$key} = $val;
                            $BannerConfig->save();
                        }
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
            if (isset($failedRules['banner_config_id']['required'])) {
                $return['status'] = 2;
                $return['title'] = "BannerConfig Us is required";
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
        $content = BannerConfig::select();
        $return['status'] = 1;
        $return['title'] = 'Get Banner Config';
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
    // public function update(Request $request, $id)
    // {
    //     $input_all = $request->all();
    //     $validator = Validator::make($request->all(), [
    //         // 'banner_config_time' => 'required',
    //     ]);
    //     if (!$validator->fails()) {
    //         \DB::beginTransaction();
    //         try {
    //             $BannerConfig = BannerConfig::find($id);
    //             foreach ($input_all as $key => $val) {
    //                 $BannerConfig->{$key} = $val;
    //             }
    //             if (!isset($input_all['banner_config_status'])) {
    //                 $BannerConfig->banner_config_status = 0;
    //             }
    //             $BannerConfig->save();
    //             \DB::commit();
    //             $return['status'] = 1;
    //             $return['content'] = 'Success';
    //         } catch (Exception $e) {
    //             \DB::rollBack();
    //             $return['status'] = 0;
    //             $return['content'] = 'Unsuccess';
    //         }
    //     } else {
    //         $failedRules = $validator->failed();
    //         $return['content'] = 'Unsuccess';
    //         if (isset($failedRules['banner_config_seo_title']['required'])) {
    //             $return['status'] = 2;
    //             $return['title'] = "Banner Config is required";
    //         }
    //     }
    //     $return['title'] = 'Update';
    //     return $return;
    // }

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

    // public function lists(Request  $request)
    // {
    //     $result = BannerConfig::select();
    //     $banner_config_seo_title = $request->input('banner_config_seo_title');
    //     $banner_config_detail = $request->input('banner_config_detail');
    //     if ($banner_config_seo_title) {
    //         $result->where('banner_config_seo_title', 'like', '%' . $banner_config_seo_title . '%');
    //     };
    //     if ($banner_config_detail) {
    //         $result->where('banner_config_details', 'like', '%' . $banner_config_detail . '%');
    //     };
    //     return Datatables::of($result)
    //         ->addColumn('checkbox', function ($res) {
    //             $str = '<div class="custom-control custom-checkbox">
    //                     <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->banner_config_id . '">
    //                     <label class="custom-control-label" for="checkbox-item-' . $res->banner_config_id . '"></label>
    //                 </div>';
    //             return $str;
    //         })
    //         ->addColumn('action', function ($res) {
    //             $view = Helper::CheckPermissionMenu('BannerConfig', '1');
    //             $insert = Helper::CheckPermissionMenu('BannerConfig', '2');
    //             $update = Helper::CheckPermissionMenu('BannerConfig', '3');
    //             $delete = Helper::CheckPermissionMenu('BannerConfig', '4');
    //             if ($res->banner_config_status == 1) {
    //                 $checked = 'checked';
    //             } else {
    //                 $checked = '';
    //             }
    //             $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->banner_config_id . '" data-style="ios" data-on="On" data-off="Off">';
    //             $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->banner_config_id . '">View</button>';
    //             $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->banner_config_id . '">Edit</button>';
    //             $btnDelete = '<button type="button" class="btn btn-danger btn-md btn-delete" data-id="' . $res->banner_config_id . '">Delete</button>';
    //             $str = '';
    //             if ($update) {
    //                 $str .= ' ' . $btnStatus;
    //             }
    //             if ($view) {
    //                 $str .= ' ' . $btnView;
    //             }
    //             if ($update) {
    //                 $str .= ' ' . $btnEdit;
    //             }
    //             if ($delete) {
    //                 $str .= ' ' . $btnDelete;
    //             }
    //             return $str;
    //         })
    //         ->addIndexColumn()
    //         ->rawColumns(['checkbox', 'action'])
    //         ->make(true);
    // }

    // public function ChangeStatus(Request $request, $id)
    // {
    //     $status = $request->input('status');
    //     \DB::beginTransaction();
    //     try {
    //         $input_all['banner_config_status'] = $status;
    //         $input_all['updated_at'] = date('Y-m-d H:i:s');
    //         BannerConfig::where('banner_config_id', $id)->update($input_all);
    //         \DB::commit();
    //         $return['status'] = 1;
    //         $return['content'] = 'Success';
    //     } catch (Exception $e) {
    //         \DB::rollBack();
    //         $return['status'] = 0;
    //         $return['content'] = 'Unsuccess';
    //     }
    //     $return['title'] = 'Update Status';
    //     return $return;
    // }

    public function GetBannerConfig(Request  $request)
    {
        $content = BannerConfig::select()->get();
        // $content['BannerConfigImagePath'] = asset('uploads/');
        $return['status'] = 1;
        $return['title'] = 'Get Banner Config';
        $return['content'] = $content;
        return $return;
    }
}
