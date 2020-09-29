<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\Social;
use App\Language;

class SocialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'Social')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['Language'] = Language::where('languages_status', '1')->get();

        if (Helper::CheckPermissionMenu('Social', '1')) {
            return view('admin.Social.social', $data);
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
        $url_temp = public_path('uploads/SocialImageTemp');
        $url_upload = public_path('uploads/SocialImage');

        $file_name_all = $this->readDir($url_temp);
        // $social_input = $request->input('lang');
        $validator = Validator::make($request->all(), [
            // 'social_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Social = new Social;
                foreach($input_all as $key=>$val){
                    $Social->{$key} = $val;
                    if (isset($input_all['social_icon'])) {
                        $image_cut = str_replace("SocialImageTemp/", "", $input_all['social_icon']);
                        $Social->social_icon = $image_cut;
                        copy($url_temp . '/' . $image_cut, $url_upload . '/' . $image_cut);
                    }
                }
                if(!isset($input_all['social_status'])){
                    $Social->social_status = 0;
                }
                $Social->save();

                if ($file_name_all) {
                    foreach ($file_name_all as $val) {
                        $data_pic = explode('/', $val);
                        $cout_path = count($data_pic);
                        $pic_name =  $data_pic[$cout_path - 1];

                        // copy($url_temp . '/' . $pic_name, $url_upload . '/' . $pic_name);
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
            if (isset($failedRules['social_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Social Us is required";
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
        $content = Social::select()->with('Language')->find($id);;
        $return['status'] = 1;
        $return['title'] = 'Get Social Us';
        $return['content'] = $content;
        $content['SocialImagePath'] = asset('uploads/SocialImage');

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
        $url_temp = public_path('uploads/SocialImageTemp');
        $url_upload = public_path('uploads/SocialImage');

        $file_name_all = $this->readDir($url_temp);

        $validator = Validator::make($request->all(), [
            // 'social_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Social = Social::find($id);
                foreach ($input_all as $key => $val) {
                    $old_image = $Social->social_icon;
                    $Social->{$key} = $val;
                    if (isset($input_all['social_icon'])) {
                        if($old_image){
                            unlink($url_upload . '/' . $old_image);
                        }
                        $image_cut = str_replace("SocialImageTemp/", "", $input_all['social_icon']);
                        $Social->social_icon = $image_cut;
                        copy($url_temp . '/' . $image_cut, $url_upload . '/' . $image_cut);
                    }
                }
                if (!isset($input_all['social_status'])) {
                    $Social->social_status = 0;
                }
                $Social->save();


                if ($file_name_all) {
                    foreach ($file_name_all as $val) {
                        $data_pic = explode('/', $val);
                        $cout_path = count($data_pic);
                        $pic_name =  $data_pic[$cout_path - 1];

                        // copy($url_temp . '/' . $pic_name, $url_upload . '/' . $pic_name);
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
            if (isset($failedRules['social_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Social Us is required";
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
        $result = Social::select();
        $social_name = $request->input('social_name');
 
        if ($social_name) {
            $result->where('social_social_name', 'like', '%' . $social_name . '%');
        };
      
        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->social_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->social_id . '"></label>
                    </div>';
                return $str;
            })
            ->addColumn('social_icon',function ($res){
                $path = asset('uploads/SocialImage/' .$res->social_icon);
                return '<img src="' . $path .'" style="height: 80px;">';
            })
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('Social', '1');
                $insert = Helper::CheckPermissionMenu('Social', '2');
                $update = Helper::CheckPermissionMenu('Social', '3');
                $delete = Helper::CheckPermissionMenu('Social', '4');
                if ($res->social_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->social_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->social_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->social_id . '">Edit</button>';
                $btnDelete = '<button type="button" class="btn btn-danger btn-md btn-delete" data-id="' . $res->social_id . '">Delete</button>';
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
            ->rawColumns(['checkbox','social_icon','action'])
            ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            $input_all['social_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            Social::where('social_id', $id)->update($input_all);
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

    public function GetSocial(Request  $request)
    {
        $content = Social::select()->get();
        $content['SocialImagePath'] = asset('uploads/');
        $return['status'] = 1;
        $return['title'] = 'Get Social Us';
        $return['content'] = $content;
        return $return;
    }
    public function Delete(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {

            Social::where('social_id', $id)->delete();
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
