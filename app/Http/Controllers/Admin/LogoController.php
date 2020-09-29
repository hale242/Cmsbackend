<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\Logo;

class LogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'Logo')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        if (Helper::CheckPermissionMenu('Logo', '1')) {
            return view('admin.Logo.logo', $data);
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

         $url_temp = public_path('uploads/LogoImageTemp');
        $url_upload = public_path('uploads/LogoImage');
        $file_name_all = $this->readDir($url_temp);

        $validator = Validator::make($request->all(), [
            'logo_title' => 'required',
            // 'logo_image' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Logo = new Logo;
                foreach ($input_all as $key => $val) {
                    $Logo = Logo::where('logo_id', $input_all['logo_id'])->first();
                    $old_image = $Logo->logo_image;
                    $Logo->{$key} = $val;
                    if (isset($input_all['logo_image'])) {
                        if($old_image){
                            unlink($url_upload . '/' . $old_image);
                        }
                        $image_cut = str_replace("LogoImageTemp/", "", $input_all['logo_image']);
                        $Logo->logo_image = $image_cut;
                        copy($url_temp . '/' . $image_cut, $url_upload . '/' . $image_cut);
                    }
                    if (!isset($input_all['logo_status'])) {
                        $Logo->logo_status = 0;
                    }
                    $Logo->save();
                }
               

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
            if (isset($failedRules['logo_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Logo is required";
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
        $content = Logo::find($id);
        $content['LogoImagePath'] = asset('uploads/LogoImage');

        $return['status'] = 1;
        $return['title'] = 'Get Logo';
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

        $url_temp = public_path('uploads/LogoImageTemp');
        $url_upload = public_path('uploads/LogoImage');
        $file_name_all = $this->readDir($url_temp);


        $validator = Validator::make($request->all(), [
            'logo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Logo = Logo::find($id);
                foreach ($input_all as $key => $val) {
                    $old_image = $Logo->logo_image;
                    $Logo->{$key} = $val;
                    if (isset($input_all['logo_image'])) {
                        if($old_image){
                            unlink($url_upload . '/' . $old_image);
                        }
                        $image_cut = str_replace("LogoImageTemp/", "", $input_all['logo_image']);
                        $Logo->logo_image = $image_cut;
                        copy($url_temp . '/' . $image_cut, $url_upload . '/' . $image_cut);
                       
                    }
                }
                if (!isset($input_all['logo_status'])) {
                    $Logo->logo_status = 0;
                }
                // if (isset($input_all['logo_image'])) {
                //     $Logo->logo_image = str_replace("LogoImage/", "", $input_all['logo_image']);
                // }
                $Logo->save();

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
            if (isset($failedRules['logo_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Logo is required";
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
        $result = Logo::select();
        $logo_name = $request->input('logo_name');
        $logo_detail = $request->input('logo_detail');
        if ($logo_name) {
            $result->where('logo_name', 'like', '%' . $logo_name . '%');
        };
        if ($logo_detail) {
            $result->where('logo_details', 'like', '%' . $logo_detail . '%');
        };
        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->logo_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->logo_id . '"></label>
                    </div>';
                return $str;
            })
            ->addColumn('logo_image',function ($res){
                $path = asset('uploads/LogoImage/' .$res->logo_image);
                return '<img src="' . $path .'" style="height: 80px;" >';
            })
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('Logo', '1');
                $insert = Helper::CheckPermissionMenu('Logo', '2');
                $update = Helper::CheckPermissionMenu('Logo', '3');
                $delete = Helper::CheckPermissionMenu('Logo', '4');
                if ($res->logo_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->logo_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->logo_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->logo_id . '">Edit</button>';
                $btnDelete = '<button type="button" class="btn btn-danger btn-md btn-delete" data-id="' . $res->logo_id . '">Delete</button>';

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
            ->rawColumns(['checkbox','logo_image','action'])
            ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            $input_all['logo_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            Logo::where('logo_id', $id)->update($input_all);
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
    public function GetLogo(Request  $request)
    {
        $content = Logo::select()->get();
        $return['LogoImagePath'] = asset('uploads/LogoImage');
        $return['status'] = 1;
        $return['title'] = 'Get Logo Us';
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
